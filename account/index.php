<?php
session_start();
// echo 'session started';
// die();
// only "logged in" users allowed in /account
$userId = isset( $_COOKIE['user_id'] ) ? $_COOKIE['user_id'] : null;
$username = isset( $_COOKIE['username'] ) ? $_COOKIE['username'] : null;
$passHash = isset( $_COOKIE['pass_hash'] ) ? $_COOKIE['pass_hash'] : null;
if ( !$userId or !$username or !$passHash ) {
    $headerString = 'Location: ../signout';
    header( $headerString );
    die();
}

/* requires and vars */
require '../app/db.php'; // just initiates the dbase connection
require '../app/helpers.php';

$remindersActive = [];
$remindersInactive = [];
$reminders = getAllUsersReminders( $userId );
foreach( $reminders as $reminder ) {
    if( $reminder['active'] ) {
        $remindersActive[] = $reminder;
    } else {
        $remindersInactive[] = $reminder;
    }
}


/* start HTML output */
require '../components/header.php'; // initiates the html output (starting w/ <html>)

?>

<div id="page-account" class="full-width">

    <!-- <p style="margin-top: 100px;">this is /account</p> -->

    <!-- reminders -->
    <div id="reminders" class="bg-info">
        
        <h2 class="text-center">reminders</h2>

        <div id="active-reminders">
            <?php if( $reminders ) {
                foreach( $remindersActive as $reminder ) {
                    // echo '<pre>';
                    // var_dump( $reminder );
                    // echo '</pre>';

                    echo '<div class="row single-reminder">
                        <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 bg-warning p-3">
                            <h3>' . $reminder['title'] . '</h3>
                            <p>' . $reminder['note'] . '</p>
                        </div>
                    </div>';
                }
            } ?>
        </div>

        <div id="inactive-reminders">
            <p id="toggle-inactive-reminders"> show / hide inactive reminders</p>
            <div id="display-inactive-reminders" style="display: none;">
                <?php foreach( $remindersInactive as $reminder ) {
                    echo '<pre>';  
                    var_dump( $reminder );
                    echo '</pre>';  
                } ?>
            </div>
        </div>

    </div>

    <!-- program -->
    <div id="program" class="bg-secondary">
        <h2 class="text-center">program</h2>
    </div>
    
    <!-- vices -->
    <div id="vices" class="bg-light">
        <h2 class="text-center">vices</h2>
    </div>
    
    <!-- whatDos -->
    <div id="whatdo" class="bg-warning">
        <h2 class="text-center">whatDo</h2>
    </div>

</div>







<script defer>
$( document ).ready( function() {





} );
</script>
<?php 

require '../components/footer.php';
