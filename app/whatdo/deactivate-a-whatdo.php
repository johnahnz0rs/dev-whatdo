<?php 

$id = isset( $_GET['id'] ) ? $_GET['id'] : null;
$userId = isset( $_GET['user_id'] ) ? $_GET['user_id'] : null;

if( $id == null or $userId == null ) {
    header( 'Location: /signout' );
}

require '../db.php';

$sqlDeactivateWhatDo = $db->prepare( "UPDATE whatdos SET active = 0 WHERE id = :id AND user_id = :userId" );

try {
    $sqlDeactivateWhatDo->execute( [
        'id' => $id,
        'userId' => $userId
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}

$headerString = 'Location: /account/?view=whatdo';
header( $headerString );
die();
