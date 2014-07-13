<?php
namespace Audeio\Spotify;

use Audeio\Spotify\Entity\PlaylistCollection;
use Audeio\Spotify\Entity\User;
use Audeio\Spotify\Hydrator\ImageAwareHydrator;
use Audeio\Spotify\Hydrator\PlaylistCollectionHydrator;
use Audeio\Spotify\Hydrator\UserHydrator;
use Audeio\Spotify\Oauth2\Client\Provider\Spotify;
use GuzzleHttp;
use League\OAuth2\Client\Grant\RefreshToken;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;
use Zend\Stdlib\Hydrator\ClassMethods;

class API
{

    private static $baseUrl = 'https://api.spotify.com';

    /**
     * @var GuzzleHttp\Client
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $accessToken;

    public function __construct()
    {
        $this->guzzleClient = new GuzzleHttp\Client([
            'base_url' => static::$baseUrl,
            'defaults' => [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => sprintf('Bearer %s', $this->accessToken)
                ]
            ]
        ]);
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        $this->guzzleClient->setDefaultOption('headers/Authorization', sprintf('Bearer %s', $this->accessToken));
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        $response = $this->sendRequest($this->guzzleClient->createRequest('GET', '/v1/me'))->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new UserHydrator());
        $hydrators->add(new ImageAwareHydrator());

        return $hydrators->hydrate($response, new User());
    }

    /**
     * @param $username
     * @return PlaylistCollection
     */
    public function getUserPlaylists($username)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/users/%s/playlists', $username))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new PlaylistCollectionHydrator());

        return $hydrators->hydrate($response, new PlaylistCollection());
    }

    private function sendRequest(GuzzleHttp\Message\RequestInterface $request)
    {
        try {
            return $this->guzzleClient->send($request);
        } catch (GuzzleHttp\Exception\ClientException $e) {
//            switch ($e->getCode()) {
//                case 401:
//                    $accessToken = $this->provider->getAccessToken(new RefreshToken(), array(
//                        'refresh_token' => $this->refreshToken
//                    ));
//
//                    $this->setAccessToken($accessToken->accessToken);
//
//                    // Need to manipulate the $request object with the new access token...
//
//                    var_dump($accessToken->accessToken);
//                    var_dump($request);
//
//                    return $this->guzzleClient->send($request);
//
//                    break;
//                default:
                    var_dump($request);
                    var_dump($e->getResponse()->getBody()->__toString());
//                    break;
//            }
        } catch (\Exception $e) {
            var_dump($e);
        }

        return null;
    }
}
