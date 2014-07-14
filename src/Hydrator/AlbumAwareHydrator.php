<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Album;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
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

        $hydrators = new AggregateHydrator();
        $hydrators->add(new AlbumHydrator());
        $hydrators->add(new ImageCollectionAwareHydrator());

        $object->setAlbum($hydrators->hydrate($data['album'], new Album()));

        return $object;
    }
}