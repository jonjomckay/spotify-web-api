<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Album;
use Audeio\Spotify\Entity\AlbumCollection;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class AlbumCollectionHydrator
 * @package Audeio\Spotify\Hydrator
 */
class AlbumCollectionHydrator extends ClassMethods
{

    /**
     * @param array $data
     * @param AlbumCollection $object
     * @return AlbumCollection
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['albums'])) {
            return $object;
        }

        foreach($data['albums'] as $album) {
            $hydrators = new AggregateHydrator();
            $hydrators->add(new AlbumHydrator());
            $hydrators->add(new ArtistCollectionAwareHydrator());
            $hydrators->add(new ImageCollectionAwareHydrator());
            $hydrators->add(new PaginatedTrackCollectionAwareHydrator());

            $object->add($hydrators->hydrate($album, new Album()));
        }

        return $object;
    }
} 