<?php

// input veld
//      - search bar
//              - enter voor afronden keyword?
//              - submit button?
//      - wat te doen met input:
//              - lowercase?
//      - input sturen naar waar de sql query gemaakt wordt
//      - resultaat van sql query weergeven op frontend
//              - nieuwe pagina?
//              - dropdown menu?
//      - alles moet te vinden zijn, zowel articles als recipes
//              - laadt kitchen/type in


class search {

private $connection;

public function __construct($connection) {
    $this->connection = $connection;
}

public function searchByKeyword() {

    // $button = $_GET['submit'];
    $keyword = 'vegan';
    // $_GET['search_bar'];
    $searchResults = [];

    // query for recipes
    $sql_recipes = "SELECT *
                    FROM recipe
                    WHERE recipe_title
                    LIKE '%$keyword%'";
    $result_recipes = mysqli_query($this->connection, $sql_recipes);

    while($searchRecipes = mysqli_fetch_array($result_recipes)) {
        $searchResults[] = [
            "recipe_id" => $searchRecipes['id'],
            "recipe_title" => $searchRecipes['recipe_title'],
            "recipe_description_short" => $searchRecipes['recipe_description_short'],
            "recipe_image" => $searchRecipes['recipe_image'],
        ];
    }

    // query for articles
    $sql_articles = "SELECT * 
                    FROM articles
                    WHERE article_name
                    LIKE '%$keyword%'";
    $result_articles = mysqli_query($this->connection, $sql_articles);
    
    while($searchArticles = mysqli_fetch_array($result_articles)) {
        
        $searchResults[] = [
            "article_id" => $searchArticles['id'],
            "article_name" => $searchArticles['article_name'],
            "article_description" => $searchArticles['article_description'],
            "article_price" => $searchArticles['article_price'],
            "article_packaging" => $searchArticles['article_packaging'],
            "article_calories" => $searchArticles['article_calories'],
        ];
    }
    return $searchResults;
}}

// Oplossing van René:
// class zoek {
//     private function findRecipes() {
//         /// gaat naar alle recepten
//     }

//     public function search($keyword) {
//         $found = [];
//         $recipes = $this->findRecipes();
//         foreach($recipes as $recipe) {
//             $txt = json_encode($recipe);
//             if(strcmp($keyword, $txt) > 0 ) {
//                 $found = $recipe;
//             }
//         }
//     }
// }


?>