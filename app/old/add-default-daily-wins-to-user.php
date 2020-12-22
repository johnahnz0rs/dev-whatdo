<?php

// in the case that a user has no dailyWins (e.g. they just created an account):
// add the three default daily wins

session_start();

$userId = isset( $_COOKIE['user_id'] ) ? $_COOKIE['user_id'] : null;
if( !$userId ) {
    header( 'Location: /signout' );
}


// default 1: wake up early
$winOne = addslashes('Early Wake-Up Time');
$noteOne = addslashes("Start the day off on a positive note. Yes, it's nicer to stay in your warm, comfy bed. But command yourself to get up, which makes you master of yourself. YOU have control, NOT instant gratification.");

// default 2: PMA
$winTwo = addslashes('Work Out HARD');
$noteTwo = addslashes("Get your heart rate PUMPING. It is nature's only supplier of free feel-goods. Strengthen your body, so that you can live a long life, so that you can serve others as much as possible, as best as possible.");

// default 3: track your macros
$winThree = addslashes('Track Your Macros');
$noteThree = addslashes("Eating whatever you feel like inevitably leads to pain and regret. Instead choose PURPOSE: be aware of how what's on your plate will affect your body (and over time how you feel about yourself).");


// sql
require './db.php';
$sqlAddDefaultDailyWins = $db->prepare(" INSERT INTO daily_wins (user_id, win, note) VALUES (:userId, :winOne, :noteOne), (:userId, :winTwo, :noteTwo), (:userId, :winThree, :noteThree)");
try {
    $sqlAddDefaultDailyWins->execute([
        'userId' => $userId,
        'winOne' => $winOne,
        'noteOne' => $noteOne,
        'winTwo' => $winTwo,
        'noteTwo' => $noteTwo,
        'winThree' => $winThree,
        'noteThree' => $noteThree
    ]);
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}
$sup = $sqlAddDefaultDailyWins->rowCount();


// echo 'this is end of add-default-daily-wins-to-user.php';
$headerString = 'Location: /program';
header( $headerString );


