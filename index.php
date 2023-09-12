<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("/Users/Kimmie/Projecten/Software/vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("/Users/Kimmie/Projecten/educom-verrukkulluk/templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
require_once("lib/database.php");
require_once("lib/recipe.php");
require_once("lib/ingredient.php");
require_once("lib/recipe-info.php");
require_once("lib/shopping-list.php");
require_once("lib/search.php");

$db = new database();
$recipe = new recipe($db->getConnection());
$ingredient = new ingredient($db->getConnection());
$comments = new recipe_info($db->getConnection());
$preparation = new recipe_info($db->getConnection());
$averageRating = new recipe_info($db->getConnection());
$createRatingRecords = new recipe_info($db->getConnection());
$addToShoppingList = new shopping_list($db->getConnection());
$articleOnList = new shopping_list($db->getConnection());
$deleteArticleShoppingList = new shopping_list($db->getConnection());
$search = new search($db->getConnection());

$data = $recipe->selectRecipeById();
$ingredient_data = $ingredient->selectIngredient(1);
$comments_data = $comments->selectComments(1);
$preparation_data = $preparation->selectPreparation(1);

/*
URL:
http://localhost/index.php?recipe_id=4&action=detail
*/

$recipe_id = isset($_GET["id"]) ? $_GET["id"] : null;
$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;
$article_id = isset($_GET["article_id"]) ? $_GET["article_id"] : null;
$rating = isset($_GET['rating']) ? $_GET['rating'] : 0;
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";


switch($action) {

        case "homepage": {
            $data = $recipe->selectRecipeById(); // recipe_id / NULL by default to retrieve all recipes
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "detail": {
            $data = $recipe->selectRecipeById($recipe_id);
            $ingredient_data = $ingredient->selectIngredient($recipe_id);
            $comments_data = $comments->selectComments($recipe_id);
            $preparation_data = $preparation->selectPreparation($recipe_id);
            $averageRating_data = $averageRating->calcAverageRating($recipe_id);
            $template = 'detail.html.twig';
            $title = "Detail pagina";
            break;
        }

        case "create_rating": {
            $ratingRecords_data = $createRatingRecords->createRatingRecord($recipe_id, $rating);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($ratingRecords_data);
            die();
            break;
        }

        case "shoppinglist": {
            $addToShoppingList_data = $addToShoppingList->addToShoppingList($recipe_id, $user_id);
            $articleOnList_data = $articleOnList->articleOnList(1,1); // article_id, user_id
            $template = 'shoppinglist.html.twig';
            $title = "Boodschappenlijst";
            break;
        }

        case "deleteFromShoppingList": {
            $deleteArticleShoppingList_data = $deleteArticleShoppingList->deleteArticleShoppingList($article_id, $user_id);
            $template = 'shoppinglist.html.twig';
            $title = "Boodschappenlijst";
        }

        case "search": {
            $search_data = $search->searchByKeyword();
            // $data = $keyword->;
            $template = 'search.html.twig';
            $title = "Zoekresultaten";
            break;
        }


        // case "favourite": {
        //     $data = $favorite->determineFavorite(1,1); // recipe_id, user_id
        //     $template = 'detail.html.twig';
        //     $title = "detail";
        //     break;
        // }


}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data, "ingredient_data" => $ingredient_data, "comments_data" => $comments_data, "preparation_data" => $preparation_data, "articleOnList_data" => $articleOnList_data, "deleteArticleShoppingList_data" => $deleteArticleShoppingList_data, "search_data" => $search_data]);
