<?php
namespace Audeio\Spotify;

use Audeio\Spotify\Entity;
use Audeio\Spotify\Exception;
use Audeio\Spotify\Hydrator;
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
     * @return Entity\Album
     */
    public function getAlbum($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/albums/%s', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\AlbumHydrator());
        $hydrators->add(new Hydrator\ArtistCollectionAwareHydrator());
        $hydrators->add(new Hydrator\ImageCollectionAwareHydrator());
        $hydrators->add(new Hydrator\PaginatedTrackCollectionAwareHydrator());

        return $hydrators->hydrate($response, new Entity\Album());
    }

    /**
     * @param array $ids
     * @return Entity\AlbumCollection
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
        $hydrators->add(new Hydrator\AlbumCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\AlbumCollection());
    }

    /**
     * @param string $id
     * @param int $limit
     * @param int $offset
     * @return Entity\TrackPagination
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
        $hydrators->add(new Hydrator\PaginationHydrator());
        $hydrators->add(new Hydrator\PaginatedTrackCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\TrackPagination());
    }

    /**
     * @param string $id
     * @return Entity\Artist
     */
    public function getArtist($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/artists/%s', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\ArtistHydrator());
        $hydrators->add(new Hydrator\ImageCollectionAwareHydrator());

        return $hydrators->hydrate($response, new Entity\Artist());
    }

    /**
     * @param array $ids
     * @return Entity\ArtistCollection
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
        $hydrators->add(new Hydrator\ArtistCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\ArtistCollection());
    }

    /**
     * @param string $id
     * @param string $country
     * @param array $albumTypes
     * @param int $limit
     * @param int $offset
     * @return Entity\AlbumPagination
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
        $hydrators->add(new Hydrator\PaginationHydrator());
        $hydrators->add(new Hydrator\PaginatedAlbumCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\AlbumPagination());
    }

    /**
     * @param string $id
     * @param string $country
     * @return Entity\TrackCollection
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
        $hydrators->add(new Hydrator\TrackCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\TrackCollection());
    }

    /**
     * @param string $id
     * @return Entity\ArtistCollection
     */
    public function getArtistRelatedArtists($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/artists/%s/related-artists', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\ArtistCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\ArtistCollection());
    }

    /**
     * @param string $id
     * @return Entity\Track
     */
    public function getTrack($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/tracks/%s', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\TrackHydrator());
        $hydrators->add(new Hydrator\AlbumAwareHydrator());
        $hydrators->add(new Hydrator\ArtistCollectionAwareHydrator());

        return $hydrators->hydrate($response, new Entity\Track());
    }

    /**
     * @param array $ids
     * @return Entity\TrackCollection
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
        $hydrators->add(new Hydrator\TrackCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\TrackCollection());
    }

    /**
     * @param string $id
     * @return Entity\User
     */
    public function getUserProfile($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/users/%s', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\UserHydrator());

        return $hydrators->hydrate($response, new Entity\User());
    }

    /**
     * @return Entity\User
     */
    public function getCurrentUser()
    {
        $response = $this->sendRequest($this->guzzleClient->createRequest('GET', '/v1/me'))->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\UserHydrator());
        $hydrators->add(new Hydrator\ImageCollectionAwareHydrator());

        return $hydrators->hydrate($response, new Entity\User());
    }

    /**
     * @param string $id
     * @param string $userId
     * @param array $fields
     * @return Entity\Playlist
     */
    public function getPlaylist($id, $userId, array $fields = array())
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/users/%s/playlists/%s', $userId, $id), array(
                'query' => array(
                    'fields' => implode(',', $fields)
                )
            ))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\PlaylistHydrator());
        $hydrators->add(new Hydrator\ImageCollectionAwareHydrator());
        $hydrators->add(new Hydrator\OwnerAwareHydrator());
        $hydrators->add(new Hydrator\PaginatedPlaylistTrackCollectionAwareHydrator());

        return $hydrators->hydrate($response, new Entity\Playlist());
    }

    /**
     * @param string $id
     * @param string $userId
     * @param array $fields
     * @return Entity\PlaylistTrackPagination
     */
    public function getPlaylistTracks($id, $userId, array $fields = array())
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/users/%s/playlists/%s/tracks', $userId, $id), array(
                'query' => array(
                    'fields' => implode(',', $fields)
                )
            ))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\PaginationHydrator());
        $hydrators->add(new Hydrator\PaginatedPlaylistTrackCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\PlaylistTrackPagination());
    }

    /**
     * @param string $id
     * @return Entity\PlaylistPagination
     */
    public function getUserPlaylists($id)
    {
        $response = $this->sendRequest(
            $this->guzzleClient->createRequest('GET', sprintf('/v1/users/%s/playlists', $id))
        )->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\PaginationHydrator());
        $hydrators->add(new Hydrator\PaginatedPlaylistCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\PlaylistPagination());
    }

    /**
     * @param GuzzleHttp\Message\RequestInterface $request
     * @return GuzzleHttp\Message\ResponseInterface|null
     * @throws Exception\AccessTokenExpiredException
     * @throws \Exception
     */
    private function sendRequest(GuzzleHttp\Message\RequestInterface $request)
    {
        try {
            return $this->guzzleClient->send($request);
        } catch (GuzzleHttp\Exception\ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case 401:
                    throw new Exception\AccessTokenExpiredException();
                    break;
                default:
                    throw new \Exception(sprintf('A problem occurred: %s', $e->getMessage()));
                    break;
            }
        }
    }
}
