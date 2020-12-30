<?php 

?>
<div id="component-reminders" class="mx-3">
    <div id="carousel-reminders" class="carousel slide" data-bs-ride="carousel">

        <!-- slide indicators -->
        <ol class="carousel-indicators">
            <!-- <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li> -->
            <?php if( $reminders ) {
                foreach( $reminders as $i=>$reminder ) {
                    echo '<li data-bs-target="#carousel-reminders" data-bs-slide-to="' . $reminder['id'] .'"';
                    echo !$i ? ' class="active"' : '';
                    echo '></li>';
                }
            } ?>
        </ol>

        <!-- slides container -->
        <div class="carousel-inner px-5">
            <?php if( $reminders ) {
                foreach( $reminders as $i=>$reminder ) {
                    echo '<div id="reminder-'. $reminder['id'] . '" class="carousel-item pb-5';
                    echo !$i ? ' active' : '';
                    echo'" data-bs-interval="10000">';
                        echo '<div class="mx-auto" style="max-width: 500px;">';
                            echo '<h3>' . $reminder['title'] . '</h3>';
                            echo '<p>' . $reminder['note'] . '</p>';
                        echo '</div>';
                    echo '</div>';
                }
            } ?>
        </div>

        <!-- controls: prev/next -->
        <a class="carousel-control-prev" href="#carousel-reminders" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <!-- <span class="visually-hidden">Previous</span> -->
        </a>
        <a class="carousel-control-next" href="#carousel-reminders" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <!-- <span class="visually-hidden">Next</span> -->
        </a>

    </div>
</div>
