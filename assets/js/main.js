$('.header__menu-trigger-holder').click(() => {
    console.log('click');
    console.log($('.header__menu-holder'));
    $('.header__menu-holder').css({
        transform: 'translateY(0)'
    }, 1000);

});