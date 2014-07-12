<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\PlaylistTracks;
use Zend\Stdlib\Hydrator\ClassMethods;

class PlaylistTracksAwareHydrator extends ClassMethods
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

        $object->setTracks(new PlaylistTracks($data['tracks']));

        return $object;
    }
}