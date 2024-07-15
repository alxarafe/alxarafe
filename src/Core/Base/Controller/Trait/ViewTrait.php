<?php

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Base\Controller\Trait;

use Alxarafe\Lib\Trans;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;
use Illuminate\View\Compilers\BladeCompiler;

trait ViewTrait
{
    /**
     * Contains messages, advices and errors pending to be shown.
     *
     * @var array
     */
    public static array $messages = [];

    /**
     * Theme name.
     *
     * @var string
     */
    public static string $theme = '';

    /**
     * Template routes added by modules.
     *
     * @var array
     */
    public static array $templatesPath = [];

    /**
     * Contains the name of the blade template to print
     *
     * @var string
     */
    public string $template;

    /**
     * Contains the title of the view.
     *
     * @var string
     */
    public string $title;

    /**
     * Contains an array with the messages to be displayed, indicating the
     * type (message, advice or error) and the text to be displayed.
     *
     * @var array
     */
    public array $alerts;

    /**
     * Shows a translated text
     *
     * @param $message
     * @param array $parameters
     * @param $locale
     * @return string
     */
    public static function _($message, array $parameters = [], $locale = null): string
    {
        return Trans::_($message, $parameters, $locale);
    }

    /**
     * Add a new message (success) to show the user
     *
     * @param $message
     * @return void
     */
    public static function addMessage($message): void
    {
        self::$messages[]['success'] = $message;
    }

    /**
     * Add a new advice (warning) to show the user
     *
     * @param $message
     * @return void
     */
    public static function addAdvice($message): void
    {
        self::$messages[]['warning'] = $message;
    }

    /**
     * Add a new error (danger) to show the user
     *
     * @param $message
     * @return void
     */
    public static function addError($message): void
    {
        self::$messages[]['danger'] = $message;
    }

    /**
     * Upon completion of the controller execution, the template is displayed.
     */
    public function __destruct()
    {
        if (!isset($this->template)) {
            return;
        }

        if (!isset(self::$theme)) {
            self::$theme = 'alxarafe';
        }

        if (!isset($this->title)) {
            $this->title = 'Alxarafe';
        }

        $this->alerts = self::getMessages();

        $container = self::getContainer();

        $viewFactory = $container['view'];

        echo $viewFactory->make($this->template, ['me' => $this])->render();
    }

    /**
     * Generates an array with the messages to be displayed, indicating the
     * type (message, advice or error) and the text to be displayed.
     *
     * @return array
     */
    private static function getMessages(): array
    {
        $alerts = [];
        foreach (self::$messages as $message) {
            foreach ($message as $type => $text) {
                $alerts[] = [
                    'type' => $type,
                    'text' => $text
                ];
            }
        }
        self::$messages = [];
        return $alerts;
    }

    /**
     * Set up and return a service container configured for Blade template rendering.
     *
     * This function initializes and configures an Illuminate\Container\Container instance
     * with the necessary services and dependencies required for Blade templating.
     * It sets up the file system, view finder, Blade compiler, view engine resolver,
     * and view factory services. It ensures that the cache directory for compiled
     * Blade templates exists and is writable.
     *
     * @return Container|null Configured service container for Blade rendering.
     */
    private static function getContainer(): ?Container
    {
        $viewPaths = self::getViewPaths();

        $cachePaths = realpath(constant('BASE_PATH') . '/..') . '/tmp/blade';
        if (!is_dir($cachePaths) && !mkdir($cachePaths, 0777, true) && !is_dir($cachePaths)) {
            die('Could not create cache directory for templates: ' . $cachePaths);
        }

        $container = new Container();

        $container->singleton('files', function () {
            return new Filesystem();
        });

        $container->singleton('view.finder', function ($app) use ($viewPaths) {
            return new FileViewFinder($app['files'], $viewPaths);
        });

        $container->singleton('blade.compiler', function ($app) use ($cachePaths) {
            return new BladeCompiler($app['files'], $cachePaths);
        });

        $container->singleton('view.engine.resolver', function ($app) {
            $resolver = new EngineResolver();

            // Register Blade engine
            $resolver->register('blade', function () use ($app) {
                return new CompilerEngine($app['blade.compiler']);
            });

            return $resolver;
        });

        $container->singleton('view', function ($app) {
            $resolver = $app['view.engine.resolver'];
            $finder = $app['view.finder'];
            $dispatcher = new Dispatcher($app);

            return new Factory($resolver, $finder, $dispatcher);
        });

        return $container;
    }

    /**
     * Returns the routes to the application templates.
     *
     * @return string[]
     */
    private static function getViewPaths(): array
    {
        $viewPaths = [
            constant('APP_PATH') . '/Templates',
            constant('APP_PATH') . '/Templates/theme/' . self::$theme,
            constant('APP_PATH') . '/Templates/common',
            constant('ALX_PATH') . '/Templates',
            constant('ALX_PATH') . '/Templates/theme/' . self::$theme,
            constant('ALX_PATH') . '/Templates/common',
        ];

        if (!empty(self::$templatesPath)) {
            $viewPaths = array_merge(self::$templatesPath, $viewPaths);
        }

        return $viewPaths;
    }

    /**
     * Sets a new path for the templates, prepending the current selection.
     *
     * @param array|string $path
     * @return void
     */
    public function setTemplatesPath(array|string $path): void
    {
        if (is_array($path)) {
            self::$templatesPath = array_merge($path, self::$templatesPath);
            return;
        }
        array_unshift(self::$templatesPath, $path);
    }
}
