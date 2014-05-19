<?php

/**
 *  Constant defined for client Id,client Secret Key.
 *
 */
const CLIENT_ID = '< Enter Your CLIENT_ID >';
const CLIENT_SECRET = '< Enter Your CLIENT_SECRET >';

/*
*  Constant for token url.
*  TOKEN_URI    => From which we will get authorize token using CLIENT_ID and CLIENT_SECRET
*  
*/

const TOKEN_URI        = 'https://api.fronter.com/oauth/token';

// This is the resource url that you want to fetch after getting valid token from api.fronter.com
$resourceURL = 'https://api.fronter.com/clients/' . CLIENT_ID;
