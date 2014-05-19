<?php
/**
 * Date: 25.03.14 
 *
 * @author QuirkyMisfits Team
 * @copyright 2009-14 Fronter AS. All rights reserved.
 * @version 1.0.1
 * 
 * This is a client file which show how to fetch token
 * from api.fronter.com
 * 
 *
 */

/*
*  This will include library for accessing api.fronter.com
*/
require_once("../src/oauth2.class.php");
// Include all the configuration from config file.
include_once("../config/config.php");
include_once("templates/main.php");

echo pageHeader("A query for getting Token using OAuth 2.0 authentication");

try {
  $client_id = CLIENT_ID;
  $client_secret = CLIENT_SECRET;
  $token_end_point = TOKEN_URI;

  // Intializing call for api.fronter.com
  $oauth2ClassObj = new FronterOAuth2();

  // Setting Client Id for request
  $oauth2ClassObj->setClientId($client_id);

  // Setting Client Secret Key for Request
  $oauth2ClassObj->setClientSecretKey($client_secret);

  // Setting Authorization Type which is currently AUTH_TYPE_AUTHORIZATION_BASIC for request
  $oauth2ClassObj->setAuthorizationType('1'); // 1 for AUTH_TYPE_AUTHORIZATION_BASIC

  // Setting Token End point URL for request
  $oauth2ClassObj->setTokenEndPoint($token_end_point);

  // Setting Grant Type for request , default value is client_credentials
  $oauth2ClassObj->setGrantType('client_credentials'); // client_credentials for GRANT_TYPE_CLIENT_CREDENTIALS

  // Setting extra param if required by request
  $oauth2ClassObj->setExtraParams(array());

  // Getting Access Token using Client Id mentioned in  Config file.
  $response = $oauth2ClassObj->getAccessTokenForClientId();
?>
  <div class="box">  
    <div>
     Access Token :<br/><textarea cols="45" rows="25"><?= $response['access_token']; ?></textarea>   
    </div>
</div>
<?php
} catch (Exception $e){
  // Printing error message while accessing token from api.fronter.com
  print "Error Code : ".$response['code'] .' and Error Message : '. $response['result'];
}

echo pageFooter(__FILE__);
