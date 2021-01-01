<?php 

$id = isset( $_POST['id'] ) ? strval( $_POST['id'] ) : null;
$userId = isset( $_POST['user_id'] ) ? strval( $_POST['user_id'] ) : null;
$title = isset( $_POST['title'] ) ? strval( $_POST['title'] ) : null;
$note = isset( $_POST['note'] ) ? strval( $_POST['note'] ) : null;
$active = isset( $_POST['active'] ) ? strval( $_POST['active'] ) : null;


if( $userId == null or $title == null or $note == null or $active == null ) {
    header( 'Location: /signout' );
}
$active = $active == 'active' ? 1 : 0;

require '../db.php';
$sqlUpdateVice = $db->prepare( "UPDATE vices SET title = :title, note = :note, active = :active WHERE id = :id and user_id = :userId" );

try {
    $sqlUpdateVice->execute( [
        'title' => $title,
        'note' => $note,
        'active' => $active,
        'id' => $id,
        'userId' => $userId
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
}


$headerString = 'Location: /account/?view=vices';
header( $headerString );
die();
