<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Modules\FrameworkTest\Controller;

use Alxarafe\Infrastructure\Http\Controller\PublicResourceController;
use Alxarafe\Infrastructure\Attribute\Menu;
use Alxarafe\ResourceController\Component\Fields\Boolean;
use Alxarafe\ResourceController\Component\Fields\Date;
use Alxarafe\ResourceController\Component\Fields\DateTime;
use Alxarafe\ResourceController\Component\Fields\Decimal;
use Alxarafe\ResourceController\Component\Fields\Icon;
use Alxarafe\ResourceController\Component\Fields\Image;
use Alxarafe\ResourceController\Component\Fields\Integer;
use Alxarafe\ResourceController\Component\Fields\Select;
use Alxarafe\ResourceController\Component\Fields\Select2;
use Alxarafe\ResourceController\Component\Fields\StaticText;
use Alxarafe\ResourceController\Component\Fields\Text;
use Alxarafe\ResourceController\Component\Fields\Textarea;
use Alxarafe\ResourceController\Component\Fields\Time;
use Alxarafe\ResourceController\Component\Container\Panel;
use Alxarafe\ResourceController\Component\Container\TabGroup;
use Alxarafe\ResourceController\Component\Container\Tab;
use Alxarafe\ResourceController\Component\Container\HtmlContent;
use Alxarafe\ResourceController\Component\Container\Row;
use Alxarafe\ResourceController\Component\Container\Separator;
use Alxarafe\ResourceController\Component\Enum\ActionPosition;
use Alxarafe\ResourceController\Component\Fields\Hidden;
use Alxarafe\Infrastructure\Service\MarkdownService;
use Modules\FrameworkTest\Model\TestModel;
use Symfony\Component\Yaml\Yaml;

#[Menu(
    menu: 'main_menu',
    label: 'showcase_title',
    icon: 'fas fa-vial',
    order: 10,
    visibility: 'public'
)]
class TestController extends PublicResourceController
{
    /**
     * @return string
     */
    public static function getModuleName(): string
    {
        return 'FrameworkTest';
    }

    /**
     * Define the primary model class for this controller.
     */
    protected function getModelClassName(): string
    {
        return TestModel::class;
    }

    /**
     * Override detectMode: always show edit form as showcase.
     */
    protected function detectMode(): void
    {
        $this->mode = self::MODE_EDIT;
        $this->recordId = 'demo';
        $this->protectChanges = false;
    }

    /**
     * Override integrity check to allow demo without a real database table.
     */
    protected function checkTableIntegrity()
    {
        // No-op for demo
    }

    /**
     * Ensure the test page has a nice title.
     */
    protected function beforeConfig(): void
    {
        $this->title = \Alxarafe\Infrastructure\Lib\Trans::_('showcase_title');
    }

    // ───────────────────────────────────────────────
    //  ACTIONS
    // ───────────────────────────────────────────────

    /**
     * Clear the application cache.
     * Demonstrates how to add custom actions to a ResourceController.
     */
    public function doClearCache(): void
    {
        $appPath = defined('APP_PATH') ? constant('APP_PATH') : realpath(__DIR__ . '/../../');
        $cachePath = $appPath . '/var/cache';

        $count = \Alxarafe\Infrastructure\Lib\Functions::recursiveRemove($cachePath . '/blade', false);
        $count += \Alxarafe\Infrastructure\Lib\Functions::recursiveRemove($cachePath . '/resources', false);

        \Alxarafe\Infrastructure\Lib\Messages::addMessage(\Alxarafe\Infrastructure\Lib\Trans::_('cache_cleared', ['count' => $count]));
        \Alxarafe\Infrastructure\Lib\Functions::httpRedirect($this->url());
    }

    /**
     * Path to the temporary YAML file for demo data.
     */
    protected function getDemoFilePath(): string
    {
        return (defined('APP_PATH') ? constant('APP_PATH') : __DIR__ . '/../../') . '/var/demo_data.yaml';
    }

