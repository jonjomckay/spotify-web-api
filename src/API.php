<?php
namespace Audeio\Spotify;

use Audeio\Spotify\Entity;
use Audeio\Spotify\Exception;
use Audeio\Spotify\Hydrator;
use Guzzle;
use Zend\Stdlib\Hydrator\Aggregate\AggregateHydrator;

/**
 * Class API
 * @package Audeio\Spotify
 */
class API
{

    /**
     * @var string
     */
    private static $baseUrl = 'https://api.spotify.com';

    /**
     * @var Guzzle\Http\Client
     */
    private $guzzleClient;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var array
     */
    private $paginationFields = array('href', 'limit', 'offset', 'total');

    /**
     *
     */
    public function __construct()
    {
        $this->guzzleClient = new Guzzle\Http\Client(static::$baseUrl);
        $this->guzzleClient->setConfig(array(
            'defaults' => array(
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Authorization' => sprintf('Bearer %s', $this->accessToken)
                )
            )
        ));
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        $this->guzzleClient->setDefaultOption(
            'headers/Authorization',
            $accessToken ? sprintf('Bearer %s', $accessToken) : null
        );
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
        $request = $this->guzzleClient->createRequest('GET', '/v1/albums');
        $request->getQuery()->add('ids', implode(',', $ids));

        $response = $this->sendRequest($request)->json();

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
        $request = $this->guzzleClient->createRequest('GET', sprintf('/v1/albums/%s/tracks', $id));
        $request->getQuery()->add('limit', $limit);
        $request->getQuery()->add('offset', $offset);

        $response = $this->sendRequest($request)->json();

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
        $request = $this->guzzleClient->createRequest('GET', '/v1/artists');
        $request->getQuery()->add('ids', implode(',', $ids));

        $response = $this->sendRequest($request)->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\ArtistCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\ArtistCollection());
    }

    /**
     * @param string $id
     * @param string|null $country
     * @param array $albumTypes
     * @param int $limit
     * @param int $offset
     * @return Entity\AlbumPagination
     */
    public function getArtistAlbums($id, $country = null, array $albumTypes = array(), $limit = 20, $offset = 0)
    {
        $request = $this->guzzleClient->createRequest('GET', sprintf('/v1/artists/%s/albums', $id));
        $request->getQuery()->add('album_type', implode(',', $albumTypes));
        $request->getQuery()->add('country', $country);
        $request->getQuery()->add('limit', $limit);
        $request->getQuery()->add('offset', $offset);

        $response = $this->sendRequest($request)->json();

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
        $request = $this->guzzleClient->createRequest('GET', sprintf('/v1/artists/%s/top-tracks', $id));
        $request->getQuery()->add('country', $country);

        $response = $this->sendRequest($request)->json();

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
        $request = $this->guzzleClient->createRequest('GET', '/v1/tracks');
        $request->getQuery()->add('ids', implode(',', $ids));

        $response = $this->sendRequest($request)->json();

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
     * @param string $userId
     * @param string $id
     * @param array $fields
     * @return Entity\Playlist
     */
    public function getUserPlaylist($userId, $id, array $fields = array())
    {
        $request = $this->guzzleClient->createRequest('GET', sprintf('/v1/users/%s/playlists/%s', $userId, $id));
        $request->getQuery()->add(
            'fields',
            implode(',', empty($fields) ? $fields : array_merge($this->paginationFields, $fields))
        );

        $response = $this->sendRequest($request)->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\PlaylistHydrator());
        $hydrators->add(new Hydrator\ImageCollectionAwareHydrator());
        $hydrators->add(new Hydrator\OwnerAwareHydrator());
        $hydrators->add(new Hydrator\PaginatedPlaylistTrackCollectionAwareHydrator());

        return $hydrators->hydrate($response, new Entity\Playlist());
    }

    /**
     * @param string $userId
     * @param string $id
     * @param array $fields
     * @return Entity\PlaylistTrackPagination
     */
    public function getUserPlaylistTracks($userId, $id, array $fields = array())
    {
        $request = $this->guzzleClient->createRequest('GET', sprintf('/v1/users/%s/playlists/%s/tracks', $userId, $id));
        $request->getQuery()->add(
            'fields',
            implode(',', empty($fields) ? $fields : array_merge($this->paginationFields, $fields))
        );

        $response = $this->sendRequest($request)->json();

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
        $request = $this->guzzleClient->createRequest('GET', sprintf('/v1/users/%s/playlists', $id));

        $response = $this->sendRequest($request)->json();

        $hydrators = new AggregateHydrator();
        $hydrators->add(new Hydrator\PaginationHydrator());
        $hydrators->add(new Hydrator\PaginatedPlaylistCollectionHydrator());

        return $hydrators->hydrate($response, new Entity\PlaylistPagination());
    }

    /**
     * @param Guzzle\Http\Message\RequestInterface $request
     * @return Guzzle\Http\Message\Response|null
     * @throws Exception\AccessTokenException
     * @throws \Exception
     */
    private function sendRequest(Guzzle\Http\Message\RequestInterface $request)
    {
        // Clean the query string of any null valued parameters
        $request->getQuery()->replace(array_filter($request->getQuery()->toArray()));

        try {
            return $this->guzzleClient->send($request);
        } catch (Guzzle\Http\Exception\ClientErrorResponseException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case 401:
                    throw new Exception\AccessTokenException();
                    break;
                default:
                    $hydrator = new Hydrator\ErrorHydrator();
                    $error = $hydrator->hydrate($e->getResponse()->json(), new Entity\Error());
                    throw new Exception\SpotifyException($error);
                    break;
            }
        }
    }
}
