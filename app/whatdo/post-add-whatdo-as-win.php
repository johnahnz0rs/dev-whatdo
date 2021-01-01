<?php

$whatDoId = isset( $_POST['whatdo_id'] ) ? strval( $_POST['whatdo_id'] ) : null;
$userId = isset( $_POST['user_id'] ) ? strval( $_POST['user_id'] ) : null;
$date = isset( $_POST['date'] ) ? strval( $_POST['date'] ) : null;
$title = isset( $_POST['title'] ) ? strval( $_POST['title'] ) : null;
$note = isset( $_POST['note'] ) ? strval( $_POST['note'] ) : null;

if( $whatDoId == null or $userId == null or $date == null or $title == null or $note == null ) {
    $headerString = 'Location: /dash/?view=whatdo';
    header( $headerString );
    die();
}

require '../db.php';

$sqlStackAWhatDo = $db->prepare( "INSERT INTO wins (user_id, date, whatdo_id, title, note, user_note, stacked) VALUES (:userId, :date, :whatDoId, :title, :note, :userNote, 0)" );

try {
    $sqlStackAWhatDo->execute( [
        'userId' => $userId,
        'date' => $date,
        'whatDoId' => $whatDoId,
        'title' => $title,
        'note' => $note,
        'userNote' => 'this is a whatDo'
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}

usleep(1337);
$headerString = 'Location: /dash/?view=wins&date=' . $date;
header( $headerString );
// die();
