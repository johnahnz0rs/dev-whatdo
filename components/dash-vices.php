<?php

// get user's vices and viceCounts
$vices = getUsersVices( $userId );
$viceCounts = getUsersViceCounts( $userId, $todaysDate );
$addVices = addViceCountsAsNecessary( $userId, $vices, $viceCounts, $todaysDate );


// echo 'vices<br>';
// echo '<pre>';
// var_dump($vices);
// echo '</pre>';

// echo 'viceCounts<br>';
// echo '<pre>';
// var_dump($viceCounts);
// echo '</pre>';

// die();
if( $addVices ) { 
    $headerString = 'Location: /dash/?view=vices&date=' . $todaysDate;
    header( $headerString );
    die();
}

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
                            <form action="../app/vices/post-update-vice-count-usernote.php" method="POST">
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


<script type="text/javascript" defer>
$(document).ready(function() {

    // set vars
    const userId = <?php echo $userId; ?>;
    const todaysDate = '<?php echo strval( $dates['today'] ); ?>';

    // functions
    function updateViceCount( id, count ) {
        const updateString = '../app/vices/update-vice-count-count.php?id=' + id + '&user_id=' + userId + '&count=' + count + '&date=' + todaysDate;
        window.location.href = updateString;
    }

    // increment viceCount
    $( '.vice-increment' ).on( 'click', function() {
        const viceCountId = $( this ).data( 'id' );
        let viceCountCount = $( this ).data( 'count' );
        viceCountCount = parseInt(viceCountCount);
        viceCountCount++;
        updateViceCount( viceCountId, viceCountCount );
    } );

    // decrement viceCount
    $( '.vice-decrement' ).on( 'click', function() {
        const viceCountId = $( this ).data( 'id' );
        let viceCountCount = $( this ).data( 'count' );
        viceCountCount = parseInt(viceCountCount);
        viceCountCount = viceCountCount - 1;
        updateViceCount( viceCountId, viceCountCount );
    } );

    // toggle viceNote
    $( '.toggle-vice-note' ).on( 'click', function() {
        const viceNoteToBeToggled = '#vicenote-' + $( this ).data( 'id' );
        $( viceNoteToBeToggled ).toggle();
    } );

    // toggle add-viceUserNote
    $( '.toggle-add-vice-user-note' ).on( 'click', function() {
        const viceUserNoteToBeToggled = '#add-detail-vice-' + $( this ).data( 'id');
        $( viceUserNoteToBeToggled ).toggle();
    } );

});
</script>
