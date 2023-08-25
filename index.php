<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("E:/Tijdelijke downloads/Programming/XAMPP/XAMPP/htdocs/vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("E:/Tijdelijke downloads/Programming/XAMPP/XAMPP/htdocs/educom-verrukkulluk/templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
require_once("lib/database.php");
require_once("lib/recipe.php");
$db = new database();
$recipe = new recipe($db->getConnection());
$data = $recipe->selectRecipeById(1);


/*
URL:
http://localhost/index.php?recipe_id=4&action=detail
*/

$recipe_id = isset($_GET["id"]) ? $_GET["id"] : "";
$kitchen_id = isset($_GET["kitchen_id"]) ? $_GET["kitchen_id"] : "";
$type_id = isset($_GET["type_id"]) ? $_GET["type_id"] : "";
$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : "";
$date_added = isset($_GET["date_added"]) ? $_GET["date_added"] : "";
$recipe_title = isset($_GET["recipe_title"]) ? $_GET["recipe_title"] : "";
$recipe_description_short = isset($_GET["recipe_description_short"]) ? $_GET["recipe_description_short"] : "";
$recipe_description_long = isset($_GET["recipe_description_long"]) ? $_GET["recipe_description_long"] : "";
$recipe_image = isset($_GET["recipe_image"]) ? $_GET["recipe_image"] : "";


$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";


switch($action) {

        case "homepage": {
            $data = $recipe->selectRecipeById(1); // recipe_id
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "detail": {
            $data = $recipe->selectRecipeById(1); // recipe_id
            $template = 'detail.html.twig';
            $title = "detail pagina";
            break;
        }

        case "shoppinglist": {
            $data = $recipe->selectRecipeById(1); // recipe_id
            $template = 'shoppinglist.html.twig';
            $title = "shopping list";
            break;
        }

        // case "add_rating": {
        //     $data = $rating->selectRating(1); // recipe_id
        //     $template = 'detail.html.twig';
        //     $title = "detail pagina";
        //     break;
        // }

        // case "favourite": {
        //     $data = $favorite->determineFavorite(1,1); // recipe_id, user_id
        //     $template = 'detail.html.twig';
        //     $title = "detail";
        //     break;
        // }

        // case "shopping_list": {
        //     $data = $shoppingList->addToShoppingList(1); // recipe_id, user_id
        //     $template = 'detail.html.twig';
        //     $title = 'detail';
        //     break;
        // }

        // case "search": {
        //     $data = $keyword->;
        //     $template = ;
        //     $title = ;
        //     break;
        // }

        /// etc

}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);
