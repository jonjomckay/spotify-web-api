<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Image;
use Audeio\Spotify\Entity\User;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;

class UserAwareHydrator extends ClassMethods
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
        if (!isset($data['user'])) {
            return $object;
        }

        $object->setUser(new User($data['user']));

        return $object;
    }
}