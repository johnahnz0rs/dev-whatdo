<?php

// validate method & fields
if( $_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: /login');
}


$username = isset( $_POST['username'] ) ? strtolower( trim( $_POST['username'] ) ) : null;
$password = isset( $_POST['password'] ) ? trim( $_POST['password'] ) : null;


if( !$username or !$password ) {
    setcookie( 'login_result', 'Please enter your username and password.', time() + 15, '/' );
    $headerString = 'Location: /login';
    header($headerString);
    die();
}

// requires and vars
require '../db.php';
$dateToday = strval( date('Y-m-d') );


// get user with $username
$sqlUser = $db->prepare( "SELECT id, pass_hash FROM users WHERE username = :username" );
try {
    $sqlUser->execute( [ 'username' => $username ] );
} catch( PDOException $e ) {
    $output = $e->getMessage();
    echo $output;
}
$user = $sqlUser->rowCount() ? $sqlUser->fetch( PDO::FETCH_ASSOC ) : null;


// no user exists
if( !$user ) {
    setcookie( 'login_result', 'Username does not exist. Please try again.', time() + 15, '/' );
    $headerString = 'Location: /login';
    header($headerString);
    die();

// yes, user exists
} else {

    // bad pass
    if( !password_verify( $password, $user['pass_hash'] ) ) {
        setcookie( 'login_result', 'Bad Password. Please try again.', time() + 15, '/' );
        $headerString = 'Location: /login';
        header($headerString);
        die();
        
    // good pass
    } else {
        // set cookies and redirect to program w/ todayecho '<pre>';
        setcookie( 'username', $username, time() + 60*60*24, '/' );
        $userId = $user['id'];
        setcookie( 'user_id', $userId, time() + 60*60*24, '/' );
        $passHash = $user['pass_hash'];
        setcookie( 'pass_hash', $passHash, time() + 60*60*24, '/' );
        $headerString = 'Location: /dash?date=' . $dateToday;
        header($headerString);
        die();
    }

}


?>