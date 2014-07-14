<?php
namespace Audeio\Spotify;

use Audeio\Spotify\Entity\Album;
use Audeio\Spotify\Entity\AlbumCollection;
use Audeio\Spotify\Entity\AlbumPagination;
use Audeio\Spotify\Entity\Artist;
use Audeio\Spotify\Entity\ArtistCollection;
use Audeio\Spotify\Entity\Pagination;
use Audeio\Spotify\Entity\PlaylistCollection;
use Audeio\Spotify\Entity\Track;
use Audeio\Spotify\Entity\TrackCollection;
use Audeio\Spotify\Entity\TrackPagination;
use Audeio\Spotify\Entity\User;
use Audeio\Spotify\Hydrator\AlbumAwareHydrator;
use Audeio\Spotify\Hydrator\AlbumCollectionHydrator;
use Audeio\Spotify\Hydrator\AlbumHydrator;
use Audeio\Spotify\Hydrator\ArtistCollectionAwareHydrator;
use Audeio\Spotify\Hydrator\ArtistCollectionHydrator;
use Audeio\Spotify\Hydrator\ArtistHydrator;
use Audeio\Spotify\Hydrator\ImageCollectionAwareHydrator;
use Audeio\Spotify\Hydrator\PaginatedAlbumCollectionHydrator;
use Audeio\Spotify\Hydrator\PaginatedTrackCollectionAwareHydrator;
use Audeio\Spotify\Hydrator\PaginatedTrackCollectionHydrator;
use Audeio\Spotify\Hydrator\PaginationHydrator;
use Audeio\Spotify\Hydrator\PlaylistCollectionHydrator;
use Audeio\Spotify\Hydrator\TrackCollectionHydrator;
use Audeio\Spotify\Hydrator\TrackHydrator;
use Audeio\Spotify\Hydrator\TracksAwareHydrator;
use Audeio\Spotify\Hydrator\UserHydrator;
use GuzzleHttp;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

/**
 * Class API
 * @package Audeio\Spotify
 */
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

    /**
     *
     */
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

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        $this->guzzleClient->setDefaultOption('headers/Authorization', sprintf('Bearer %s', $this->accessToken));
    }

    /**
     * @param string $id
     * @return Album
     */
    public function getAlbum($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/albums/%s', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new AlbumHydrator());
        $hydrators->add(new ArtistCollectionAwareHydrator());
        $hydrators->add(new ImageCollectionAwareHydrator());
        $hydrators->add(new PaginatedTrackCollectionAwareHydrator());

        return $hydrators->hydrate($response, new Album());
    }

    /**
     * @param array $ids
     * @return AlbumCollection
     */
    public function getAlbums(array $ids)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', '/v1/albums', array(
                'query' => array(
                    'ids' => implode(',', $ids)
                )
            ))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new AlbumCollectionHydrator());

        return $hydrators->hydrate($response, new AlbumCollection());
    }

    /**
     * @param string $id
     * @param int $limit
     * @param int $offset
     * @return TrackPagination
     */
    public function getAlbumTracks($id, $limit = 20, $offset = 0)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/albums/%s/tracks', $id), array(
                'query' => array(
                    'limit' => $limit,
                    'offset' => $offset
                )
            ))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new PaginationHydrator());
        $hydrators->add(new PaginatedTrackCollectionHydrator());

        return $hydrators->hydrate($response, new Pagination());
    }

    /**
     * @param string $id
     * @return Artist
     */
    public function getArtist($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/artists/%s', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new ArtistHydrator());
        $hydrators->add(new ImageCollectionAwareHydrator());

        return $hydrators->hydrate($response, new Artist());
    }

    /**
     * @param array $ids
     * @return ArtistCollection
     */
    public function getArtists(array $ids)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', '/v1/artists', array(
                'query' => array(
                    'ids' => implode(',', $ids)
                )
            ))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new ArtistCollectionHydrator());

        return $hydrators->hydrate($response, new ArtistCollection());
    }

    /**
     * @param string $id
     * @param string $country
     * @param array $albumTypes
     * @param int $limit
     * @param int $offset
     * @return AlbumPagination
     */
    public function getArtistAlbums($id, $country, array $albumTypes, $limit = 20, $offset = 0)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/artists/%s/albums', $id), array(
                'query' => array(
                    'album_type' => implode(',', $albumTypes),
                    'country' => $country,
                    'limit' => $limit,
                    'offset' => $offset
                )
            ))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new PaginationHydrator());
        $hydrators->add(new PaginatedAlbumCollectionHydrator());

        return $hydrators->hydrate($response, new Pagination());
    }

    /**
     * @param string $id
     * @param string $country
     * @return TrackCollection
     */
    public function getArtistTopTracks($id, $country)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/artists/%s/top-tracks', $id), array(
                'query' => array(
                    'country' => $country
                )
            ))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new TrackCollectionHydrator());

        return $hydrators->hydrate($response, new TrackCollection());
    }

    /**
     * @param string $id
     * @return ArtistCollection
     */
    public function getArtistRelatedArtists($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/artists/%s/related-artists', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new ArtistCollectionHydrator());

        return $hydrators->hydrate($response, new ArtistCollection());
    }

    /**
     * @param string $id
     * @return Track
     */
    public function getTrack($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/tracks/%s', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new TrackHydrator());
        $hydrators->add(new AlbumAwareHydrator());
        $hydrators->add(new ArtistCollectionAwareHydrator());

        return $hydrators->hydrate($response, new Track());
    }

    /**
     * @param array $ids
     * @return TrackCollection
     */
    public function getTracks(array $ids)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', '/v1/tracks', array(
                'query' => array(
                    'ids' => implode(',', $ids)
                )
            ))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new TrackCollectionHydrator());

        return $hydrators->hydrate($response, new TrackCollection());
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
