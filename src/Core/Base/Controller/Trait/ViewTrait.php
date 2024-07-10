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
    public static $messages = [];
    /**
     * Theme name. TODO: Has to be updated according to the configuration.
     *
     * @var string
     */
    public $theme;
    /**
     * Code lang for <html lang> tag
     *
     * @var string
     */
    public $lang = 'en';
    public $body_class;
    public $templatesPath;
    public $template;
    public $title;
    public $alerts;

    public static function _($message, array $parameters = [], $locale = null)
    {
        return Trans::_($message, $parameters, $locale);
    }

    public static function addMessage($message)
    {
        self::$messages[]['success'] = $message;
    }

    public static function addAdvice($message)
    {
        self::$messages[]['warning'] = $message;
    }

    public static function addError($message)
    {
        self::$messages[]['danger'] = $message;
    }

    public function __destruct()
    {
        if (!isset($this->template)) {
            return;
        }

        if (!isset($this->theme)) {
            $this->theme = 'alxarafe';
        }

        if (!isset($this->title)) {
            $this->title = 'Alxarafe';
        }

        $this->alerts = static::getMessages();

        $vars = ['me' => $this];
        $viewPaths = [
            constant('APP_PATH') . '/Templates',
            constant('APP_PATH') . '/Templates/theme/' . $this->theme,
            constant('APP_PATH') . '/Templates/common',
            constant('ALX_PATH') . '/Templates',
            constant('ALX_PATH') . '/Templates/theme/' . $this->theme,
            constant('ALX_PATH') . '/Templates/common',
        ];

        if (isset($this->templatesPath)) {
            array_unshift($viewPaths, $this->templatesPath);
        }

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

        $viewFactory = $container['view'];

        echo $viewFactory->make($this->template, $vars)->render();
    }

    public static function getMessages()
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

    public function getTemplatesPath(): string
    {
        return $this->templatesPath;
    }

    public function setTemplatesPath(string $path)
    {
        $this->templatesPath = $path;
    }
}
