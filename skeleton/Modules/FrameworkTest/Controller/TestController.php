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

#[Menu(
    menu: 'main_menu',
    label: 'Prueba Framework',
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
        $this->title = 'Alxarafe Components Showcase';
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
                ['label' => 'Guardar Demo', 'icon' => 'fas fa-save', 'type' => 'primary', 'action' => 'submit', 'name' => 'save'],
                ['label' => 'Limpiar Cache', 'icon' => 'fas fa-broom', 'type' => 'warning', 'action' => 'submit', 'name' => 'clearCache'],
            ],
            'body' => new TabGroup([
                new Tab('components', '🧩 Componentes', 'fas fa-puzzle-piece', $this->buildComponentsPanels()),
                new Tab('nesting', '📦 Paneles Anidados', 'fas fa-boxes-stacked', $this->buildNestingPanels()),
                new Tab('markdown', '📝 Markdown', 'fab fa-markdown', $this->buildMarkdownPanels()),
            ]),
        ];
    }

    // ─── Tab 1: Componentes ────────────────────────

    protected function buildComponentsPanels(): array
    {
        // Name with a magic action
        $nameField = new Text('name', 'Nombre del Recurso', [
            'required' => true,
            'help' => 'Introduce un nombre descriptivo para este objeto de prueba',
            'placeholder' => 'Ej: Mi Primer Componente'
        ]);
        $nameField->addAction('fas fa-magic', "this.closest('.input-group').querySelector('input').value = 'Alxarafe ' + Math.floor(Math.random() * 1000);", 'Generar', 'btn-outline-primary', ActionPosition::Left);

        // Integer with utility buttons
        $intField = new Integer('integer', 'Valor de Control', [
            'min' => 0,
            'max' => 1000,
            'help' => 'Un número entero entre 0 y 1000'
        ]);
        $intField->addAction('fas fa-minus', "const i = this.closest('.input-group').querySelector('input'); i.value = Math.max(0, parseInt(i.value || 0) - 10);", '-10', 'btn-outline-secondary', ActionPosition::Left);
        $intField->addAction('fas fa-plus', "const i = this.closest('.input-group').querySelector('input'); i.value = Math.min(1000, parseInt(i.value || 0) + 10);", '+10', 'btn-outline-secondary', ActionPosition::Right);

        // Decimal with Currency
        $decimalField = new Decimal('decimal', 'Presupuesto Estimado', [
            'precision' => 2,
            'help' => 'Se formatea automáticamente con dos decimales'
        ]);
        $decimalField->addAction('fas fa-euro-sign', '', 'Moneda', 'btn-dark disabled', ActionPosition::Left);

        return [
            new Panel('⚙️ Configuración Principal', [
                $nameField,
                new Textarea('description', 'Descripción Técnica', [
                    'placeholder' => 'Detalla aquí las especificaciones...',
                    'rows' => 3
                ]),
                new Boolean('active', 'Estado de Publicación', [
                    'help' => 'Define si este elemento es visible en el frontend'
                ]),
            ], ['col' => 'col-md-7', 'class' => 'shadow-lg border-primary']),

            new Panel('🎨 Estética y Visualización', [
                new Icon('icon', 'Icono Representativo', [
                    'help' => 'Selecciona un icono de FontAwesome'
                ], ['default' => 'fas fa-rocket']),
                new Select('type', 'Clasificación de Objeto', [
                    'core' => 'Núcleo del Sistema',
                    'plugin' => 'Extensión / Plugin',
                    'theme' => 'Estilo Visual / Tema'
                ]),
                new StaticText('Este es un texto informativo que utiliza el componente StaticText para guiar al usuario sin permitir edición.', [
                    'icon' => 'fas fa-lightbulb text-warning'
                ]),
            ], ['col' => 'col-md-5']),

            new Panel('🔢 Datos Cuantitativos', [
                $intField,
                $decimalField,
            ], ['col' => 'col-md-6', 'class' => 'border-info shadow-sm']),

            new Panel('📅 Cronología', [
                new Date('date', 'Fecha de Hito'),
                new DateTime('datetime', 'Registro de Auditoría'),
                new Time('time', 'Apertura de Ventana'),
            ], ['col' => 'col-md-6']),

            new Panel('🚀 Avanzado y Multimedia', [
                new Select2('category_id', 'Etiquetas Globales (Select2)', [
                    1 => 'Tecnología',
                    2 => 'Diseño',
                    3 => 'Arquitectura',
                    4 => 'Frontend',
                    5 => 'Backend'
                ], [
                    'help' => 'Buscador asíncrono mejorado con soporte para etiquetas'
                ]),
                new Image('https://images.unsplash.com/photo-1614850523296-d8c1af93d400?auto=format&fit=crop&w=300&q=80', 'Previsualización de Branding', [
                    'width' => '100%',
                    'help' => 'Componente Image para previsualizar activos'
                ]),
            ], ['col' => 'col-md-12']),

            // --- Hidden field ---
            new Hidden('_token', 'CSRF Token'),

            // --- Separator (plain) ---
            new Separator(),

            // --- Separator (labeled) ---
            new Separator('Campos con Row (sin card)'),

            // --- Row: fields side by side, no card ---
            new Row([
                new Text('contact_first', 'Nombre de contacto', ['col' => 'col-md-4']),
                new Text('contact_last', 'Apellido de contacto', ['col' => 'col-md-4']),
                new Text('contact_email', 'Email de contacto', ['col' => 'col-md-4']),
            ], ['col' => 'col-12', 'class' => 'mb-3']),

            // --- Row with mixed field types ---
            new Row([
                new Date('row_date', 'Fecha', ['col' => 'col-md-3']),
                new Time('row_time', 'Hora', ['col' => 'col-md-3']),
                new Boolean('row_active', 'Activo', ['col' => 'col-md-3']),
                new Integer('row_priority', 'Prioridad', ['col' => 'col-md-3']),
            ], ['col' => 'col-12']),
        ];
    }

    // ─── Tab 2: Paneles Anidados ───────────────────

    protected function buildNestingPanels(): array
    {
        return [
            new Panel('🏢 Empresa Matriz', [
                new Text('company_name', 'Nombre de Empresa', [
                    'help' => 'Campo de nivel superior'
                ]),

                // ----- Panel Nivel 1 -----
                new Panel('📍 Dirección Fiscal', [
                    new Text('address_street', 'Calle'),
                    new Text('address_city', 'Ciudad'),
                    new Text('address_zip', 'Código Postal', ['col' => 'col-md-4']),
                    new Select('address_country', 'País', [
                        'ES' => 'España',
                        'FR' => 'Francia',
                        'DE' => 'Alemania',
                        'IT' => 'Italia',
                    ], ['col' => 'col-md-4']),

                    // ----- Panel Nivel 2 -----
                    new Panel('📞 Contacto Principal', [
                        new Text('contact_phone', 'Teléfono', ['col' => 'col-md-6']),
                        new Text('contact_email', 'Email', ['col' => 'col-md-6', 'type' => 'email']),
                        new Boolean('contact_gdpr', 'Acepta RGPD'),
                    ], ['col' => 'col-12']),

                ], ['col' => 'col-12']),

                new StaticText('↑ El panel "Dirección Fiscal" contiene un sub-panel "Contacto Principal". Esto demuestra paneles anidados en 3 niveles.', [
                    'icon' => 'fas fa-info-circle text-info'
                ]),
            ], ['col' => 'col-12', 'class' => 'border-warning']),

            new Panel('🔧 Configuración Avanzada', [
                new Panel('🔒 Seguridad', [
                    new Boolean('two_factor', 'Autenticación 2FA'),
                    new Select('session_timeout', 'Tiempo de Sesión', [
                        '15' => '15 minutos',
                        '30' => '30 minutos',
                        '60' => '1 hora',
                        '120' => '2 horas',
                    ]),
                ], ['col' => 'col-12']),
            ], ['col' => 'col-md-6']),

            new Panel('📊 Métricas', [
                new Integer('users_count', 'Usuarios Activos'),
                new Decimal('monthly_revenue', 'Ingresos Mensuales', ['precision' => 2]),
                new Date('last_audit', 'Última Auditoría'),
            ], ['col' => 'col-md-6']),
        ];
    }

    // ─── Tab 3: Markdown ───────────────────────────

    protected function buildMarkdownPanels(): array
    {
        $contentHtml = '<div class="alert alert-warning">No se encontró el archivo test_markdown.md</div>';

        try {
            $filePath = defined('APP_PATH')
                ? APP_PATH . '/data/test_markdown.md'
                : __DIR__ . '/../../../data/test_markdown.md';

            if (file_exists($filePath)) {
                $parsed = MarkdownService::parse($filePath);
                $contentHtml = MarkdownService::render($parsed['content']);
            }
        } catch (\Exception $e) {
            $contentHtml = '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }

        return [
            new HtmlContent($contentHtml, '📄 Documento Renderizado', ['col' => 'col-12']),
        ];
    }

    // ─── Demo Data ─────────────────────────────────

    protected function getDemoData(): array
    {
        return [
            'name' => 'Alxarafe Showcase 2026',
            'description' => 'Este es un ejemplo de cómo Alxarafe maneja formularios complejos con paneles y componentes modernizados.',
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
