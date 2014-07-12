<?php
namespace Audeio\Spotify\Hydrator;

use Audeio\Spotify\Entity\Image;
use Zend\Stdlib\Hydrator\ClassMethods;

class ImageAwareHydrator extends ClassMethods
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
        if (!isset($data['images'])) {
            return $object;
        }

        $images = array();

        foreach ($data['images'] as $image) {
            $images[] = new Image($image);
        }

        $object->setImages($images);

        return $object;
    }
}