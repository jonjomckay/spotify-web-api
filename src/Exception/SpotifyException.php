<?php
namespace Audeio\Spotify\Exception;

use Audeio\Spotify\Entity\Error;

/**
 * Class SpotifyException
 * @package Audeio\Spotify\Exception
 */
class SpotifyException extends \Exception
{

    /**
     * @var Error
     */
    private $error;

    /**
     * @param Error $error
     */
    public function __construct(Error $error)
    {
        $this->error = $error;

        parent::__construct($error->getMessage(), $error->getStatus());
    }

    /**
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }
} 