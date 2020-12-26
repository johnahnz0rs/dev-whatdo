<?php

?>


<div id="component-vices">

    <?php foreach( $viceCounts as $vice ) {
        echo '<div class="d-flex justify-content-center">
            <div class="single-vice">
                <div class="d-flex justify-content-between align-items-top">
                    <div class="w-25 manipulate-count">
                        <div class="d-flex flex-column justify-content-around align-items-center">
                            <i class="vice-increment fas fa-chevron-up mb-1" data-id="' . $vice['id'] . '" data-count="' . $vice['count'] . '"></i>
                            <span>' . $vice['count'] . '</span>
                            <i class="vice-decrement fas fa-chevron-down mt-1" data-id="' . $vice['id'] . '" data-count="' . $vice['count'] . '"></i>
                        </div>
                    </div>
                    <div class="w-75">
                        <!-- <div class="w-100"> -->
                            <h3 class="w-100"><span class="float-end"><i class="fas fa-sm fa-chevron-down toggle-vice-note" data-id="' . $vice['id'] . '"></i></span>' . $vice['title'] . '</h3>
                            
                        <!-- </div> -->
                        <div class="w-100 vice-note" id="vicenote-' . $vice['id'] . '">
                            <p>' . $vice['note'] . '</p>
                        </div>
                        <span class="toggle-add-vice-user-note badge rounded-pill bg-secondary text-light" data-id="' . $vice['id'] . '">add a note</span>
                        <div id="add-detail-vice-' . $vice['id'] . '" class="w-100" style="display: none;">
                            <form action="../app/vices/post-update-vice-usernote.php" method="POST">
                                <input name="user_id" type="hidden" value="' . $userId . '">
                                <input name="id" type="hidden" value="' . $vice['id'] . '">
                                <input name="date" type="hidden" value="' . $dates['today'] . '">
                                <textarea name="user_note">' . $vice['user_note'] . '</textarea>
                                <input type="submit" class="btn btn-sm btn-primary" value="Submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>';
    } ?>

</div>
