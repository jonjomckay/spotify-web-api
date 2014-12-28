<?php
namespace Audeio\Spotify\Oauth2\Client\Provider;

use League\OAuth2\Client\Entity\User;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Class Spotify
 * @package Audeio\Spotify\Oauth2\Client\Provider
 */
class Spotify extends AbstractProvider
{

    public $scopeSeparator = ' ';

    /**
     * @return string
     */
    public function urlAuthorize()
    {
        return 'https://accounts.spotify.com/authorize';
    }

    /**
     * @return string
     */
    public function urlAccessToken()
    {
        return 'https://accounts.spotify.com/api/token';
    }

    /**
     * @param AccessToken $token
     * @return string
     */
    public function urlUserDetails(AccessToken $token)
    {
        $this->headers = array(
            'Authorization' => sprintf('Bearer %s', $token->accessToken)
        );

        return 'https://api.spotify.com/v1/me';
    }

    /**
     * @param $response
     * @param AccessToken $token
     * @return User
     */
    public function userDetails($response, AccessToken $token)
    {
        $this->headers = array(
            'Authorization' => sprintf('Bearer %s', $token->accessToken)
        );

        $user = new User();
        $user->uid = $response['id'];
        $user->name = $response['display_name'];
        $user->email = $response['email'];
        $user->imageUrl = isset($response['images'][0]['url']) ?: null;
        $user->urls = $response['external_urls'];

        return $user;
    }
}