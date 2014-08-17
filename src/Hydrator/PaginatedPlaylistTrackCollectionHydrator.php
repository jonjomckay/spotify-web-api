<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Pagination;
use Audeio\Spotify\Entity\PlaylistTrack;
use Audeio\Spotify\Entity\PlaylistTrackCollection;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class PaginatedPlaylistTrackCollectionHydrator
 * @package Audeio\Spotify\Hydrator
 */
class PaginatedPlaylistTrackCollectionHydrator extends ClassMethods
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

        $playlistTrackCollection = new PlaylistTrackCollection();

        foreach($data['items'] as $playlistTrack) {
            $hydrators = new AggregateHydrator();
            $hydrators->add(new TrackAwareHydrator());

            $playlistTrackCollection->add($hydrators->hydrate($playlistTrack, new PlaylistTrack()));
        }

        $object->setItems($playlistTrackCollection);

        return $object;
    }
} 