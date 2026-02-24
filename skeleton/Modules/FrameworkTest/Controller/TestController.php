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
use Alxarafe\Component\Enum\ActionPosition;
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
     * Showcase all components in groups using Panels.
     */
    protected function getEditFields(): array
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
        $decimalField->addAction('fas fa-euro-sign', "", 'Moneda', 'btn-dark disabled', ActionPosition::Left);

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
        ];
    }

    /**
     * Define columns for the list view.
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

    /**
     * Override detectMode to always show the form as a showcase.
     */
    protected function detectMode()
    {
        $this->mode = self::MODE_EDIT;
        $this->recordId = 'demo';
        $this->protectChanges = false; // Disable warning for the demo
    }

    /**
     * Provide dummy data for the showcase.
     */
    protected function fetchRecordData(): array
    {
        return [
            'id' => 'demo',
            'data' => [
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
                'category_id' => 3
            ]
        ];
    }

    /**
     * Ensure the test page has a nice title.
     */
    protected function beforeConfig()
    {
        $this->title = 'Alxarafe Components Magic';
    }

    /**
     * Override integrity check to allow demo without a real database table.
     */
    protected function checkTableIntegrity()
    {
        // No-op for demo
    }
}
