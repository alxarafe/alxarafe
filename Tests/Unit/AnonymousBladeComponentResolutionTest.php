<?php

declare(strict_types=1);

namespace Tests\Unit;

use Alxarafe\Infrastructure\Persistence\BladeContainer;
use Alxarafe\Infrastructure\Persistence\Template;
use Illuminate\Container\Container;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class AnonymousBladeComponentResolutionTest extends TestCase
{
    private string $fixtureRoot;

    /** @var list<string> */
    private array $createdCacheFiles = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixtureRoot = sys_get_temp_dir() . '/alxarafe-blade-components-' . bin2hex(random_bytes(8));
        mkdir($this->fixtureRoot, 0777, true);
        $this->resetBladeContainer();
    }

    protected function tearDown(): void
    {
        $this->removeDirectory($this->fixtureRoot);
        foreach ($this->createdCacheFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        $this->resetBladeContainer();

        parent::tearDown();
    }

    public function testFallbackAndOverridesRemainDeterministicWithColdAndWarmCache(): void
    {
        $paths = $this->createPrecedenceFixture();
        $cacheBefore = $this->cacheFiles();

        // Characterise the observed failure: the same login is first compiled
        // with a theme override, then rendered as Default using the fallback.
        $cyberpunk = new Template('page/login');
        $cyberpunk->setPaths($paths['cyberpunk']);
        $this->assertRenderedCard($cyberpunk, 'package-theme-card');

        $this->resetBladeContainer();

        $default = new Template('page/login');
        $default->setPaths($paths['default']);
        $this->assertRenderedCard($default, 'app-card');
        $this->assertRenderedCard($default, 'app-card'); // warm cache

        $this->resetBladeContainer();

        $appTheme = new Template('page/login');
        $appTheme->setPaths($paths['app_theme']);
        $this->assertRenderedCard($appTheme, 'app-theme-card');

        $this->resetBladeContainer();

        $fallbackOnly = new Template('page/login');
        $fallbackOnly->setPaths($paths['fallback_only']);
        $this->assertRenderedCard($fallbackOnly, 'package-card');
        $this->assertRenderedCard($fallbackOnly, 'package-card'); // warm cache

        $this->createdCacheFiles = array_values(array_diff($this->cacheFiles(), $cacheBefore));
    }

    public function testAllSixTemplateLevelsKeepTheirDocumentedPrecedence(): void
    {
        $names = [
            'app-theme',
            'package-theme',
            'app-module',
            'package-module',
            'app-general',
            'package-general',
        ];
        $roots = [];
        foreach ($names as $name) {
            $roots[$name] = $this->fixtureRoot . '/precedence/' . $name;
            mkdir($roots[$name], 0777, true);
            $this->writeCard($roots[$name], $name . '-card');
        }

        $viewRoot = $this->fixtureRoot . '/precedence/view';
        mkdir($viewRoot . '/page', 0777, true);
        file_put_contents(
            $viewRoot . '/page/login.blade.php',
            '<x-component.card>login-form<x-form.input /></x-component.card>'
        );

        $this->writeInput($roots['package-general']);

        $orderedPaths = array_values($roots);
        foreach ($names as $index => $name) {
            $template = new Template('page/login');
            $template->setPaths([...array_slice($orderedPaths, $index), $viewRoot]);
            $this->assertRenderedCard($template, $name . '-card');
            $this->resetBladeContainer();
        }
    }
    /**
     * @return array<string, list<string>>
     */
    private function createPrecedenceFixture(): array
    {
        $names = [
            'app-theme',
            'package-theme',
            'app-module',
            'package-module',
            'app-general',
            'package-general',
        ];
        $roots = [];
        foreach ($names as $name) {
            $roots[$name] = $this->fixtureRoot . '/' . $name;
            mkdir($roots[$name], 0777, true);
        }

        mkdir($roots['app-module'] . '/page', 0777, true);
        file_put_contents(
            $roots['app-module'] . '/page/login.blade.php',
            '<x-component.card>login-form<x-form.input /></x-component.card>'
        );

        $this->writeCard($roots['package-general'], 'package-card');
        $this->writeInput($roots['package-general']);
        $this->writeCard($roots['app-general'], 'app-card');
        $this->writeCard($roots['package-theme'], 'package-theme-card');
        $this->writeCard($roots['app-theme'], 'app-theme-card');

        $default = [
            $roots['app-theme'] . '/missing-default',
            $roots['package-theme'] . '/missing-default',
            $roots['app-module'],
            $roots['package-module'],
            $roots['app-general'],
            $roots['package-general'],
        ];

        return [
            'cyberpunk' => [
                $roots['app-theme'] . '/missing-component',
                $roots['package-theme'],
                $roots['app-module'],
                $roots['package-module'],
                $roots['app-general'],
                $roots['package-general'],
            ],
            'default' => $default,
            'app_theme' => [
                $roots['app-theme'],
                $roots['package-theme'],
                $roots['app-module'],
                $roots['package-module'],
                $roots['app-general'],
                $roots['package-general'],
            ],
            'fallback_only' => [
                $roots['app-theme'] . '/missing-component',
                $roots['package-theme'] . '/missing-component',
                $roots['app-module'],
                $roots['package-module'],
                $roots['app-general'] . '/missing-component',
                $roots['package-general'],
            ],
        ];
    }

    private function writeCard(string $root, string $marker): void
    {
        mkdir($root . '/component', 0777, true);
        file_put_contents(
            $root . '/component/card.blade.php',
            '<article data-card="' . $marker . '">{{ $slot }}</article>'
        );
    }

    private function writeInput(string $root): void
    {
        mkdir($root . '/component/form', 0777, true);
        file_put_contents(
            $root . '/component/form/input.blade.php',
            '<input data-input="fallback-input" {{ $attributes }}>'
        );
    }

    private function assertRenderedCard(Template $template, string $expectedMarker): void
    {
        $html = (string) $template->render();

        self::assertStringContainsString('data-card="' . $expectedMarker . '"', $html);
        self::assertStringContainsString('login-form', $html);
        self::assertStringContainsString('data-input="fallback-input"', $html);
        self::assertDoesNotMatchRegularExpression('/[a-f0-9]{32}::component\.card/', $html);
    }

    private function resetBladeContainer(): void
    {
        $property = new ReflectionProperty(Template::class, 'globalContainer');
        $property->setValue(null, null);
        Container::setInstance(new BladeContainer());
    }

    /** @return list<string> */
    private function cacheFiles(): array
    {
        $files = glob(constant('BASE_PATH') . '/../var/cache/blade/*/*') ?: [];
        sort($files);

        return $files;
    }

    private function removeDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            return;
        }

        $items = scandir($directory) ?: [];
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $path = $directory . '/' . $item;
            if (is_dir($path)) {
                $this->removeDirectory($path);
            } else {
                unlink($path);
            }
        }
        rmdir($directory);
    }
}
