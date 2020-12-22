<?php ?>

<style>
    #component-vices .vice-note {
        display: none;
        margin-bottom: 0;
        font-style: italic;
        font-size: 0.85em;
    }
    #component-vices .toggle-vice-note {
        color: rgba(0,0,0,0.5);
    }
    #component-vices .toggle-vice-note:hover {
        cursor: pointer;
    }
</style>

<div id="component-vices">
    <?php foreach( $viceCounts as $vice ) {
    echo '<div id="vice-' . $vice['id'] . '" class="row full-width p-3 my-3">';
        echo '<div class="col col-md-1 col-lg-3 d-none d-md-inline">&nbsp;</div>';
        echo '<div class="col col-12 col-md-10 col-lg-6">';
            echo '<div class="d-flex justify-content-center">';
                echo '<div class="col-2">';
                    echo '<div class="d-flex flex-column justify-content-around align-items-center fs-5">';
                        echo '<div><i class="vice-increment fas fa-chevron-up" data-id="' . $vice['id'] . '"></i></div>';
                        echo '<div>' . $vice['count'] . '</div>';
                        echo '<div><i class="vice-decrement fas fa-chevron-down" data-id="' . $vice['id'] . '"></i></div>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="col-10 p-2">';
                    echo '<h3>' . $vice['title'] . '</h3>';
                    echo '<p id="vicenote-' . $vice['id'] . '" class="vice-note">' . $vice['note'] . '</p>';
                    echo '<small class="toggle-vice-note" data-id="' . $vice['id'] . '"> show / hide note</small>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<div class="col col-md-1 col-lg-3 d-none d-md-inline">&nbsp;</div>';
    echo '</div>';
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
} );
</script>
