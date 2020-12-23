<?php
session_start();


$date = isset( $_GET['date'] ) ? $_GET['date'] : null;
$dates = getArrayOfDateStringsForYesterdayTodayTomorrow( $date );
$userId = isset( $_COOKIE['user_id'] ) ? $_COOKIE['user_id'] : null;
$username = isset( $_COOKIE['username'] ) ? $_COOKIE['username'] : null;
$passHash = isset( $_COOKIE['pass_hash'] ) ? $_COOKIE['pass_hash'] : null;
$user = ( $userId and $username and $passHash ) ? true : false;
$request_uri = strtolower( $_SERVER['REQUEST_URI'] );
$request_uri = strpos( $request_uri, '/dash');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>STACKIN wins</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

    <!-- fontawesome -->
    <!-- <script src="https://kit.fontawesome.com/d7baaf610f.js" crossorigin="anonymous"></script> -->
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js" integrity="sha512-WNLxfP/8cVYL9sj8Jnp6et0BkubLP31jhTG9vhL/F5uEZmg5wEzKoXp1kJslzPQWwPT1eyMiSxlKCgzHLOTOTQ==" crossorigin="anonymous"></script>
    <!-- custom css -->
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<header id="stackin-header-nav" class="sticky-top bg-dark">
    <nav class="navbar navbar-expand-md navbar-dark">

        <!-- BRAND -->
        <a class="navbar-brand" href="<?php echo $user ? '/dash' : '/'; ?>">
            <img src="../assets/images/stackinwins-logo-light-180x52.png" width="135" height="39" alt="">
        </a>

        <!-- HAMBURGER ICON -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- NAV-ITEMS -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav px-3">
                <?php if( !$user ) { ?>
                    <li class="nav-item text-right">
                        <a href="/#register" class="nav-link">Get Started</a>
                    </li>
                    <li class="nav-item text-right">
                        <a href="/login" class="nav-link">Log In</a>
                    </li>
                <?php } else { ?>
                    <!-- dash -->
                    <li class="nav-item text-right">
                        <a href="/dash" class="nav-link">Let's Win</a>
                    </li>
                    <!-- FAQs -->
                    <li class="nav-item text-right">
                        <a href="/faqs" class="nav-link">FAQs</a>
                    </li>
                    <!-- my account -->
                    <li class="nav-item text-right">
                        <a href="/account" class="nav-link">My Account</a>
                    </li>
                    <!-- sign out -->
                    <li class="nav-item text-right">
                        <a href="/signout" class="nav-link">Sign Out</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        
    </nav>

    <?php 
    if( $user and $dates and $request_uri !== false ) { 
        echo '<div id="dates" class="text-center p-2 bg-light">';
            echo '<p class="mb-2">' . $dates['today'] . '</p>';
            echo '<p class="d-flex justify-content-around mb-0">';
                echo '<a href="#reminders">Reminders</a>';
                echo '<a href="#wins">Wins</a>';
                echo '<a href="#food">Food</a>';
                echo '<a href="#vices">Vices</a>';
                echo '<a href="#whatdo">whatDo</a>';
            echo '</p>';
        echo '</div>';
    } 
    
    ?>

    
    
</header>


<script defer>
//  this script just makes it so that when you click a nav-item on mobile-nav, the whole menu collapses after the click
$( document ).ready( function() {

    $( '.navbar-toggler' ).on( 'click', function() {
        if( $( '#navbarNav' ).hasClass( 'show' ) ) {
            $( '#navbarNav' ).removeClass( 'show' );
        } else {
            $( '#navbarNav' ).addClass( 'show' );
        }
    } );

    // $( '.nav-item a' ).on( 'click', function() {
    //     if( $( '.navbar-toggler' ).hasClass( 'collapsed ') ) {
    //         $( '.navbar-toggler' ).removeClass( 'collapsed' );
    //     } else {
    //         $( '.navbar-toggler' ).addClass( 'collapsed' );
    //     }
    //     if( '#navbarNav' ).hasClass( 'show' ){
    //         $( '#navbarNav' ).removeClass( 'show' );
    //     } else {
    //         $( '#navbarNav' ).addClass( 'show' );
    //     }
        
    // } );

} );
</script>
