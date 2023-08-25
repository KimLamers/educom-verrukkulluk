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
