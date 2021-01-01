<?php 

$id = isset( $_GET['id'] ) ? $_GET['id'] : null;
$userId = isset( $_GET['user_id'] ) ? $_GET['user_id'] : null;

if( $id == null or $userId == null ) {
    header( 'Location: /signout' );
}

require '../db.php';

$sqlDeactivateReminder = $db->prepare( "UPDATE reminders SET active = 0 WHERE id = :id AND user_id = :userId" );

try {
    $sqlDeactivateReminder->execute( [
        'id' => $id,
        'userId' => $userId
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}

// echo 'this is /app/reminders/deactivate-a-reminder.php<br>';
// var_dump($_GET);
// die();

$headerString = 'Location: /account/?view=reminders';
header( $headerString );
die();
