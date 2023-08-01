<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

require_once("lib/database.php");
require_once("lib/article.php");
require_once("lib/user.php");
require_once("lib/kitchen-type.php");
require_once("lib/ingredient.php");
// require_once("lib/recipe-info.php");

/// INIT
$db = new database();
$article = new article($db->getConnection());
$user = new user($db->getConnection());
$kitchen_type = new kitchen_type($db->getConnection());
$ingredient = new ingredient($db->getConnection());
$articleList = new ingredient($db->getConnection());
// $recipe_info = new recipe_info($db->getConnection());
// $articleInfo = new ingredient($db->getConnection());


/// VERWERK 
$data_article = $article->selectArticle(8);
$data_user = $user->selectUser(1);
$data_kitchen_type = $kitchen_type->selectKitchenType(10);
$data_ingredient = $ingredient->selectIngredient(17); // Select individual ingredient
$data_articleList = $articleList->selectIngredientsForRecipe(1); // Select ingredient list for each recipe_id
//$data_recipe_info = $recipe_info->selectRecipeInfo(9);
//$data_article_info = $articleInfo->selectArticlesInfo(1);

/// RETURN
// var_dump($data_article);
// var_dump($data_user);
// var_dump($data_kitchen_type);
// var_dump($data_ingredient);
var_dump($data_articleList);
