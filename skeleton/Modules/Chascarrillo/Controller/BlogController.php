<?php

namespace Modules\Chascarrillo\Controller;

use Alxarafe\Base\Controller\GenericPublicController;
use Modules\Chascarrillo\Model\Post;
use Alxarafe\Attribute\Menu;

#[Menu(
    menu: 'main_menu',
    label: 'Ver Chascarrillos',
    icon: 'fas fa-newspaper',
    order: 41,
    visibility: 'public',
    url: 'index.php?module=Chascarrillo&controller=Blog&action=index'
)]
class BlogController extends GenericPublicController
{
    public static function getModuleName(): string
    {
        return 'Chascarrillo';
    }

    public static function getControllerName(): string
    {
        return 'Blog';
    }

    public function doIndex(): bool
    {
        $this->title = 'Chascarrillo Blog';

        $posts = Post::where('is_published', true)
            ->where('published_at', '<=', date('Y-m-d H:i:s'))
            ->orderBy('published_at', 'DESC')
            ->get();

        $this->addVariable('posts', $posts);

        return true;
    }

    public function doShow(): bool
    {
        $slug = $_GET['slug'] ?? '';

        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (!$post) {
            \Alxarafe\Lib\Functions::httpRedirect(\CoreModules\Admin\Controller\ErrorController::url(true));
            return false;
        }

        $this->title = $post->title;
        $this->addVariable('post', $post);

        return true;
    }
}
