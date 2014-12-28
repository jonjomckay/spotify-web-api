Spotify Web API
===============

[![Build Status](https://travis-ci.org/jonjomckay/spotify-web-api.png?branch=develop)](https://travis-ci.org/jonjomckay/spotify-web-api)

## Requirements

* PHP 5.4+
* An OAuth 2 client ([league/oauth2-client](https://github.com/thephpleague/oauth2-client) works well)

## Installation

1. Add `"audeio/spotify-web-api": "0.*"` to your `composer.json`
2. Run `composer update` to update your application with the new dependency
3. That's all!

### Usage

1. Instantiate a new instance of `Audeio\Spotify\API` and set the access token retrieved by your OAuth 2 client (a provider for `league/oauth2-client` is included under `Audeio\Spotify\
Oauth2\Client\Provider\Spotify`):

    ```php
    $api = new \Audeio\Spotify\API();
    $api->setAccessToken('BAWSDOJWEO984yt34y35YgdsnhlreGERH56u45htrH54y');
    ```

2. Call all the methods you need!

    ```php
    $api->getAlbum('id');
    $api->getAlbums(array('id-1', 'id-2', 'id-3'));
    $api->getAlbumTracks('id');
    $api->getArtist('id');
    $api->getArtists(array('id-1', 'id-2', 'id-3'));
    $api->getArtistAlbums('id', 'country');
    $api->getArtistRelatedArtists('id');
    $api->getTrack('id');
    $api->getTracks(array('id-1', 'id-2', 'id-3'));
    $api->getUserProfile('id');
    $api->getCurrentUser();
    $api->getUserPlaylist('userId', 'id');
    $api->getUserPlaylistTracks('userId', 'id');
    $api->getUserPlaylists('id');
    ```

## License
The MIT License; please see [LICENSE](LICENSE) for more information.