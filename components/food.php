<?php
// require './recipes.php'; // i call this file at the top of /dash/index.php

?>


<div id="component-food" class="">

    <div id="total-macros" class="sticky-top bg-warning">
        <div class="text-center">
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

    <div class="container py-3">
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
                            <div class="accordion-body">
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






