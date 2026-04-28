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

namespace Alxarafe\Infrastructure\Http\Controller;

use Alxarafe\Infrastructure\Adapter\AlxarafeHookAdapter;
use Alxarafe\Infrastructure\Adapter\AlxarafeMessageBag;
use Alxarafe\Infrastructure\Adapter\AlxarafeTranslator;
use Alxarafe\ResourceController\Contracts\HookContract;
use Alxarafe\ResourceController\Contracts\MessageBagContract;
use Alxarafe\ResourceController\Contracts\RepositoryContract;
use Alxarafe\ResourceController\Contracts\TransactionContract;
use Alxarafe\ResourceController\Contracts\TranslatorContract;
use Alxarafe\ResourceController\ResourceInterface;
use Alxarafe\ResourceController\Trait\ResourceTrait;
use Alxarafe\ResourceEloquent\EloquentRepository;
use Alxarafe\ResourceEloquent\EloquentTransaction;

/**
 * Class PublicResourceController
 *
 * Public version of ResourceController.
 * Extends GenericPublicController (No Auth required).
 */
abstract class PublicResourceController extends GenericPublicController implements ResourceInterface
{
    use ResourceTrait;
    use \Alxarafe\Infrastructure\Http\Controller\Trait\AlxarafeResourceBridgeTrait;

    private AlxarafeTranslator $alxTranslator;
    private AlxarafeMessageBag $alxMessages;
    private AlxarafeHookAdapter $alxHooks;
    private EloquentTransaction $alxTransaction;

    /**
     * Eager loading relationships for the repository.
     * @var array
     */
    protected array $with = [];

    public function __construct()
    {
        $this->alxTranslator = new AlxarafeTranslator();
        $this->alxMessages = new AlxarafeMessageBag();
        $this->alxHooks = new AlxarafeHookAdapter();
        $this->alxTransaction = new EloquentTransaction();

        parent::__construct();
    }

    protected function getTranslator(): TranslatorContract
    {
        return $this->alxTranslator;
    }

    protected function getMessages(): MessageBagContract
    {
        return $this->alxMessages;
    }

    protected function getHooks(): HookContract
    {
        return $this->alxHooks;
    }

    protected function getTransaction(): TransactionContract
    {
        return $this->alxTransaction;
    }

    public static function url(string $action = 'index', array $params = []): string
    {
        $baseUrl = 'index.php?module=' . static::getModuleName() . '&controller=' . static::getControllerName();
        if ($action && $action !== 'index') {
            $baseUrl .= '&action=' . $action;
        }
        foreach ($params as $k => $v) {
            $baseUrl .= '&' . $k . '=' . urlencode((string)$v);
        }
        return $baseUrl;
    }

    public function doIndex(): bool
    {
        $this->privateCore();
        return true;
    }

    public function doSave(): bool
    {
        $this->privateCore();
        return true;
    }

    public function doDelete(): bool
    {
        $this->privateCore();
        return true;
    }

    public function doCreate(): bool
    {
        $this->privateCore();
        return true;
    }

    protected function getRepository(string $tabId = 'default'): RepositoryContract
    {
        return new EloquentRepository($this->getModelClassName(), $this->with);
    }

    /**
     * @return string
     */
    abstract protected function getModelClassName(): string;
}
