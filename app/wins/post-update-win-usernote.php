<?php 

$userId = isset( $_POST['user_id'] ) ? strval( $_POST['user_id'] ) : null;
$id = isset( $_POST['id'] ) ? strval( $_POST['id'] ) : null;
$userNote = isset( $_POST['user_note'] ) ? addslashes( $_POST['user_note'] ) : null;
$date = isset( $_POST['date'] ) ? strval( $_POST['date'] ) : null;


if( $userId == null or $id == null or $date == null or $userNote == null ) {
    header( 'Location: /dash?view=wins');
}

require '../db.php';
$sqlUpdateWinUserNote = $db->prepare( "UPDATE wins SET user_note = :userNote WHERE id = :id and user_id = :userId" );
try {
    $sqlUpdateWinUserNote->execute( [
        'userNote' => $userNote,
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
