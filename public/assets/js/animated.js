
$(document).ready(function(){
    
    $(function() {
        var offsettop=317;
        
        $(window).scroll(function(){
            var main=$('.main').outerHeight();
            if($(window).scrollTop() > offsettop && $(window).scrollTop() < main){
                $('#mySidenav').css({
                    'position':'fixed',
                    'display':'block',
                    'top':'-200px'
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