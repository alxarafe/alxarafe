<?php

namespace Modules\Agenda\Api;

use Alxarafe\Base\Controller\ApiController;
use Modules\Agenda\Model\Person;

/**
 * Class PersonApiController.
 *
 * API Endpoint for managing Person resources.
 * This controller provides methods to retrieve person data via JSON API.
 *
 * @package Modules\Agenda\Api
 */
class PersonApiController extends ApiController
{
    /**
     * Retrieve a Person by ID.
     *
     * Fetches a person record from the database using the provided ID.
     * returns a 404 error if the person is not found.
     *
     * @param int $id The unique identifier of the person.
     *
     * @return never Outputs JSON response and terminates execution.
     */
    public function get(int $id)
    {
        /** @var Person|null $person */
        $person = Person::find($id);

        if (!$person) {
            self::badApiCall('Person not found', 404);
        }

        self::jsonResponse($person->toArray());
    }
}
