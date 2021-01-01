<?php 

$userId = isset( $_POST['user_id'] ) ? strval( $_POST['user_id'] ) : null;
$id = isset( $_POST['id'] ) ? strval( $_POST['id'] ) : null;
$date = isset( $_POST['date'] ) ? strval( $_POST['date'] ) : null;
$userNote = isset( $_POST['user_note'] ) ? $_POST['user_note'] : null;
// $userNote = isset( $_POST['user_note'] ) ? htmlspecialchars( $_POST['user_note'] ) : null;
// $userNote = isset( $_POST['user_note'] ) ? addslashes( $_POST['user_note'] ) : null;
// $userNote = addslashes( $userNote );

// echo '<p>id: ' . $id . ' (' . gettype($id) . ')</p>';
// echo '<p>userId: ' . $userId . ' (' . gettype($userId) . ')</p>';
// echo '<p>date: ' . $date . ' (' . gettype($date) . ')</p>';
// echo '<p>userNote: ' . $userNote . ' (' . gettype($userNote) . ')</p>';
// var_dump($userNote);
// die();


if( $userId == null or $id == null or $date == null or $userNote == null ) {
    $headerString = 'Location: /dash?view=vices';
    header( $headerString );
}

require '../db.php';
$sqlUpdateViceUserNote = $db->prepare( 'UPDATE vice_counts SET user_note = :userNote WHERE id = :id and user_id = :userId' );
try {
    $sqlUpdateViceUserNote->execute( [
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
$headerString = 'Location: /dash/?view=vices&date=' . $date;
header( $headerString );
die();
