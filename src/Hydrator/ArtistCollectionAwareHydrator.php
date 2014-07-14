<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Artist;
use Audeio\Spotify\Entity\ArtistCollection;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class ArtistCollectionAwareHydrator
 * @package Audeio\Spotify\Hydrator
 */
class ArtistCollectionAwareHydrator extends ClassMethods
{

    /**
     * @param array $data
     * @param object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['artists'])) {
            return $object;
        }

        $artistCollection = new ArtistCollection();

        foreach($data['artists'] as $artist) {
            $artistCollection->add(new Artist($artist));
        }

        $object->setArtists($artistCollection);

        return $object;
    }
} 