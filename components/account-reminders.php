<?php

$remindersActive = [];
$remindersInactive = [];
$reminders = getAllUsersReminders( $userId );
foreach( $reminders as $reminder ) {
    if( $reminder['active'] ) {
        $remindersActive[] = $reminder;
    } else {
        $remindersInactive[] = $reminder;
    }
}

?>

<div id="account-reminders">
    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 ">
        <h3 class="text-center">Reminders</h3>
        <p>
            Pain and necessity give birth to ingenuity and creativity. You've done all this self-reflection; don't waste that work and growth by simply FORGETTING. Keep those pains, regrets, solutions, revelations, and visions of your best self at the forefront of your mind.
        </p>
    </div>

    <div id="active-reminders">
        <?php if( $remindersActive ) {
            foreach( $remindersActive as $reminder ) {

                echo '<div class="row single-reminder">
                    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 bg-warning p-3">
                        <div id="single-reminder-' . $reminder['id'] . '">
                            <h3>' . $reminder['title'] . '</h3>
                            <p>' . $reminder['note'] . '</p>
                            <span class="badge rounded-pill bg-success">Active</span>
                            <div id="manipulate-reminder-' . $reminder['id'] . '" class="float-end">
                                <button data-id="' . $reminder['id'] . '" class="update-reminder btn btn-primary">Edit</button>
                                <button data-id="' . $reminder['id'] . '" class="deactivate-reminder btn btn-outline-dark">Deactivate</button>
                                <button data-id="' . $reminder['id'] . '" class="delete-reminder btn btn-outline-danger">Delete</button>
                            </div>
                        </div>
                        <div id="single-reminder-form-' . $reminder['id'] . '" style="display: none;">
                            <form action="../app/reminders/post-update-a-reminder.php" method="POST">
                                <input type="hidden" name="id" value="' . $reminder['id'] . '">
                                <input type="hidden" name="user_id" value="' . $userId . '">
                                <textarea name="title" rows="1">' . $reminder['title'] . '</textarea>
                                <textarea name="note">' . $reminder['note'] . '</textarea>
                                <select name="active">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <div>
                                    <span class="float-end">
                                        <button data-id="' . $reminder['id'] . '" class="cancel-update-reminder btn btn-outline-dark">Cancel</button>
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

    <div id="togglers-reminders" class="text-center pt-5">
        <p><span id="toggle-inactive-reminders"> show / hide inactive reminders </span></p>
        <p><span id="toggle-create-reminder"> add a new reminder </span></p>
    </div>
        
    <div id="display-inactive-reminders" style="display: none;">
        <?php if( $remindersInactive ) {
            foreach( $remindersInactive as $reminder ) {
                echo '<div class="row single-reminder">
                    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-light p-3 inactive-reminder">
                        <div id="single-reminder-' . $reminder['id'] . '">
                            <h3>' . $reminder['title'] . '</h3>
                            <p>' . $reminder['note'] . '</p>
                            <span class="badge rounded-pill bg-dark">Inactive</span>
                            <div id="manipulate-reminder-' . $reminder['id'] . '" class="float-end">
                                <button data-id="' . $reminder['id'] . '" class="activate-reminder btn btn-success">Activate</button>
                                <button data-id="' . $reminder['id'] . '" class="delete-reminder btn btn-outline-danger text-light">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="row single-reminder">
                <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-light p-3 inactive-reminder">
                    <h3>No Inactive Reminders</h3>
                </div>
            </div>';
        } ?>
    </div>

    <div id="create-reminder" style="display: none;">
        <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 bg-light p-3">
            <form action="../app/reminders/post-create-a-reminder.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                <input type="hidden" name="page" value="account">
                <textarea name="title" id="create-title" placeholder="Reminder Title (big, bold)"></textarea>
                <textarea name="note" id="create-note" placeholder="Reminder Note (details, description)"></textarea>
                <div class="pb-5">
                    <span class="float-end">
                        <button class="cancel-create-reminder btn btn-outline-primary">Cancel</button>
                        <input class="btn btn-success" type="submit" value="Add New Reminder">
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

    // toggle edit a reminder (active only)
    $( '.update-reminder, .cancel-update-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $( '#single-reminder-' + id ).toggle();
        $( '#single-reminder-form-' + id ).toggle();
        $( '#manipulate-reminder-' + id ).toggle();
    } );

    // deactivate a reminder (active only)
    $( '.deactivate-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/reminders/deactivate-a-reminder.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    } );

    // activate a reminder (inactive only)
    $( '.activate-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/reminders/activate-a-reminder.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href= redirectString;
    } );

    // delete a reminder
    $( '.delete-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        const redirectString = '../app/reminders/delete-a-reminder.php?id=' + $(this).data('id') + '&user_id=' + userId;
        window.location.href = redirectString;
    } );

    // show / hide inactive reminders
    $( '#toggle-inactive-reminders' ).on( 'click', function(e) {
        e.preventDefault();
        $( '#display-inactive-reminders' ).toggle();
        $( '#create-reminder' ).hide();
    } );

    // show / hide create a new reminder
    $( '#toggle-create-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        $( '#create-reminder' ).toggle();
        $( '#display-inactive-reminders' ).hide();
    } );

    // cancel create-a-new-reminder
    $( '.cancel-create-reminder' ).on( 'click', function(e) {
        e.preventDefault();
        $( '#create-title, #create-note' ).val( '' );
        $( '#create-reminder' ).hide();
    } );

});
</script>
