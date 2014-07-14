<?php
namespace Audeio\Spotify\Entity;

use Zend\Stdlib\AbstractOptions;

/**
 * Class Tracks
 * @package Audeio\Spotify\Entity
 */
class Tracks extends AbstractOptions
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
}
