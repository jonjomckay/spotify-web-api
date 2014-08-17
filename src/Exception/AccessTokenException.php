<?php
namespace Audeio\Spotify\Exception;

/**
 * Class AccessTokenExpiredException
 * @package Audeio\Spotify\Exception
 */
class AccessTokenException extends \Exception
{

    protected $message = 'There was a problem with your access token';
    protected $code = 401;
} 