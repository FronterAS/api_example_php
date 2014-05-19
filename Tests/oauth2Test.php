<?php
namespace Tests;

use OAuth2;

class Oauth2Test extends \PHPUnit_Framework_TestCase
{
    /**
    * It is intializing configuration need for calling api.fronter.com
    */
    public function __construct()
    {
        require_once('config/config.php');
    }

    /**
    * Test Case for getting token using valid ClientId
    */

    public function testGetTokenWithValidClientId()
    {
        $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

        // Here you can define any other params that you want to pass.
        $params = array();

        // Generating Token
        $tokenResponse = $client->getAccessToken(TOKEN_URI, OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS, $params);
        $httpCode = $tokenResponse['code'];
        $this->assertEquals($httpCode, 200);
    }

    /**
    * Test Case for getting token using Invalid ClientId
    *
    */

    public function testGetTokenWithInValidClientId()
    {
        $client = new OAuth2\Client('', CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

        // Here you can define any other params that you want to pass.
        $params = array();

        // Generating Token
        $tokenResponse = $client->getAccessToken(TOKEN_URI, OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS, $params);
        $httpCode = $tokenResponse['code'];

        $this->assertEquals($httpCode, 401);
    }

    /**
    * Test Case for getting token using valid Token End Point
    */

    public function testGetTokenWithInValidTokenEndPoint()
    {
        $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

        // Here you can define any other params that you want to pass.
        $params = array();

        // Generating Token
        $tokenResponse = $client->getAccessToken(
            'http://api.fronter.com/clients',
            OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS,
            $params
        );
        $httpCode = $tokenResponse['code'];

        $this->assertEquals($httpCode, 404);
    }

    /**
    * Test Case for getting resource with Valid Token fetched in previous request from
    * api.fronter.com
    *
    */

    public function testValidateResourceWithValidToken()
    {
        $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

        // Here you can define any other params that you want to pass.
        $params = array();

        // Generating Token
        $tokenResponse = $client->getAccessToken(TOKEN_URI, OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS, $params);
        $httpCode = $tokenResponse['code'];
        
        $client->setAccessToken($tokenResponse['result']['access_token']);
        // Setting Up the access Token Type to client Object
        $client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);

        // Finally fetching resource from Resource URL using access token
        $resourceResponse = $client->fetch('https://api.fronter.com/clients/'.CLIENT_ID);
        $checkClientId = $resourceResponse['result']['client_id'];

        $this->assertEquals($checkClientId, CLIENT_ID);
    }

    /**
    * Test Case for getting resource from resource url using Invalid Token
    */

    public function testFetchResourceWithInValidToken()
    {
        $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

        // Here you can define any other params that you want to pass.
        $params = array();

        // Generating Token
        $tokenResponse = $client->getAccessToken(TOKEN_URI, OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS, $params);
        $httpCode = $tokenResponse['code'];
        
        $client->setAccessToken('');
        // Setting Up the access Token Type to client Object
        $client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);

        // Finally fetching resource from Resource URL using access token
        $resourceResponse = $client->fetch('https://api.fronter.com/clients/'.CLIENT_ID);
        $resourceURLResponseHttpCode = $resourceResponse['code'];

        $this->assertEquals(401, $resourceURLResponseHttpCode);
    }

    /**
    * Test Case for fetching Resource using invalid resource url 
    *
    * @expectedException Exception
    *
    */
    public function testFetchingResourceWithInvalidResourceURL()
    {
        $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

        // Here you can define any other params that you want to pass.
        $params = array();

        // Generating Token
        $tokenResponse = $client->getAccessToken(TOKEN_URI, OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS, $params);
        $httpCode = $tokenResponse['code'];
        
        $client->setAccessToken($tokenResponse['result']['access_token']);
        // Setting Up the access Token Type to client Object
        $client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);

        // Finally fetching resource from Resource URL using access token
        $resourceResponse = $client->fetch('https://api.fronter1.com/clients/'.CLIENT_ID);
    }

    /**
    * Test Case for fetching Resource using invalid Access Token Bearer Type
    *
    */
    public function testFetchingResourceWithInvalidAccessTokenBearer()
    {
        $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

        // Here you can define any other params that you want to pass.
        $params = array();

        // Generating Token
        $tokenResponse = $client->getAccessToken(TOKEN_URI, OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS, $params);
        $httpCode = $tokenResponse['code'];
        
        $client->setAccessToken($tokenResponse['result']['access_token']);
        // Setting Up the access Token Type to client Object
        $client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_OAUTH);

        // Finally fetching resource from Resource URL using access token
        $resourceResponse = $client->fetch('https://api.fronter.com/clients/'.CLIENT_ID);

        $resourceURLResponseHttpCode = $resourceResponse['code'];

        $this->assertEquals(401, $resourceURLResponseHttpCode);
    }

    /**
    * Test Case for fetching Resource while using invalid Resource Client Id
    *
    */

    public function testFetchingResourceWithInvalidResourceClientId()
    {
        $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

        // Here you can define any other params that you want to pass.
        $params = array();

        // Generating Token
        $tokenResponse = $client->getAccessToken(TOKEN_URI, OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS, $params);
        $httpCode = $tokenResponse['code'];
        
        $client->setAccessToken($tokenResponse['result']['access_token']);
        // Setting Up the access Token Type to client Object
        $client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_OAUTH);

        // Finally fetching resource from Resource URL using access token
        $resourceResponse = $client->fetch('https://api.fronter.com/clients/12323');
        $resourceURLResponseHttpCode = $resourceResponse['code'];

        $this->assertEquals(401, $resourceURLResponseHttpCode);
    }

    /**
    * Test Case for fetching resource from resource url while using Invalid
    * Grant Type
    * 
    * @expectedException Exception
    *
    */

    public function testFetchingResourceWithInvalidGrantType()
    {
        $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

        // Here you can define any other params that you want to pass.
        $params = array();

        // It will throw an Exception(InvalidArgumentException)
        $tokenResponse = $client->getAccessToken(TOKEN_URI, OAuth2\Client::GRANT_TYPE_PASSWORD, $params);
    }

    /**
    * Test Case for fetching resource from resource url while using Invalid
    * Authorization Type
    * 
    * @expectedException Exception
    *
    */

    public function testFetchingResourceWithInvalidAthorizationType()
    {
        $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_URI);

        // Here you can define any other params that you want to pass.
        $params = array();

        // It will throw an Exception(InvalidArgumentException)
        $tokenResponse = $client->getAccessToken(TOKEN_URI, OAuth2\Client::GRANT_TYPE_PASSWORD, $params);
    }
}
