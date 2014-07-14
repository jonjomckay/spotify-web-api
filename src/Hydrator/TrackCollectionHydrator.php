<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Track;
use Audeio\Spotify\Entity\TrackCollection;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class TrackCollectionHydrator
 * @package Audeio\Spotify\Hydrator
 */
class TrackCollectionHydrator extends ClassMethods
{

    /**
     * @param array $data
     * @param TrackCollection $object
     * @return TrackCollection
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['tracks'])) {
            return $object;
        }

        foreach($data['tracks'] as $track) {
            $hydrators = new AggregateHydrator();
            $hydrators->add(new TrackHydrator());
            $hydrators->add(new AlbumAwareHydrator());
            $hydrators->add(new ArtistCollectionAwareHydrator());
            $hydrators->add(new ImageCollectionAwareHydrator());

            $object->add($hydrators->hydrate($track, new Track()));
        }

        return $object;
    }
} 