<?php
namespace Audeio\Spotify;

class AuthorizationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var string
     */
    private $clientId = 'clientId';

    /**
     * @var string
     */
    private $clientSecret = 'clientSecret';

    /**
     * @var string
     */
    private $redirectUri = 'redirectUri';

    /**
     * @var Authorization
     */
    private $authorization;

    public function setUp()
    {
        $this->authorization = new Authorization($this->clientId, $this->clientSecret, $this->redirectUri);
    }

    public function testGetAuthorizationUrl()
    {
        $result = $this->authorization->getAuthorizationUrl();

        $expectedUrl = sprintf(
            "https://accounts.spotify.com/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=&show_dialog=false&state=",
            $this->clientId,
            $this->redirectUri
        );

        $this->assertSame($expectedUrl, $result);
    }

    public function testGetAuthorizationUrlWithScope()
    {
        $result = $this->authorization->getAuthorizationUrl(array(
                'scope' => array('playlist-modify')
            ));

        $expectedUrl = sprintf(
            "https://accounts.spotify.com/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s&show_dialog=false&state=",
            $this->clientId,
            $this->redirectUri,
            'playlist-modify'
        );

        $this->assertSame($expectedUrl, $result);
    }

    public function testGetAuthorizationUrlWithScopes()
    {
        $result = $this->authorization->getAuthorizationUrl(array(
            'scope' => array('playlist-modify', 'user-read-email')
        ));

        $expectedUrl = sprintf(
            "https://accounts.spotify.com/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s&show_dialog=false&state=",
            $this->clientId,
            $this->redirectUri,
            'playlist-modify+user-read-email'
        );

        $this->assertSame($expectedUrl, $result);
    }

    public function testGetAuthorizationUrlWithShowDialog()
    {
        $result = $this->authorization->getAuthorizationUrl(array(
            'show_dialog' => true
        ));

        $expectedUrl = sprintf(
            "https://accounts.spotify.com/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=&show_dialog=true&state=",
            $this->clientId,
            $this->redirectUri
        );

        $this->assertSame($expectedUrl, $result);
    }

    public function testGetAuthorizationUrlWithState()
    {
        $result = $this->authorization->getAuthorizationUrl(array(
            'state' => 'something'
        ));

        $expectedUrl = sprintf(
            "https://accounts.spotify.com/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=&show_dialog=false&state=something",
            $this->clientId,
            $this->redirectUri
        );

        $this->assertSame($expectedUrl, $result);
    }

    public function testGetAuthorizationUrlWithScopesAndState()
    {
        $result = $this->authorization->getAuthorizationUrl(array(
            'scope' => array('playlist-modify', 'user-read-email'),
            'state' => 'something'
        ));

        $expectedUrl = sprintf(
            "https://accounts.spotify.com/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s&show_dialog=false&state=something",
            $this->clientId,
            $this->redirectUri,
            'playlist-modify+user-read-email'
        );

        $this->assertSame($expectedUrl, $result);
    }

    public function testGetAuthorizationUrlWithScopesStateAndDialog()
    {
        $result = $this->authorization->getAuthorizationUrl(array(
            'scope' => array('playlist-modify', 'user-read-email'),
            'show_dialog' => true,
            'state' => 'something',
        ));

        $expectedUrl = sprintf(
            "https://accounts.spotify.com/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s&show_dialog=true&state=something",
            $this->clientId,
            $this->redirectUri,
            'playlist-modify+user-read-email'
        );

        $this->assertSame($expectedUrl, $result);
    }
}
 