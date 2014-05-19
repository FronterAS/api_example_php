<?php
/* Ad hoc functions to make the examples marginally prettier.*/
function isWebRequest()
{
    return isset($_SERVER['HTTP_USER_AGENT']);
}

function pageHeader($title)
{
    $ret = "";
    if (isWebRequest()) {
        $ret .= "<!doctype html>
    <html>
    <head>
      <title>" . $title . "</title>
      <link href='styles/style.css' rel='stylesheet' type='text/css' />
    </head>
    <body>\n";
        $ret .= '<img src="images/fronter_big-logo.png" alt="Fronter" id="fronter-logo">';
        if (!preg_match('/index.php/', $_SERVER['SCRIPT_NAME'])) {
            $ret .= "<p><a href='index.php'>Back</a></p>";
        }
        $ret .= "<header><h1>" . $title . "</h1></header>";
    }
    return $ret;
}


function pageFooter($file = null)
{
    $ret = "";
    if (isWebRequest()) {
        // Echo the code if in an example.
        if ($file) {
            $ret .= "<h3>Code:</h3>";
            $ret .= "<pre class='code'>";
            $ret .= htmlspecialchars(file_get_contents($file));
            $ret .= "</pre>";
        }
        $ret .= "</html>";
    }
    return $ret;
}
