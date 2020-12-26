<?php
session_start();
require '../app/db.php'; // just initiates the dbase connection
require '../app/helpers.php';
require '../components/header.php'; // initiates the html output (starting w/ <html>)
?>

<div id="page-login" class="container-fluid">
    <div style="min-height: 71vh;">
        <div id="login" class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <?php require '../components/login.php'; ?>
            </div>
        </div>
    </div>
</div>




<?php require '../components/footer.php';