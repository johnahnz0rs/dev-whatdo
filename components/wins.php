<?php ?>

<style>
    #component-wins .win-note {
        display: none;
        margin-bottom: 0;
        font-style: italic;
        font-size: 0.85em;
    }
    #component-wins .toggle-win-note {
        color: rgba(255,255,255,0.5);
    }
    #component-wins .toggle-win-note:hover {
        cursor: pointer;
    }
</style>

<div id="component-wins">
    
    <?php foreach( $wins as $win ) {
    
    echo '<div id="win-' . $win['id'] . '" class="row full-width p-3">';
        echo '<div class="col col-md-1 col-lg-3 d-none d-md-inline">&nbsp;</div>';
        echo '<div class="col col-12 col-md-10 col-lg-6 bg-secondary text-light p-3">';
            echo '<div class="d-flex justify-content-center align-items-baseline">';
                echo '<div class="col">';
                    echo '<i class="far fa-square fa-lg stack-this-win" data-id="' . $win['id'] .'"></i>';
                echo '</div>';
                echo '<div class="col-9">';
                    echo '<h3>' . $win['title'] . '</h3>';
                    echo '<p id="winnote-' . $win['id'] . '" class="win-note">' . $win['note'] . '</p>';
                    echo '<small class="toggle-win-note" data-id="' . $win['id'] . '"> show / hide note </small>';
                    echo '<div id="formeditwin-' . $win['id'] . '" style="display: none;">';
                        echo '<form action="">';
                            echo '<input type="hidden" name="id" value="' . $win['id'] . '">';
                            echo '<input type="hidden" name="title" value="' . $win['title'] . '">';
                            echo '<textarea name="note" style="width: 100%;" disabled>' . $win['note'] . '</textarea>';
                        echo '</form>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="col d-flex flex-column align-items-end">';
                    echo '<i class="edit-this-win fas fa-pen" data-id="' . $win['id'] . '"></i><br>';
                    echo '<i class="delete-this-win far fa-trash-alt" data-id="' . $win['id'] . '"></i>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<div class="col col-md-1 col-lg-3 d-none d-md-inline">&nbsp;</div>';
    echo '</div>';

    } ?>

</div>

<?php 
// win data (from dbase sql call)
// array(6) {
//   ["id"]=>
//   string(2) "13"
//   ["program_id"]=>
//   string(1) "1"
//   ["whatdo_id"]=>
//   string(1) "0"
//   ["title"]=>
//   string(67) "Early Wake Up - get up and start making yourself proud of yourself!"
//   ["note"]=>
//   string(26) "What time did you wake up?"
//   ["stacked"]=>
//   string(1) "0"
// }
?>

<script defer>
$( document ).ready( function() {
    $( '.stack-this-win' ).on( 'click', function() {
        // console.log( $( this ).attr( 'id' ) + ' - ajax to dbase: update row by id' );
        alert('you did this forreal? my man, way to go.');
        console.log( $( this ).data( 'id' ) + ' - ajax to dbase: update row by id' );
    } );
    $( '.toggle-win-note' ).on( 'click', function() {
        const formToBeToggled = '#winnote-' + $( this ).data( 'id' );
        $( formToBeToggled ).toggle();
    } );
    $( '.edit-this-win' ).on( 'click', function() {
        const toggleThisFormEditWin = '#formeditwin-' + $( this ).data( 'id' );
        console.log( 'edit this win by id: ' + toggleThisFormEditWin );
        $( toggleThisFormEditWin ).toggle();
    } );
    $( '.delete-this-win' ).on( 'click', function() {
        alert('cannot delete this win right meow - id: ' + $( this ).data( 'id' ) );
    } );
} );
</script>
