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

/* LINKING TO DETAIL PAGE */


