<?php

session_start();
$userId = isset( $_COOKIE['user_id'] ) ? $_COOKIE['user_id'] : null;
$dateToday = isset( $_COOKIE['date_today'] ) ? $_COOKIE['date_today'] : null;
$jsonArrayOfWinsToAdd = isset( $_COOKIE['json_array_of_wins_to_add'] ) ? $_COOKIE['json_array_of_wins_to_add'] : null;

if( !$jsonArrayOfWinsToAdd or !$dateToday or !$userId ) {
    setcookie( 'login_result', 'Something went wrong. Please log in and try again.', time() + 15, '/' );
    $headerString = 'Location: /signout';
    header( $headerString );
    die();
}

require './db.php';
$arrayOfWinsToAdd = json_decode( $jsonArrayOfWinsToAdd, true );

$stringAddWins = "INSERT INTO wins (user_id, win_id, date, win, note, stacked) VALUES ";
foreach( $arrayOfWinsToAdd as $win ) {
    $stringAddWins .= "(" . $userId . ", " . $win['id'] . ", \'" . strval( $dateToday ) . "\', '" . $win['win'] . "', '" . $win['note'] . "', '0'),";
}


$stringAddWins = rtrim( $stringAddWins, ',' );


// var_dump($stringAddWins);
// die();

$sqlAddWins = $db->prepare( $stringAddWins );
try {
    $sqlAddWins->execute();
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
}

$result = $sqlAddWins->rowCount();

setcookie( 'json_array_of_wins_to_add', '', -3600, '/' );
$headerString = 'Location: /program?date=' . strval( $dateToday );
header( $headerString );
die();






// // clear the cookie and redirect to /program
