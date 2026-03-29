<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * Backward-compatibility aliases for the Alxarafe Hexagonal restructuring.
 */

declare(strict_types=1);

// Base classes
class_alias(\Alxarafe\Infrastructure\Persistence\Database::class, 'Alxarafe\Base\Database');
class_alias(\Alxarafe\Infrastructure\Persistence\Config::class, 'Alxarafe\Base\Config');
class_alias(\Alxarafe\Infrastructure\Persistence\Model\Model::class, 'Alxarafe\Base\Model\Model');
class_alias(\Alxarafe\Infrastructure\Persistence\Seeder::class, 'Alxarafe\Base\Seeder');
class_alias(\Alxarafe\Infrastructure\Persistence\Template::class, 'Alxarafe\Base\Template');

// Controllers
class_alias(\Alxarafe\Infrastructure\Http\Controller\Controller::class, 'Alxarafe\Base\Controller\Controller');
class_alias(\Alxarafe\Infrastructure\Http\Controller\GenericController::class, 'Alxarafe\Base\Controller\GenericController');
class_alias(\Alxarafe\Infrastructure\Http\Controller\ViewController::class, 'Alxarafe\Base\Controller\ViewController');
class_alias(\Alxarafe\Infrastructure\Http\Controller\ApiController::class, 'Alxarafe\Base\Controller\ApiController');
class_alias(\Alxarafe\Infrastructure\Http\Controller\ResourceController::class, 'Alxarafe\Base\Controller\ResourceController');
class_alias(\Alxarafe\Infrastructure\Http\Controller\GenericPublicController::class, 'Alxarafe\Base\Controller\GenericPublicController');
class_alias(\Alxarafe\Infrastructure\Http\Controller\PublicResourceController::class, 'Alxarafe\Base\Controller\PublicResourceController');

// Services
class_alias(\Alxarafe\Infrastructure\Service\MarkdownService::class, 'Alxarafe\Service\MarkdownService');

// Components → Infrastructure\Component\Fields
class_alias(\Alxarafe\Infrastructure\Component\Fields\Text::class, 'Alxarafe\Component\Fields\Text');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Integer::class, 'Alxarafe\Component\Fields\Integer');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Integer::class, 'Alxarafe\Component\Fields\Number');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Integer::class, 'Alxarafe\Component\Fields\Id');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Boolean::class, 'Alxarafe\Component\Fields\Boolean');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Date::class, 'Alxarafe\Component\Fields\Date');
class_alias(\Alxarafe\Infrastructure\Component\Fields\DateTime::class, 'Alxarafe\Component\Fields\DateTime');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Time::class, 'Alxarafe\Component\Fields\Time');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Decimal::class, 'Alxarafe\Component\Fields\Decimal');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Select::class, 'Alxarafe\Component\Fields\Select');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Select2::class, 'Alxarafe\Component\Fields\Select2');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Textarea::class, 'Alxarafe\Component\Fields\Textarea');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Hidden::class, 'Alxarafe\Component\Fields\Hidden');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Icon::class, 'Alxarafe\Component\Fields\Icon');
class_alias(\Alxarafe\Infrastructure\Component\Fields\Image::class, 'Alxarafe\Component\Fields\Image');
class_alias(\Alxarafe\Infrastructure\Component\Fields\StaticText::class, 'Alxarafe\Component\Fields\StaticText');
class_alias(\Alxarafe\Infrastructure\Component\Fields\RelationList::class, 'Alxarafe\Component\Fields\RelationList');

// Components → Infrastructure\Component\Container
class_alias(\Alxarafe\Infrastructure\Component\Container\AbstractContainer::class, 'Alxarafe\Component\Container\AbstractContainer');
class_alias(\Alxarafe\Infrastructure\Component\Container\TabGroup::class, 'Alxarafe\Component\Container\TabGroup');
class_alias(\Alxarafe\Infrastructure\Component\Container\Tab::class, 'Alxarafe\Component\Container\Tab');
class_alias(\Alxarafe\Infrastructure\Component\Container\Row::class, 'Alxarafe\Component\Container\Row');
class_alias(\Alxarafe\Infrastructure\Component\Container\Panel::class, 'Alxarafe\Component\Container\Panel');
class_alias(\Alxarafe\Infrastructure\Component\Container\Separator::class, 'Alxarafe\Component\Container\Separator');
class_alias(\Alxarafe\Infrastructure\Component\Container\HtmlContent::class, 'Alxarafe\Component\Container\HtmlContent');

// Components → Infrastructure\Component\Fields
class_alias(\Alxarafe\Infrastructure\Component\AbstractField::class, 'Alxarafe\Component\Fields\AbstractField');

