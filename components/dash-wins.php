<?php

// get user's daily program and wins
$program = getUsersProgram( $userId );
$wins = getUsersWins( $userId, $todaysDate );
$addWins = addWinsAsNecessary( $userId, $program, $wins, $todaysDate );

if( $addWins ) { 
    $headerString = 'Location: /dash/?view=vices&date=' . $todaysDate;
    header( $headerString );
    die();
}

?>

<div id="component-wins" class="py-3">
    
    <?php foreach( $wins as $win ) {

        // echo '<pre>';
        // var_dump($win);
        // echo '</pre>';
        // break;
        $stackedClass;
        if( $win['stacked'] == 1 ) {
            $stackedClass = 'fa-check-square';
        } else {
            $stackedClass = 'fa-square';
        }
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
                <div id="add-detail-win-' . $win['id'] . '" class="w-100" style="display: none;">
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


<!-- custom js for /dash/wins -->
<script type="text/javascript" defer>
$(document).ready(function() {

    // set vars
    const userId = <?php echo $userId; ?>;
    const date = '<?php echo $todaysDate; ?>';

    // stack or unstack a win
    $( '.stack-this-win' ).on( 'click', function() {
        const id = $( this ).data( 'id' ).toString();
        const stacked = $( this ).data( 'stacked' ).toString();
        if( !id || !stacked ) {
            alert( 'Something is wrong. Please refresh the page. Please contact us if problem persists.' );
        } else {
            const updateString = '../app/wins/update-win-stacked.php?id=' + id + '&user_id=' + userId + '&stacked=' + stacked + '&date=' + date;
            window.location.href = updateString;
        }
    } );

    // toggle win-note
    $( '.toggle-win-note' ).on( 'click', function() {
        const formToBeToggled = '#winnote-' + $( this ).data( 'id' );
        $( formToBeToggled ).toggle();
    } );

    // toggle add-user-note
    $( '.toggle-add-win-user-note' ).on( 'click', function() {
        const winUserNoteToBeToggled = '#add-detail-win-' + $( this ).data( 'id' );
        $( winUserNoteToBeToggled ).toggle();
    } );

});
</script>
