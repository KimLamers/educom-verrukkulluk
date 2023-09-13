/* NAVIGATION */
let isOpen = false;
let isAnimating = false;

$('.header__menu-trigger-holder').click(() => {
    $('.header__menu-holder').toggleClass('header__menu-holder--is-open');

});


/* RECIPE DETAIL TABLE */
let previousTab = document.querySelector('[data-tab]');
let previousButton = document.querySelector('.tablinks');

function openTab(event, tabName) {
    const tabContent = document.querySelector(`[data-tab="${tabName}"]`);

    if (tabContent.classList.contains('active')) {
        return;
    }

    tabContent.classList.add('active');
    event.currentTarget.classList.add('active');

    previousTab.classList.remove('active');
    previousTab = tabContent;
    
    previousButton.classList.remove('active');
    previousButton = event.currentTarget;

}


/* RATING SYSTEM */

// user creating corresponding database entry by clicking on star (detail page)
$('.content__container-recipe-detail-info-top--rating svg, .content__container-recipe-content-top--rating svg').click(function () {
    const ratingValue = $(this).attr('data-value');
    const recipe_id = $(this).attr('data-id');
    const url = `index.php?id=${ recipe_id }&action=create_rating&rating=${ ratingValue }`;


    $.ajax ({
        url: url,
        method: "GET",
        success: function(result){
            console.log(result);
            var averageRating = result.average;
            console.log(`The average rating is ${ averageRating } star(s) for this recipe`);




            // DETAIL PAGE: fill stars corresponding to average rating for recipe
            $(".content__container-recipe-detail-info-top--rating svg").removeClass('content__container-recipe-detail-info-top--rating-filled')

            $('.content__container-recipe-detail-info-top--rating svg').each( (index, elem) => {
                const itemValue = $(elem).attr('data-value');
                if(itemValue <= averageRating) {
                    $(elem).addClass('content__container-recipe-detail-info-top--rating-filled');
                }
            })




            // HOMEPAGE: take input from clicked star as rating to database, display average rating for each recipe
            $('.content__container-recipe-content-top--rating svg').each( (index, elem) => {
                const itemValue = $(elem).attr('data-value');
                const elem_id = $(elem).attr('id');

                if(result.recipe_id === "1") {
                    if(itemValue <= result.average) {
                        if(elem_id === "1-1" || elem_id === "1-2" || elem_id === "1-3" || elem_id === "1-4" || elem_id === "1-5") {
                            $(elem).addClass('content__container-recipe-content-top--rating-filled')
                        }
                    } else if(itemValue > result.average) {
                        if(elem_id === "1-1" || elem_id === "1-2" || elem_id === "1-3" || elem_id === "1-4" || elem_id === "1-5") {
                            $(elem).removeClass('content__container-recipe-content-top--rating-filled')
                        }
                    }
                }
                if(result.recipe_id === "2") {
                    if(itemValue <= result.average) {
                        if(elem_id === "2-1" || elem_id === "2-2" || elem_id === "2-3" || elem_id === "2-4" || elem_id === "2-5") {
                            $(elem).addClass('content__container-recipe-content-top--rating-filled')
                        }
                    } else if(itemValue > result.average) {
                        if(elem_id === "2-1" || elem_id === "2-2" || elem_id === "2-3" || elem_id === "2-4" || elem_id === "2-5") {
                            $(elem).removeClass('content__container-recipe-content-top--rating-filled')
                        }
                    }
                }
                if(result.recipe_id === "3") {
                    if(itemValue <= result.average) {
                        if(elem_id === "3-1" || elem_id === "3-2" || elem_id === "3-3" || elem_id === "3-4" || elem_id === "3-5") {
                            $(elem).addClass('content__container-recipe-content-top--rating-filled')
                        }
                    } else if(itemValue > result.average) {
                        if(elem_id === "3-1" || elem_id === "3-2" || elem_id === "3-3" || elem_id === "3-4" || elem_id === "3-5") {
                            $(elem).removeClass('content__container-recipe-content-top--rating-filled')
                        }
                    }
                }
                if(result.recipe_id === "4") {
                    if(itemValue <= result.average) {
                        if(elem_id === "4-1" || elem_id === "4-2" || elem_id === "4-3" || elem_id === "4-4" || elem_id === "4-5") {
                            $(elem).addClass('content__container-recipe-content-top--rating-filled')
                        }
                    } else if(itemValue > result.average) {
                        if(elem_id === "4-1" || elem_id === "4-2" || elem_id === "4-3" || elem_id === "4-4" || elem_id === "4-5") {
                            $(elem).removeClass('content__container-recipe-content-top--rating-filled')
                        }
                    }
                }
            })
        }
    })
})


/* ADD RECIPE INGREDIENTS TO SHOPPING LIST */
$('.content__container-recipe-detail-info-bottom-leftbutton--text').click(function() {
    
    const recipe_id = $(this).attr('data-id');
    const user_id = 1;

    $.ajax ({
        url: `index.php?id=${ recipe_id }&action=shoppinglist&user_id=${ user_id }`,
        method: "GET",
        async: false,
        success: function(result) {
            console.log(recipe_id);
            console.log(user_id);
        }
    })
})

/* DELETE ARTICLE FROM SHOPPING LIST */
$('.shoppinglist__content-icon-holder svg').click(function() {

    const article_id = $(this).attr('data-id');
    const user_id = 1;

    $.ajax ({
        url: `index.php?article_id=${ article_id }&action=deleteFromShoppingList&user_id=${ user_id }`,
        method: "GET",
        async: false,
        success: function(result) {
            console.log(article_id);
            console.log(user_id);
        }
    })

})

$("[name='submit']").click(function() {

    const button = $_GET['submit'];
    const keyword = $_GET['search_bar'];

    $.ajax ({
        url: `index.php?action=search&search_bar=${ keyword }&submit=${ button }`,
        method: "GET",
        async: false,
        success: function(result) {
            console.log(keyword);
            console.log(button);
        }
    })

})
