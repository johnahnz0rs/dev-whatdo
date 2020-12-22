<?php

// validate method
if( $_SERVER['REQUEST_METHOD'] !== "POST") {
    header('Location: /#register');
}

// validate fields
$username = isset( $_POST['username'] ) ? strtolower( trim( $_POST['username'] ) ) : null;
$email = isset( $_POST['email'] ) ? trim( $_POST['email'] ) : null;
$password = isset( $_POST['password'] ) ? trim( $_POST['password'] ) : null;
$confirmPassword = isset( $_POST['confirm-password'] ) ? trim( $_POST['confirm-password'] ) : null;
$fname = isset( $_POST['fname'] ) ? trim( $_POST['fname'] ) : null;
$lname = isset( $_POST['lname'] ) ? trim( $_POST['lname'] ) : null;
$dob = isset( $_POST['dob'] ) ? trim( $_POST['dob'] ) : null;
if( !$username or !$email or !$password or !$confirmPassword or !$fname or !$lname or ($password != $confirmPassword) ) {
    setcookie('register_result', 'Please enter all required fields.', time() + 15, '/');
    $headerString = 'Location: /#register';
    header( $headerString );
    die();
}


// check if user already exists
require '../db.php';
$sqlDoesUserExist = $db->prepare( "SELECT id FROM users WHERE username = :username" );
try {
    $sqlDoesUserExist->execute([
        'username' => $username
    ]);
} catch( PDOException $e ) {
    $output .= $e->getMessage();
    echo $output;
}
$doesUserExist = $sqlDoesUserExist->rowCount() ? true : false;
if( $doesUserExist ) {
    setcookie('register_result', 'Sorry, username already exists. Please choose another.', time() + 15, '/');
    $headerString = 'Location: /#register';
    header( $headerString );
    die();
}


// hash the pass & insert user
$passHash = password_hash( $password, PASSWORD_DEFAULT );
$sqlAddNewUser = $db->prepare( "INSERT INTO users (username, email, pass_hash, fname, lname, dob) VALUES (:username, :email, :pass_hash, :fname, :lname, :dob)" );
try {
    $sqlAddNewUser->execute([
        'username' => $username,
        'email' => $email,
        'pass_hash' => $passHash,
        'fname' => $fname,
        'lname' => $lname,
        'dob' => $dob
    ]);
} catch( PDOException $e ) {
    $output .= $e->getMessage();
    echo $output;
}

// check if user insert was successful
$userId = $db->lastInsertId() ? $db->lastInsertId() : null;
// if not successful
if( !$userId ) {
    setcookie( 'register_result', 'Registration failed. Please try again.', time() + 15, '/' );
    $headerString = 'Location: /#register';
    header( $headerString );
    die();
}
// if user insert successful, then add default reminders, wins to stack in their daily program, and default vices
$sqlAddNewReminders = $db->prepare( "INSERT INTO reminders (user_id, type, title, note, active) VALUES (:user_id,  'vision', 'Everyone has a vision of their higher self', 'it comes from your own conscience; it is a message FROM your higher self, for you to BE your higher self. Even if nobody else can picture it for you, you MUST make it happen, or you will be unnecessarily filled with regret and resentment.' , 1), (:user_id, 'pains', 'Common Problem: Wallet', 'in present-day America, you MUST find a level of financial freedom that suits you and your dreams; otherwise, you WILL be a slave to your own financial illiteracy. LEARN! Track your expenses, reduce your expenses, and find ways to increase or multiply your income stream(s).', 1), (:user_id, 'pains', 'Common Problem: Waistline', 'when you look in the mirror, your reflection does not look like what you want to look like. You MUST fix this, or you will unnecessarily hate your experience of Life.', 1), (:user_id, 'personal', 'Your WHOLE World can change... if only YOU will change', 'Face it; if your life sucks, then it means something/everything that YOU have been doing is not working. You gotta try something new if you want something new.', 1)" );
try {
    $sqlAddNewReminders->execute( [
        'user_id' => $userId
    ] );
} catch( PDOException $e ) {
    $output .= $e->getMessage();
    echo $output;
}

$sqlAddNewPrograms = $db->prepare( "INSERT INTO programs (user_id, title, note, active) VALUES (:userId, 'Early Wake Up - get up and start making yourself proud of yourself!', 'What time did you wake up?', 1), (:userId, 'Alone Time', 'Spend time with yourself, by yourself. Listen to your own conscience: if you feel bad about something, then BINGO! You know what you need to fix. Get to it!', 1), (:userId, 'Work Out HARD', 'Getting your heart rate BUMPING is the only FREE method of earning CONFIDENCE, SELF-WORTH, and the POSITIVE state of mind you NEED to solve all your problems.', 1), (:userId, 'Track Your Macros', 'This is an exercise in self-honesty, discipline and dedication, and MAKING your body look and feel the way YOU want. If you cannot master what you put in your mouth, then you have no chance of meaningfully changing anything else in your Life.', 1)" );
try {
    $sqlAddNewPrograms->execute( [
        'userId' => $userId
    ] );
} catch( PDOException $e ) {
    $output .= $e->getMessage();
    echo $output;
}


$sqlAddNewVices = $db->prepare( "INSERT INTO vices (user_id, title, note, active) VALUES (:userId, 'Eating for Pleasure over Purpose', 'The purpose of food is to fuel your endeavor towards being a person YOU admire. Don\'t eat for pleasure, grow fat bitch man tits, and then feel bad about having fat bitch man tits because you ignored food\'s purpose and effects.', 1), (:userId, 'Financial Immaturity', 'Control your expenses, increase and multiply your income streams.', 1), (:userId, 'Drugs, Booze, Sex, Pills, Substances, TV, Games, Social Media, Internet', 'These are shortcuts to muting your negative self-talk (because negative self-talk doesn\'t feel good). Unfortunately, these things come with a bunch of super-wack side effects. What you\'re really looking for is a Positive Mental Attitude, which can most easily be gained through whole-hearted, positive ACTION and self-investment.', 1)" );
try {
    $sqlAddNewVices->execute( [
        'user_id' => $userId
    ] );
} catch( PDOException $e ) {
    $output .= $e->getMessage();
    echo $output;
}





// if( $userId ) {
setcookie( 'login_result', 'Registration Successful! Please log in to continue.', time() + 15, '/' );
$headerString = 'Location: /login';
header( $headerString );
// die();
// } 

?>