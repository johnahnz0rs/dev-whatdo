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

?>


<div id="account-wins">

    <div class="col-10 offset-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <h3 class="text-center">Wins</h3>
        <p>
            Your program is how you live, how you conduct yourself on a daily basis. It's your wake-up time, how you work out (do you just go through the motions, or do you EARN that PMA Positive Mental Attitude?), your nutrition; it's all the things <u><em>you</em></u> do to validate <u><em>yourself</em></u>. Each item is a Win; STACK enough Wins everyday, and you'll earn that righteous confidence and self-love. These wins will appear everyday in the Wins tab on your dashboard.
        </p>
    <div>

    <div id="active-wins">

    </div>

    <div id="togglers-wins" class="text-center pt-5">
        <p><span id="toggle-inactive-wins"> show / hide inactive wins </span></p>
        <p><span id="toggle-create-win"> create a new win</span></p>
    </div>

    <div id="inactive-wins" style="display: none;">
        inactive wins
    </div>

    <div id="create-win" style="display: none;">
        create win
    </div>

</div>




<script type="text/javascript" defer>
$(document).ready(function() {
    const userId = <?php echo $userId; ?>;
    const date = '<?php echo $todaysDate; ?>'; 
    
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
});
</script>


