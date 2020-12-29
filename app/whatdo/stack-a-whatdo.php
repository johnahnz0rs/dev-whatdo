<?php
// user_id, date, whatdo_id, title
// echo 'this is /app/whatdo/stack-a-whatdo.php';
// echo '<pre>';
// var_dump($_GET);
// echo '</pre>';
// die();

$whatDoId = isset( $_GET['whatdo_id'] ) ? strval( $_GET['whatdo_id'] ) : null;
$userId = isset( $_GET['user_id'] ) ? strval( $_GET['user_id'] ) : null;
$date = isset( $_GET['date'] ) ? strval( $_GET['date'] ) : null;
$title = isset( $_GET['title'] ) ? strval( $_GET['title'] ) : null;
$note = isset( $_GET['note'] ) ? strval( $_GET['note'] ) : null;

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
