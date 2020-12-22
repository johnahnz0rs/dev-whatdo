<?php
session_start();
require '../app/db.php'; // just initiates the dbase connection
require '../app/helpers.php';
require '../components/header.php'; // initiates the html output (starting w/ <html>)
?>

<div id="page-faq" class="container full-height py-5">
    <div class="row m-3">
        <div class="col-12 text-center">
            <h3>FAQs - coming soon</h3>
        </div>
    </div>
    <div class="row">
        <div class="d-none d-lg-inline-block col-3">&nbsp;</div>
        <div class="col-12 col-lg-6">
            <p>What the heck is this?</p>
            <p>What should I do first?</p>
            <p>I can't access my stuff. What the hey?</p>
            <p>Who the frig is you to tell me this and that?</p>
        </div>
        <div class="d-none d-lg-inline-block col-3">&nbsp;</div>
    </div>
</div>


<?php require '../components/footer.php';