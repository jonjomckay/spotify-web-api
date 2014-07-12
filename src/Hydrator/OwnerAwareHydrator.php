<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\User;
use Zend\Stdlib\Hydrator\ClassMethods;

class OwnerAwareHydrator extends ClassMethods
{

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['owner'])) {
            return $object;
        }

        $object->setOwner(new User($data['owner']));

        return $object;
    }
}