    /**
     * Handle the request for the test page.
     * Intercepts the 'save' action to persist data into a YAML file for demo purposes.
     */
    #[\Override]
    protected function handleRequest(): void
    {
        // Custom handling for 'save' button in demo mode
        if ((isset($_POST['action']) && $_POST['action'] === 'save') || (isset($_GET['ajax']) && $_GET['ajax'] === 'save_record')) {
            $data = $_POST['data'] ?? [];
            if (!empty($data)) {
                try {
                    file_put_contents($this->getDemoFilePath(), Yaml::dump($data));
                    \Alxarafe\Infrastructure\Lib\Messages::addMessage("DEMO: Los datos se han guardado correctamente en el archivo YAML temporal.");
                } catch (\Exception $e) {
                    \Alxarafe\Infrastructure\Lib\Messages::addError("Error al guardar en YAML: " . $e->getMessage());
                }
            }
            return;
        }

        parent::handleRequest();
    }

    /**
     * AJAX action to render markdown content.
     */
    public function doRenderMarkdown()
    {
        $md = $_POST['markdown'] ?? '';
        $html = MarkdownService::render($md);
        $this->jsonResponse(['html' => $html]);
    }

    // ───────────────────────────────────────────────
    //  VIEW DESCRIPTOR — Component-based body format
    // ───────────────────────────────────────────────

    /**
     * Build the full multi-tab ViewDescriptor using body components.
     *
     * Tab 1: "Componentes" — Every field type in the system
     * Tab 2: "Paneles Anidados" — Nested panels demo (Panel in Panel in Panel)
     * Tab 3: "Markdown" — Rendered content from test_markdown.md
     */
    #[\Override]
    public function getViewDescriptor(): array
    {
        return [
            'mode'     => $this->mode ?? 'edit',
            'method'   => 'POST',
            'action'   => '?module=' . static::getModuleName() . '&controller=' . static::getControllerName(),
            'recordId' => 'demo',
            'record'   => $this->getDemoData(),
            'buttons'  => [
                ['label' => \Alxarafe\Infrastructure\Lib\Trans::_('save_demo'), 'icon' => 'fas fa-save', 'type' => 'primary', 'action' => 'submit', 'name' => 'save'],
                ['label' => \Alxarafe\Infrastructure\Lib\Trans::_('clear_cache'), 'icon' => 'fas fa-broom', 'type' => 'warning', 'action' => 'submit', 'name' => 'clearCache'],
            ],
            'body' => new TabGroup([
                new Tab('components', \Alxarafe\Infrastructure\Lib\Trans::_('tab_components'), 'fas fa-puzzle-piece', $this->buildComponentsPanels()),
                new Tab('nesting', \Alxarafe\Infrastructure\Lib\Trans::_('tab_nesting'), 'fas fa-boxes-stacked', $this->buildNestingPanels()),
                new Tab('markdown', \Alxarafe\Infrastructure\Lib\Trans::_('tab_markdown'), 'fab fa-markdown', $this->buildMarkdownPanels()),
            ]),
        ];
    }

    // ─── Tab 1: Componentes ────────────────────────

