<?php

declare(strict_types=1);

namespace Tests\Unit;

use Alxarafe\Infrastructure\Persistence\Template;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;

final class NavigationTemplateUrlTest extends TestCase
{
    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testThemeLinksRemainRootRelativeFromNestedPages(): void
    {
        $template = new Template('partial/theme_switcher');
        $template->setPaths([constant('ALX_PATH') . '/templates']);
        $html = (string) $template->render();

        preg_match_all('/href="([^"]*action=setTheme[^"]*)"/', $html, $matches);

        self::assertNotEmpty($matches[1]);
        foreach ($matches[1] as $href) {
            self::assertStringStartsWith('/index.php?', $href);
        }
        self::assertStringNotContainsString('href="index.php?', $html);
    }

    public function testGuestLoginLinkIsRootRelative(): void
    {
        $template = file_get_contents(constant('ALX_PATH') . '/templates/partial/user_menu.blade.php');

        self::assertIsString($template);
        self::assertStringContainsString(
            'href="/index.php?module=Admin&controller=Auth"',
            $template
        );
        self::assertStringNotContainsString(
            'href="index.php?module=Admin&controller=Auth"',
            $template
        );
    }
}
