<?php
namespace Audeio\Spotify\Entity;

use Zend\Stdlib\AbstractOptions;

class Playlist extends AbstractOptions
{

    /**
     * @var boolean
     */
    private $collaborative;

    /**
     * @var array
     */
    private $externalUrls;

    /**
     * @var string
     */
    private $href;

    /**
     * @var string
     */
    private $id;

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
     * @var PlaylistTrack
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
    public function getCollaborative()
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
    public function getPublic()
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
     * @return PlaylistTrack
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * @param PlaylistTrack $tracks
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
} 