    protected function buildComponentsPanels(): array
    {
        // Name with a magic action
        $nameField = new Text('name', \Alxarafe\Infrastructure\Lib\Trans::_('resource_name'), [
            'required' => true,
            'help' => \Alxarafe\Infrastructure\Lib\Trans::_('resource_name_help'),
            'placeholder' => \Alxarafe\Infrastructure\Lib\Trans::_('resource_name_placeholder')
        ]);
        $nameField->addAction('fas fa-magic', "this.closest('.input-group').querySelector('input').value = 'Alxarafe ' + Math.floor(Math.random() * 1000);", \Alxarafe\Infrastructure\Lib\Trans::_('generate'), 'btn-outline-primary', ActionPosition::Left);

        // Integer with utility buttons
        $intField = new Integer('integer', \Alxarafe\Infrastructure\Lib\Trans::_('control_value'), [
            'min' => 0,
            'max' => 1000,
            'help' => \Alxarafe\Infrastructure\Lib\Trans::_('control_value_help')
        ]);
        $intField->addAction('fas fa-minus', "const i = this.closest('.input-group').querySelector('input'); i.value = Math.max(0, parseInt(i.value || 0) - 10);", '-10', 'btn-outline-secondary', ActionPosition::Left);
        $intField->addAction('fas fa-plus', "const i = this.closest('.input-group').querySelector('input'); i.value = Math.min(1000, parseInt(i.value || 0) + 10);", '+10', 'btn-outline-secondary', ActionPosition::Right);

        // Decimal with Currency
        $decimalField = new Decimal('decimal', \Alxarafe\Infrastructure\Lib\Trans::_('estimated_budget'), [
            'precision' => 2,
            'help' => \Alxarafe\Infrastructure\Lib\Trans::_('estimated_budget_help')
        ]);
        $decimalField->addAction('fas fa-euro-sign', '', \Alxarafe\Infrastructure\Lib\Trans::_('currency'), 'btn-dark disabled', ActionPosition::Left);

        return [
            new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('main_config'), [
                $nameField,
                new Textarea('description', \Alxarafe\Infrastructure\Lib\Trans::_('technical_description'), [
                    'placeholder' => \Alxarafe\Infrastructure\Lib\Trans::_('technical_description_placeholder'),
                    'rows' => 3
                ]),
                new Boolean('active', \Alxarafe\Infrastructure\Lib\Trans::_('publication_status'), [
                    'help' => \Alxarafe\Infrastructure\Lib\Trans::_('publication_status_help')
                ]),
            ], ['col' => 'col-md-7', 'class' => 'shadow-lg border-primary']),

            new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('aesthetics'), [
                new Icon('icon', \Alxarafe\Infrastructure\Lib\Trans::_('icon_representative'), [
                    'help' => \Alxarafe\Infrastructure\Lib\Trans::_('icon_help_fa'),
                    'default' => 'fas fa-rocket'
                ]),
                new Select('type', \Alxarafe\Infrastructure\Lib\Trans::_('object_classification'), [
                    'core' => \Alxarafe\Infrastructure\Lib\Trans::_('core_system'),
                    'plugin' => \Alxarafe\Infrastructure\Lib\Trans::_('plugin_extension'),
                    'theme' => \Alxarafe\Infrastructure\Lib\Trans::_('visual_theme')
                ]),
                new StaticText(\Alxarafe\Infrastructure\Lib\Trans::_('static_text_demo'), [
                    'icon' => 'fas fa-lightbulb text-warning'
                ]),
            ], ['col' => 'col-md-5']),

