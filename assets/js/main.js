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
$(".content__container-recipe-detail-info-top--rating svg").click(function () {
    const ratingValue = $(this).attr('data-value');
    const recipe_id = $(this).attr('data-id');
    const url = `index.php?id=${ recipe_id }&action=create_rating&rating=${ ratingValue }`

    $.ajax ({
        url: url,
        method: "GET",
        success: function(result){
            console.log(result);
        }
    })

    $(".content__container-recipe-detail-info-top--rating svg").removeClass('content__container-recipe-detail-info-top--rating-filled')

            $('.content__container-recipe-detail-info-top--rating svg').each( (index, elem) => {
                const itemValue = $(elem).attr('data-value');
                if(itemValue <= ratingValue) {
                    $(elem).addClass('content__container-recipe-detail-info-top--rating-filled');
                }
            })
            console.log(`Value: ${ ratingValue }`);
})

// display amount of stars corresponding to average rating, rounded (homepage)
$('.content__container-recipe-content-top--rating svg').each( (index, elem) => {
    
})