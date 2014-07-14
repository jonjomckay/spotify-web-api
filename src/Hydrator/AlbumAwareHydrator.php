<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Album;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class AlbumAwareHydrator
 * @package Audeio\Spotify\Hydrator
 */
class AlbumAwareHydrator extends ClassMethods
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
        if (!isset($data['album'])) {
            return $object;
        }

        $object->setAlbum(new Album($data['album']));

        return $object;
    }
}