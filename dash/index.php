<?php
session_start();

// only "logged in" users allowed in the dash
$userId = isset( $_COOKIE['user_id'] ) ? $_COOKIE['user_id'] : null;
$username = isset( $_COOKIE['username'] ) ? $_COOKIE['username'] : null;
$passHash = isset( $_COOKIE['pass_hash'] ) ? $_COOKIE['pass_hash'] : null;
if ( !$userId or !$username or !$passHash ) {
    $headerString = 'Location: ../signout';
    header( $headerString );
    die();
}

/** requires and vars */
require '../app/db.php'; // just initiates the dbase connection
require '../app/helpers.php';
require '../components/recipes.php';
$view = isset( $_GET['view'] ) ? $_GET['view'] : 'reminders';
$date = isset( $_GET['date'] ) ? $_GET['date'] : null;
$dates = getArrayOfDateStringsForYesterdayTodayTomorrow( $date );
// get user's daily program and wins
$program = getUsersProgram( $userId );
$wins = getUsersWins( $userId, $dates['today'] );
$addWins = addWinsAsNecessary( $userId, $program, $wins, $dates['today'] );
// get user's vices and viceCounts
$vices = getUsersVices( $userId );
$viceCounts = getUsersViceCounts( $userId, $dates['today'] );
$addVices = addViceCountsAsNecessary( $userId, $vices, $viceCounts, $dates['today'] );
if( $addWins or $addVices ) { 
    $headerString = 'Location: /dash/?date=' . $dates['today'];
    header( $headerString );
    die();
}
// get user's reminders
$reminders = getUsersReminders( $userId );
// get user's whatDos and whatDones
$whatDos = getUsersWhatDos( $userId );
$whatDones = getUsersWhatDones( $wins, $whatDos );


/* start HTML output */
require '../components/header.php'; // initiates the html output (starting w/ <html>)

?>

<div id="page-dash" class="full-width">

    <!-- reminders -->
    <div id="reminders" class="stack-component text-light bg-dark"<?php echo $view == 'reminders' ? '': ' style="display: none"'; ?>>
        <!-- <h2 class="full-width text-center mb-5">Reminders</h2> -->
        <?php require '../components/reminders.php'; ?> 
    </div>

    <!-- stackin wins -->
    <div id="wins" class="stack-component"<?php echo $view == 'wins' ? '': ' style="display: none"'; ?>>
        <!-- <h2 class="full-width text-center mb-5">Daily Wins</h2> -->
        <?php require '../components/wins.php'; ?>
    </div>

    <!-- meal plan -->
    <div id="food" class="stack-component text-secondary bg-info"<?php echo $view == 'food' ? '': ' style="display: none"'; ?>>
        <!-- <h2 class="full-width text-center">Meal Plan</h2> -->
        <?php require '../components/food.php'; ?>
    </div>

    <!-- vices -->
    <div id="vices" class="stack-component"<?php echo $view == 'vices' ? '': ' style="display: none"'; ?>>
        <!-- <h2 class="full-width text-center mb-5">Vices</h2> -->
        <?php require '../components/vices.php'; ?>
    </div>

    <!-- whatDo -->
    <div id="whatdo" class="stack-component text-light bg-dark"<?php echo $view == 'whatdo' ? '': ' style="display: none"'; ?>>
        <!-- <h2 class="full-width text-center">whatDo</h2> -->
        <?php require '../components/whatdo.php'; ?>
    </div>
    
</div>




