<?php

$userId = isset( $_POST['user_id'] ) ? strval( $_POST['user_id'] ) : null;
$title = isset( $_POST['title'] ) ? strval( $_POST['title'] ) : null;
$note = isset( $_POST['note'] ) ? strval( $_POST['note'] ) : null;

if( $userId == null or $title == null or $note == null ) {
    header( 'Location: /signout' );
}

require '../db.php';

$sqlCreateVice = $db->prepare( "INSERT INTO vices (user_id, title, note, active) VALUES (:userId, :title, :note, 1)" );

try {
    $sqlCreateVice->execute( [
        'userId' => $userId,
        'title' => $title,
        'note' => $note
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}

header( 'Location: /account/?view=vices' );
die();
