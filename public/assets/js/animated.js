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
});