<?php ?>

<div id="component-wins" class="py-3">
    
    <?php foreach( $wins as $win ) {
        $stackedClass = $win['stacked'] ? 'fa-check-square' : 'fa-square';

        echo '<div class="d-flex justify-content-center">
            <div class="single-win">
                <div class="d-flex justify-content-between align-items-baseline">
                    <i class="far ' . $stackedClass . ' fa-lg stack-this-win" data-id="' . $win['id'] .'" data-stacked="' . $win['stacked'] . '" data-fake-attr=""></i>
                    <h3 class="w-100">' . $win['title'] . '</h3>
                    <span class="d-inline toggle-note-chevron"><i class="fas fa-lg fa-chevron-down toggle-win-note" data-id="' . $win['id'] . '"></i></span>
                </div>
                <div class="w-100 win-note" id="winnote-' . $win['id'] . '">
                    <p>' . $win['note'] . '</p>    
                </div>
                <span class="toggle-add-win-user-note badge rounded-pill bg-light text-dark" data-id="' . $win['id'] . '">add a note</span>
                <div id="add-detail-' . $win['id'] . '" class="w-100" style="display: none;">
                    <form action="../app/wins/post-update-win-usernote.php" method="POST">
                        <input name="user_id" type="hidden" value="' . $userId . '">
                        <input name="id" type="hidden" value="' . $win['id'] . '">
                        <input name="date" type="hidden" value="' . $dates['today'] . '">
                        <textarea name="user_note">' . $win['user_note'] . '</textarea>
                        <input type="submit" class="btn btn-sm btn-primary" value="Submit">
                    </form>
                </div>
            </div>
        </div>';

    } ?>

</div>
