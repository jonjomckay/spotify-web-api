<?php
namespace Audeio\Spotify\Exception;

/**
 * Class AccessTokenExpiredException
 * @package Audeio\Spotify\Exception
 */
class AccessTokenExpiredException extends \Exception
{

    protected $message = 'Access token expired';
    protected $code = 401;
} 