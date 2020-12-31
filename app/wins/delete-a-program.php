<?php 

// $id = isset( $_GET['id'] ) ? $_GET['id'] : null;
// $userId = isset( $_GET['user_id'] ) ? $_GET['user_id'] : null;

// if( $id == null or $userId == null ) {
//     header( 'Location: /account/?view=reminders' );
// }

// require '../db.php';

// $sqlDeleteReminder = $db->prepare( "DELETE FROM reminders WHERE id = :id AND user_id = :userId" );

// try {
//     $sqlDeleteReminder->execute( [
//         'id' => $id,
//         'userId' => $userId
//     ] );
// } catch( PDOException $e ) {
//     $output = $e->getMessage();
//     echo $output;
//     die();
// }

// $headerString = 'Location: /account/?view=reminders';
// header( $headerString );
// die();

echo 'this is /app/wins/delete-a-program.php';
die();
