<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Image;
use Audeio\Spotify\Entity\ImageCollection;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class ImageCollectionAwareHydrator
 * @package Audeio\Spotify\Hydrator
 */
class ImageCollectionAwareHydrator extends ClassMethods
{

    /**
     * @param array $data
     * @param object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        if (!isset($data['images'])) {
            return $object;
        }

        $imageCollection = new ImageCollection();

        foreach ($data['images'] as $image) {
            $imageCollection->add(new Image($image));
        }

        $object->setImages($imageCollection);

        return $object;
    }
}