<!-- custom script -->
<script defer>
$( document ).ready( function() {

    // set vars & initialize
    const userId = <?php echo $userId; ?>;
    const date = '<?php echo $dates['today']; ?>';
    const initialView = '<?php echo $view; ?>';
    setView( initialView );
    const recipes = <?php echo json_encode( $recipes ); ?>;
    const platesSides = <?php echo json_encode( $platesSides ); ?>;
    const $totalCalories = $( '#total-calories' );
    const $totalProtein = $( '#total-protein' );
    const $totalFats = $( '#total-fats' );
    const $totalCarbs = $( '#total-carbs' );
    let totalCalories = 0;
    let totalProtein = 0;
    let totalFats = 0;
    let totalCarbs = 0;
    let selectedMeals = { 1: null, 2: null, 3: null, 4: null, 5: null };




    // functions
    function setView( view ) {
        $( '#display-this-component' ).text( view );
        [ 'reminders', 'wins', 'food', 'vices', 'whatdo' ].forEach( sectionName => {
            if( sectionName == view.toLowerCase() ) {
                $( '#' + sectionName ).show();
            } else {
                $( '#' + sectionName ).hide();
            }
        } );
    }
    function calculateTotalCalories( ) {
        let calories = 0;
        let protein = 0;
        let fats = 0;
        let carbs = 0;
        let arrayMeal = [1, 2, 3, 4, 5];
        arrayMeal.forEach( i => {
            if( selectedMeals[i] ) {
                const index = selectedMeals[i]
                const selectedMeal = recipes[index];
                protein += selectedMeal['protein'];
                fats += selectedMeal['fats'];
                carbs += selectedMeal['carbs'];
                calories = (protein * 4) + (fats * 9) + (carbs * 4);
                console.log('yes selectedMeals[i] ' . i);
            } else {
                console.log( ' no selectedMeals[i]');
            }
        } );
        $totalCalories.text(calories);
        $totalProtein.text(protein);
        $totalFats.text(fats);
        $totalCarbs.text(carbs);
    }





    // subpage menu - controls/toggles which component is being displayed
    $( '.submenu-link' ).on( 'click', function(e) {
        e.preventDefault();
        const section = $( this ).data( 'submenu' );
        setView( section );
    } );





    // wins - (1) stack/unstack a win;  
    $( '.stack-this-win' ).on( 'click', function() {
        const id = $( this ).data( 'id' ).toString();
        const stacked = $( this ).data( 'stacked' ).toString();
        if( !id || !stacked ) {
            alert( 'Something is wrong. Please refresh the page. Please contact us if problem persists.' );
        } else {
            const updateString = '../app/wins/update-win-stacked.php?id=' + id + '&user_id=' + userId + '&stacked=' + stacked + '&date=' + date;
            window.location.href = updateString;
        }
    } );
    // (2) toggle win-note;
    $( '.toggle-win-note' ).on( 'click', function() {
        const formToBeToggled = '#winnote-' + $( this ).data( 'id' );
        $( formToBeToggled ).toggle();
    } );
    // (3) toggle add-user-note
    $( '.toggle-add-win-user-note' ).on( 'click', function() {
        const winUserNoteToBeToggled = '#add-detail-win-' + $( this ).data( 'id' );
        $( winUserNoteToBeToggled ).toggle();
    } );





    // // food - (1) meal selection; (2) daily totals; (3) add cookies
    // handler - when user selects a recipe, update that meal's .accordion-body w/ that recipe's macros, then update selectedMeals and call calculateTotalCalories
    $( '.recipe-select' ).on( 'change', function() {
        // initialize
        const selectedRecipe = $(this).val() == '0' ? null : $(this).val();
        const meal = $(this).data('meal');
        selectedMeals[meal] = selectedRecipe;
        // update checkbox
        const classToRemove = selectedRecipe ? 'fa-square' : 'fa-check-square';
        const classToAdd = selectedRecipe ? 'fa-check-square' : 'fa-square';
        $( '#checkbox-meal-' + meal ).removeClass( classToRemove ).addClass( classToAdd );
        // update meal name in accordion header
        const thisIsTheSelectedRecipe = selectedRecipe ? recipes[selectedRecipe] : null;
        const thisIsTheSelectedRecipeName = thisIsTheSelectedRecipe ? thisIsTheSelectedRecipe['name'] : '';
        $( '#accordion-header-meal-' + meal ).text( thisIsTheSelectedRecipeName );
        // update meal name in accordion body
        // $( '#selected-meal-name-' + meal ).text( thisIsTheSelectedRecipeName );
        
        // update meal ingredients 
        let ingredientsString = '';
        if( thisIsTheSelectedRecipe ) {
            thisIsTheSelectedRecipe['ingredients'].forEach( ing => {
                ingredientsString += '<li>' + ing;
                if( ing == 'pick 2 sides' ) {
                    ingredientsString += '<br>(' + platesSides + ')';
                }
                ingredientsString += '</li>';
            } );
            $( '#selected-meal-ingredients-' + meal ).html( ingredientsString );
        } else {
            $( '#selected-meal-ingredients-' + meal ).empty();
        }

        // update meal protein, fats, carbs
        const mealProtein = thisIsTheSelectedRecipe ? thisIsTheSelectedRecipe['protein'] : '0';
        const mealFats = thisIsTheSelectedRecipe ? thisIsTheSelectedRecipe['fats'] : '0';
        const mealCarbs = thisIsTheSelectedRecipe ? thisIsTheSelectedRecipe['carbs'] : '0';
        const mealCalories = thisIsTheSelectedRecipe ? ( thisIsTheSelectedRecipe['protein'] * 4 ) + ( thisIsTheSelectedRecipe['fats'] * 9 ) + ( thisIsTheSelectedRecipe['carbs'] * 4 ) : '0';
        // console.log( 'mealProtein ' . mealProtein);
        // console.log( 'mealFats ' . mealFats);
        // console.log( 'mealCarbs ' . mealCarbs);
        // console.log( 'mealCalories ' . mealCalories);
        $( '#selected-meal-protein-' + meal ).text( mealProtein );
        $( '#selected-meal-fats-' + meal ).text( mealFats );
        $( '#selected-meal-carbs-' + meal ).text( mealCarbs );
        $( '#selected-meal-calories-' + meal ).text( mealCalories );
        calculateTotalCalories();

    } );
    // Cookies.set('test_cookie', 'lolomgwtfbbq!?', { expires: 1, path: '/' });
    // const testCookie = Cookies.get( 'test_cookie' );
    // console.log( testCookie );

});

</script>

<?php require '../components/footer.php';
