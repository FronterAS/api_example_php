DESCRIPTION
============
This is a working example for getting access token from api.fronter.com and how to fetch resource using api.fronter.com.

It is using adoy/PHP-OAuth2 Library for authentication and authorization.

Currently we are using these types for grant, access token and authorization.

Grant Type         : OAuth2\Client::GRANT_TYPE_CLIENT_CREDENTIALS

Access Token Type  : OAuth2\Client::ACCESS_TOKEN_OAUTH

Authorization Type : OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC


REQUIREMENTS
==============
1. php
2. git
3. composer.phar


INSTALLATION
==============
1. To get sample example for consuming api.fronter.com clone git repository ( https://gitlab.fronter.net/dhirajkumar.gupta/php_example_to_consume_api_fronter_com.git)
2. Install composer.phar from this url ( https://getcomposer.org/doc/00-intro.md)
   using below command you can install composer.phar.<br/>
   " curl -sS https://getcomposer.org/installer | php "
3. After you install composer.phar, run command " php composer.phar install "
4. Please replace '< Enter Your CLIENT_ID >' and '< Enter Your CLIENT_SECRET >' with your Client Id and Client Secert values respectively in config/config.php .
5. After you done with all dependencies try to run examples/index.php file on your browser.
6. If you want to customize sample application then you can modify examples/get_token.php or examples/get_resource.php or you can create your own consumer application.

TESTING
===========
To Run PHPUnit Test:

	./vendor/bin/phpunit

HOMEPAGE
==========
https://fronter.com