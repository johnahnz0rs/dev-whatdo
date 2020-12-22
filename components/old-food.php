<?php


?>


<style>
    #totals {
        padding: 36px 12px;
        background-color: gold;
    }
    #totals strong {
        font-weight: bold;
        font-size: 125%;
    }
    .meal-row {
        padding: 16px;
    }
    .meal-row .col .d-flex .card-body {
        width: 360px;
        color: black;
    }
</style>
<div id="component-food">
<!-- header (total counts) -->
<div class="text-center sticky-top" id="totals">
    <div class="">
        <h1>food planner / calculator</h1>
        <p class="py-2" style="background-color: rgba(0,0,0,0.125);">
            <strong>how to use:</strong> select the plate you will eat for each meal. total calories/macros will be displayed up top.
        </p>
        <div class="d-flex justify-content-around">
            <div>
                <strong>calories</strong>
                <div id="total-cal"></div>
            </div>
            <div>
                <strong>protein</strong>
                <div id="total-protein"></div>
            </div>
            <div>
                <strong>fats</strong>
                <div id="total-fats"></div>
            </div>
            <div>
                <strong>carbs</strong>
                <div id="total-carbs"></div>
            </div>
        </div>
    </div>
</div> <!-- end header (total counts) -->
<!-- meals to select from -->
<div id="meals my-3">
    <div id="meal1" class="row meal-row">
        <div class="col">
            <h2>Meal 1</h2>
            <div id="options-meal1" class="d-flex"></div>
        </div>
    </div>
    <div id="meal2" class="row meal-row">
        <div class="col">
            <h2>Meal 2</h2>
            <div id="options-meal2" class="d-flex"></div>
        </div>
    </div>
    <div id="meal3" class="row meal-row">
        <div class="col">
            <h2>Meal 3</h2>
            <div id="options-meal3" class="d-flex"></div>
        </div>
    </div>
    <div id="meal4" class="row meal-row">
        <div class="col">
            <h2>Meal 4</h2>
            <div id="options-meal4" class="d-flex"></div>
        </div>
    </div>
    <div id="meal5" class="row meal-row">
        <div class="col">
            <h2>Meal 5</h2>
            <div id="options-meal5" class="d-flex"></div>
        </div>
    </div>
</div> <!-- end #meals -->
</div>





<script defer>
    $( document ).ready( function() {
        // set vars
        const meals = {
            meal1: [
                {
                    name: "Vivo & Egg Whites",
                    meal: 'meal1',
                    protein: 58,
                    fats: 8,
                    carbs: 24
                }
            ],
            meal2: [
                {
                    name: "Tuna Sandwich",
                    meal: 'meal2',
                    protein: 46,
                    fats: 9,
                    carbs: 40
                },
                {
                    name: "Turkey Sandwich",
                    meal: 'meal2',
                    protein: 48,
                    fats: 15,
                    carbs: 40
                }
            ],
            meal3: [
                {
                    name: "Salad w/ Chicken",
                    meal: 'meal3',
                    protein: 43,
                    fats: 3,
                    carbs: 27
                }
            ],
            meal4: [
                {
                    name: "Tilapia Plate",
                    meal: 'meal4',
                    protein: 28,
                    fats: 3,
                    carbs: 24
                },
                {
                    name: "Salmon Plate",
                    meal: 'meal4',
                    protein: 39,
                    fats: 19,
                    carbs: 24
                }
            ],
            meal5: [
                {
                    name: "KBW Top Round Steak Plate",
                    meal: 'meal5',
                    protein: 60,
                    fats: 40,
                    carbs: 75
                }
            ]
        };
        macros = {
            meal1: {
                protein: 0,
                fats: 0,
                carbs: 0
            },
            meal2: {
                protein: 0,
                fats: 0,
                carbs: 0
            },
            meal3: {
                protein: 0,
                fats: 0,
                carbs: 0
            },
            meal4: {
                protein: 0,
                fats: 0,
                carbs: 0
            },
            meal5: {
                protein: 0,
                fats: 0,
                carbs: 0
            }
        };      
        // onload: add options to each meal
        [ 'meal1', 'meal2', 'meal3', 'meal4', 'meal5' ].forEach( function( mealx ) {
            meals[mealx].forEach( function( meal, index ) {
                const elementId = '#options-' + meal.meal;
                const cal = ( 4 * meal.protein ) + ( 9 * meal.fats ) + ( 4 * meal.carbs );
                const mealCard = '<div class="card m-3 meal-select" id="'+ meal.meal + '-' + index + '"><div class="card-body"><h4>' + meal.name + '</h4><h5>' + meal.protein + ' P</h5><h5>' + meal.fats + ' F</h5><h5>' + meal.carbs + ' C</h5><h5>' + cal + ' calories</h5></div></div>';
                $( elementId ).append( mealCard );
                calculateMacros();
            } );
        } ); 
        // $( '#btn-calculate-macros' ).click(calculateMacros);
        // calculate macros
        function calculateMacros() {
            let protein = 0, fats = 0, carbs = 0, calories = 0;
            [ 'meal1', 'meal2', 'meal3', 'meal4', 'meal5' ].forEach( function( meal ) {
                protein += macros[meal].protein;
                fats += macros[meal].fats;
                carbs += macros[meal].carbs;
            } );
            calories = ( protein * 4 ) + ( fats * 9 ) + ( carbs * 4 );
            $( '#total-cal' ).text( calories );
            $( '#total-protein' ).text( protein );
            $( '#total-fats' ).text( fats );
            $( '#total-carbs' ).text( carbs );
        };
        // handle meal-option selection/click (radio buttons)
        $( '.meal-select' ).on( 'click', function(e) {
            e.preventDefault();
            const meal = this.id.split( '-' );
            console.log(meal);
            // console.log(  );
            $( this ).parent().children().css( 'border', '1px solid rgba(0,0,0,0.125)');
            $( this ).css('border', '4px solid red');
            macros[meal[0]].protein = meals[meal[0]][meal[1]].protein;
            macros[meal[0]].fats = meals[meal[0]][meal[1]].fats;
            macros[meal[0]].carbs = meals[meal[0]][meal[1]].carbs;
            calculateMacros();
        } );
    } );
</script>
