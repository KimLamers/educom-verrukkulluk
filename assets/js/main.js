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


$(".content__container-recipe-detail-info-top--rating svg").click(function () {
    const ratingValue = $(this).attr('data-value');

// FIRST SEND TO INDEX, USE SWITCH CASE TO CALL FUNCTION addOrUpdate

    $.ajax ({
        url: "",
        method: "POST",
        data: { rating: ratingValue },
        success: function(result){
            console.log(ratingValue);
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

