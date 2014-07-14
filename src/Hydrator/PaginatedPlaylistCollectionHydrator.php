<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Pagination;
use Audeio\Spotify\Entity\Playlist;
use Audeio\Spotify\Entity\PlaylistCollection;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class PaginatedPlaylistCollectionHydrator
 * @package Audeio\Spotify\Hydrator
 */
class PaginatedPlaylistCollectionHydrator extends ClassMethods
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

        $playlistCollection = new PlaylistCollection();

        foreach($data['items'] as $playlist) {
            $hydrators = new AggregateHydrator();
            $hydrators->add(new PlaylistHydrator());
            $hydrators->add(new OwnerAwareHydrator());
            $hydrators->add(new TracksAwareHydrator());

            $playlistCollection->add($hydrators->hydrate($playlist, new Playlist()));
        }

        $object->setItems($playlistCollection);

        return $object;
    }
} 