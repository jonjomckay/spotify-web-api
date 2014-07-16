<?php
namespace Audeio\Spotify\Entity;

use Zend\Stdlib\AbstractOptions;

/**
 * Class Playlist
 * @package Audeio\Spotify\Entity
 */
class Playlist extends AbstractOptions
{

    /**
     * @var boolean
     */
    private $collaborative;

    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $externalUrls;

    /**
     * @var array
     */
    private $followers;

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
     * @var User
     */
    private $owner;

    /**
     * @var boolean
     */
    private $public;

    /**
     * @var PlaylistTrackPagination
     */
    private $tracks;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $uri;

    /**
     * @return boolean
     */
    public function isCollaborative()
    {
        return $this->collaborative;
    }

    /**
     * @param boolean $collaborative
     */
    public function setCollaborative($collaborative)
    {
        $this->collaborative = $collaborative;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

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
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @param array $followers
     */
    public function setFollowers($followers)
    {
        $this->followers = $followers;
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
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * @return PlaylistTrackPagination
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * @param PlaylistTrackPagination $tracks
     */
    public function setTracks($tracks)
    {
        $this->tracks = $tracks;
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