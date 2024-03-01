<?php



namespace Modules\Core\App\Classes;

use Illuminate\Support\Facades\Lang;

class Internacionalization
{
    /**
     * <options only can be one of these values bold, underscore, blink, reverse, conceal.
     *
     * @var array[]
     *
     * TODO Support the <br>
     */
    private static array $transcodeTags = [
        '<options=bold>' => ['<b>', '<strong>'],
        '<options=italic>' => ['<i>', '<em>'],
        '<options=reverse>' => ['<code>'],
        '</>' => ['</b>', '</strong>', '</i>', '</em>', '</code>'],
        PHP_EOL => ['<br>', '</p>'],
        '' => ['<p>'],
    ];

    /**
     * Translate and return the array given in the current locale.
     * The array must be in the lang file format.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     *
     * @param string $module       The module name where the lang file is located. if module is
     *                             set to 'app', it means that the lang file is located in the
     *                             app/lang folder.
     * @param string $domain       The name of the lang file
     * @param mixed  $messagesKeys The messages keys
     *
     * @throws \Exception
     */
    public function alxTrans(string $module, string $domain, mixed $messagesKeys): mixed
    {
        $message = !strcmp($module, 'app') ?
            sprintf('%s.%s', $domain, $messagesKeys) :
            sprintf('%s::%s.%s', $module, $domain, $messagesKeys);

        return match (\gettype($messagesKeys)) {
            'array' => self::translateArray($domain, $messagesKeys),
            'string' => trans($message),
            default => throw new \Exception('Unexpected match value'),
        };
    }

    /**
     * Get the list of languages codes.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     */
    public function getLanguageIdentifiers(): array
    {
        return array_keys(Lang::get('core::languages'));
    }

    /**
     * Return the list of available languages in Alxarafe project
     * The language list always be.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     */
    public function getAvailableLanguages(): array
    {
        return array_unique(Lang::get('core::languages'), SORT_STRING);
    }

    /**
     * Transcode the HTML text to Symfony Console Codes.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     */
    public static function HTMLToConsole(string $text): string
    {
        foreach (self::$transcodeTags as $key => $values) {
            foreach ($values as $value) {
                if (str_contains($text, $value)) {
                    $text = str_replace($value, $key, $text);
                }
            }
        }

        return $text;
    }

    /**
     * Translate and return a group of keys given in $array parameter.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     */
    private function translateArray(string $domain, array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $result[$key] = trans(sprintf('%s.%s', $domain, $value));
        }

        return $result;
    }
}
