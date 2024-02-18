<?php

namespace App\Console\Commands;

use App\Helpers\I18nHelpers;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class install extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alxarafe:install 
                                {locale? : Language to use during installation}
                                {--show-languages : Show all available languages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Alxarafe application.';

    /**
     * Handle function for the console command.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     *
     * @return void
     */
    public function handle()
    {
        $this->showHeader();

        if (! $this->option('show-languages')) {
            $this->info('Setting the language for installation...');
        }
        $availableLanguagesCodes = I18nHelpers::getAvailableLanguages();
        $selectedLanguage = ! $this->argument('locale') ? config('app.default_fallback_locale') : $this->argument('locale');

        // Validation of language code
        if (! $this->option('show-languages') && ! in_array($selectedLanguage, $availableLanguagesCodes)) {
            $this->warn('The selected language is not available. By defaiult the isntallation will be done in English.');
        }
        // App::currentLocale($selectedLanguage);
        App::setLocale($selectedLanguage);
        $availableLanguagesNames = I18nHelpers::translateConfig('languages', config('alxarafe.i18n.available_install_languages'));
        if ($this->option('show-languages')) {
            $this->showAvailableLanguages($availableLanguagesCodes, $availableLanguagesNames);
        }

        $this->info(Str::inlineMarkdown(trans('install.ConfFileExists', [
            'configfile' => 'pepe.pgp',
            '<strong>' => '<options=bold>',
            '</strong>' => '</>',
        ])));
    }

    /**
     * Show a table with the available languages.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     *
     * @return void
     */
    private function showAvailableLanguages(array $langCodes, array $langNames)
    {
        $this->info('The available languages for Alxarafe installation are:');
        $fullLanguages = array_map(null, $langCodes, $langNames);
        $this->table(['Code', 'Name'], $fullLanguages);
    }

    /**
     * Show the header of the console command.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     */
    public function showHeader(): void
    {
        $copyright = config('alxarafe.info.copyright');
        $version = sprintf('Version: %s - Subversion: %s', config('alxarafe.info.version'), config('alxarafe.info.subversion'));
        $loveMsg = 'Craft with ♥ in Spain';

        $this->newLine(2);
        $this->line('    █████╗ ██╗     ██╗  ██╗ █████╗ ██████╗  █████╗ ███████╗███████╗');
        $this->line('   ██╔══██╗██║     ╚██╗██╔╝██╔══██╗██╔══██╗██╔══██╗██╔════╝██╔════╝');
        $this->line('   ███████║██║      ╚███╔╝ ███████║██████╔╝███████║█████╗  █████╗');
        $this->line('   ██╔══██║██║      ██╔██╗ ██╔══██║██╔══██╗██╔══██║██╔══╝  ██╔══╝');
        $this->line('   ██║  ██║███████╗██╔╝ ██╗██║  ██║██║  ██║██║  ██║██║     ███████╗');
        $this->line('   ══╝  ╚═╝╚══════╝╚═╝  ╚═╝╚═╝  ╚═╝╚═╝  ╚═╝╚═╝  ╚═╝╚═╝     ╚══════╝');
        $this->line($copyright);
        $this->line($loveMsg.str_pad(' ', strlen($copyright) - (strlen($version) + strlen($loveMsg)) + 2).$version);
        $this->newLine(2);
    }
}
