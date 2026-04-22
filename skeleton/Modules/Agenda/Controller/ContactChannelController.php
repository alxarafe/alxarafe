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

namespace Modules\Agenda\Controller;

use Alxarafe\Infrastructure\Http\Controller\PublicResourceController;
use Alxarafe\Infrastructure\Attribute\Menu;
use Alxarafe\ResourceController\Component\Fields\Text;
use Alxarafe\ResourceController\Component\Fields\Icon;
use Alxarafe\Infrastructure\Lib\Trans;
use Modules\Agenda\Model\ContactChannel;

/**
 * Controller for managing communication channel types (master data).
 */
#[Menu(
    menu: 'main_menu',
    label: 'channels',
    icon: 'fas fa-phone-alt',
    order: 2,
    parent: 'agenda',
    visibility: 'public'
)]
class ContactChannelController extends PublicResourceController
{
    #[\Override]
    public static function getModuleName(): string
    {
        return 'Agenda';
    }

    #[\Override]
    public static function getControllerName(): string
    {
        return 'ContactChannel';
    }

    #[\Override]
    protected function getModelClass(): string|array
    {
        return ContactChannel::class;
    }

    #[\Override]
    protected function getListColumns(): array
    {
        return [
            new \Alxarafe\ResourceController\Component\Fields\Icon('icon', Trans::_('icon')),
            new Text('name', Trans::_('channel_name')),
        ];
    }

    #[\Override]
    protected function getEditFields(): array
    {
        return [
            new Text('name', Trans::_('channel_name'), [
                'required' => true,
                'placeholder' => Trans::_('channel_name_placeholder'),
            ]),
            new Icon('icon', Trans::_('icon'), [
                'help' => Trans::_('icon_help'),
            ]),
        ];
    }
}
