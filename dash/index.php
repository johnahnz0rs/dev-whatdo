<?php
session_start();

// only "logged in" users allowed in the dash
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
$view = isset( $_GET['view'] ) ? strtolower( $_GET['view'] ) : 'reminders';
$date = isset( $_GET['date'] ) ? $_GET['date'] : null;
$dates = getArrayOfDateStringsForYesterdayTodayTomorrow( $date );
$todaysDate = $dates['today'];

/* start HTML output */
require '../components/component-header.php'; // initiates the html output (starting w/ <html>)

?>

<div id="page-dash">

    <!-- reminders -->
    <?php if( $view == 'reminders') {
        echo '<div id="reminders" class="stack-component text-light bg-dark">';
            require '../components/dash-reminders.php'; 
        echo '</div>';
    } ?>

    <!-- stackin wins -->
    <?php if( $view == 'wins' ) {
        echo '<div id="wins" class="stack-component">';
            require '../components/dash-wins.php';
        echo '</div>';
    } ?>

    <!-- meal plan -->
    <?php if( $view == 'food' ) {
        echo '<div id="food" class="stack-component text-secondary bg-info">';
            require '../components/dash-food.php';
        echo '</div>';
    } ?>

    <!-- vices -->
    <?php if( $view == 'vices' ) {
        echo '<div id="vices" class="stack-component">';
            require '../components/dash-vices.php';
        echo '</div>';
    } ?>

    <!-- whatDo -->
    <?php if( $view == 'whatdo' ) {
        echo '<div id="whatdo" class="stack-component text-light bg-dark">';
            require '../components/dash-whatdo.php';
        echo '</div>';
    } ?>
    
</div>


<script type="text/javascript" defer>
    $( document ).ready( function() {
        
        // set vars & initialize
        const userId = <?php echo $userId; ?>;
        const date = '<?php echo $todaysDate; ?>';
        const view = '<?php echo $view; ?>';
        $( '#display-this-component' ).text( view );

    } );
</script>


<?php 

// custom js for /account is called in the footer.
require '../components/component-footer.php';
