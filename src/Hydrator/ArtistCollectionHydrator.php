<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Artist;
use Audeio\Spotify\Entity\ArtistCollection;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

class ArtistCollectionHydrator extends ClassMethods
{

    /**
     * @param array $data
     * @param ArtistCollection $object
     * @return ArtistCollection
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['artists'])) {
            return;
        }

        foreach($data['artists'] as $artist) {
            $hydrators = new AggregateHydrator();
            $hydrators->add(new ArtistHydrator());
            $hydrators->add(new ImageCollectionAwareHydrator());

            $object->add($hydrators->hydrate($artist, new Artist()));
        }

        return $object;
    }
} 