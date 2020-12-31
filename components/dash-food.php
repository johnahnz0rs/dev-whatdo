<?php

require 'recipes.php';
// echo '<h2 style="padding-top: 200px;">got it</h2>';
// echo 'recipes:<br>';
// var_dump($recipes);
// die();

?>


<div id="component-food">

    <div id="total-macros" class="sticky-top bg-warning">
        <div class="text-center">
            <p>
                Total energy intake for the day: <span id="total-calories">0</span> cal
            </p>
        </div>
        <div class="d-flex justify-content-around">
            <div>&nbsp;</div>
            <div class="text-center"><span id="total-protein">0</span> g protein</div>
            <div class="text-center"><span id="total-fats">0</span> g fats</div>
            <div class="text-center"><span id="total-carbs">0</span> g carbs</div>
            <div>&nbsp;</div>
        </div>
    </div>

    <div class="container py-3">
        <p class="text-center p-1" style="line-height: 1.2;">
            <strong><em>These are estimates meant to help you plan your day; use a macro tracker like MyFitnessPal for accuracy.</em></strong>
        </p>
        <div class="accordion" id="accordion-meal-planner">

            <?php        
                foreach( $listOfMeals as $i=>$meal ) {

                    echo '<div id="accordion-meal-' . $i . '" class="accordion-item">
                        <h3 class="accordion-header" id="heading-' . $i . '">
                            <button class="accordion-button fs-3';
                                echo $i != "1" ? ' collapsed' : '' ;
                                echo '" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '">
                                <i id="checkbox-meal-' . $i . '" class="far fa-square"></i>
                                <span id="accordion-header-meal-' . $i . '" class="fs-5">' . $meal . '</span>
                            </button>
                        </h3>
                        <div id="collapse-' . $i . '" class="accordion-collapse collapse';
                        echo $i == "1" ? ' show' : '';
                        echo '" aria-labelledby="heading-' . $i . '" data-bs-parent="#accordion-meal-planner">
                            <div class="accordion-body bg-light">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <form action="">
                                            <select class="recipe-select" id="select-meal-' . $i . '" data-meal="' . $i . '">';
                                                foreach( $recipes as $k=>$recipe ) {
                                                    echo '<option value="' . $k .'">' . $recipe['name'] . '</option>';
                                                }
                                            echo '</select>
                                        </form>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div>
                                            <strong>Ingredients</strong><br>
                                            <ul id="selected-meal-ingredients-' . $i . '"></ul>
                                        </div>
                                        <div class="p-3">
                                            <p>
                                                <strong><em>This meal</em></strong> has <span id="selected-meal-calories-' . $i . '">0</span> calories
                                            </p>
                                            <div class="d-flex justify-content-around" style="font-weight: bold;">
                                                <div><span id="selected-meal-protein-' . $i . '">0</span> g Protein</div>
                                                <div><span id="selected-meal-fats-' . $i . '">0</span> g Fats</div>
                                                <div><span id="selected-meal-carbs-' . $i . '">0</span> g Carbs</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

                }
            ?>
        </div>
    </div>

</div>


<script type="text/javascript" defer>
$(document).ready(function() {

    // set vars
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

    // handler - when user selects a recipe, update that meal's .accordion-body w/ that recipe's macros, then: update selectedMeals, and call calculateTotalCalories
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
        $( '#selected-meal-protein-' + meal ).text( mealProtein );
        $( '#selected-meal-fats-' + meal ).text( mealFats );
        $( '#selected-meal-carbs-' + meal ).text( mealCarbs );
        $( '#selected-meal-calories-' + meal ).text( mealCalories );
        calculateTotalCalories();

    } );

});
</script>


