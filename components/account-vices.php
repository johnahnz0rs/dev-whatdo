<?php 

$vices = getAllUsersVices( $userId );
$vicesActive = [];
$vicesInactive = [];

foreach( $vices as $vice ) {
    if( $vice['active'] == 1 ) {
        $vicesActive[] = $vice;
    } else {
        $vicesInactive[] = $vice;
    }
}

?>

<div id="account-vices">

    <!-- info block -->
    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <h3 class="text-center">Vices</h3>
        <p>
            No one needs to tell you what you shouldn't be doing. Ben Franklin used this method to get rid of <em>his</em> vices: everyday, tally how many times you indugled in any vice. After holding hiself responsible for his indulgences (being mindful of his vice counts, and remembering why he wants to stop doing what) for some length of time, he was able to completely eliminate the behaviors he no longer desired.
        </p>
    </div>

    <!-- active vices -->
    <div id="active-vices">
        <?php if( $vicesActive ) {
            foreach( $vicesActive as $vice ) {
                echo '<div class="row single-vice">
                    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 bg-warning p-3">
                        <div id="single-vice-' . $vice['id'] . '">
                            <h3>' . $vice['title'] . '</h3>
                            <p>' . $vice['note'] . '</p>
                            <span class="badge rounded-pill bg-success">Active</span>
                            <div id="manipulate-vice-' . $vice['id'] . '" class="float-end">
                                <button data-id="' . $vice['id'] . '" class="update-vice btn btn-primary">Edit</button>
                                <button data-id="' . $vice['id'] . '" class="deactivate-vice btn btn-outline-dark">Deactivate</button>
                                <button data-id="' . $vice['id'] . '" class="delete-vice btn btn-outline-danger">Delete</button>
                            </div>
                        </div>
                        <div id="single-vice-form-' . $vice['id'] . '" style="display: none;">
                            <form action="/app/vice/post-update-a-vice.php" method="POST">
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="user_id" value="">
                                <textarea name="title" rows="1">' . $vice['title'] . '</textarea>
                                <textarea name="note">' . $vice['note'] . '</textarea>
                                <select name="active" selected>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <div>
                                    <span class="float-end">
                                        <button data-id="' . $vice['id'] . '" class="cancel-update-vice btn btn-outline-dark">Cancel</button>
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
    <div id="togglers-vices" class="text-center pt-5">
        <p><span id="toggle-inactive-vices"> show / hide inactive vices </span></p>
        <p><span id="toggle-create-vice"> create a new vice </span></p>
    </div>

    <!-- inactive vices -->
    <div id="inactive-vices" style="display: none;">
        <?php if( $vicesInactive ) {
            foreach( $vicesInactive as $vice ) {
                echo '<div class="row single-vice">
                    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-light p-3 inactive-vice">
                        <div id="single-vice-' . $vice['id'] . '">
                            <h3>' . $vice['title'] . '</h3>
                            <p>' . $vice['note'] . '</p>
                            <span class="badge rounded-pill bg-dark">Inactive</span>
                            <div id="manipulate-vice-' . $vice['id'] . '" class="float-end">
                                <button data-id="' . $vice['id'] . '" class="activate-vice btn btn-success">Activate</button>
                                <button data-id="' . $vice['id'] . '" class="delete-vice btn btn-outline-danger text-light">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="row single-vice">
                <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-light p-3 inactive-vice">
                    <h3>No Inactive Vices</h3>
                </div>
            </div>';
        } ?>
    </div>

    <!-- create new vice -->
    <div id="create-vice" style="display: none;">
        <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 bg-light p-3">
            <form action="../app/vices/post-create-a-vice.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                <input type="hidden" name="page" value="account">
                <textarea name="title" id="create-title" placeholder="Vice Title (big, bold)"></textarea>
                <textarea name="note" id="create-note" placeholder="Vice Note (details, description)"></textarea>
                <div class="pb-5">
                    <span class="float-end">
                        <button id="cancel-create-vice" class="btn btn-outline-primary">Cancel</button>
                        <input type="submit" value="Add New Vice" class="btn btn-success">
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
    const $activateVice = $('.activate-vice');
    const $deactivateVice = $('.deactivate-vice');
    const $deleteVice = $('.delete-vice');
    
    // show / hide #inactive-vices
    $('#toggle-inactive-vices').on( 'click', function(e) {
        e.preventDefault();
        $('#inactive-vices').toggle();
        $('#create-vice').hide();
    });

    // show / hide #create-vice
    $('#toggle-create-vice').on( 'click', function(e) {
        e.preventDefault();
        $('#create-vice').toggle();
        $('#inactive-vices').hide();
    });

    // cancel creating a new vice
    $('#cancel-create-vice').on( 'click', function(e) {
        e.preventDefault();
        $('#create-title, #create-note').val('');
        $('#create-vice').hide();
    });

    // toggle edit a vice (active only)
    $('.update-vice, .cancel-update-vice').on( 'click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $( '#single-vice-' + id ).toggle();
        $( '#single-vice-form-' + id ).toggle();
        $( '#manipulate-vice-' + id ).toggle();
    });

    // activate an inactive vice
    $activateVice.on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/vices/activate-a-vice.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href= redirectString;
    });

    // deactivate an active vice
    $deactivateVice.on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/vices/deactivate-a-vice.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    });

    // delete a vice
    $deleteVice.on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/vices/delete-a-vice.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    });

});
</script>
