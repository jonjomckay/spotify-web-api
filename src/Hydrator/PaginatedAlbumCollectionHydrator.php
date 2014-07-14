<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Pagination;
use Audeio\Spotify\Entity\Album;
use Audeio\Spotify\Entity\AlbumCollection;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class PaginatedAlbumCollectionHydrator
 * @package Audeio\Spotify\Hydrator
 */
class PaginatedAlbumCollectionHydrator extends ClassMethods
{

    /**
     * @param array $data
     * @param Pagination $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['items'])) {
            return $object;
        }

        $albumCollection = new AlbumCollection();

        foreach($data['items'] as $album) {
            $hydrators = new AggregateHydrator();
            $hydrators->add(new AlbumHydrator());
            $hydrators->add(new ImageCollectionAwareHydrator());

            $albumCollection->add($hydrators->hydrate($album, new Album()));
        }

        $object->setItems($albumCollection);

        return $object;
    }
} 