            new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('quantitative_data'), [
                $intField,
                $decimalField,
            ], ['col' => 'col-md-6', 'class' => 'border-info shadow-sm']),

            new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('chronology'), [
                new Date('date', \Alxarafe\Infrastructure\Lib\Trans::_('milestone_date')),
                new DateTime('datetime', \Alxarafe\Infrastructure\Lib\Trans::_('audit_record')),
                new Time('time', \Alxarafe\Infrastructure\Lib\Trans::_('window_opening')),
            ], ['col' => 'col-md-6']),

            new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('advanced_multimedia'), [
                new Select2('category_id', \Alxarafe\Infrastructure\Lib\Trans::_('global_tags'), [
                    1 => \Alxarafe\Infrastructure\Lib\Trans::_('tech'),
                    2 => \Alxarafe\Infrastructure\Lib\Trans::_('design'),
                    3 => \Alxarafe\Infrastructure\Lib\Trans::_('architecture'),
                ], [
                    'help' => \Alxarafe\Infrastructure\Lib\Trans::_('select2_help')
                ]),
                new Image('/alxarafe/assets/img/logo.png', \Alxarafe\Infrastructure\Lib\Trans::_('branding_preview'), [
                    'width' => '100%',
                    'help' => \Alxarafe\Infrastructure\Lib\Trans::_('image_help')
                ]),
            ], ['col' => 'col-md-12']),

            // --- Hidden field ---
            new Hidden('_token', \Alxarafe\Infrastructure\Lib\Trans::_('csrf_token')),

            // --- Separator (plain) ---
            new Separator(),

            // --- Separator (labeled) ---
            new Separator(\Alxarafe\Infrastructure\Lib\Trans::_('fields_row')),

            // --- Row: fields side by side, no card ---
            new Row([
                new Text('contact_first', \Alxarafe\Infrastructure\Lib\Trans::_('contact_first_name'), ['col' => 'col-md-4']),
                new Text('contact_last', \Alxarafe\Infrastructure\Lib\Trans::_('contact_last_name'), ['col' => 'col-md-4']),
                new Text('contact_email', \Alxarafe\Infrastructure\Lib\Trans::_('contact_email'), ['col' => 'col-md-4']),
            ], ['col' => 'col-12', 'class' => 'mb-3']),

            // --- Row with mixed field types ---
            new Row([
                new Date('row_date', \Alxarafe\Infrastructure\Lib\Trans::_('date'), ['col' => 'col-md-3']),
                new Time('row_time', \Alxarafe\Infrastructure\Lib\Trans::_('time'), ['col' => 'col-md-3']),
                new Boolean('row_active', \Alxarafe\Infrastructure\Lib\Trans::_('active'), ['col' => 'col-md-3']),
                new Integer('row_priority', \Alxarafe\Infrastructure\Lib\Trans::_('priority'), ['col' => 'col-md-3']),
            ], ['col' => 'col-12']),
        ];
    }

    // ─── Tab 2: Paneles Anidados ───────────────────

    protected function buildNestingPanels(): array
    {
        return [
            new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('parent_company'), [
                new Text('company_name', \Alxarafe\Infrastructure\Lib\Trans::_('parent_company'), [
                    'help' => \Alxarafe\Infrastructure\Lib\Trans::_('parent_company_help')
                ]),

                // ----- Panel Nivel 1 -----
                new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('fiscal_address'), [
                    new Text('address_street', \Alxarafe\Infrastructure\Lib\Trans::_('street')),
                    new Text('address_city', \Alxarafe\Infrastructure\Lib\Trans::_('city')),
                    new Text('address_zip', \Alxarafe\Infrastructure\Lib\Trans::_('postal_code'), ['col' => 'col-md-4']),
                    new Select('address_country', \Alxarafe\Infrastructure\Lib\Trans::_('country'), [
                        'ES' => 'España',
                        'FR' => 'Francia',
                        'DE' => 'Alemania',
                        'IT' => 'Italia',
                    ], ['col' => 'col-md-4']),

                    // ----- Panel Nivel 2 -----
                    new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('primary_contact'), [
                        new Text('contact_phone', \Alxarafe\Infrastructure\Lib\Trans::_('phone'), ['col' => 'col-md-6']),
                        new Text('contact_email', \Alxarafe\Infrastructure\Lib\Trans::_('email'), ['col' => 'col-md-6', 'type' => 'email']),
                        new Boolean('contact_gdpr', \Alxarafe\Infrastructure\Lib\Trans::_('gdpr_accept')),
                    ], ['col' => 'col-12']),

                ], ['col' => 'col-12']),

                new StaticText(\Alxarafe\Infrastructure\Lib\Trans::_('nesting_demo_info'), [
                    'icon' => 'fas fa-info-circle text-info'
                ]),
            ], ['col' => 'col-12', 'class' => 'border-warning']),

            new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('security_config'), [
                new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('security'), [
                    new Boolean('two_factor', \Alxarafe\Infrastructure\Lib\Trans::_('two_factor')),
                    new Select('session_timeout', \Alxarafe\Infrastructure\Lib\Trans::_('session_timeout'), [
                        '15' => \Alxarafe\Infrastructure\Lib\Trans::_('15_minutes'),
                        '30' => \Alxarafe\Infrastructure\Lib\Trans::_('30_minutes'),
                        '60' => \Alxarafe\Infrastructure\Lib\Trans::_('1_hour'),
                        '120' => \Alxarafe\Infrastructure\Lib\Trans::_('2_hours'),
                    ]),
                ], ['col' => 'col-12']),
            ], ['col' => 'col-md-6']),

            new Panel(\Alxarafe\Infrastructure\Lib\Trans::_('metrics'), [
                new Integer('users_count', \Alxarafe\Infrastructure\Lib\Trans::_('active_users')),
                new Decimal('monthly_revenue', \Alxarafe\Infrastructure\Lib\Trans::_('monthly_revenue'), ['precision' => 2]),
                new Date('last_audit', \Alxarafe\Infrastructure\Lib\Trans::_('last_audit')),
            ], ['col' => 'col-md-6', 'class' => 'border-success shadow']),
        ];
    }

    // ─── Tab 3: Markdown ───────────────────────────

    protected function buildMarkdownPanels(): array
    {
        $mdContent = '';
        $contentHtml = '<div class="alert alert-warning">No se encontró el archivo test_markdown.md</div>';

        try {
            $filePath = defined('APP_PATH')
                ? APP_PATH . '/data/test_markdown.md'
                : __DIR__ . '/../../../data/test_markdown.md';

            if (file_exists($filePath)) {
                $parsed = MarkdownService::parse($filePath);
                $mdContent = $parsed['content'];
                $contentHtml = MarkdownService::render($mdContent);
            }
        } catch (\Exception $e) {
            $contentHtml = '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }

        // Inline script to handle the preview refresh on tab change
        // We use a MutationObserver or a simple Interval if we don't want to rely on exact IDs,
        // but here we can try to target the data-bs-toggle="tab" links.
        $script = '<script>
            (function() {
                const initPreview = () => {
                    const previewTab = document.querySelector(\'[data-bs-target*="tab_md_preview"]\');
                    if (!previewTab) return;
                    
                    previewTab.addEventListener(\'show.bs.tab\', async () => {
                        const textarea = document.querySelector(\'textarea[name="data[test_markdown]"]\');
                        const preview = document.getElementById(\'markdown-preview-container\');
                        if (!textarea || !preview) return;
                        
                        // Show loading
                        preview.style.opacity = "0.5";
                        
                        try {
                            const resp = await fetch(\'?module=FrameworkTest&controller=Test&action=renderMarkdown\', {
                                method: \'POST\',
                                headers: { 
                                    \'Content-Type\': \'application/x-www-form-urlencoded\',
                                    \'X-Requested-With\': \'XMLHttpRequest\'
                                },
                                body: \'markdown=\' + encodeURIComponent(textarea.value)
                            });
                            const result = await resp.json();
                            preview.innerHTML = result.html;
                        } catch (e) {
                            console.error("Markdown preview error:", e);
                        } finally {
                            preview.style.opacity = "1";
                        }
                    });
                };
                
                if (document.readyState === "loading") {
                    document.addEventListener("DOMContentLoaded", initPreview);
                } else {
                    initPreview();
                }
            })();
        </script>';

        return [
            new TabGroup([
                new Tab('md_editor', \Alxarafe\Infrastructure\Lib\Trans::_('editor'), 'fas fa-edit', [
                    new Textarea('test_markdown', '', [
                        'rows' => 15,
                        'col' => 'col-12',
                        'value' => $mdContent // Initial value
                    ])
                ]),
                new Tab('md_preview', \Alxarafe\Infrastructure\Lib\Trans::_('preview'), 'fas fa-eye', [
                    new HtmlContent('<div id="markdown-preview-container">' . $contentHtml . '</div>' . $script, '', ['col' => 'col-12']),
                ]),
            ])
        ];
    }

    // ─── Demo Data ─────────────────────────────────

    protected function getDemoData(): array
    {
        $filePath = $this->getDemoFilePath();
        if (file_exists($filePath)) {
            try {
                $savedData = Yaml::parseFile($filePath);
                if (is_array($savedData)) {
                    return $savedData;
                }
            } catch (\Exception $e) {
                // Return default if parse fails
            }
        }

        return [
            'name' => 'Alxarafe Showcase 2026',
            'description' => 'Este es un ejemplo de cómo Alxarafe maneja formularios complejos con paneles y componentes modernizados. Estás viendo los datos por defecto porque aún no has guardado nada.',
            'active' => true,
            'integer' => 42,
            'decimal' => 1250.50,
            'type' => 'core',
            'icon' => 'fas fa-shield-alt',
            'date' => date('Y-m-d'),
            'datetime' => date('Y-m-d H:i:s'),
            'time' => date('H:i:s'),
            'category_id' => 3,
            // Nesting tab data
            'company_name' => 'Alxarafe Technologies S.L.',
            'address_street' => 'Calle Innovación, 42',
            'address_city' => 'Sevilla',
            'address_zip' => '41013',
            'address_country' => 'ES',
            'contact_phone' => '+34 954 000 000',
            'contact_email' => 'info@alxarafe.com',
            'contact_gdpr' => true,
            'two_factor' => true,
            'session_timeout' => '30',
            'users_count' => 127,
            'monthly_revenue' => 45890.75,
            'last_audit' => date('Y-m-d'),
        ];
    }

    /**
     * Provide dummy data for the showcase (used by ResourceTrait).
     */
    protected function fetchRecordData(): array
    {
        return [
            'id' => 'demo',
            'data' => $this->getDemoData(),
        ];
    }

    /**
     * Define columns for the list view (not used in demo, but required).
     */
    protected function getListColumns(): array
    {
        return [
            new Text('name', 'Nombre'),
            new Boolean('active', 'Activo'),
            new Icon('icon', 'Icono'),
            new Date('date', 'Fecha'),
            new Integer('integer', 'Valor'),
        ];
    }
}
