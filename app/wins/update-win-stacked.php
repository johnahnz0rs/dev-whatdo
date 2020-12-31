<?php
// this script updates the "stacked" column of a win (by id and user_id) and redirects to dash

// echo 'this is /app/wins/update-win-stacked.php';
// array(4) {
//     ["id"]=>
//     string(4) "1345"
//     ["user_id"]=>
//     string(1) "2"
//     ["stacked"]=>
//     string(1) "0"
//     ["date"]=>
//     string(10) "2020-12-24"
//   }

$id = isset( $_GET['id'] ) ? strval( $_GET['id'] ) : null;
$userId = isset( $_GET['user_id'] ) ? strval( $_GET['user_id'] ) : null;
$stacked = isset( $_GET['stacked'] ) ? strval( $_GET['stacked'] ) : null;
$date = isset( $_GET['date'] ) ? strval( $_GET['date'] ) : null;

if( $id == null or $userId == null or $stacked == null or $date == null ) {
    header( 'Location: /dash' ); 
    die();
}

require '../db.php';
$sqlUpdateWinStacked = $db->prepare( "UPDATE wins SET stacked = :stacked WHERE id = :id and user_id = :userId" );
$stacked = $stacked == '1' ? '0' : '1' ;

try {
    $sqlUpdateWinStacked->execute( [
        'stacked' => $stacked,
        'id' => $id,
        'userId' => $userId
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}

usleep(1337);
$headerString = 'Location: /dash/?view=wins&date=' . $date;
header( $headerString );
die();
