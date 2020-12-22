<?php ?>

<div id="login-component">
    <h2 class="text-center">Log In</h2>
    <?php if( isset($_COOKIE['login_result'])) { ?>
        <p class="bg-danger p-3"><?php echo $_COOKIE['login_result']; ?></p>
    <?php } ?>
    <form id="login-form" action="/app/user/login.php" method="POST">
        <input name="username" type="text" placeholder="Username" required>
        <input name="password" type="password" placeholder="Password" required>
        <input class="btn btn-success text-dark font-weight-bold" type="submit" value="You Got This" role="button">
        <div class="full-width text-center">
            <a href="/register" class="full-width text-center" style="color: black; font-size: 1.05em;">Need an account? Register here.</a>
        </div>
    </form>
</div>