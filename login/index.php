<?php
session_start();
require '../app/db.php'; // just initiates the dbase connection
require '../app/helpers.php';
require '../components/component-header.php'; // initiates the html output (starting w/ <html>)
?>

<div id="page-login" class="container-fluid">
    <div style="min-height: 71vh;">
        <div id="login" class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <?php require '../components/component-login.php'; ?>
            </div>
        </div>
    </div>
</div>




<?php require '../components/component-footer.php';