<?php
// get user's whatDos and whatDones
// $wins = getUsersWins( $userId, $todaysDate );
$whatDos = getUsersWhatDos( $userId );
// $whatDones = getUsersWhatDones( $wins, $whatDos );

?>


<div id="component-whatdo">

    <div id="suggestion-whatdo" class="sticky-top bg-warning text-dark px-3 py-5">
        <div class="text-center">
            <p id="suggested-whatdo">
                <em>waste</em> no time; <em>invest</em> some right now on these mid- to long-term goals/projects.
            </p>
        </div>
        <div id="whatdo-buttons-array">
            <div id="array-1" class="text-center">
                <button id="button-whatdo" class="button-whatdo btn btn-lg btn-success">whatDo?</button>
            </div>
            <div id="array-2" class="text-center" style="display: none;">
                <button id="button-something-else" class="button-whatdo btn btn-danger">Gimme something else</button>
                <button id="button-lets-whatdo" class="btn btn-primary">Let's Do It!</button>
            </div>
        </div>
    </div>

    <div id="display-whatdos" class="row py-5">
        <h3 class="text-center"><u>Running Projects</u></h3>
        <div class="col-18 offset-2 col-md-6 offset-md-3">
            <ul>
                <?php foreach( $whatDos as $whatDo ) {
                    echo '<li class="m-3">
                            <p><!-- <i class="far fa-dot-circle"></i> -->' . $whatDo['title'] . '</p>
                    </li>';
                } ?>
            </ul>
        </div>
    </div>

    <form action="/app/whatdo/post-add-whatdo-as-win.php" method="POST" id="form-whatdo" style="display: none;">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
        <input type="hidden" name="date" value="<?php echo $todaysDate; ?>">
        <input type="hidden" name="whatdo_id" id="whatdo-id" value="">
        <input type="hidden" name="title" id="whatdo-title" value="">
        <input type="hidden" name="note" id="whatdo-note" value="">
    </form>


</div>


<script type="text/javascript">
$(document).ready(function() {

    // set vars
    const userId = <?php echo $userId; ?>;
    const date = '<?php echo $todaysDate; ?>';
    const whatDos = <?php echo json_encode( $whatDos ); ?>;
    const count = Object.keys(whatDos).length;
    let suggestedWhatDo = null;
    const $whatDo = $( '.button-whatdo' );
    const $suggestedWhatDo = $( '#suggested-whatdo' );
    const $letsGo = $( '#button-lets-whatdo' );

    // functions
    function suggestWhatDo() {
        const randomNum = Math.floor( ( Math.random() * count ) );
        suggestedWhatDo = whatDos[randomNum];
        $( '#form-whatdo #whatdo-id' ).val( suggestedWhatDo['id'] );
        $( '#form-whatdo #whatdo-title' ).val( suggestedWhatDo['title'] );
        $( '#form-whatdo #whatdo-note' ).val( suggestedWhatDo['note'] );
        // $letsGo.data( 'whatdo-id', suggestedWhatDo['id'] );
        $suggestedWhatDo.text( suggestedWhatDo['title'] );
    }

    // when user clicks WhatDo? or GimmeSomethingElse
    $whatDo.on( 'click', function() {
        console.log('clicked whatDo');
        $( '#whatdo-buttons-array #array-1' ).hide();
        $( '#whatdo-buttons-array #array-2' ).show();
        suggestWhatDo();
    } );

    // when user says LetsDoThis!
    $letsGo.on( 'click', function() {
        const letsGo = confirm( 'Do you accept the challenge? Will you do this and STACK another win today?' );
        if( letsGo ) {
            // const title = suggestedWhatDo['title'];
            // const note = suggestedWhatDo['note'];
            // const whatDoId = $( this ).data( 'whatdo-id' );
            // const updateString = '../app/whatdo/stack-a-whatdo.php?whatdo_id=' + whatDoId + '&user_id=' + userId + '&date=' + date + '&title=' + title + '&note=' + note;
            // window.location.href = updateString;
            // console.log(title);
            // console.log(note);
            // console.log(whatDoId);
            // console.log(updateString);
            $( '#form-whatdo' ).submit();
        }
    } );

});
</script>