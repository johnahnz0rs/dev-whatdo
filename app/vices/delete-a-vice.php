<?php 

$id = isset( $_GET['id'] ) ? $_GET['id'] : null;
$userId = isset( $_GET['user_id'] ) ? $_GET['user_id'] : null;

if( $id == null or $userId == null ) {
    header( 'Location: /signout' );
}

require '../db.php';

$sqlDeleteVice = $db->prepare( "DELETE FROM vices WHERE id = :id AND user_id = :userId" );

try {
    $sqlDeleteVice->execute( [
        'id' => $id,
        'userId' => $userId
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}

$headerString = 'Location: /account/?view=vices';
header( $headerString );
die();
