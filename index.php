<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

require_once("lib/database.php");
require_once("lib/article.php");
require_once("lib/user.php");
require_once("lib/kitchen-type.php");
require_once("lib/ingredient.php");
require_once("lib/recipe-info.php");
require_once("lib/recipe.php");


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


/// VERWERK 
$data_article = $article->selectArticle(8);
$data_user = $user->selectUser(1);
$data_kitchen_type = $kitchen_type->selectKitchenType(10);
$data_ingredient = $ingredient->selectIngredient(1); // Select individual ingredient
$data_recipe_info = $recipe_info->selectRecipeInfoById(1);
// data_addRecipeToFavorites = $addRecipeToFavorites->addRecipeToFavorites(NULL, 4, 1); // recipe_info_id, recipe_id, user_id
// $data_deleteRecipeFromFavorites = $deleteRecipeFromFavorites->deleteRecipeFromFavorites(4, 1); // recipe_id, user_id
$data_recipe = $recipe->selectRecipeById(1);



/// RETURN
// var_dump($data_article);
// var_dump($data_user);
// var_dump($data_kitchen_type);
// var_dump($data_ingredient);
// var_dump($data_recipe_info);
var_dump($data_recipe);
