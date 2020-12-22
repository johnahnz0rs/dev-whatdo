<?php

session_start();

if( !isset( $_COOKIE['user_id'] ) or !isset( $_COOKIE['json_add_users_daily_wins_to_today_wins'] ) ) {
    // setcookie( 'login_result', 'Something went wrong. Please log in and try again.', time() + 30, '/' );
    // $headerString = 'Location: /signout';
    // header( $headerString );
    echo 'uh oh<br>';
    echo 'userId: ' . $_COOKIE['user_id'] . '<br>';
    echo 'userId: ' . $_COOKIE['json_add_users_daily_wins_to_today_wins'] . '<br>';
    die();
}
$userId = $_COOKIE['user_id'];
$jsonAddUsersDailyWinsToTodayWins = json_decode( $_COOKIE['json_add_users_daily_wins_to_today_wins'], true );
// echo gettype($jsonAddUsersDailyWinsToTodayWins) . '<br>';
// var_dump($jsonAddUsersDailyWinsToTodayWins);
// die();
$stringSQL = "INSERT INTO wins (user_id, win, note, win_id) VALUES ";
foreach( $jsonAddUsersDailyWinsToTodayWins as $win ) {
    // $stringSQL .= `( {$userId}, {$win['win']}, {$win['note']}, {$win['id']} ),`;
    $stringSQL .= '(' . $userId . ', \'' . $win['win'] . '\', \'' . $win['note'] . '\', ' . $win['id'] . '),';
    // $stringSQL .= '(' . $userId . ', ' . strval($win['win']) . ', '  . strval($win['note']) . ', ' . $win['id'] . '),';
    // var_dump($win);
    // echo '<br>';
    // echo '<p style="margin: 12px; padding: 12px; min-height: 100px; border: 1px solid black;">';
    // echo 'lol<br>';
    // echo $win['id'];
    // echo gettype($win) . '<br>';
    // var_dump($win);
    // echo $win['win'] . '<br>';
    // echo $win['note'] . '<br>';
    // echo $win['id'] . '<br>';
    // echo '</p>';
}
$stringSQL = rtrim( $stringSQL, ',' );

// echo 'lolololol<br>' . $stringSQL;
// die();

require './db.php';
$sqlAddUsersDailyWinsToTodayWins = $db->prepare( $stringSQL );
$sqlAddUsersDailyWinsToTodayWins->execute();
$sup = $sqlAddUsersDailyWinsToTodayWins->rowCount();





header( 'Location: /program ');
