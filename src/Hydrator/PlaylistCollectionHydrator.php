<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Playlist;
use Audeio\Spotify\Entity\PlaylistCollection;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

class PlaylistCollectionHydrator extends ClassMethods
{

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  PlaylistCollection $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['items'])) {
            return $object;
        }

        foreach ($data['items'] as $item) {
            $hydrators = new AggregateHydrator();
            $hydrators->add(new PlaylistHydrator());
            $hydrators->add(new OwnerAwareHydrator());
            $hydrators->add(new PlaylistTracksAwareHydrator());

            $object->add($hydrators->hydrate($item, new Playlist()));
        }

        return $object;
    }
}