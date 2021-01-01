<?php 

$whatDos = getAllUsersWhatDos( $userId );
$whatDosActive = [];
$whatDosInactive = [];

foreach( $whatDos as $whatDo ) {
    if( $whatDos['active'] == 1 ) {
        $whatDosActive[] = $whatDo;
    } else {
        $whatDosInactive[] = $whatDo;
    }
}

?>

<div id="account-whatdo">

    <!-- info block -->
    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <h3 class="text-center">whatDo</h3>
        <p>
            As children, we wanted simple, easily accomplishable things, like an ice cream, or a hug, or play time. As adults, our desires and purpose in Life are more mature and layered; they usually require larger commitments of time, focus, and energy. Whenever you find yourself twiddling your thumbs, or wasting time on activities with no lasting rewards, just put a little work in on these projects — chip away at it consistently, and before you know it you'll have finished a big block of work!
        </p>
    </div>

    <!-- active whatDos -->
    <div id="active-whatDos">
        <?php if( $whatDosActive ) {
            foreach( $whatDosActive as $whatDo ) {
                echo '<div class="row single-whatdo">
                    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 bg-warning p-3">
                        <div id="single-whatdo-' . $whatDo['id'] . '">
                            <h3>' . $whatDo['title'] . '</h3>
                            <p>' . $whatDo['note'] . '</p>
                            <span class="badge rounded-pill bg-success">Active</span>
                            <div id="manipulate-whatdo-' . $whatDo['id'] . '" class="float-end">
                                <button data-id="' . $whatDo['id'] . '" class="update-whatdo btn btn-primary">Edit</button>
                                <button data-id="' . $whatDo['id'] . '" class="deactivate-whatdo btn btn-outline-dark">Deactivate</button>
                                <button data-id="' . $whatDo['id'] . '" class="delete-whatdo btn btn-outline-danger">Delete</button>
                            </div>
                        </div>
                        <div id="single-whatdo-form-' . $whatDo['id'] . '" style="display: none;">
                            <form action="/app/whatdo/post-update-a-whatdo.php" method="POST">
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="user_id" value="">
                                <textarea name="title" rows="1">' . $whatDo['title'] . '</textarea>
                                <textarea name="note">' . $whatDo['note'] . '</textarea>
                                <select name="active" selected>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <div>
                                    <span class="float-end">
                                        <button data-id="' . $whatDo['id'] . '" class="cancel-update-whatdo btn btn-outline-dark">Cancel</button>
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

    <!-- togglers -->
    <div id="togglers-whatdos" class="text-center pt-5">
        <p><span id="toggle-inactive-whatdos"> show / hide inactive whatDo </span></p>
        <p><span id="toggle-create-whatdo"> create a new whatDo </span></p>
    </div>

    <!-- inactive whatDos -->
    <div id="inactive-whatdos" style="display: none;">
        <?php if( $whatDosInactive ) {
            foreach( $whatDosInactive as $whatDo ) {
                echo '<div class="row single-whatdo">
                    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-light p-3 inactive-whatdo">
                        <div id="single-whatdo-' . $whatDo['id'] . '">
                            <h3>' . $whatDo['title'] . '</h3>
                            <p>' . $whatDo['note'] . '</p>
                            <span class="badge rounded-pill bg-dark">Inactive</span>
                            <div id="manipulate-whatdo-' . $whatDo['id'] . '" class="float-end">
                                <button data-id="' . $whatDo['id'] . '" class="activate-whatdo btn btn-success">Activate</button>
                                <button data-id="' . $whatDo['id'] . '" class="delete-whatdo btn btn-outline-danger text-light">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="row single-whatdo">
                <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-light p-3 inactive-whatdo">
                    <h3>No Inactive whatDos</h3>
                </div>
            </div>';
        } ?>
    </div>

    <!-- create new whatDo -->
    <div id="create-whatdo" style="display: none;">
        <div class="col-10 offset-1 col-md-8 offset-md-12 col-lg-6 offset-lg-3 bg-light p-3">
            <form action="../app/whatdo/post-create-a-whatdo.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                <input type="hidden" name="page" value="account">
                <textarea name="title" id="create-title" placeholder="whatDo Title (big, bold)"></textarea>
                <textarea name="note" id="create-note" placeholder="whatDo Note (details, description)"></textarea>
                <div class="pb-5">
                    <span class="float-end">
                        <button id="cancel-create-whatdo" class="btn btn-outline-primary">Cancel</button>
                        <input type="submit" value="Add New whatDo" class="btn btn-success">
                    </span>
                </div>
            </form>
        </div>
    </div>

</div>

<script type="text/javascript" defer>
$(document).ready(function() {
    
    // set vars
    const userId = <?php echo $userId; ?>;
    const date = '<?php echo $todaysDate; ?>';
    const $activateWhatDo = $('.activate-whatdo');
    const $deactivateWhatDo = $('.deactivate-whatdo');
    const $deleteWhatDo = $('.delete-whatdo');
    
    // show / hide #inactive-whatdos
    $('#toggle-inactive-whatdos').on( 'click', function(e) {
        e.preventDefault();
        $('#inactive-whatdos').toggle();
        $('#create-whatdo').hide();
    });

    // show / hide #create-whatdo
    $('#toggle-create-whatdo').on( 'click', function(e) {
        e.preventDefault();
        $('#create-whatdo').toggle();
        $('#inactive-whatdos').hide();
    });

    // cancel creating a new whatDo
    $('#cancel-create-whatdo').on( 'click', function(e) {
        e.preventDefault();
        $('#create-title, #create-note').val('');
        $('#create-whatdo').hide();
    });

    // toggle edit a whatDo (active only)
    $('.update-whatdo, .cancel-update-whatdo').on( 'click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $( '#single-whatdo-' + id ).toggle();
        $( '#single-whatdo-form-' + id ).toggle();
        $( '#manipulate-whatdo-' + id ).toggle();
    });

    // activate an inactive whatDo
    $activateWhatDo.on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/whatdo/activate-a-whatdo.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href= redirectString;
    });

    // deactivate an active whatDo
    $deactivateWhatDo.on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/whatdo/deactivate-a-whatdo.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    });

    // delete a whatDo
    $deleteWhatDo.on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/whatdo/delete-a-whatdo.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    });

});
</script>