// Components → Infrastructure\Component\Filter
class_alias(\Alxarafe\Infrastructure\Component\AbstractFilter::class, 'Alxarafe\Component\Filter\AbstractFilter');
class_alias(\Alxarafe\Infrastructure\Component\Filter\TextFilter::class, 'Alxarafe\Component\Filter\TextFilter');
class_alias(\Alxarafe\Infrastructure\Component\Filter\SelectFilter::class, 'Alxarafe\Component\Filter\SelectFilter');
class_alias(\Alxarafe\Infrastructure\Component\Filter\Select2Filter::class, 'Alxarafe\Component\Filter\Select2Filter');
class_alias(\Alxarafe\Infrastructure\Component\Filter\RelationFilter::class, 'Alxarafe\Component\Filter\RelationFilter');
class_alias(\Alxarafe\Infrastructure\Component\Filter\DateRangeFilter::class, 'Alxarafe\Component\Filter\DateRangeFilter');
class_alias(\Alxarafe\Infrastructure\Component\Filter\AutocompleteFilter::class, 'Alxarafe\Component\Filter\AutocompleteFilter');

// Enums → Infrastructure\Component\Enum
class_alias(\Alxarafe\Infrastructure\Component\Enum\ActionPosition::class, 'Alxarafe\Component\Enum\ActionPosition');

// Attributes
class_alias(\Alxarafe\Infrastructure\Attribute\Menu::class, 'Alxarafe\Attribute\Menu');
class_alias(\Alxarafe\Infrastructure\Attribute\ApiRoute::class, 'Alxarafe\Attribute\ApiRoute');

// Lib
class_alias(\Alxarafe\Infrastructure\Auth\Auth::class, 'Alxarafe\Lib\Auth');
class_alias(\Alxarafe\Infrastructure\Http\Router::class, 'Alxarafe\Lib\Router');
class_alias(\Alxarafe\Infrastructure\Http\Routes::class, 'Alxarafe\Lib\Routes');
class_alias(\Alxarafe\Infrastructure\Lib\Functions::class, 'Alxarafe\Lib\Functions');
class_alias(\Alxarafe\Infrastructure\Lib\Messages::class, 'Alxarafe\Lib\Messages');
class_alias(\Alxarafe\Infrastructure\Lib\Trans::class, 'Alxarafe\Lib\Trans');

// Tools
class_alias(\Alxarafe\Infrastructure\Tools\Debug::class, 'Alxarafe\Tools\Debug');
class_alias(\Alxarafe\Infrastructure\Tools\Dispatcher\WebDispatcher::class, 'Alxarafe\Tools\Dispatcher\WebDispatcher');

// Traits (Required for internal controller compatibility)
class_alias(\Alxarafe\Infrastructure\Http\Controller\Trait\ViewTrait::class, 'Alxarafe\Base\Controller\Trait\ViewTrait');
class_alias(\Alxarafe\Infrastructure\Http\Controller\Trait\DbTrait::class, 'Alxarafe\Base\Controller\Trait\DbTrait');
class_alias(\Alxarafe\Infrastructure\Http\Controller\Trait\ResourceTrait::class, 'Alxarafe\Base\Controller\Trait\ResourceTrait');

// Interfaces
class_alias(\Alxarafe\Infrastructure\Http\Controller\Interface\ResourceInterface::class, 'Alxarafe\Base\Controller\Interface\ResourceInterface');

/**
 * Temporary PSR-4 Autoloader for Modules namespace during migration.
 * This compensates for the lack of a composer dump-autoload.
 */
spl_autoload_register(function ($class) {
    // 1. Handle Modules namespace
    if (str_starts_with($class, 'Modules\\')) {
        $relativeClass = substr($class, 8);
        $file = str_replace('\\', '/', $relativeClass) . '.php';
        
        // Try Framework Modules (src/Modules)
        $frameworkFile = __DIR__ . '/../../Modules/' . $file;
        if (file_exists($frameworkFile)) {
            require_once $frameworkFile;
            return;
        }
        
        // Try Application Modules (skeleton/Modules)
        if (defined('APP_PATH')) {
            $appFile = constant('APP_PATH') . '/Modules/' . $file;
            if (file_exists($appFile)) {
                require_once $appFile;
                return;
            }
        }
    }

    // 2. Handle Alxarafe\Infrastructure namespace (Backup for Composer)
    if (str_starts_with($class, 'Alxarafe\\Infrastructure\\')) {
        $relativeClass = substr($class, 24);
        $file = __DIR__ . '/../' . str_replace('\\', '/', $relativeClass) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
        // error_log("DEBUG ALX: Failed to find file for $class -> $file");
    }
});
