<?php

namespace Modules\Chascarrillo\Controller;

use Alxarafe\Base\Controller\GenericPublicController;
use Modules\Chascarrillo\Model\Post;

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
            ->orderBy('published_at', 'desc')
            ->get();

        $this->addVariable('posts', $posts);

        // Template should be automatically inferred as 'Blog/index' 
        // if ViewTrait logic assumes Controller/Method
        // But explicitly setting it is safer if unsure.
        // setDefaultTemplate() might have set it to 'Chascarrillo/Blog/index'?
        return true;
    }

    public function doShow(): bool
    {
        $slug = $_GET['slug'] ?? '';

        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (!$post) {
            \Alxarafe\Lib\Functions::httpRedirect(\CoreModules\Admin\Controller\Error404Controller::url(true));
            return false;
        }

        $this->title = $post->title;
        $this->addVariable('post', $post);

        // Template: Blog/show
        return true;
    }
}
