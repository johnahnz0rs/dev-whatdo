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
// $remindersUnsorted = getUsersReminders( $userId );
// $reminders = [
//     'vision' => [],
//     'pains' => [],
//     'personal' => []
// ];
// foreach( $remindersUnsorted as $reminder ) {
//     switch( $reminder['type'] ) {
//         case 'vision':
//             $reminders['vision'][] = $reminder;
//             break;
//         case 'pains':
//             $reminders['pains'][] = $reminder;
//             break;
//         case 'personal':
//             $reminders['personal'][] = $reminder;
//             break;
//     }
// }

// get meal plan
// get whatDo



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
        <!-- <div style="height: 120px; background-color: lightgray;" class="m-3 p-3">this is a meal</div>
        <div style="height: 120px; background-color: lightgray;" class="m-3 p-3">this is a meal</div>
        <div style="height: 120px; background-color: lightgray;" class="m-3 p-3">this is a meal</div> -->
    </div>

    <!-- vices -->
    <div id="vices" class="full-height">
        <h2 class="full-width text-center mb-5">Vices</h2>
        <?php require '../components/vices.php'; ?>
    </div>

    <!-- whatDo -->
    <div id="whatdo" class="text-light bg-dark">
        <div class="container-md">
            <h2 class="full-width text-center">whatDo</h2>
            <div style="height: 120px; background-color: lightgray;" class="m-3 p-3">this is a whatDo</div>
            <div style="height: 120px; background-color: lightgray;" class="m-3 p-3">this is a whatDo</div>
            <div style="height: 120px; background-color: lightgray;" class="m-3 p-3">this is a whatDo</div>
        </div>
    </div>
    
</div>

<?php require '../components/footer.php';
