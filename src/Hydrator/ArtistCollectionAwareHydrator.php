<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Artist;
use Audeio\Spotify\Entity\ArtistCollection;
use Zend\Stdlib\Hydrator\ClassMethods;

class ArtistCollectionAwareHydrator extends ClassMethods
{

    public function hydrate(array $data, $object)
    {
        if (!isset($data['artists'])) {
            return;
        }

        $artistCollection = new ArtistCollection();

        foreach($data['artists'] as $artist) {
            $artistCollection->add(new Artist($artist));
        }

        $object->setArtists($artistCollection);

        return $object;
    }
} 