<?php

namespace Alxarafe\Base\Controller;

use Alxarafe\Base\Controller\Trait\ResourceTrait;

/**
 * Class ResourceController
 *
 * Unified controller for Listing and Editing resources.
 * Extends standard Controller (Private).
 */
abstract class ResourceController extends Controller implements ResourceInterface
{
    use ResourceTrait;
}
