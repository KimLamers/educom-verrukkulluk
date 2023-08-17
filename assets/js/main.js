let isOpen = false;
let isAnimating = false;

// $('.header__menu-trigger-holder').click(() => {
//     console.log('click');
//     console.log($('.header__menu-holder'));
//     $('.header__menu-holder').css({
//         transform: isOpen ? 'translateY(-100%)' : 'translateY(0)'
//     }, 1000);

// });

$('.header__menu-trigger-holder').click(() => {
    $('.header__menu-holder').toggleClass('header__menu-holder--is-open');

});