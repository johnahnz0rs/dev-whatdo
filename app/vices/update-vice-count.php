<?php

// echo 'this is /app/vices/increment-vice-count.php<br>';
// echo '<pre>';
// var_dump($_GET);
// echo '</pre>';
// die();


$count = isset( $_GET['count'] ) ? $_GET['count'] : null;
$id = isset( $_GET['id'] ) ? $_GET['id'] : null;
$userId = isset( $_GET['user_id'] ) ? $_GET['user_id'] : null;
$date = isset( $_GET['date'] ) ? $_GET['date'] : null;

if( $count == null or $id == null or $userId == null or $date == null ) {
    header( 'Location: /dash/?view=vices' );
    die();
}

require '../db.php';

$sqlIncrementViceCount = $db->prepare( 'UPDATE vice_counts SET count = :count WHERE id = :id AND user_id = :userId' );
try {
    $sqlIncrementViceCount->execute( [
        'count' => $count,
        'id' => $id,
        'userId' => $userId
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}

$headerString = 'Location: /dash/?date=' . $date . '&view=vices';
die();
header( $headerString );
