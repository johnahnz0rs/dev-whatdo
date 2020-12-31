<?php

$program = getAllUsersProgram( $userId );
$programsInactive = [];
$programsActive = [];
foreach( $program as $win ) {
    if( $win['active'] == '1' ) {
        $programsActive[] = $win;
    } else {
        $programsInactive[] = $in;
    }
}
// if( $program ) {
//     foreach( $program as $win ) {
//         echo '<pre>';
//         var_dump($win);
//         echo '</pre>';
//     }
// } else {
//     echo 'no program';
// }
// die();

// array(4) {
    // ["id"]=>
    // string(1) "1"
    // ["title"]=>
    // string(32) "Uncomfortably Early Wake Up Time"
    // ["note"]=>
    // string(132) "Be GRATEFUL for another chance to enjoy a better Life! JUMP tf up out of bed and SPRING into GROWTH! What time did you get up today?"
    // ["active"]=>
    // string(1) "1"
// }

?>


<div id="account-program">

    <!-- info block -->
    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <h3 class="text-center">Program</h3>
        <p>
            Your Program is how you live, how you conduct yourself on a daily basis. It's your wake-up time, how you work out (do you just go through the motions, or do you EARN that PMA Positive Mental Attitude?), your nutrition; it's all the things <u><em>you</em></u> do to validate <u><em>yourself</em></u>. Each item is a Win; STACK enough Wins everyday, and you'll earn that righteous confidence and self-love. These wins will appear everyday in the Wins tab on your dashboard.
        </p>
    <div>

    <!-- active program items -->
    <div id="active-program">
        <?php if( $programsActive ) {
            foreach( $programsActive as $program ) {
                echo '<div class="row single-program">
                    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 bg-warning p-3">
                        <div id="single-program-' . $program['id'] . '">
                            <h3>' . $program['title'] . '</h3>
                            <p>' . $program['note'] . '</p>
                            <span class="badge rounded-pill bg-success">Active</span>
                            <div id="manipulate-program-' . $program['id'] . '" class="float-end">
                                <button data-id="' . $program['id'] . '" class="update-program btn btn-primary">Edit</button>
                                <button data-id="' . $program['id'] . '" class="deactivate-program btn btn-outline-dark">Deactivate</button>
                                <button data-id="' . $program['id'] . '" class="delete-program btn btn-outline-danger">Delete</button>
                            </div>
                        </div>
                        <div id="single-program-form-' . $program['id'] . '" style="display: none;">
                            <form action="/app/program/post-update-a-program.php" method="POST">
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="user_id" value="">
                                <textarea name="title" rows="1">' . $program['title'] . '</textarea>
                                <textarea name="note">' . $program['note'] . '</textarea>
                                <select name="active" selected>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <div>
                                    <span class="float-end">
                                        <button data-id="' . $program['id'] . '" class="cancel-update-program btn btn-outline-dark">Cancel</button>
                                        <input class="btn btn-outline-success" type="submit" value="Update">
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';
            }
        } ?>
    </div>

    <div id="togglers-program" class="text-center pt-5">
        <p><span id="toggle-inactive-program"> show / hide inactive wins </span></p>
        <p><span id="toggle-create-program"> create a new win</span></p>
    </div>

    <div id="inactive-program" style="display: none;">
        <!-- inactive program items -->
        <?php if( $programsInactive ) {
            foreach( $programsInactive as $program ) {
                echo '<div class="row single-program">
                    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-light p-3 inactive-program">
                        <div id="single-program-' . $program['id'] . '">
                            <h3></h3>
                            <p></p>
                            <span class="badge rounded-pill bg-dark">Inactive</span>
                            <div id="manipulate-program-' . $program['id'] . '" class="float-end">
                                <button data-id="' . $program['id'] . '" class="activate-program btn btn-success">Activate</button>
                                <button data-id="' . $program['id'] . '" class="delete-program btn btn-outline-danger text-light">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="row single-program">
                <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-light p-3 inactive-reminder">
                    <h3>No Inactive Program Items</h3>
                </div>
            </div>';
        } ?>
    </div>

    <div id="create-program" style="display: none;">
        <!-- create program item -->
        <div class="col-10 offset-1 col-md-8 offset-md-12 col-lg-6 offset-lg-3 bg-light p-3">
            <form action="../app/program/post-create-a-program.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                <input type="hidden" name="page" value="account">
                <textarea name="title" id="create-title" placeholder="Win Title (big, bold)"></textarea>
                <textarea name="note" id="create-note" placeholder="Win Note (details, description)"></textarea>
                <div class="pb-5">
                    <span class="float-end">
                        <button id="cancel-create-program" class="btn btn-outline-primary">Cancel</button>
                        <input type="submit" value="Add New Win" class="btn btn-success">
                    </span>
                </div>
            </form>
        </div>
    </div>

</div>




<script type="text/javascript" defer>
$(document).ready(function() {
    const userId = <?php echo $userId; ?>;
    const date = '<?php echo $todaysDate; ?>'; 
    const $activateProgram = $('.activate-program');
    const $deactivateProgram = $('.deactivate-program');
    const $deleteProgram = $('.delete-program');
    
    // show / hide inactive wins
    $('#toggle-inactive-wins').on( 'click', function(e) {
        e.preventDefault();
        $('#inactive-wins').toggle();
        $('#create-win').hide();
    });

    // show / hide create-a-new-win/program
    $('#toggle-create-win').on( 'click', function(e) {
        e.preventDefault();
        $('#create-win').toggle();
        $('#inactive-wins').hide();
    });

    // cancel creating a new program
    $('#cancel-create-program').on( 'click', function(e) {
        e.preventDefault();
        $('#create-title, #create-note').val('');
        $('#create-program').hide();
    });

    // toggle edit a program (active only)
    $('.update-program, .cancel-update-program').on( 'click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $( '#single-program-' + id ).toggle();
        $( '#single-program-form-' + id ).toggle();
        $( '#manipulate-program-' + id ).toggle();
    });

    // activate an inactive program
    $activateProgram.on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/program/activate-a-program.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href= redirectString;
    });

    // deactivate an active program
    $deactivateProgram.on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/program/deactivate-a-program.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    });

    // delete a program
    $deleteProgram.on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/program/delete-a-program.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    });
});
</script>


