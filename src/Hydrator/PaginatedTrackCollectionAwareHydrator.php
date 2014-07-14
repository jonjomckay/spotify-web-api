<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Pagination;
use Audeio\Spotify\Entity\Track;
use Audeio\Spotify\Entity\TrackCollection;
use Zend\Stdlib\Hydrator\ClassMethods;

class PaginatedTrackCollectionAwareHydrator extends ClassMethods
{

    public function hydrate(array $data, $object)
    {
        if (!isset($data['tracks'])) {
            return;
        }

        $paginatedTrackCollection = new Pagination($data['tracks']);

        $trackCollection = new TrackCollection();

        foreach($paginatedTrackCollection->getItems() as $track) {
            $trackCollection->add(new Track($track));
        }

        $paginatedTrackCollection->setItems($trackCollection);

        $object->setTracks($paginatedTrackCollection);

        return $object;
    }
} 