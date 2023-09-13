<?php

// input veld
//      - alles moet te vinden zijn, zowel articles als      recipes
//              - laadt kitchen/type in


class search {

private $connection;

public function __construct($connection) {
    $this->connection = $connection;
}

public function searchByKeyword() {

    $button = $_GET['submit'];
    $keyword = $_GET['search_bar'];
    $searchResults = [];

    // query for recipes
    $sql_recipes = "SELECT *
                    FROM recipe
                    WHERE recipe_title
                    LIKE '%$keyword%'";
    $result_recipes = mysqli_query($this->connection, $sql_recipes);

    while($searchRecipes = mysqli_fetch_array($result_recipes)) {
        $searchResults[] = [
            "name" => $searchRecipes['recipe_title'],
            "description" => $searchRecipes['recipe_description_short'],
            "image" => $searchRecipes['recipe_image'],
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
            "name" => $searchArticles['article_name'],
            "description" => $searchArticles['article_description'],
            "image" => $searchArticles['article_packaging'],
        ];
    }
    return $searchResults;
}}

// Oplossing van René:
// class zoek {
//     private function selectRecipeById() {
//         /// gaat naar alle recepten wanneer null
//     }

//     public function search($keyword) {
//         $found = [];
//         $recipes = $this->selectRecipeById();
//         foreach($recipes as $recipe) {
//             $txt = json_encode($recipe);
//             if(strcmp($keyword, $txt) > 0 ) {
//                 $found = $recipe;
//             }
//         }
//     }
// }


?>