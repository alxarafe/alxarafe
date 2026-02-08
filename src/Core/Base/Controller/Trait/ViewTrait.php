<?php

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

declare(strict_types=1);

namespace Alxarafe\Base\Controller\Trait;

use Alxarafe\Base\Template;

/**
 * Trait ViewTrait.
 *
 * Provides template management and view variable injection for controllers.
 */
trait ViewTrait
{
    /**
     * Instance of the template engine.
     */
    public ?Template $template = null;

    /**
     * Array of variables to be passed to the view.
     */
    protected array $viewData = [];

    /**
     * @var bool If true, enables protection against unsaved changes (warns on exit).
     */
    public bool $protectChanges = false;

    /**
     * Sets the default template for the controller.
     */
    /**
     * Sets the default template for the controller.
     */
    public function setDefaultTemplate(?string $templateName = null): void
    {
        if ($this->template === null) {
            $this->template = new Template($templateName);
        } else {
            $this->template->setTemplateName($templateName);
        }
    }

    /**
     * Adds a variable to be accessible in the view.
     *
     * @param string $name Variable name.
     * @param mixed $value Variable value.
     */
    public function addVariable(string $name, mixed $value): void
    {
        $this->viewData[$name] = $value;
    }

    /**
     * Bulk adds variables to the view data.
     */
    public function addVariables(array $variables): void
    {
        $this->viewData = array_merge($this->viewData, $variables);
    }

    /**
     * Sets the paths where templates are located.
     */
    public function setTemplatesPath(array $paths): void
    {
        if ($this->template === null) {
            $this->setDefaultTemplate();
        }
        $this->template->setPaths($paths);
    }

    /**
     * Renders a specific view file within the current template.
     */
    public function render(?string $viewPath = null): string
    {
        if ($this->template === null) {
            $this->setDefaultTemplate();
        }

        return $this->template->render($viewPath, $this->viewData);
    }
}
