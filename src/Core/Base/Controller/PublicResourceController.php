<?php

namespace Alxarafe\Base\Controller;

use Alxarafe\Base\Controller\Trait\ResourceTrait;

/**
 * Class PublicResourceController
 *
 * Public version of ResourceController.
 * Extends GenericPublicController (No Auth required).
 */
abstract class PublicResourceController extends GenericPublicController implements ResourceInterface
{
    use ResourceTrait;
}
