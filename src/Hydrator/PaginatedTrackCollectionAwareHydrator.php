<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Track;
use Audeio\Spotify\Entity\TrackCollection;
use Audeio\Spotify\Entity\TrackPagination;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class PaginatedTrackCollectionAwareHydrator
 * @package Audeio\Spotify\Hydrator
 */
class PaginatedTrackCollectionAwareHydrator extends ClassMethods
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

        $paginatedTrackCollection = new TrackPagination($data['tracks']);

        $trackCollection = new TrackCollection();

        foreach($paginatedTrackCollection->getItems() as $track) {
            $trackCollection->add(new Track($track));
        }

        $paginatedTrackCollection->setItems($trackCollection);

        $object->setTracks($paginatedTrackCollection);

        return $object;
    }
} 