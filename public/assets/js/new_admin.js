$('ul.sidebar-menu>li').click(function(){
    $(this).addClass(active);
    $('ul.sidebar-menu li').removeClass('active');
});
