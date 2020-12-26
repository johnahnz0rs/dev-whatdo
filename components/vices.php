<?php ?>
<style>

    .single-vice {
        width: 400px;
        margin: 10px 0;
    }
    .single-vice .manipulate-count {
        font-size: 1.5em;
        line-height: 0.9em;
    }
    .single-vice .toggle-vice-note {
        margin-right: 8px;
    }
    .single-vice .vice-note {
        display: none;
        margin-bottom: 0;
        font-style: italic;
        font-size: 0.85em;
    }
    .single-vice .vice-note p {
        text-align: justify;
        margin: 4px 2% 0px 12%;
    }
    .single-vice .toggle-add-detail-to-vice {
        font-style: italic;
        font-size: 0.6em;
    }
    .single-vice .toggle-add-detail-to-vice:hover, .single-vice .toggle-add-vice-user-note:hover, .single-vice i:hover {
        cursor: pointer;
    }
    .single-vice textarea {
        width: 100%;
    }
</style>
<div id="component-vices">

    <?php foreach( $viceCounts as $vice ) {
        echo '<div class="d-flex justify-content-center">
            <div class="single-vice">
                <div class="d-flex justify-content-between align-items-top" style="border: 1px solid black;">
                    <div class="bg-primary w-25 manipulate-count">
                        <div class="d-flex flex-column justify-content-around align-items-center">
                            <i class="vice-increment fas fa-chevron-up" data-id="' . $vice['id'] . '"></i>
                            <span>' . $vice['count'] . '</span>
                            <i class="vice-decrement fas fa-chevron-down" data-id="' . $vice['id'] . '"></i>
                        </div>
                    </div>
                    <div class="bg-info w-75">
                        <!-- <div class="w-100"> -->
                            <h3 class="w-100"><span class="float-end"><i class="fas fa-sm fa-chevron-down toggle-vice-note" data-id="' . $vice['id'] . '"></i></span>' . $vice['title'] . '</h3>
                            
                        <!-- </div> -->
                        <div class="w-100 vice-note" id="vicenote-' . $vice['id'] . '">
                            <p>' . $vice['note'] . '</p>
                        </div>
                        <span class="toggle-add-vice-user-note badge rounded-pill bg-light text-dark" data-id="' . $vice['id'] . '">add a note</span>
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

<script defer>
$( document ).ready( function() {
    $( '.vice-increment' ).on( 'click', function() {
        alert( 'INCREMENT the count of this vice - id: ' + $( this ).data( 'id' ) );
    } );
    $( '.vice-decrement' ).on( 'click', function() {
        alert( 'DECREMENT the count of this vice - id: ' + $( this ).data( 'id' ) );
    } );
    $( '.toggle-vice-note' ).on( 'click', function() {
        const viceNoteToBeToggled = '#vicenote-' + $( this ).data( 'id' );
        $( viceNoteToBeToggled ).toggle();
    } );
    $( '.toggle-add-vice-user-note' ).on( 'click', function() {
        const viceUserNoteToBeToggled = '#add-detail-vice-' + $( this ).data( 'id');
        $( viceUserNoteToBeToggled ).toggle();
    } );
} );
</script>
