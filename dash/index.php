<?php
session_start();

$userId = isset( $_COOKIE['user_id'] ) ? $_COOKIE['user_id'] : null;
$username = isset( $_COOKIE['username'] ) ? $_COOKIE['username'] : null;
$passHash = isset( $_COOKIE['pass_hash'] ) ? $_COOKIE['pass_hash'] : null;

if ( !$userId or !$username or !$passHash ) {
    $headerString = 'Location: ../signout';
    header( $headerString );
    die();
}

/** requires and vars */
require '../app/db.php'; // just initiates the dbase connection
require '../app/helpers.php';
require '../components/recipes.php';
// get user's daily program
$date = $_GET['date'] ? $_GET['date'] : strval( date( 'Y-m-d' ) );
$program = getUsersProgram( $userId );
$wins = getUsersWins( $userId, $date );
$addWins = addWinsAsNecessary( $userId, $program, $wins, $date );
// get vices
$vices = getUsersVices( $userId );
$viceCounts = getUsersViceCounts( $userId, $date );
$addVices = addViceCountsAsNecessary( $userId, $vices, $viceCounts, $date );
if( $addWins or $addVices ) { 
    $headerString = 'Location: /dash/?date=' . $date;
    header( $headerString );
    die();
}
// get user's reminders
$reminders = getUsersReminders( $userId );
// get meal plan -- this is actually handled by /components/recipes.php and js in /components/food.php
// get whatDo
$whatDos = getUsersWhatDos( $userId );
$whatDones = getUsersWhatDones( $wins, $whatDos );


/* start HTML output */
require '../components/header.php'; // initiates the html output (starting w/ <html>)

?>

<div id="page-dash" class="stack-page full-width">
    
    <!-- reminders -->
    <div id="reminders" class="text-light bg-dark full-height">
        <h2 class="full-width text-center mb-5">Reminders</h2>
        <?php require '../components/reminders.php'; ?>
    </div>

    <!-- stackin wins -->
    <div id="wins" class="full-height">
        <h2 class="full-width text-center mb-5">Daily Wins</h2>
        <?php require '../components/wins.php'; ?>
    </div>

    <!-- meal plan -->
    <div id="food" class="text-secondary bg-info full-height">
        <h2 class="full-width text-center">Meal Plan</h2>
        <?php require '../components/food.php'; ?>
    </div>

    <!-- vices -->
    <div id="vices" class="full-height">
        <h2 class="full-width text-center mb-5">Vices</h2>
        <?php require '../components/vices.php'; ?>
    </div>

    <!-- whatDo -->
    <div id="whatdo" class="text-light bg-dark">
        <h2 class="full-width text-center">whatDo</h2>
        <?php require '../components/whatdo.php'; ?>
    </div>
    
</div>

<?php require '../components/footer.php';
