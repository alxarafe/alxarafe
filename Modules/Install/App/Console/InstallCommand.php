<?php



namespace Modules\Install\App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Modules\Core\App\Facades\I18n;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;

class InstallCommand extends Command
{
    public const SCREEN_MESSAGE_WIDTH = 82;
    public const TABLE_COLUMN_NUMBER = 3;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'alxarafe:install
                                {--c|config_file= : JSON configuration file to run the installation}
                                {--l|locale= : Language to use during installation}
                                {--s|show-languages : Show all available languages}';

    /**
     * The console command description.
     */
    protected $description = 'Install the Alxarafe application.';

    public function __construct()
    {
        parent::__construct();
        App::setLocale(config('core.i18n.default_locale.default_console_locale'));
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->showHeader();
        if (!Module::isEnabled('Core')) {
            $this->error(I18n::alxTrans('app', 'modules', 'core-module-not-enabled'));

            exit(-1);
        }

        if ($this->option('locale')) {
            if (!\in_array($this->option('locale'), I18n::getLanguageIdentifiers(), true)) {
                $this->error(I18n::alxTrans('install', 'install', 'unknown-language'));

                exit(-1);
            }
            App::setLocale($this->option('locale'));
        }

        if ($this->option('config_file')) {
            $filename = $this->option('config_file');
            if (!file_exists($filename) || !is_readable($filename)) {
                $this->error(I18n::alxTrans('install', 'install', 'config-file-not-readable'));
            }
        }

        if ($this->option('show-languages')) {
            $this->showAvailableLanguages(I18n::getAvailableLanguages());
        }

        //        $this->info('Config => ' . config('install.name'));
        //        $this->info('Config => ' . config('core.info.copyright'));

        // $this->info(I18n::HTMLToConsole(Str::markdown(trans('install.ConfFileExists', ['configfile' => 'axarafe.php']))));
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
        $version = sprintf(
            config('alxaraafe.info.version-message'),
            config('alxarafe.info.version'),
            config('alxarafe.info.subversion')
        );
        $loveMsg = config('alxarafe.info.love-message');

        $this->newLine(2);
        $this->line('<fg=yellow;>   █████████   ████                                               ██████</>');
        $this->line('<fg=yellow;>  ███░░░░░███ ░░███                                              ███░░███</>');
        $this->line('<fg=yellow;> ░███    ░███  ░███  █████ █████  ██████   ████████   ██████    ░███ ░░░   ██████</>');
        $this->line('<fg=yellow;> ░███████████  ░███ ░░███ ░░███  ░░░░░███ ░░███░░███ ░░░░░███  ███████    ███░░███</>');
        $this->line('<fg=yellow;> ░███░░░░░███  ░███  ░░░█████░    ███████  ░███ ░░░   ███████ ░░░███░    ░███████</>');
        $this->line('<fg=yellow;> ░███    ░███  ░███   ███░░░███  ███░░███  ░███      ███░░███   ░███     ░███░░░</>');
        $this->line('<fg=yellow;> █████   █████ █████ █████ █████░░████████ █████    ░░████████  █████    ░░██████</>');
        $this->line('<fg=yellow;>░░░░░   ░░░░░ ░░░░░ ░░░░░ ░░░░░  ░░░░░░░░ ░░░░░      ░░░░░░░░  ░░░░░      ░░░░░░</>');

        $this->line('<fg=yellow;>'.$copyright.'</>');
        $this->line(sprintf(
            '<fg=yellow;>%s%s%s</>',
            $loveMsg,
            str_pad(' ', self::SCREEN_MESSAGE_WIDTH - (\strlen($version) + \strlen($loveMsg)) + 2),
            $version
        ));
        $this->newLine(2);
    }

    /**
     * Show a three column table with the available languages.
     *
     * @author Cayetano H. Osma <chernandez@elestadoweb.com>
     *
     * @version Feb.2024
     */
    private function showAvailableLanguages(array $availableLanguages): void
    {
        $this->info('The available languages for Alxarafe installation are:');

        $table = new Table($this->output);
        $table->setHeaders([[new TableCell("\n<options=bold>Languages</>\n", ['colspan' => 3])]]);
        $itemsPerColumn = ceil(\count($availableLanguages) / self::TABLE_COLUMN_NUMBER);
        $rowContent = [];
        $columnedLanguages = array_chunk($availableLanguages, self::TABLE_COLUMN_NUMBER, true);
        for ($row = 0; $row < $itemsPerColumn; ++$row) {
            foreach ($columnedLanguages[$row] as $key => $value) {
                $rowContent[] = sprintf('%s - %s', $key, $columnedLanguages[$row][$key]);
            }
            $table->addRow($rowContent);
            $rowContent = [];
        }
        $table->setStyle('compact');
        $table->render();
        $this->newLine(1);
    }
}
