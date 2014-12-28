<?php
namespace Audeio\Spotify;

use Audeio\Spotify\Oauth2\Client\Provider\Spotify;
use League\OAuth2\Client\Grant\RefreshToken;

/**
 * Class APITest
 * @package Audeio\Spotify
 */
class APITest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var API
     */
    private $api;

    /**
     * @var string
     */
    private static $accessToken;

    public static function setUpBeforeClass()
    {
        $oauthProvider = new Spotify(array(
            'clientId' => getenv('SPOTIFY_CLIENT_ID'),
            'clientSecret' => getenv('SPOTIFY_CLIENT_SECRET'),
            'redirectUri' => 'http://localhost:8000'
        ));

        self::$accessToken = $oauthProvider->getAccessToken(new RefreshToken(), array(
            'refresh_token' => getenv('SPOTIFY_REFRESH_TOKEN')
        ))->accessToken;
    }

    public function setUp()
    {
        $this->api = new API();
        $this->api->setAccessToken(self::$accessToken);
    }

    public function testGetAlbum()
    {
        $response = $this->api->getAlbum('4lFDt4sVpCni9DRHRmDjgG');

        $this->assertInstanceOf('Audeio\Spotify\Entity\Album', $response);
        $this->assertNotNull($response->getAlbumType());
        $this->assertInstanceOf('Audeio\Spotify\Entity\ArtistCollection', $response->getArtists());
        $this->assertNotEmpty($response->getAvailableMarkets());
        $this->assertNotEmpty($response->getExternalIds());
        $this->assertNotEmpty($response->getExternalUrls());
        $this->assertNotNull($response->getHref());
        $this->assertNotNull($response->getId());
        $this->assertInstanceOf('Audeio\Spotify\Entity\ImageCollection', $response->getImages());
        $this->assertNotNull($response->getName());
        $this->assertNotNull($response->getPopularity());
        $this->assertNotNull($response->getReleaseDate());
        $this->assertNotNull($response->getReleaseDatePrecision());
        $this->assertInstanceOf('Audeio\Spotify\Entity\TrackPagination', $response->getTracks());
        $this->assertSame('album', $response->getType());
        $this->assertNotNull($response->getUri());
    }

    public function testGetAlbumThatDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getAlbum('fake-album');
    }

    public function testGetAlbums()
    {
        $response = $this->api->getAlbums(
            array('41MnTivkwTO3UUJ8DrqEJJ', '6JWc4iAiJ9FjyK0B59ABb4', '6UXCm6bOO4gFlDQZV5yL37')
        );

        $this->assertInstanceOf('Audeio\Spotify\Entity\AlbumCollection', $response);
    }

    public function testGetAlbumsThatDoNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getAlbums(array('fake-album-1', 'fake-album-2'));
    }

    public function testGetAlbumTracks()
    {
        $response = $this->api->getAlbumTracks('6akEvsycLGftJxYudPjmqK');

        $this->assertInstanceOf('Audeio\Spotify\Entity\TrackPagination', $response);
        $this->assertNotNull($response->getHref());
        $this->assertNotNull($response->getLimit());
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
    }

    public function testGetAlbumTracksWithLimit()
    {
        $response = $this->api->getAlbumTracks('6akEvsycLGftJxYudPjmqK', 5);

        $this->assertInstanceOf('Audeio\Spotify\Entity\TrackPagination', $response);
        $this->assertEquals(5, $response->getItems()->count());
        $this->assertNotNull($response->getHref());
        $this->assertNotNull(5);
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
    }

    public function testGetAlbumTracksWhenAlbumDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getAlbumTracks('fake-album');
    }

    public function testGetArtist()
    {
        $response = $this->api->getArtist('6jJ0s89eD6GaHleKKya26X');

        $this->assertInstanceOf('Audeio\Spotify\Entity\Artist', $response);
        $this->assertNotEmpty($response->getExternalUrls());
        $this->assertNotEmpty($response->getGenres());
        $this->assertNotNull($response->getHref());
        $this->assertNotNull($response->getId());
        $this->assertInstanceOf('Audeio\Spotify\Entity\ImageCollection', $response->getImages());
        $this->assertNotNull($response->getName());
        $this->assertNotNull($response->getPopularity());
        $this->assertSame('artist', $response->getType());
        $this->assertNotNull($response->getUri());
    }

    public function testGetArtistThatDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getArtist('fake-artist');
    }

    public function testGetArtists()
    {
        $response = $this->api->getArtists(array('0oSGxfWSnnOXhD2fKuz2Gy', '3dBVyJ7JuOMt4GE9607Qin'));

        $this->assertInstanceOf('Audeio\Spotify\Entity\ArtistCollection', $response);
    }

    public function testGetArtistsWhereArtistDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getArtists(array('fake-artist', '3dBVyJ7JuOMt4GE9607Qin'));
    }

    public function testGetArtistAlbums()
    {
        $response = $this->api->getArtistAlbums('0LcJLqbBmaGUft1e9Mm8HV');

        $this->assertInstanceOf('Audeio\Spotify\Entity\AlbumPagination', $response);
        $this->assertNotNull($response->getHref());
        $this->assertNotNull($response->getLimit());
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
    }

    public function testGetArtistAlbumsWhenArtistDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getArtistAlbums('fake-artist');
    }

    public function testGetArtistAlbumsWithCountry()
    {
        $response = $this->api->getArtistAlbums('0LcJLqbBmaGUft1e9Mm8HV', 'GB');

        $this->assertInstanceOf('Audeio\Spotify\Entity\AlbumPagination', $response);
        $this->assertNotNull($response->getHref());
        $this->assertNotNull($response->getLimit());
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
    }

    public function testGetArtistAlbumsWithCountryAndAlbumTypes()
    {
        $response = $this->api->getArtistAlbums('0LcJLqbBmaGUft1e9Mm8HV', 'GB', array('single', 'compilation'));

        $this->assertInstanceOf('Audeio\Spotify\Entity\AlbumPagination', $response);
        $this->assertContains('album_type=single,compilation', $response->getHref());
        $this->assertNotNull($response->getLimit());
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
    }

    public function testGetArtistAlbumsWithCountryAlbumTypesAndLimit()
    {
        $response = $this->api->getArtistAlbums('0LcJLqbBmaGUft1e9Mm8HV', 'GB', array('single', 'compilation'), 2);

        $this->assertInstanceOf('Audeio\Spotify\Entity\AlbumPagination', $response);
        $this->assertContains('album_type=single,compilation', $response->getHref());
        $this->assertEquals(2, $response->getLimit());
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
        $this->assertLessThanOrEqual(2, $response->getItems()->count());
    }

    public function testGetArtistTopTracks()
    {
        $response = $this->api->getArtistTopTracks('43ZHCT0cAZBISjO8DG9PnE', 'SE');

        $this->assertInstanceOf('Audeio\Spotify\Entity\TrackCollection', $response);
    }

    public function testGetArtistTopTracksWhereArtistDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getArtistTopTracks('fake-artist', 'SE');
    }

    public function testGetArtistTopTracksWhereCountryDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'Invalid country code');

        $this->api->getArtistTopTracks('43ZHCT0cAZBISjO8DG9PnE', 'NOPE');
    }

    public function testGetArtistRelatedArtists()
    {
        $response = $this->api->getArtistRelatedArtists('43ZHCT0cAZBISjO8DG9PnE');

        $this->assertInstanceOf('Audeio\Spotify\Entity\ArtistCollection', $response);
    }

    public function testGetArtistRelatedArtistsWhereArtistDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getArtistRelatedArtists('fake-artist');
    }

    public function testGetTrack()
    {
        $response = $this->api->getTrack('0eGsygTp906u18L0Oimnem');

        $this->assertInstanceOf('Audeio\Spotify\Entity\Track', $response);
    }

    public function testGetTrackWhereTrackDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getTrack('fake-track');
    }

    public function testGetTracks()
    {
        $response = $this->api->getTracks(array('0eGsygTp906u18L0Oimnem', '1lDWb6b6ieDQ2xT7ewTC3G'));

        $this->assertInstanceOf('Audeio\Spotify\Entity\TrackCollection', $response);
    }

    public function testGetTracksWhereTrackDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'invalid id');

        $this->api->getTracks(array('fake-track', '1lDWb6b6ieDQ2xT7ewTC3G'));
    }

    public function testGetUserProfile()
    {
        $response = $this->api->getUserProfile('wizzler');

        $this->assertInstanceOf('Audeio\Spotify\Entity\User', $response);
    }

    public function testGetUserProfileWhereUserDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'No such user');

        $this->api->getUserProfile('fake-user-made-up-by-me-for-testing-93874123');
    }

    public function testGetCurrentUser()
    {
        $response = $this->api->getCurrentUser();

        $this->assertInstanceOf('Audeio\Spotify\Entity\User', $response);
    }

    public function testGetCurrentUserWithNoAuthorization()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\AccessTokenException');

        $this->api->setAccessToken(null);
        $this->api->getCurrentUser();
    }

    public function testGetUserPlaylist()
    {
        $response = $this->api->getUserPlaylist('beefkidney', '2YT3S2z4Q7qKbiPTIUiE2q');

        $this->assertInstanceOf('Audeio\Spotify\Entity\Playlist', $response);
    }

    public function testGetUserPlaylistWithSelectFields()
    {
        $response = $this->api->getUserPlaylist('beefkidney', '2YT3S2z4Q7qKbiPTIUiE2q', array('id', 'name'));

        $this->assertInstanceOf('Audeio\Spotify\Entity\Playlist', $response);
        $this->assertNull($response->isCollaborative());
        $this->assertNull($response->getDescription());
        $this->assertNull($response->getExternalUrls());
        $this->assertNull($response->getFollowers());
        $this->assertNotNull($response->getHref());
        $this->assertNotNull($response->getId());
        $this->assertNull($response->getImages());
        $this->assertNotNull($response->getName());
        $this->assertNull($response->getOwner());
        $this->assertNull($response->isPublic());
        $this->assertNull($response->getTracks());
        $this->assertNull($response->getType());
        $this->assertNull($response->getUri());
    }

    public function testGetUserPlaylistWhereUserDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'Not found');

        $this->api->getUserPlaylist('fake-user-made-up-by-me-for-testing-93874123', '2YT3S2z4Q7qKbiPTIUiE2q');
    }

    public function testGetUserPlaylistWherePlaylistDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'Not found');

        $this->api->getUserPlaylist('beefkidney', 'fake-playlist');
    }

    public function testGetUserPlaylistTracks()
    {
        $response = $this->api->getUserPlaylistTracks('beefkidney', '2YT3S2z4Q7qKbiPTIUiE2q');

        $this->assertInstanceOf('Audeio\Spotify\Entity\PlaylistTrackPagination', $response);
        $this->assertNotNull($response->getHref());
        $this->assertNotNull($response->getLimit());
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
    }

    public function testGetUserPlaylistTracksWithSelectFields()
    {
        $response = $this->api->getUserPlaylistTracks(
            'beefkidney',
            '2YT3S2z4Q7qKbiPTIUiE2q',
            array('href', 'items.track.name', 'items.track.uri')
        );

        $this->assertInstanceOf('Audeio\Spotify\Entity\PlaylistTrackPagination', $response);
        $this->assertNotNull($response->getHref());
        $this->assertNotNull($response->getLimit());
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
        $this->assertNull($response->getItems()->first()->getTrack()->getId());
        $this->assertNotNull($response->getItems()->first()->getTrack()->getName());
        $this->assertNotNull($response->getItems()->first()->getTrack()->getUri());
    }

    public function testGetUserPlaylistTracksWhereUserDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'Not found');

        $this->api->getUserPlaylistTracks('fake-user-made-up-by-me-for-testing-93874123', '2YT3S2z4Q7qKbiPTIUiE2q');
    }

    public function testGetUserPlaylistTracksWherePlaylistDoesNotExist()
    {
        $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'Not found');

        $this->api->getUserPlaylistTracks('beefkidney', 'fake-playlist');
    }

    public function testGetUserPlaylists()
    {
        $response = $this->api->getUserPlaylists('beefkidney');

        $this->assertInstanceOf('Audeio\Spotify\Entity\PlaylistPagination', $response);
        $this->assertNotNull($response->getHref());
        $this->assertNotNull($response->getLimit());
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
    }

    public function testGetUserPlaylistsWhereUserDoesNotExist()
    {
        // TODO: Check with Spotify is this is really meant to return an empty Pagination object
        // $this->setExpectedException('Audeio\Spotify\Exception\SpotifyException', 'No such user');

        $response = $this->api->getUserPlaylists('fake-user-made-up-by-me-for-testing-93874123');

        $this->assertInstanceOf('Audeio\Spotify\Entity\PlaylistPagination', $response);
        $this->assertNotNull($response->getHref());
        $this->assertSame(0, $response->getItems()->count());
        $this->assertSame(20, $response->getLimit());
        $this->assertNotNull($response->getOffset());
        $this->assertNotNull($response->getTotal());
    }
}
