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

$db = new database();
$recipe = new recipe($db->getConnection());
$ingredient = new ingredient($db->getConnection());
$comments = new recipe_info($db->getConnection());
$preparation = new recipe_info($db->getConnection());

$data = $recipe->selectRecipeById();
$ingredient_data = $ingredient->selectIngredient(1);
$comments_data = $comments->selectComments(1);
$preparation_data = $preparation->selectPreparation(1);


/*
URL:
http://localhost/index.php?recipe_id=4&action=detail
*/

$recipe_id = isset($_GET["id"]) ? $_GET["id"] : null;
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";


switch($action) {

        case "homepage": {
            $data = $recipe->selectRecipeById(); // recipe_id
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "burger_detail": {
            $data = $recipe->selectRecipeById(1); // recipe_id
            $ingredient_data = $ingredient->selectIngredient(1); // recipe_id
            $comments_data = $comments->selectComments(1); // recipe_id
            $preparation_data = $preparation->selectPreparation(1); // recipe_id
            $template = 'burger_detail.html.twig';
            $title = "Vegan burger";
            break;
        }

        case "detail": {
            $data = $recipe->selectRecipeById(4); // recipe_id
            $ingredient_data = $ingredient->selectIngredient(4); // recipe_id
            $comments_data = $comments->selectComments(4); // recipe_id
            $preparation_data = $preparation->selectPreparation(4); // recipe_id
            $template = 'detail.html.twig';
            $title = "detail pagina";
            break;
        }

        // case "detail": {
        //     $data = $recipe->selectRecipeById(4); // recipe_id
        //     $ingredient_data = $ingredient->selectIngredient(4); // recipe_id
        //     $comments_data = $comments->selectComments(4); // recipe_id
        //     $preparation_data = $preparation->selectPreparation(4); // recipe_id
        //     $template = 'detail.html.twig';
        //     $title = "detail pagina";
        //     break;
        // }

        // case "detail": {
        //     $data = $recipe->selectRecipeById(4); // recipe_id
        //     $ingredient_data = $ingredient->selectIngredient(4); // recipe_id
        //     $comments_data = $comments->selectComments(4); // recipe_id
        //     $preparation_data = $preparation->selectPreparation(4); // recipe_id
        //     $template = 'detail.html.twig';
        //     $title = "detail pagina";
        //     break;
        // }


        // case "shoppinglist": {
        //     $data = $recipe->selectRecipeById(1); // recipe_id
        //     $template = 'shoppinglist.html.twig';
        //     $title = "shopping list";
        //     break;
        // }

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
echo $template->render(["title" => $title, "data" => $data, "ingredient_data" => $ingredient_data, "comments_data" => $comments_data, "preparation_data" => $preparation_data]);
