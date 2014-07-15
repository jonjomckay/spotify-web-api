<?php
namespace Audeio\Spotify\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Stdlib\AbstractOptions;

/**
 * Class Pagination
 * @package Audeio\Spotify\Entity
 */
class Pagination extends AbstractOptions
{

    /**
     * @var string
     */
    private $href;

    /**
     * @var ArrayCollection
     */
    private $items;

    /**
     * @var integer
     */
    private $limit;

    /**
     * @var string
     */
    private $next;

    /**
     * @var integer
     */
    private $offset;

    /**
     * @var string
     */
    private $previous;

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
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return bool
     */
    public function hasItems()
    {
        return !empty($this->items);
    }

    /**
     * @param ArrayCollection $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param string $next
     */
    public function setNext($next)
    {
        $this->next = $next;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * @param string $previous
     */
    public function setPrevious($previous)
    {
        $this->previous = $previous;
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