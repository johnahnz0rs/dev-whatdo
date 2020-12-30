<?php


?>


<div id="component-whatdo">

    <div id="suggestion-whatdo" class="sticky-top bg-warning text-dark px-3 py-5">
        <div class="text-center">
            <p id="suggested-whatdo"><em>waste</em> no time; <em>invest</em> some right now on these mid- to long-term goals/projects.</p>
        </div>
        <div id="whatdo-buttons-array">
            <div id="array-1" class="text-center">
                <button id="button-whatdo" class="button-whatdo btn btn-lg btn-success">whatDo?</button>
            </div>
            <div id="array-2" class="text-center" style="display: none;">
                <button id="button-something-else" class=" button-whatdo btn btn-danger">Gimme something else</button>
                <button id="button-lets-whatdo" class="btn btn-primary">Let's Do It!</button>
            </div>
        </div>
    </div>


    <!-- <div class="row">
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
    </div> -->

    <div class="row py-5">
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
