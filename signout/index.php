<?php

session_start();
setcookie( 'user_id', '', -3600, '/' );
setcookie( 'username', '', -3600, '/' );
setcookie( 'pass_hash', '', -3600, '/');
setcookie( 'date_today', '', -3600, '/');
$headerString = 'Location: /';
header( $headerString );
