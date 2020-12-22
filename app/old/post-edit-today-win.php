<?php

if( $_SERVER['REQUEST_METHOD'] !== 'POST') {
    setcookie( 'login_result', 'Something went wrong. Please log in and try again.', time() + 15, '/' );
    $headerString = 'Location: /signout';
    header( $headerString );
}


echo 'id: ' . $_POST['id'] . '<br>';
echo 'winId: ' . $_POST['win_id'] . '<br>';
echo 'date: ' . $_POST['date'] . '<br>';
echo 'user_id: ' . $_POST['user_id'] . '<br>';
echo 'win: ' . $_POST['win'] . '<br>';
echo 'note: ' . $_POST['note'] . '<br>';
echo 'stacked: ' . $_POST['stacked'] . '<br>';

die();
