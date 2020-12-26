<?php 

$userId = isset( $_POST['user_id'] ) ? strval( $_POST['user_id'] ) : null;
$id = isset( $_POST['id'] ) ? strval( $_POST['id'] ) : null;
$userNote = isset( $_POST['user_note'] ) ? addslashes( $_POST['user_note'] ) : null;
$date = isset( $_POST['date'] ) ? strval( $_POST['date'] ) : null;

// echo 'yoooo<br> userId: ' . $userId . ' <br> id: ' . $id . ' <br> userNote: ' . $userNote . ' <br> date: ' . $date;
// die();


if( $userId == null or $id == null or $date == null or $userNote == null ) {
    header( 'Location: /dash?view=wins ');
    // echo '<p style="border: 1px solid black; margin: 24px; padding: 12px;">someting wong<br>';
    // echo 'yoooo<br> userId: ' . $userId . ' <br> id: ' . $id . ' <br> userNote: ' . $userNote . ' <br> date: ' . $date;
    // echo '</p>';
    // die();
}

// echo 'yoooo<br> userId: ' . $userId . ' <br> id: ' . $id . ' <br> userNote: ' . $userNote . ' <br> date: ' . $date;
// die();

// array(4) {
//     ["user_id"]=>
//     string(1) "2"
//     ["id"]=>
//     string(4) "1345"
//     ["date"]=>
//     string(10) "2020-12-24"
//     ["user_note"]=>
//     string(7) "9:00 am"
//   }

require '../db.php';
$sqlUpdateWinUserNote = $db->prepare( "UPDATE wins SET user_note = :userNote WHERE id = :id and user_id = :userId" );
try {
    $sqlUpdateWinUserNote->execute( [
        'userNote' => $userNote,
        'id' => $id,
        'userId' => $userId
    ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
    die();
}

$headerString = 'Location: /dash/?view=wins&date=' . $date;
header( $headerString );
die();
