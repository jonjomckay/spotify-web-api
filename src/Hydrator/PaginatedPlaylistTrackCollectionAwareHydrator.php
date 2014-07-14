<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Pagination;
use Audeio\Spotify\Entity\PlaylistTrack;
use Audeio\Spotify\Entity\PlaylistTrackCollection;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class PaginatedPlaylistTrackCollectionAwareHydrator
 * @package Audeio\Spotify\Hydrator
 */
class PaginatedPlaylistTrackCollectionAwareHydrator extends ClassMethods
{

    /**
     * @param array $data
     * @param object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['tracks'])) {
            return $object;
        }

        $paginatedTrackCollection = new Pagination($data['tracks']);

        $playlistTrackCollection = new PlaylistTrackCollection();

        foreach($paginatedTrackCollection->getItems() as $track) {
            $hydrators = new AggregateHydrator();
            $hydrators->add(new TrackAwareHydrator());

            $playlistTrackCollection->add($hydrators->hydrate($track, new PlaylistTrack()));
        }

        $paginatedTrackCollection->setItems($playlistTrackCollection);

        $object->setTracks($paginatedTrackCollection);

        return $object;
    }
} 