<?php


?>

<style>
#component-whatdo ul {
    list-style-type: none;
}
#component-whatdo ul li i {
    margin-right: 8px;
}
#component-whatdo ul li .badge {
    margin-left: 12px;
}
</style>


<div id="component-whatdo">

    <div class="row">
        <div class="col-12 col-md-6 offset-md-3 text-center p-5 pb-3">
            <p class="mb-4"><em>waste</em> no time; <em>invest</em> some right now on these mid- to long-term goals/projects.</p>
            <button id="button-whatdo" class="btn btn-success">
                Tell Me whatDo?
            </button>
        </div>
    </div>

    <div id="suggestion-whatdo" class="row m-3 mb-5 p-3 bg-warning" style="display: none;">
        <div class="col-1 col-md-3">&nbsp;</div>
        <div class="col-10 col-md-6 text-dark py-5">
            <h3 id="suggested-whatdo" class="text-center"></h3>
        </div>
        <div class="col-1 col-md-3">&nbsp;</div>
        <div class="col-12">
            <div class="d-flex justify-content-around">
                <button id="button-something-else" class="btn btn-danger">Gimme something else</button>
                <button id="button-lets-whatdo" class="btn btn-primary">Let's Do It!</button>
            </div>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-12 col-md-6 offset-md-3">
            <ul>
                <?php
                    $todaysDate = new DateTime( $dates['today'] );
                    
                    foreach($whatDos as $whatDo) {
                        $dateCreated = new DateTime( $whatDo['created_at'] );
                        $diff = $todaysDate->diff($dateCreated)->format("%a");
                        echo '<li class="m-3">';
                            echo '<div class="d-flex px-3">';
                                echo '<div class="col-1">';
                                    echo '<i class="';
                                    echo in_array( $whatDo['id'], $whatDones ) ? 'fas fa-check' : 'far fa-dot-circle' ;
                                    echo '"></i>';
                                echo '</div>';
                                echo '<div class="col flex-fill">';
                                    echo '<p>' . $whatDo['title'];
                                        echo '<span class="badge rounded-pill bg-secondary">';
                                            if( !$diff ) {
                                                echo 'created today';
                                            } elseif( $diff == 1 ) {
                                                echo 'created yesterday';
                                            } else {
                                                echo 'created ' . $diff . ' days ago';
                                            }
                                        echo '</span>';
                                    echo '</p>';
                                echo '</div>';
                            echo '</div>';
                        echo '</li>';
                    }
                ?>
                
            </ul>
            
        </div>
    </div>


</div>


<script defer>
$( document ).ready( function() {
    const $suggestionWhatDo = $( '#suggestion-whatdo' );
    const $suggestedWhatDo = $( '#suggested-whatdo' );
    const $somethingElse = $( '#button-something-else' );
    const $letsWhatDo = $( '#button-lets-whatdo' );
    const whatDos = <?php echo json_encode( $whatDos ); ?>;
    const count = Object.keys(whatDos).length;

    function suggestWhatDo( ) {
        const randomNum = Math.floor((Math.random() * count) + 1);
        const suggestedWhatDo = whatDos[randomNum]['title'];
        const suggestedWhatDoId = whatDos[randomNum]['id'];
        const userId = '<?php echo $userId; ?>';
        const today = '<?php echo $dates['today']; ?>';
        $suggestedWhatDo.text( suggestedWhatDo );
        $letsWhatDo.data( 'whatdo-id', suggestedWhatDoId );
        $letsWhatDo.data( 'user-id', userId );
        $letsWhatDo.data( 'date', today );
    }

    $( '#button-whatdo' ).on( 'click', function() {
        $suggestionWhatDo.show();
        suggestWhatDo();
        // $( '#button-whatdo' ).prop( 'disabled', true );
        $( '#button-whatdo' ).hide();
        
    } );

    $somethingElse.on( 'click', function() {
        suggestWhatDo();
    } );

    $letsWhatDo.on( 'click', function() {
        alert('muthafuckin RIGHT!');
        console.log( 'whatdo-id: ' + $letsWhatDo.data( 'whatdo-id' ) + typeof $letsWhatDo.data( 'whatdo-id' ) );
        console.log( 'user-id: ' + $letsWhatDo.data( 'user-id' ) + typeof $letsWhatDo.data( 'user-id' ) );
        console.log( 'date: ' + $letsWhatDo.data( 'date' ) + typeof $letsWhatDo.data( 'date' ) );
    } );


} );
</script>