<?php 

$id = isset( $_GET['id'] ) ? $_GET['id'] : null;
$userId = isset( $_GET['user_id'] ) ? $_GET['user_id'] : null;

if( $id == null or $userId == null ) {
    header( 'Location: /signout' );
}

require '../db.php';

$sqlDeleteProgram = $db->prepare( "DELETE FROM programs WHERE id = :id AND user_id = :userId" );

try {
    $sqlDeleteProgram->execute( [
        'id' => $id,
        'userId' => $userId
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}

$headerString = 'Location: /account/?view=wins';
header( $headerString );
die();
