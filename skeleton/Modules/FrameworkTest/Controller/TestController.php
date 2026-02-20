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
        return [
            new Panel('Información Básica', [
                new Text('name', 'Nombre del Test', [
                    'required' => true,
                    'help' => 'Introduce un nombre descriptivo',
                    'placeholder' => 'Ej: Prueba de componentes 2026'
                ]),
                new Textarea('description', 'Descripción Detallada', [
                    'placeholder' => 'Escribe aquí una descripción larga...',
                    'rows' => 4
                ]),
            ], ['col' => 'col-md-8']),

            new Panel('Configuración', [
                new Boolean('active', '¿Está activo?', ['default' => true]),
                new Icon('icon', 'Icono de referencia', [], ['default' => 'fas fa-star']),
                new Select('type', 'Tipo de Elemento', [
                    'admin' => 'Administración',
                    'user' => 'Usuario',
                    'guest' => 'Invitado'
                ]),
            ], ['col' => 'col-md-4']),

            new Panel('Datos Numéricos', [
                new Integer('integer', 'Valor Entero', [
                    'min' => 0,
                    'max' => 100,
                    'help' => 'Un número entre 0 y 100'
                ]),
                new Decimal('decimal', 'Valor Decimal', [
                    'precision' => 2,
                    'help' => 'Ej: 123.45'
                ]),
            ], ['col' => 'col-md-6']),

            new Panel('Fechas y Horas', [
                new Date('date', 'Fecha de Registro'),
                new DateTime('datetime', 'Sello de Tiempo Completo'),
                new Time('time', 'Hora Especificada'),
            ], ['col' => 'col-md-6']),

            new Panel('Selectis Avanzados', [
                new Select2('category_id', 'Categoría (Select2)', [
                    1 => 'Categoría A',
                    2 => 'Categoría B',
                    3 => 'Categoría C'
                ], [
                    'multiple' => false,
                    'help' => 'Buscador mejorado con Select2'
                ]),
                new StaticText('Este es un texto estático que no se puede editar, pero se muestra en el formulario.', [
                    'icon' => 'fas fa-info-circle'
                ]),
                new Image('https://via.placeholder.com/150', 'Imagen de Ejemplo', [
                    'help' => 'Visualizador de imagen (si el modelo tiene la URL)',
                    'width' => 150
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
     * Ensure the test page has a nice title.
     */
    protected function beforeConfig()
    {
        $this->title = 'Framework Components Showcase';
    }

    /**
     * Override integrity check to allow demo without a real database table.
     */
    protected function checkTableIntegrity()
    {
        // No-op for demo
    }
}
