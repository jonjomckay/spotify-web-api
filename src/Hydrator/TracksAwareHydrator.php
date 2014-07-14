<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Tracks;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class TracksAwareHydrator
 * @package Audeio\Spotify\Hydrator
 */
class TracksAwareHydrator extends ClassMethods
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
        if (!isset($data['tracks'])) {
            return $object;
        }

        $object->setTracks(new Tracks($data['tracks']));

        return $object;
    }
}