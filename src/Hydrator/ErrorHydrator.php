<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Error;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class ErrorHydrator
 * @package Audeio\Spotify\Hydrator
 */
class ErrorHydrator extends ClassMethods
{

    /**
     * @param array $data
     * @param object $object
     * @return Error
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['error'])) {
            return $object;
        }

        return parent::hydrate($data['error'], new Error());
    }
} 