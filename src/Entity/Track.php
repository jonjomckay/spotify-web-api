<?php
namespace Audeio\Spotify\Entity;

use Zend\Stdlib\AbstractOptions;

/**
 * Class Track
 * @package Audeio\Spotify\Entity
 */
class Track extends AbstractOptions
{

    /**
     * @var Album
     */
    private $album;

    /**
     * @var ArtistCollection
     */
    private $artists;

    /**
     * @var array
     */
    private $availableMarkets;

    /**
     * @var integer
     */
    private $discNumber;

    /**
     * @var integer
     */
    private $durationMs;

    /**
     * @var boolean
     */
    private $explicit;

    /**
     * @var array
     */
    private $externalIds;

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
     * @var integer
     */
    private $popularity;

    /**
     * @var string
     */
    private $previewUrl;

    /**
     * @var integer
     */
    private $trackNumber;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $uri;

    /**
     * @return Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param Album $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    /**
     * @return ArtistCollection
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * @param ArtistCollection $artists
     */
    public function setArtists($artists)
    {
        $this->artists = $artists;
    }

    /**
     * @return array
     */
    public function getAvailableMarkets()
    {
        return $this->availableMarkets;
    }

    /**
     * @param array $availableMarkets
     */
    public function setAvailableMarkets($availableMarkets)
    {
        $this->availableMarkets = $availableMarkets;
    }

    /**
     * @return int
     */
    public function getDiscNumber()
    {
        return $this->discNumber;
    }

    /**
     * @param int $discNumber
     */
    public function setDiscNumber($discNumber)
    {
        $this->discNumber = $discNumber;
    }

    /**
     * @return int
     */
    public function getDurationMs()
    {
        return $this->durationMs;
    }

    /**
     * @param int $durationMs
     */
    public function setDurationMs($durationMs)
    {
        $this->durationMs = $durationMs;
    }

    /**
     * @return boolean
     */
    public function isExplicit()
    {
        return $this->explicit;
    }

    /**
     * @param boolean $explicit
     */
    public function setExplicit($explicit)
    {
        $this->explicit = $explicit;
    }

    /**
     * @return array
     */
    public function getExternalIds()
    {
        return $this->externalIds;
    }

    /**
     * @param array $externalIds
     */
    public function setExternalIds($externalIds)
    {
        $this->externalIds = $externalIds;
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
    public function getPreviewUrl()
    {
        return $this->previewUrl;
    }

    /**
     * @param string $previewUrl
     */
    public function setPreviewUrl($previewUrl)
    {
        $this->previewUrl = $previewUrl;
    }

    /**
     * @return int
     */
    public function getTrackNumber()
    {
        return $this->trackNumber;
    }

    /**
     * @param int $trackNumber
     */
    public function setTrackNumber($trackNumber)
    {
        $this->trackNumber = $trackNumber;
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
