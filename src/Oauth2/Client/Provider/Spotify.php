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
    protected $birthdate, $country, $followers, $product;

    const PARAM_BIRTHDATE = 'birthdate';
    const PARAM_COUNTRY = 'country';
    const PARAM_FOLLOWERS = 'followers';
    const PARAM_PRODUCT = 'product';
    const PRODUCT_PREMIUM = 'premium';

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
        
        $response = json_decode(json_encode($response), true);
        $this->setAdditionalParams($response);
        $user = new User();
        $user->uid = $response['id'];
        $user->name = $response['display_name'];
        $user->email = !empty($response['email']) ? $response['email'] : null;
        $user->imageUrl = isset($response['images'][0]['url']) ?: null;
        $user->urls = $response['external_urls'];

        return $user;
    }
    
    /**
     * Sets additional parametes being returned from "me" endpoint when additional scopes are available
     * @param $response
     */
    public function setAdditionalParams($response)
    {
        $this->birthdate = !empty($response[self::PARAM_BIRTHDATE]) ? $response[self::PARAM_BIRTHDATE] : null;
        $this->country = !empty($response[self::PARAM_COUNTRY]) ? $response[self::PARAM_COUNTRY] : null;
        $this->followers = !empty($response[self::PARAM_FOLLOWERS]) ? $response[self::PARAM_FOLLOWERS] : null;
        $this->product = !empty($response[self::PARAM_PRODUCT]) ? $response[self::PARAM_PRODUCT] : null;
    }
    
    /**
     * Checks if user has a premium account
     */
    public function isPremium()
    {
        return ($this->product == self::PRODUCT_PREMIUM);
    }

    
    /**
     * Returns country of user if available
     */
    public function country()
    {
        return !empty($this->country) ? $this->country : null;
    }
    
    /**
     * Returns followers if available
     */
    public function followers()
    {
        return !empty($this->followers) ? $this->followers : null;
    }
}
