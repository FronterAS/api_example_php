<?php
/**
 * Date: 25.03.14
 *
 * @author QuirkyMisfits Team
 * @copyright 2009-14 Fronter AS. All rights reserved.
 * @version 1.0.1
 *
 * This is a client file which contains different
 * methods for defining/initailizing different variable which 
 * are used during generating Access Token and  fetching
 * resource from Access Token Endpoint and Resource End Point
 * respectively.
 * 
 */

/*
*  This will include library for accessing api.fronter.com
*/
require_once(__DIR__ ."/../vendor/autoload.php");
// Include all the configuration from config file.
include_once(__DIR__ ."/../config/config.php");


class FronterOAuth2 extends OAuth2\Client
{

    private $clientId = null;
    private $clientSecretKey = null;
    private $authorizationType = null;
    private $accessToken = null;
    private $tokenEndPoint = null;
    private $grantType = null;
    private $extraParams = array();
    private $tokenType = null;
    private $resourceEndPoint = null;

    /**
     * __constructor for intializing obejct for this class
     */
    public function __construct()
    {
        return true;
    }

    /**
     * To get clientId
     * @return string $this->clientId
    */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * To set clientId 
     * @param string $client_id Client Id for consuming application
     */
    public function setClientId($client_id)
    {
        $this->clientId = $client_id;
    }

    /**
     * To get client sceret key
     * @return string client sceret key
     */
    public function getClientSecretKey()
    {
        return $this->clientSecretKey;
    }

    /**
     * To set client sceret key
     * @param string $client_secret_key Client Sceret Key for consuming application
     */
    public function setClientSecretKey($client_secret_key)
    {
        $this->clientSecretKey = $client_secret_key;
    }

    /**
     * To get suthorization Type
     * @return string Authorization Type used by consuming application
     */
    public function getAuthorizationType()
    {
        return $this->authorizationType;
    }

    /**
     * To set authorization Type
     * @param string $authorization_type Authorization type used by consuming application
     */
    public function setAuthorizationType($authorization_type)
    {
        switch ($authorization_type) {
            case '0':
                $this->authorizationType = OAuth2\Client::AUTH_TYPE_URI;
                break;
            case '1':
                $this->authorizationType = OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC;
                break;
            case '2':
                $this->authorizationType = OAuth2\Client::AUTH_TYPE_FORM;
                break;
        }
    }

    /**
     * To get Access Token
     * @return string Access Token generated by api.fronter.com
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * To set Access Token for getting resource
     * @param string $access_token Access Token generated by api.fronter.com
     */
    public function setAccessToken($access_token)
    {
        $this->accessToken = $access_token;
    }

    /**
     * To get Token Endpoint URL
     * @return string Token endpoint url
     */
    public function getTokenEndPoint()
    {
        return $this->tokenEndPoint;
    }

    /**
     * To set Token Endpoint URL
     * @param string $token_endpoint Token Endpoint URL from where you need to request token
     */
    public function setTokenEndPoint($token_endpoint)
    {
        $this->tokenEndPoint = $token_endpoint;
    }

    /**
     * To get Grant Type
     * @return string Grant type used for requesting token
     */
    public function getGrantType()
    {
        return $this->grantType;
    }

    /**
     * To set Grant Type
     * @param string $grant_type Grant Type used for requesting access token
     */
    public function setGrantType($grant_type)
    {
        switch ($grant_type) {
            case 'client_credentials':
                $this->grantType = OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS;
                break;
            case 'password':
                $this->grantType = OAuth2\Client::GRANT_TYPE_PASSWORD;
                break;
            case 'authorization_code':
                $this->grantType = OAuth2\Client::GRANT_TYPE_AUTH_CODE;
                break;
            case 'refresh_token':
                $this->grantType = OAuth2\Client::GRANT_TYPE_REFRESH_TOKEN;
                break;
        }
    }


    /**
     * To get extra params if used any
     * @return array Extra Params used for requesting access token
     */
    public function getExtraParams()
    {
        return $this->extraParams;
    }

    /**
     * To set extra Params if used any
     * @param array $extra_params Extra Params used while requesting access token
     */
    public function setExtraParams($extra_params)
    {
        $this->extraParams = $extra_params;
    }

    /**
     * To get Token Type
     * @return string Token Type used while accessing Resource
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * To set Token Type
     * @param string $token_type Token Type used while accessing resource
     */
    public function setTokenType($token_type)
    {
        switch ($token_type) {
            case '0':
                $this->tokenType = OAuth2\Client::ACCESS_TOKEN_URI;
                break;
            case '1':
                $this->tokenType = OAuth2\Client::ACCESS_TOKEN_BEARER;
                break;
            case '2':
                $this->tokenType = OAuth2\Client::ACCESS_TOKEN_OAUTH;
                break;
            case '3':
                $this->tokenType = OAuth2\Client::ACCESS_TOKEN_MAC;
                break;
        }
    }

    /**
     * To get Resource End Point
     * @return string Resource End Point URL
     */
    public function getResourceEndPoint()
    {
        return $this->resourceEndPoint;
    }

    /**
     * To set Resource End Point URL
     * @param string $resource_endpoint Resource End Point URL used for accessing Resource
     */
    public function setResourceEndPoint($resource_endpoint)
    {
        $this->resourceEndPoint = $resource_endpoint;
    }

    /**
     * To get Access Token for specified Client Id
     * @return array/Exception Array for Acces Token details generated for specified clientId 
     * ,Client Secret Key/Exception with message
     */
    public function getAccessTokenForClientId()
    {
        try {
            $oauthClientObject = new OAuth2\Client(
                $this->clientId,
                $this->clientSecretKey,
                $this->authorizationType
            );
            // Generating Token
            $tokenResponse = $oauthClientObject->getAccessToken(
                $this->tokenEndPoint,
                $this->grantType,
                $this->extraParams
            );
            // Redirect User to resource page after getting valid access token for client id
            if ($tokenResponse['code'] == '200') {
                $response = $tokenResponse['result'];
            } else {
                if(is_array($tokenResponse['result'])){
                    $tokenResponse['result'] = $tokenResponse['result']['error'];
                }
                // print error code and error message for error occured during fetching
                $response['access_token'] = $tokenResponse['result'];
            }
            return $response;
        } catch (Exception $e) {
            throw new Exception('Error Occured');
        }
    }

    /**
     * To get Resource Using Access Token
     * @return array/Exception Response Array containg resource details/Exception if any
     */
    public function getResourceUsingAccessToken()
    {

        try {
            $oauthClientObject = new OAuth2\Client($this->clientId, $this->clientSecretKey, $this->authorizationType);
            $oauthClientObject->setAccessToken($this->accessToken);
            // Setting Up the access Token Type to client Object
            $oauthClientObject->setAccessTokenType($this->tokenType);

            // Finally fetching resource from Resource URL using access token
            $resourceResponse = $oauthClientObject->fetch($this->resourceEndPoint);

            // response fetched
            $response = $resourceResponse['result'];

            return $response;
        } catch (Exception $e) {
            throw new Exception('Error Occured');
        }
    }
}
