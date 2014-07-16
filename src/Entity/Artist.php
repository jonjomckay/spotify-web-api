<?php
namespace Audeio\Spotify\Entity;

use Zend\Stdlib\AbstractOptions;

/**
 * Class Artist
 * @package Audeio\Spotify\Entity
 */
class Artist extends AbstractOptions
{

    /**
     * @var array
     */
    private $externalUrls;

    /**
     * @var array
     */
    private $genres;

    /**
     * @var string
     */
    private $href;

    /**
     * @var string
     */
    private $id;

    /**
     * @var ImageCollection
     */
    private $images;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $popularity;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $uri;

    /**
     * @return array
     */
    public function getExternalUrls()
    {
        return $this->externalUrls;
    }

    /**
     * @param array $externalUrls
     */
    public function setExternalUrls($externalUrls)
    {
        $this->externalUrls = $externalUrls;
    }

    /**
     * @return array
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @param array $genres
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return ImageCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param ImageCollection $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * @param int $popularity
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
