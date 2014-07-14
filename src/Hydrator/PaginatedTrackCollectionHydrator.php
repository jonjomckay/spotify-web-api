<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Pagination;
use Audeio\Spotify\Entity\Track;
use Audeio\Spotify\Entity\TrackCollection;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class PaginatedTrackCollectionHydrator
 * @package Audeio\Spotify\Hydrator
 */
class PaginatedTrackCollectionHydrator extends ClassMethods
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

        $trackCollection = new TrackCollection();

        foreach($data['items'] as $track) {
            $trackCollection->add(new Track($track));
        }

        $object->setItems($trackCollection);

        return $object;
    }
} 