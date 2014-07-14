<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Track;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class TrackAwareHydrator
 * @package Audeio\Spotify\Hydrator
 */
class TrackAwareHydrator extends ClassMethods
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
        if (!isset($data['track'])) {
            return $object;
        }

        $hydrators = new AggregateHydrator();
        $hydrators->add(new TrackHydrator());
        $hydrators->add(new AlbumAwareHydrator());
        $hydrators->add(new ArtistCollectionAwareHydrator());
        $hydrators->add(new ImageCollectionAwareHydrator());

        $object->setTrack($hydrators->hydrate($data['track'], new Track()));

        return $object;
    }
}