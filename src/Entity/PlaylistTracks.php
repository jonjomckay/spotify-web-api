<?php
namespace Audeio\Spotify\Entity;

use Zend\Stdlib\AbstractOptions;

class PlaylistTracks extends AbstractOptions
{

    /**
     * @var string
     */
    private $href;

    /**
     * @var integer
     */
    private $total;

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
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
} 