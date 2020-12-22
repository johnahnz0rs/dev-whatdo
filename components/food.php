<?php
// require './recipes.php';

?>
<!-- custom styles -->
<style>
    #component-food .accordion .accordion-item i {
        padding-right: 6px;
    }
    #component-food #total-macros {
        margin: 24px;
        padding: 12px;
        border: 1px solid black;
    }
    #component-food .recipe-select {
        max-width: 100%;
    }
</style>


<div id="component-food" class="container-fluid p-5 fs-3 fs-md-4">

    <div id="total-macros" class="sticky-top bg-warning mt-5">
        <div class="text-center py-4">
            <p>Total food intake for the day: <span id="total-calories">0</span> cal</p>
        </div>
        <div class="d-flex justify-content-around">
            <div>&nbsp;</div>
            <div class="text-center"><span id="total-protein">0</span> g protein</div>
            <div class="text-center"><span id="total-fats">0</span> g fats</div>
            <div class="text-center"><span id="total-carbs">0</span> g carbs</div>
            <div>&nbsp;</div>
        </div>
    </div>

    <div class="accordion" id="accordion-meal-planner">

        <?php 
            $listOfMeals = [ "1" => "Meal 1", "2" => "Meal 2", "3" => "Meal 3", "4" => "Meal 4", "5" => "Meal 5" ];
        
            foreach( $listOfMeals as $i=>$meal ) {

                echo '<div id="accordion-meal-' . $i . '" class="accordion-item">';
                    echo '<h3 class="accordion-header" id="heading-' . $i . '">';
                        echo '<button class="accordion-button fs-2';
                        echo $i != "1" ? ' collapsed' : '' ;
                        echo '" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '">';
                            echo '<i id="checkbox-meal-' . $i . '" class="far fa-square"></i> ' . $meal;
                        echo '</button>';
                    echo '</h3>';
                    echo '<div id="collapse-' . $i . '" class="accordion-collapse collapse';
                    echo $i == "1" ? ' show' : '';
                    echo '" aria-labelledby="heading-' . $i . '" data-bs-parent="#accordion-meal-planner">';
                        echo '<div class="accordion-body">';
                            echo '<div class="row">';
                                echo '<div class="col-12 col-md-4">';
                                    echo '<form action="">';
                                        echo '<select class="recipe-select" id="select-meal-' . $i . '" data-meal="' . $i . '">';
                                            foreach( $recipes as $k=>$recipe ) {
                                                echo '<option value="' . $k .'">' . $recipe['name'] . '</option>';
                                            }
                                        echo '</select>';
                                    echo '</form>';
                                echo '</div>';
                                echo '<div class="col-12 col-md-8">';
                                    echo '<h4 id="selected-meal-name-' . $i . '" style="font-weight: bold; font-size: 1.5em; text-decoration: underline;"></h4>';
                                    echo '<div>';
                                        echo '<strong>Ingredients</strong><br>';
                                        echo '<ul id="selected-meal-ingredients-' . $i . '">';
                                        echo '</ul>';
                                    echo '</div>';
                                    echo '<div>';
                                        echo '<p><strong><em>This meal</em></strong> has <span id="selected-meal-calories-' . $i . '">0</span> calories</p>';
                                        echo '<div class="d-flex justify-content-around">';
                                            echo '<div><span id="selected-meal-protein-' . $i . '">0</span> g Protein</div>';
                                            echo '<div><span id="selected-meal-fats-' . $i . '">0</span> g Fats</div>';
                                            echo '<div><span id="selected-meal-carbs-' . $i . '">0</span> g Carbs</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

            }
        ?>
    </div>

</div>





















<script defer>
$( document ).ready( function() {
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
    let selectedMeals = {
        1: null,
        2: null,
        3: null,
        4: null,
        5: null
    };


    // this function re-calculates the day's total macros (based on recipe selection[s] and displays the new totals in the section-header)
    function calculateTotalCalories( ) {
        let calories = 0;
        let protein = 0;
        let fats = 0;
        let carbs = 0;
        [1, 2, 3, 4, 5].forEach( mealIndex => {
            if( selectedMeals[mealIndex] ) {
                const index = selectedMeals[mealIndex]
                const selectedMeal = recipes[index];
                protein += selectedMeal['protein'];
                fats += selectedMeal['fats'];
                carbs += selectedMeal['carbs'];
                calories = (protein * 4) + (fats * 9) + (carbs * 4);
            }
        } );
        $totalCalories.text(calories);
        $totalProtein.text(protein);
        $totalFats.text(fats);
        $totalCarbs.text(carbs);
    }

    // handler - when user selects a recipe, update that meal's .accordion-body w/ that recipe's macros, then update selectedMeals and call calculateTotalCalories
    $( '.recipe-select' ).on( 'change', function() {

        // .recipe-select
        // checkbox-meal-1
        // selected-meal-name-1
        // selected-meal-ingredients-1
        // selected-meal-calories
        // selected-meal-protein-1
        // selected-meal-fats-1
        // selected-meal-ßcarbs-1

        // set vars
        const selectedRecipe = $(this).val() == '0' ? null : $(this).val();
        const meal = $(this).data('meal');
        selectedMeals[meal] = selectedRecipe;
        
        if( selectedRecipe ) {
            const thisIsTheSelectedRecipe = recipes[selectedRecipe];
            // update checkbox
            $( '#checkbox-meal-' + meal ).removeClass( 'fa-square' ).addClass( 'fa-check-square' );
            // update meal name
            $( '#selected-meal-name-' + meal ).text( thisIsTheSelectedRecipe['name'] );
            // update meal ingredients
            let ingredientsString = '';
            thisIsTheSelectedRecipe['ingredients'].forEach( ing => {
                ingredientsString += '<li>' + ing;
                if( ing == 'pick 2 sides' ) {
                    ingredientsString += '<br>(' + platesSides + ')';
                }
                ingredientsString += '</li>';
            } );
            $( '#selected-meal-ingredients-' + meal ).html( ingredientsString );
            // update meal protein
            $( '#selected-meal-protein-' + meal ).text( thisIsTheSelectedRecipe['protein'] );
            // update meal fats
            $( '#selected-meal-fats-' + meal ).text( thisIsTheSelectedRecipe['fats'] );
            // update meal carbs
            $( '#selected-meal-carbs-' + meal ).text( thisIsTheSelectedRecipe['carbs'] );
            // update meal calories
            const thisMealsCalories = ( thisIsTheSelectedRecipe['protein'] * 4 ) + ( thisIsTheSelectedRecipe['fats'] * 9 ) + ( thisIsTheSelectedRecipe['carbs'] * 4 );
            $( '#selected-meal-calories-' + meal ).text( thisMealsCalories );
        } else {
            // update checkbox
            $( '#checkbox-meal-' + meal ).removeClass( 'fa-check-square' ).addClass( 'fa-square' );
            // update meal name
            $( '#selected-meal-name-' + meal ).text( '' );
            // update meal ingredients
            $( '#selected-meal-ingredients-' + meal ).empty();
            // update meal calories
            $( '#selected-meal-calories-' + meal ).text( '0' );
            // update meal protein
            $( '#selected-meal-protein-' + meal ).text( '0' );
            // update meal fats
            $( '#selected-meal-fats-' + meal ).text( '0' );
            // update meal carbs
            $( '#selected-meal-carbs-' + meal ).text( '0' );
        }

        // update the day's macros
        calculateTotalCalories();
    });

} );
</script>
