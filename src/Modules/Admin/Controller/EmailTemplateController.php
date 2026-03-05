<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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

namespace CoreModules\Admin\Controller;

use Alxarafe\Attribute\Menu;
use Alxarafe\Base\Controller\ResourceController;

/**
 * Class EmailTemplateController.
 *
 * CRUD controller for managing email templates.
 * Each template has a unique code, subject, body (with {variable} placeholders),
 * and a list of available variables.
 */
#[Menu(menu: 'main_menu', label: 'Email Templates', icon: 'fas fa-envelope-open-text', order: 75, parent: HomeController::class)]
class EmailTemplateController extends ResourceController
{
    protected function getModelClass()
    {
        return \CoreModules\Admin\Model\EmailTemplate::class;
    }
}
