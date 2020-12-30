<?php
session_start();

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

<div id="page-account">

    <!-- <p style="margin-top: 100px;">this is /account</p> -->

    <!-- reminders -->
    <div id="reminders" class="bg-info">
        <?php require '../components/account-reminders.php'; ?>
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

    const userId = <?php echo $userId; ?>;

    // edit a reminder (active only)
    $( '.update-reminder, .cancel-update-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $( '#single-reminder-' + id ).toggle();
        $( '#single-reminder-form-' + id ).toggle();
        $( '#manipulate-reminder-' + id ).toggle();
    } );

    // deactivate a reminder (active only)
    $( '.deactivate-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/reminders/deactivate-a-reminder.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    } );

    // activate a reminder (inactive only)
    $( '.activate-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/reminders/activate-a-reminder.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href= redirectString;
    } );

    // delete a reminder
    $( '.delete-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/reminders/delete-a-reminder.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    } );

    // show / hide inactive reminders
    $( '#toggle-inactive-reminders' ).on( 'click', function(e) {
        e.preventDefault();
        $( '#display-inactive-reminders' ).toggle();
        $( '#create-reminder' ).hide();
    } );

    // show / hide create a new reminder
    $( '#toggle-create-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        $( '#create-reminder' ).toggle();
        $( '#display-inactive-reminders' ).hide();
    } );

    // cancel create-a-new-reminder
    $( '.cancel-create-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        $( '#create-title, #create-note' ).val( '' );
        $( '#create-reminder' ).hide();
    } );

} );
</script>
<?php 

require '../components/footer.php';
