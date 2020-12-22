<?php
session_start();
require '../app/db.php'; // just initiates the dbase connection
require '../components/header.php'; // initiates the html output (starting w/ <html>)
?>

<p style="margin-top: 100px;">this is /dash</p>


<?php
die();


session_start();

/** requires and vars */
$cookieUserId = isset( $_COOKIE['user_id'] ) ? $_COOKIE['user_id'] : null;
$cookieUsername = isset( $_COOKIE['username'] ) ? $_COOKIE['username'] : null;
$cookiePassHash = isset( $_COOKIE['pass_hash'] ) ? $_COOKIE['pass_hash'] : null;
require '../app/db.php';
// require '../app/load-program.php';


/******************
 * ABOVE IS DONE *
******************/

// get user[ id, username, pass_hash ]
$user = ( $cookieUserId and $cookieUsername and $cookiePassHash ) ? validateUserCookie( $cookieUserId, $cookieUsername, $cookiePassHash ) : null;

// get dates[ yesterday, today, tomorrow ]
$dates = isset( $_GET['date'] ) ? getArrayOfDateStringsForYesterdayTodayTomorrow( $_GET['date'] ) : getArrayOfDateStringsForYesterdayTodayTomorrow( false );



// if user is logged in:
if( $user ) {


    // get user's dailyWins
    $dailyWins = getUsersDailyWins( $user['id'] );
    // if no dailyWins, then add the 3 default ones: early wakeup, work out hard, track your macros.
    if( !$dailyWins ) {
        setcookie( 'user_id', $user['id'], time() + 60*60*24, '/');
        setcookie( 'date_today', $dates['today'], time() + 60*30, '/' );
        $headerString = 'Location: ../app/add-default-daily-wins-to-user.php';
        header( $headerString );
        die();
    }

    // get user's todayWins (at this point, assumes user's dailyWins exist)
    $todayWins = getUsersTodayWins( $user['id'], $dates['today'] );
    // if no todayWins, then add the user's dailyWins
    if( !$todayWins ) {
        $jsonDailyWins = json_encode( $dailyWins );
        if( $jsonDailyWins ) {
            setcookie( 'user_id', $user['id'], time() + 60*60*24, '/' );
            setcookie( 'date_today', $dates['today'], time() + 60*30, '/' );
            setcookie( 'json_array_of_wins_to_add', $jsonDailyWins, time() + 60, '/' );
            $headerString = 'Location: ../app/json-array-of-wins-to-add.php';
            header( $headerString );
            die();
        }
    }
    $jsonTodayWins = json_encode( $todayWins );

    // check if there are any dailyWins missing from todayWins
    $remainingDailyWinsIdsToBeAddedToToday = getRemainingDailyWinsIdsToBeAddedToToday( $dailyWins, $todayWins );
    // if 1+ dailyWins need to be added to todayWins, then add them
    if( $remainingDailyWinsIdsToBeAddedToToday ) {
        $remainingDailyWins = [];
        foreach( $dailyWins as $win ) {
            if( in_array( $win['id'], $remainingDailyWinsIdsToBeAddedToToday ) ) {
                $remainingDailyWins[] = $win;
            }
        }
        $jsonRemainingDailyWins = json_encode( $remainingDailyWins );
        setcookie( 'user_id', $user['id'], time() + 60*60*24, '/' );
        setcookie( 'date_today', $dates['today'], time() + 60*30, '/' );
        setcookie( 'json_array_of_wins_to_add', $jsonRemainingDailyWins, time() + 60*30, '/' );
        $headerString = 'Location: /app/json-array-of-wins-to-add.php';
        header( $headerString );
        die();
    }
}
/* finished loading user's info */






require '../components/header.php';


?>


<div id="page-program" class="page full-height">
<div class="container-fluid">

    <!-- dates -->
    <div id="section-dates" class="row d-flex justify-content-center text-center">
        <div class="col-2">
            <a href="/program?date=<?php echo $dates['yesterday']; ?>">
                <i class="fas fa-chevron-circle-left fa-lg"></i>
            </a>
        </div>
        <div class="col-8 font-big-john">
            <h2><?php echo $dates['today']; ?></h2>
        </div>
        <div class="col-2">
            <a href="/program?date<?php echo $dates['tomorrow']; ?>">
                <i class="fas fa-chevron-circle-right fa-lg"></i>
            </a>
        </div>
    </div>

    <div id="section-stack-count" class="row text-center">
        <div class="col-12 font-slim-joe">
            <span id="count"></span> Wins <span class="font-big-john">Stacked</span>
        </div>
    </div>

    <div id="section-wins" class="row">
        <?php
            $win = $todayWins[0];
            $win['stacked'] = 0;
        ?>
        <div class="d-none d-lg-inline col-3">&nbsp;</div>
        <div class="col-12 col-lg-6">
        
        
        <!-- foreach( $todayWins as $win) {} -->
            <!-- <div class="single-today-win"> -->
                <form action="../app/post-edit-today-win.php" method="POST" id="<?php echo $win['id']; ?>">
                    <div class="row">
                        <div class="col-2 d-flex flex-column justify-content-between">
                            <input type="hidden" name="user_id" value="<?php $win['user_id']; ?>">
                            <input type="hidden" name="date" value="<?php echo $win['date']; ?>">
                            <input type="hidden" name="id" value="<?php echo $win['id']; ?>">
                            <input type="hidden" name="win_id" value="<?php echo $win['win_id']; ?>">
                            <input type="checkbox" name="stacked" <?php echo $win['stacked'] ? 'checked' : ''; ?>>
                            <p class="enable-form text-dark">Edit</p>
                            <p>D</p>
                        </div>
                        <div class="col-10">
                            <input type="text" class="win-win" name="win" value="<?php echo $win['win']; ?>" readonly><br>
                            <input type="text" class="win-note" name="note"value="<?php echo $win['note']; ?>" readonly><br>
                            <input type="submit" class="btn btn-success" value="Update"><br>
                        </div>
                    </div>
                    <!-- <button role="button" class="btn btn-primary enable-form">enable the form</button><br> -->
                    <!-- <em class="enable-form ml-auto text-dark">Edit this win</em> -->
                </form>
            <!-- </div> end .single-today-win -->
        <!-- foreach( $todayWins as $win) {} -->

        </div> <!-- end .col-12 -->
        <div class="d-none d-lg-inline col-3">&nbsp;</div>
    </div> <!-- end #section-wins -->

</div>
</div>

<script>
$(document).ready(function() {
    const todayWins = <?php echo $jsonTodayWins; ?>;
    let stackCount = 0;
    $.each(todayWins, function( i, v ) {
        stackCount += v['stacked'] ? 1 : 0;
    });
    $('#count').html(stackCount);


    // click a thing to make the todayWin editable
    $('.enable-form').on('click', function(e) {
        e.preventDefault();
        formId = $(e.target).parent().parent().parent().attr('id');
        console.log(formId);
    });
});

function enableForm() {
    // $('').prop('disabled', false);
    // $('').prop('disabled', false);
    // $('').prop('disabled', false);
    // $('').prop('disabled', false);
    // $('').prop('disabled', false);
    // $('').prop('disabled', false);
}
</script>


<?php require '../components/footer.php';
