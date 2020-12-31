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
$view = isset( $_GET['view'] ) ? strtolower( $_GET['view'] ) : 'reminders';
$date = isset( $_GET['date'] ) ? $_GET['date'] : null;
$dates = getArrayOfDateStringsForYesterdayTodayTomorrow( $date );
$todaysDate = $dates['today'];



/* start HTML output */
require '../components/component-header.php'; // initiates the html output (starting w/ <html>)

?>

<div id="page-account">

    <!-- <p style="margin-top: 100px;">this is /account</p> -->

    <!-- reminders -->
    <?php if( $view == 'reminders' ) {
        echo '<div id="reminders" class="bg-info">';
            require '../components/account-reminders.php';
        echo '</div>';
    } ?>

    <!-- program -->
    <?php if( $view == 'wins' ) {
        echo '<div id="program" class="bg-light">';
            require '../components/account-program.php';
            // <h2 class="text-center">Wins</h2>
        echo '</div>';
    } ?>

    <!-- meal plan -->
    <?php if( $view == 'food' ) {
        echo '<div id="food" class="bg-light">';
            require '../components/account-food.php';
            // <h2 class="text-center">Meal Plan</h2>
        echo '</div>';
    } ?>
    
    <!-- vices -->
    <?php if( $view == 'vices' ) {
        echo '<div id="vices" class="bg-light">';
            require '../components/account-vices.php';
            // <h2 class="text-center">vices</h2>
        echo '</div>';
    } ?>
    
    <!-- whatDos -->
    <?php if( $view == 'whatdo' ) {
        echo '<div id="whatdo" class="bg-warning">';
            require '../components/account-whatdo.php';
            // <h2 class="text-center">whatDo</h2>
        echo '</div>';
    } ?>

</div>

<script type="text/javascript" defer>
$( document ).ready( function() {

    // set vars & initialize
    const view = '<?php echo $view; ?>';
    $( '#display-this-component' ).text( view );
    const userId = <?php echo $userId; ?>;
    const date = '<?php echo $todaysDate; ?>';    

    // Cookies.set('test_cookie', 'lolomgwtfbbq!?', { expires: 1, path: '/' });
    // const testCookie = Cookies.get( 'test_cookie' );
    // console.log( testCookie );

});
</script>

<?php 

// custom js for /account is called in the footer.
require '../components/component-footer.php';
