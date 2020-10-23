<?php

header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/shanghai');

$password = md5(md5($_SERVER['PHP_AUTH_PW']) . md5('admin'). 'lEhAP4lSlm1581494378');
/////////////////// Password protect ////////////////////////////////////////////////////////////////
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' || '014b5afad4beb6367b7e89f4b74dca0d' != $password) {
    Header("WWW-Authenticate: Basic realm=\"Admin Login\"");
    Header("HTTP/1.0 401 Unauthorized");

    echo <<<EOB
                    <html><body>
                    <h1>Rejected!</h1>
                    <big>Wrong Username or Password!</big>
                    </body></html>
EOB;
    exit;
}

phpinfo();
