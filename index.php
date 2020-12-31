<?php
session_start();
require './app/db.php'; // just initiates the dbase connection
require './app/helpers.php';
require './components/component-header.php'; // initiates the html output (starting w/ <html>)
?>



<div id="page-homepage" class="container-fluid">


    <!-- section - hero -->
    <div id="hero" class="row">
        <div class="d-flex flex-column justify-content-between">
            <div>
                <h1 class="font-big-john">Confidence & Self-Love don't come free.</h1>
            </div>
            <div class="text-right">
                <h2 class="font-slim-joe ml-auto">You earn them everyday through <u>ACTION</u>.</h2>
                <a href="/#intro" class="btn btn-warning mt-4"><strong>Learn More</strong></a>
            </div>
        </div>
    </div>


    <!-- section - intro -->
    <div id="intro" class="row py-5 px-3">
        <div class="d-flex">
            <div class="col-1 col-md-2 col-lg-3">&nbsp;</div>
            <div class="col">
                <p><strong>Do you go through the day and feel like, "Meh, Life is like whatever" or "Mannn, I'm feeling down"?</strong></p>
                <p>It's <em>probably</em> because you haven't DONE anything to <em>MAKE YOURSELF</em> feel good.</p>
                <p>Just doing the bare minimum will leave you feeling like a pussy forreal because REAL motherfuckers <strong>DO MORE</strong> than the bare minimum.<p>
                <p>So unless you're into being a nobody who's hard to love, you gotta be honest with yourself, clarify who you want to be, then start/keep acting like that person. This site helps with that.</p>
                <p><a href="<?php echo $user ? '/login' : '/#register' ; ?>" style="color: black; font-weight: bold; font-size: 1.2em;"><span style="text-decoration: underline;">Let's get started</span>. <i class="fas fa-arrow-circle-right"></i></a></p>
            </div>
            <div class="col-1 col-md-2 col-lg-3">&nbsp;</div>
        </div>
    </div>


    <!-- section - visual break -->
    <div id="break" class="row"></div>


    <!-- section - register -->
    <?php if( !$user ) { ?>
        <div id="register" class="row text-light bg-dark justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <?php require './components/component-register.php'; ?>
            </div>
        </div>
    <?php } ?>


</div>

<?php require './components/component-footer.php';
