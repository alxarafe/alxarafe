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

use Alxarafe\Base\Controller\PublicResourceController;
use Alxarafe\Attribute\Menu;
use Alxarafe\Component\Fields\Boolean;
use Alxarafe\Component\Fields\Date;
use Alxarafe\Component\Fields\DateTime;
use Alxarafe\Component\Fields\Decimal;
use Alxarafe\Component\Fields\Icon;
use Alxarafe\Component\Fields\Image;
use Alxarafe\Component\Fields\Integer;
use Alxarafe\Component\Fields\Select;
use Alxarafe\Component\Fields\Select2;
use Alxarafe\Component\Fields\StaticText;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Component\Fields\Textarea;
use Alxarafe\Component\Fields\Time;
use Alxarafe\Component\Container\Panel;
use Alxarafe\Component\Container\TabGroup;
use Alxarafe\Component\Container\Tab;
use Alxarafe\Component\Container\HtmlContent;
use Alxarafe\Component\Container\Row;
use Alxarafe\Component\Container\Separator;
use Alxarafe\Component\Enum\ActionPosition;
use Alxarafe\Component\Fields\Hidden;
use Alxarafe\Service\MarkdownService;
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
     * Define the primary model class for this controller.
     */
    protected function getModelClass()
    {
        return TestModel::class;
    }

    /**
     * Override detectMode: always show edit form as showcase.
     */
    protected function detectMode()
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
    protected function beforeConfig()
    {
        $this->title = \Alxarafe\Lib\Trans::_('showcase_title');
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

        $count = \Alxarafe\Lib\Functions::recursiveRemove($cachePath . '/blade', false);
        $count += \Alxarafe\Lib\Functions::recursiveRemove($cachePath . '/resources', false);

        \Alxarafe\Lib\Messages::addMessage("Caché limpiado con éxito. Se han eliminado $count elementos.");
        \Alxarafe\Lib\Functions::httpRedirect($this->url());
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
    protected function handleRequest()
    {
        // Custom handling for 'save' button in demo mode
        if ((isset($_POST['action']) && $_POST['action'] === 'save') || (isset($_GET['ajax']) && $_GET['ajax'] === 'save_record')) {
            $data = $_POST['data'] ?? [];
            if (!empty($data)) {
                try {
                    file_put_contents($this->getDemoFilePath(), Yaml::dump($data));
                    \Alxarafe\Lib\Messages::addMessage("DEMO: Los datos se han guardado correctamente en el archivo YAML temporal.");
                } catch (\Exception $e) {
                    \Alxarafe\Lib\Messages::addError("Error al guardar en YAML: " . $e->getMessage());
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
                ['label' => \Alxarafe\Lib\Trans::_('save_demo'), 'icon' => 'fas fa-save', 'type' => 'primary', 'action' => 'submit', 'name' => 'save'],
                ['label' => \Alxarafe\Lib\Trans::_('clear_cache'), 'icon' => 'fas fa-broom', 'type' => 'warning', 'action' => 'submit', 'name' => 'clearCache'],
                ['label' => \Alxarafe\Lib\Trans::_('back'), 'icon' => 'fas fa-arrow-left', 'type' => 'secondary', 'action' => 'url', 'target' => 'index.php'],
            ],
            'body' => new TabGroup([
                new Tab('components', \Alxarafe\Lib\Trans::_('tab_components'), 'fas fa-puzzle-piece', $this->buildComponentsPanels()),
                new Tab('nesting', \Alxarafe\Lib\Trans::_('tab_nesting'), 'fas fa-boxes-stacked', $this->buildNestingPanels()),
                new Tab('markdown', \Alxarafe\Lib\Trans::_('tab_markdown'), 'fab fa-markdown', $this->buildMarkdownPanels()),
            ]),
        ];
    }

    // ─── Tab 1: Componentes ────────────────────────

    protected function buildComponentsPanels(): array
    {
        // Name with a magic action
        $nameField = new Text('name', \Alxarafe\Lib\Trans::_('resource_name'), [
            'required' => true,
            'help' => \Alxarafe\Lib\Trans::_('resource_name_help'),
            'placeholder' => \Alxarafe\Lib\Trans::_('resource_name_placeholder')
        ]);
        $nameField->addAction('fas fa-magic', "this.closest('.input-group').querySelector('input').value = 'Alxarafe ' + Math.floor(Math.random() * 1000);", \Alxarafe\Lib\Trans::_('generate'), 'btn-outline-primary', ActionPosition::Left);

        // Integer with utility buttons
        $intField = new Integer('integer', \Alxarafe\Lib\Trans::_('control_value'), [
            'min' => 0,
            'max' => 1000,
            'help' => \Alxarafe\Lib\Trans::_('control_value_help')
        ]);
        $intField->addAction('fas fa-minus', "const i = this.closest('.input-group').querySelector('input'); i.value = Math.max(0, parseInt(i.value || 0) - 10);", '-10', 'btn-outline-secondary', ActionPosition::Left);
        $intField->addAction('fas fa-plus', "const i = this.closest('.input-group').querySelector('input'); i.value = Math.min(1000, parseInt(i.value || 0) + 10);", '+10', 'btn-outline-secondary', ActionPosition::Right);

        // Decimal with Currency
        $decimalField = new Decimal('decimal', \Alxarafe\Lib\Trans::_('estimated_budget'), [
            'precision' => 2,
            'help' => \Alxarafe\Lib\Trans::_('estimated_budget_help')
        ]);
        $decimalField->addAction('fas fa-euro-sign', '', \Alxarafe\Lib\Trans::_('currency'), 'btn-dark disabled', ActionPosition::Left);

        return [
            new Panel(\Alxarafe\Lib\Trans::_('main_config'), [
                $nameField,
                new Textarea('description', \Alxarafe\Lib\Trans::_('technical_description'), [
                    'placeholder' => \Alxarafe\Lib\Trans::_('technical_description_placeholder'),
                    'rows' => 3
                ]),
                new Boolean('active', \Alxarafe\Lib\Trans::_('publication_status'), [
                    'help' => \Alxarafe\Lib\Trans::_('publication_status_help')
                ]),
            ], ['col' => 'col-md-7', 'class' => 'shadow-lg border-primary']),

            new Panel(\Alxarafe\Lib\Trans::_('aesthetics'), [
                new Icon('icon', \Alxarafe\Lib\Trans::_('icon_representative'), [
                    'help' => \Alxarafe\Lib\Trans::_('icon_help_fa')
                ], ['default' => 'fas fa-rocket']),
                new Select('type', \Alxarafe\Lib\Trans::_('object_classification'), [
                    'core' => \Alxarafe\Lib\Trans::_('core_system'),
                    'plugin' => \Alxarafe\Lib\Trans::_('plugin_extension'),
                    'theme' => \Alxarafe\Lib\Trans::_('visual_theme')
                ]),
                new StaticText(\Alxarafe\Lib\Trans::_('static_text_demo'), [
                    'icon' => 'fas fa-lightbulb text-warning'
                ]),
            ], ['col' => 'col-md-5']),

            new Panel(\Alxarafe\Lib\Trans::_('quantitative_data'), [
                $intField,
                $decimalField,
            ], ['col' => 'col-md-6', 'class' => 'border-info shadow-sm']),

            new Panel(\Alxarafe\Lib\Trans::_('chronology'), [
                new Date('date', \Alxarafe\Lib\Trans::_('milestone_date')),
                new DateTime('datetime', \Alxarafe\Lib\Trans::_('audit_record')),
                new Time('time', \Alxarafe\Lib\Trans::_('window_opening')),
            ], ['col' => 'col-md-6']),

            new Panel(\Alxarafe\Lib\Trans::_('advanced_multimedia'), [
                new Select2('category_id', \Alxarafe\Lib\Trans::_('global_tags'), [
                    1 => \Alxarafe\Lib\Trans::_('tech'),
                    2 => \Alxarafe\Lib\Trans::_('design'),
                    3 => \Alxarafe\Lib\Trans::_('architecture'),
                ], [
                    'help' => \Alxarafe\Lib\Trans::_('select2_help')
                ]),
                new Image('https://images.unsplash.com/photo-1614850523296-d8c1af93d400?auto=format&fit=crop&w=300&q=80', \Alxarafe\Lib\Trans::_('branding_preview'), [
                    'width' => '100%',
                    'help' => \Alxarafe\Lib\Trans::_('image_help')
                ]),
            ], ['col' => 'col-md-12']),

            // --- Hidden field ---
            new Hidden('_token', \Alxarafe\Lib\Trans::_('csrf_token')),

            // --- Separator (plain) ---
            new Separator(),

            // --- Separator (labeled) ---
            new Separator(\Alxarafe\Lib\Trans::_('fields_row')),

            // --- Row: fields side by side, no card ---
            new Row([
                new Text('contact_first', \Alxarafe\Lib\Trans::_('contact_first_name'), ['col' => 'col-md-4']),
                new Text('contact_last', \Alxarafe\Lib\Trans::_('contact_last_name'), ['col' => 'col-md-4']),
                new Text('contact_email', \Alxarafe\Lib\Trans::_('contact_email'), ['col' => 'col-md-4']),
            ], ['col' => 'col-12', 'class' => 'mb-3']),

            // --- Row with mixed field types ---
            new Row([
                new Date('row_date', \Alxarafe\Lib\Trans::_('date'), ['col' => 'col-md-3']),
                new Time('row_time', \Alxarafe\Lib\Trans::_('time'), ['col' => 'col-md-3']),
                new Boolean('row_active', \Alxarafe\Lib\Trans::_('active'), ['col' => 'col-md-3']),
                new Integer('row_priority', \Alxarafe\Lib\Trans::_('priority'), ['col' => 'col-md-3']),
            ], ['col' => 'col-12']),
        ];
    }

    // ─── Tab 2: Paneles Anidados ───────────────────

    protected function buildNestingPanels(): array
    {
        return [
            new Panel(\Alxarafe\Lib\Trans::_('parent_company'), [
                new Text('company_name', \Alxarafe\Lib\Trans::_('parent_company'), [
                    'help' => \Alxarafe\Lib\Trans::_('parent_company_help')
                ]),

                // ----- Panel Nivel 1 -----
                new Panel(\Alxarafe\Lib\Trans::_('fiscal_address'), [
                    new Text('address_street', \Alxarafe\Lib\Trans::_('street')),
                    new Text('address_city', \Alxarafe\Lib\Trans::_('city')),
                    new Text('address_zip', \Alxarafe\Lib\Trans::_('postal_code'), ['col' => 'col-md-4']),
                    new Select('address_country', \Alxarafe\Lib\Trans::_('country'), [
                        'ES' => 'España',
                        'FR' => 'Francia',
                        'DE' => 'Alemania',
                        'IT' => 'Italia',
                    ], ['col' => 'col-md-4']),

                    // ----- Panel Nivel 2 -----
                    new Panel(\Alxarafe\Lib\Trans::_('primary_contact'), [
                        new Text('contact_phone', \Alxarafe\Lib\Trans::_('phone'), ['col' => 'col-md-6']),
                        new Text('contact_email', \Alxarafe\Lib\Trans::_('email'), ['col' => 'col-md-6', 'type' => 'email']),
                        new Boolean('contact_gdpr', \Alxarafe\Lib\Trans::_('gdpr_accept')),
                    ], ['col' => 'col-12']),

                ], ['col' => 'col-12']),

                new StaticText(\Alxarafe\Lib\Trans::_('nesting_demo_info'), [
                    'icon' => 'fas fa-info-circle text-info'
                ]),
            ], ['col' => 'col-12', 'class' => 'border-warning']),

            new Panel(\Alxarafe\Lib\Trans::_('security_config'), [
                new Panel(\Alxarafe\Lib\Trans::_('security'), [
                    new Boolean('two_factor', \Alxarafe\Lib\Trans::_('two_factor')),
                    new Select('session_timeout', \Alxarafe\Lib\Trans::_('session_timeout'), [
                        '15' => \Alxarafe\Lib\Trans::_('15_minutes'),
                        '30' => \Alxarafe\Lib\Trans::_('30_minutes'),
                        '60' => \Alxarafe\Lib\Trans::_('1_hour'),
                        '120' => \Alxarafe\Lib\Trans::_('2_hours'),
                    ]),
                ], ['col' => 'col-12']),
            ], ['col' => 'col-md-6']),

            new Panel(\Alxarafe\Lib\Trans::_('metrics'), [
                new Integer('users_count', \Alxarafe\Lib\Trans::_('active_users')),
                new Decimal('monthly_revenue', \Alxarafe\Lib\Trans::_('monthly_revenue'), ['precision' => 2]),
                new Date('last_audit', \Alxarafe\Lib\Trans::_('last_audit')),
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
                new Tab('md_editor', \Alxarafe\Lib\Trans::_('editor'), 'fas fa-edit', [
                    new Textarea('test_markdown', '', [
                        'rows' => 15,
                        'col' => 'col-12',
                        'value' => $mdContent // Initial value
                    ])
                ]),
                new Tab('md_preview', \Alxarafe\Lib\Trans::_('preview'), 'fas fa-eye', [
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
