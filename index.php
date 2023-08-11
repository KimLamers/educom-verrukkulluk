<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

require_once("lib/database.php");
require_once("lib/article.php");
require_once("lib/user.php");
require_once("lib/kitchen-type.php");
require_once("lib/ingredient.php");
require_once("lib/recipe-info.php");
require_once("lib/recipe.php");
require_once("lib/shopping-list.php");


/// INIT
$db = new database();
$article = new article($db->getConnection());
$user = new user($db->getConnection());
$kitchen_type = new kitchen_type($db->getConnection());
$ingredient = new ingredient($db->getConnection());
$recipe_info = new recipe_info($db->getConnection());
$addRecipeToFavorites = new recipe_info($db->getConnection());
$deleteRecipeFromFavorites = new recipe_info($db->getConnection());
$recipe = new recipe($db->getConnection());
$priceRecipe = new recipe($db->getConnection());
$caloriesRecipe = new recipe($db->getConnection());
$ratingRecipe = new recipe($db->getConnection());
$stepsRecipe = new recipe($db->getConnection());
$remarks = new recipe($db->getConnection());
$determineFavorite = new recipe($db->getConnection());
$addToShoppingList = new shopping_list($db->getConnection());


/// VERWERK 
$data_article = $article->selectArticle(8);
$data_user = $user->selectUser(1);
$data_kitchen_type = $kitchen_type->selectKitchenType(10);
$data_ingredient = $ingredient->selectIngredient(1); // Select individual ingredient
$data_recipe_info = $recipe_info->selectRecipeInfoById(1);
// data_addRecipeToFavorites = $addRecipeToFavorites->addRecipeToFavorites(NULL, 4, 1); // recipe_info_id, recipe_id, user_id
// $data_deleteRecipeFromFavorites = $deleteRecipeFromFavorites->deleteRecipeFromFavorites(4, 1); // recipe_id, user_id
$data_recipe = $recipe->selectRecipeById(3,4);
$data_priceRecipe = $priceRecipe->calcPriceForRecipe(4); // by recipe_id
$data_caloriesRecipe = $caloriesRecipe->calcCaloriesForRecipe(1); // by recipe_id
$data_ratingRecipe = $ratingRecipe->selectRating(1); // by recipe_id
$data_stepsRecipe = $stepsRecipe->selectSteps(1); // by recipe_id
$data_remarks = $remarks->selectRemarks(1); // by recipe_id
// $data_determineFavorite = $determineFavorite->determineFavorite(1,4); // by recipe_id, user_id
$data_addToShoppingList = $addToShoppingList->addToShoppingList(3,3); // by recipe_id, user_id


/// RETURN
// echo "<pre>; print_r($data_article); echo "</pre>;
// echo "<pre>; print_r($data_user); echo "</pre>;
// echo "<pre>; print_r($data_kitchen_type); echo "</pre>;
// echo "<pre>; print_r($data_ingredient); echo "</pre>;
// echo "<pre>"; print_r($data_recipe_info); echo "</pre>";
// echo "<pre>"; print_r($data_recipe); echo "</pre>";
// echo "<pre>"; print_r($data_priceRecipe); echo "</pre>";
// echo "<pre>"; print_r($data_caloriesRecipe); echo "</pre>";
// echo "<pre>"; print_r($data_ratingRecipe); echo "</pre>";
// echo "<pre>"; print_r($data_stepsRecipe); echo "</pre>";
// echo "<pre>"; print_r($data_remarks); echo "</pre>";
// echo "<pre>"; print_r($data_determineFavorite); echo "</pre>";
echo "<pre>"; print_r($data_addToShoppingList); echo "</pre>";