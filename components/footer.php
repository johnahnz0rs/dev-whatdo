<?php ?>

<footer id="stackin-footer-nav" class="full-width">
    <div class="text-right">
        <p><a href="/faqs">FAQs</a></p>
        <?php if( !$user ) { ?>
            <p><a href="/#register">Get Started</a></p>
            <p><a href="/login">Log In</a></p>
        <?php } else { ?>
            <p><a href="/review">Review My Week</a></p>
            <p><a href="/account">My Account</a></p>
            <p><a href="/signout">Sign Out</a></p>        
        <?php } ?>
    </div>
</footer>

<!-- scripts -->
<script src="https://kit.fontawesome.com/bf6498c16c.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>



</body>
</html>