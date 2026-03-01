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

namespace Alxarafe\Base\Frontend;

use Alxarafe\Component\Container\AbstractContainer;

/**
 * Unified Blade template generator.
 *
 * Converts a ViewDescriptor array into a Blade template string.
 *
 * The generated template is a thin wrapper (form, buttons, record extraction)
 * that delegates all rendering to the `body` component via its render() method.
 * Each container component (Panel, TabGroup, Tab, HtmlContent) uses its own
 * Blade template in templates/container/ for rendering.
 *
 * Usage:
 *   $generator = new TemplateGenerator();
 *   $blade     = $generator->generate($this->getViewDescriptor());
 *   file_put_contents($cacheFile, $blade);
 */
class TemplateGenerator
{
    /**
     * Generate a complete Blade template from a ViewDescriptor array.
     */
    public function generate(array $descriptor): string
    {
        $mode = $descriptor['mode'] ?? 'edit';

        if ($mode === 'edit') {
            return $this->generateEdit($descriptor);
        }

        return $this->generateList($descriptor);
    }

    // ──────────────────────────────────────────
    //  EDIT MODE
    // ──────────────────────────────────────────

    protected function generateEdit(array $descriptor): string
    {
        $out  = "@extends('partial.layout.main')\n\n";

        // --- Header actions (buttons) ---
        $out .= $this->generateHeaderActions($descriptor);

        // --- Content ---
        $out .= "@section('content')\n";
        $out .= "@php\n";
        $out .= "    \$_record = \$viewDescriptor['record'] ?? [];\n";
        $out .= "    \$record = is_object(\$_record) ? json_decode(json_encode(\$_record), true) : \$_record;\n";
        $out .= "@endphp\n\n";

        $out .= "<div class=\"container-fluid\">\n";

        // --- Form wrapper ---
        $out .= "<form method=\"{{ \$viewDescriptor['method'] ?? 'POST' }}\"\n";
        $out .= "      action=\"{{ \$viewDescriptor['action'] ?? '' }}\"\n";
        $out .= "      id=\"alxarafe-edit-form\">\n";
        $out .= "    <input type=\"hidden\" name=\"action\" value=\"save\">\n";
        $out .= "    @if(!empty(\$viewDescriptor['recordId']))\n";
        $out .= "        <input type=\"hidden\" name=\"id\" value=\"{{ \$viewDescriptor['recordId'] }}\">\n";
        $out .= "    @endif\n\n";

        // --- Body: delegate to component render() ---
        $out .= "    @if(\$viewDescriptor['body'] instanceof \\Alxarafe\\Component\\Container\\AbstractContainer)\n";
        $out .= "        {!! \$viewDescriptor['body']->render(['record' => \$record]) !!}\n";
        $out .= "    @endif\n\n";

        $out .= "</form>\n";
        $out .= "</div>\n";
        $out .= "@endsection\n";

        return $out;
    }

    /**
     * Generate @section('header_actions') with buttons.
     */
    protected function generateHeaderActions(array $descriptor): string
    {
        $out  = "@section('header_actions')\n";
        $out .= "@php \$buttons = \$viewDescriptor['buttons'] ?? []; @endphp\n";
        $out .= "@foreach(\$buttons as \$btn)\n";
        $out .= "    @if((\$btn['action'] ?? 'submit') === 'submit')\n";
        $out .= "        <button type=\"submit\" form=\"alxarafe-edit-form\"\n";
        $out .= "                name=\"{{ \$btn['name'] ?? '' }}\" value=\"{{ \$btn['name'] ?? '' }}\"\n";
        $out .= "                onclick=\"document.querySelector('#alxarafe-edit-form input[name=action]').value='{{ \$btn['name'] ?? 'save' }}'\"\n";
        $out .= "                class=\"btn btn-{{ \$btn['type'] ?? 'primary' }}\">\n";
        $out .= "            @if(!empty(\$btn['icon']))<i class=\"{{ \$btn['icon'] }} me-1\"></i>@endif\n";
        $out .= "            {{ \$btn['label'] ?? '' }}\n";
        $out .= "        </button>\n";
        $out .= "    @elseif((\$btn['action'] ?? '') === 'url')\n";
        $out .= "        <a href=\"{{ \$btn['target'] ?? '#' }}\"\n";
        $out .= "           class=\"btn btn-{{ \$btn['type'] ?? 'secondary' }}\">\n";
        $out .= "            @if(!empty(\$btn['icon']))<i class=\"{{ \$btn['icon'] }} me-1\"></i>@endif\n";
        $out .= "            {{ \$btn['label'] ?? '' }}\n";
        $out .= "        </a>\n";
        $out .= "    @endif\n";
        $out .= "@endforeach\n";
        $out .= "@endsection\n\n";
        return $out;
    }

    // ──────────────────────────────────────────
    //  LIST MODE (delegates to JS renderer)
    // ──────────────────────────────────────────

    protected function generateList(array $descriptor): string
    {
        $out  = "@extends('partial.layout.main')\n\n";

        $out .= "@section('header_actions')\n";
        $out .= "    <div class=\"btn-group me-2\" id=\"alxarafe-toolbar-left\"></div>\n";
        $out .= "    <div class=\"d-flex gap-2\" id=\"alxarafe-toolbar-right\"></div>\n";
        $out .= "@endsection\n\n";

        $out .= "@section('content')\n";
        $out .= "    <div id=\"alxarafe-resource-container\" class=\"mt-3\"></div>\n";
        $out .= "    <script src=\"/js/resource.bundle.js\"></script>\n";
        $out .= "    <script>\n";
        $out .= "        document.addEventListener('DOMContentLoaded', function() {\n";
        $out .= "            try {\n";
        $out .= "                var config = JSON.parse(atob(\"{{ \$me->viewConfig }}\"));\n";
        $out .= "                new AlxarafeResource.AlxarafeResource(document.getElementById('alxarafe-resource-container'), config);\n";
        $out .= "            } catch(e) { console.error(e); }\n";
        $out .= "        });\n";
        $out .= "    </script>\n";
        $out .= "@endsection\n";

        return $out;
    }
}
