<?php

declare(strict_types=1);

namespace Tests\Unit;

use Alxarafe\Infrastructure\Persistence\Template;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;

final class LanguageSwitcherTemplateTest extends TestCase
{
    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testLanguageLinksRemainRootRelativeFromNestedPages(): void
    {
        $_COOKIE['alx_lang'] = 'en_US';

        $template = new Template('partial/lang_switcher');
        $template->setPaths([constant('ALX_PATH') . '/templates']);
        $html = (string) $template->render();

        preg_match_all(
            '/href="([^"]*action=setLang[^"]*)"/',
            $html,
            $matches
        );

        self::assertNotEmpty($matches[1]);
        foreach ($matches[1] as $href) {
            self::assertStringStartsWith('/index.php?', $href);
        }
        self::assertContains(
            '/index.php?module=Admin&controller=Auth&action=setLang&lang=en_US',
            $matches[1]
        );
        self::assertStringNotContainsString('href="index.php?', $html);
    }
}
