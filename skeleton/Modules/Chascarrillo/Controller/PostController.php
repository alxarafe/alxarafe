<?php

namespace Modules\Chascarrillo\Controller;

use Alxarafe\Base\Controller\ResourceController;
use Modules\Chascarrillo\Model\Post;

class PostController extends ResourceController
{
    public static function getModuleName(): string
    {
        return 'Chascarrillo';
    }

    public static function getControllerName(): string
    {
        return 'Post';
    }

    protected function getModelClass(): array
    {
        return [
            'general' => Post::class,
        ];
    }

    protected function getListColumns(): array
    {
        return [
            'id',
            'title',
            'slug',
            'is_published' => [
                'type' => 'boolean',
                'label' => 'Publicado'
            ],
            'published_at' => [
                'type' => 'datetime',
                'label' => 'Fecha de Publicación'
            ],
        ];
    }

    protected function getEditFields(): array
    {
        return [
            'id' => ['readonly' => true],
            'title',
            'slug',
            'is_published' => ['type' => 'boolean', 'label' => 'Publicado'],
            'published_at' => ['type' => 'datetime', 'label' => 'Fecha de Publicación'],
            'content' => ['type' => 'textarea', 'multiline' => true, 'rows' => 10],
            'created_at' => ['readonly' => true],
        ];
    }
}
