<?php
include_once "templates/main.php";
if (!isWebRequest()) {
    echo "To view this page on a webserver using PHP 5.4 or above run: \n\t
    php -S localhost:8080\n";
    exit();
}
echo pageHeader("Examples for Consuming api.fronter.com using Fronter Library."); ?>
    <ul>
        <li><a href="get_token.php">A query for getting Token using OAuth 2.0 authentication</a></li>
        <li><a href="get_resource.php">A query for accessing resource using OAuth 2.0 authentication.</a></li>
    </ul>
<?php echo pageFooter();