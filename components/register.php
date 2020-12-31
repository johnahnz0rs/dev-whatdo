<?php

session_start();

?>

<div id="register-component">
    <h2 class="text-center">Register</h2>
    <?php if( isset($_COOKIE['register_result'])) { ?>
        <p class="bg-danger m-3"><?php echo $_COOKIE['register_result']; ?></p>
    <?php } ?>
    <form id="register-form" action="/app/user/register.php" method="POST">
        <div class="m-3">
            <span><strong><em>Required</em></strong></span>
            <input name="username" type="text" placeholder="Username" required>
            <input name="email" type="email" placeholder="Email" required>
            <input name="password" type="password" placeholder="Password" required>
            <input name="confirm-password" type="password" placeholder="Confirm Password" required>
        </div>
        <div class="m-3">
            <span><strong><em>Optional</em></strong></span>
            <input name="fname" type="text" placeholder="First Name">
            <input name="lname" type="text" placeholder="Last Name">
            <input name="dob" type="text" placeholder="Date of Birth" onfocus="(this.type='date')" onblur="(this.type='text')">
        </div>
        <div class="m-3">
            <span style="opacity: 0.6;"><em>We'll never spam you or sell your info.</em></span>
            <input class="btn btn-success text-dark font-weight-bold" type="submit" value="Let's GROW!" role="button">
            <a href="/login" class="text-center" style="color: white; font-size: 1.05em;">Already have an account? Log in here.</a>
        </div>
    </form>
</div>