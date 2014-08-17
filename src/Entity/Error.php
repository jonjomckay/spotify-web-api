<?php
namespace Audeio\Spotify\Entity;

use Zend\Stdlib\AbstractOptions;

/**
 * Class Error
 * @package Audeio\Spotify\Entity
 */
class Error extends AbstractOptions
{

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
} 