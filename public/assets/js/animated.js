$(document).ready(function(){
    
    $(function() {
        var offsettop=200;
        $(window).scroll(function(){
            if($(window).scrollTop() > offsettop){
                $('#mySidenav').css({
                    'position':'fixed',
                    'display':'block',
                    'top':'-300px'
                });
            }else{
                $('#mySidenav').css({
                    'display':'none'
                });
            }
        });
    });
    //followed
    $('#unfollowed').mouseover(function(){
        $(this).text("Unfollow");
    });
    $('#unfollowed').mouseleave(function(){
        $(this).text("Following");
    }); 
    $(document).ajaxComplete(function(){
        $('.followed i').css({
            'display':'none'
        });
        $('#unfollowed').mouseover(function(){
            $(this).text("Unfollow");
        });
        $('#unfollowed').mouseleave(function(){
            $(this).text("Following");
        });
    });
    //smooth navbar when scrolling
    $('.slide-section').click(function(e){  
        var linkHref=$(this).attr('href');
        var headerHeight=$('.header-companies').outerHeight();
        $('html, body').animate({
            scrollTop: $(linkHref).offset().top - headerHeight
        },1000);
        

        e.preventDefault();
    });
});