$( document ).ready( function() {
    console.log('what what this is from dash.js');
    const userId = <?php echo $userId; ?>;

    // wins
    $( '.stack-this-win' ).on( 'click', function() {
        // console.log( $( this ).attr( 'id' ) + ' - ajax to dbase: update row by id' );
        // alert('you did this forreal? my man, way to go.');
        // console.log( $( this ).data( 'id' ) + ' - ajax to dbase: update row by id' );
        const updateString = '../app/post/update-win-stacked.php?id=' + userId;
        console.log(updateString);
    } );
    $( '.toggle-win-note' ).on( 'click', function() {
        const formToBeToggled = '#winnote-' + $( this ).data( 'id' );
        $( formToBeToggled ).toggle();
    } );
    $( '.toggle-add-detail-to-win' ).on( 'click', function() {
        $( '#add-detail-' + $( this ).data( 'id' ) ).toggle();
        
    } );
});
