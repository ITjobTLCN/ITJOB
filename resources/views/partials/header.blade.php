<header><nav class="navbar horizontal-navbar navbar-default"><div class="container-fluid"><div class="navbar-header hidden-xs"><a href="/" class="navbar-brand hidden-xs"><img src="/assets/img/logo.png" alt="TopDev" title="TopDev - Top Recruitment" height="40px"></a></div> <div class="hidden-xs"><ul class="nav navbar-nav navbar-left"><li><a href="https://topdev.vn/search">All Jobs</a></li> <li><a target="_blank" href="http://salary.topdev.vn/"><span>Your Salary</span></a></li> <li class="dropdown"><a href="#" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle"><span>Tech Events</span> <b class="caret"></b></a> <ul class="dropdown-menu" style="display: none;"><li><span class="icon-img icon-md"></span> <a href="http://mobileday.vn" target="_blank">
                                        Vietnam Mobile Day
                                    </a></li> <li><span class="icon-img icon-vnw"></span> <a href=" https://vietnamwebsummit.com" target="_blank">
                                        Vietnam Web Summit
                                    </a></li> <li><span class="icon-img icon-techtalk"></span> <a href="https://www.facebook.com/topdevvietnam/events" target="_blank">
                                        TopDev Techtalk
                                    </a></li></ul></li> <li><a target="_blank" href="http://blog.topdev.vn/"><span>Tech Blog</span></a></li></ul> <ul class="nav navbar-nav navbar-right"><li class="hidden-md hidden-sm hidden-xs"><a title="Contact Us" class="header-contact"><i class="fa fa-phone"></i> +84-28 62645022 | +84-28 62733496 | +84-28 62733497                            </a></li> <li><a href="https://topdev.vn/search" title="Tìm Việc Làm" class="box-search-job clickable"><i class="glyphicon glyphicon-search"></i></a></li> <li class="horizontal-navbar__employer-site"><a target="_blank" href="https://topdev.vn/employers"><strong class="hidden-xs">Employers</strong><br> <span>Post Job &amp; Find Talents</span></a></li></ul></div> <div class="visible-xs mobile-nav"><ul><li class="pull-left mobile-logo"><a href="https://topdev.vn"><img src="/assets/img/logo.png" alt="" class="visible-xs-inline"></a></li> <li><a class="menu-toggler"><i class="fa fa-lg fa-bars"></i></a></li> <li><a onclick="https://topdev.vn/search" class="clickable"><i class="glyphicon glyphicon-search"></i></a></li></ul></div></div></nav></header>

{{-- <div class="header">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".menu123">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="logo" href="{{route('/')}}"><img src="assets/img/logo.png" class="logo" alt="" titl=""/></a>
                <a href="#" class="hamburger"></a>
            </div>
            <div class="collapse navbar-collapse menu123" id="menu-info">
                <ul id="menu-header" class="nav navbar-nav navbar-left">
                    <li><a href="{{route('/')}}">Home</a></li>
                    <li><a href="{{route('alljobs')}}">All Jobs</a></li>
                    <li><a href="{{route('searchCompanies')}}">Company</a></li>
                    
                    <li><a href="{{route('lienhe')}}">Contact</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check())
                    <li>
                        <a href="#">{{Auth::user()->name}} <span class="caret"></span> <div class="sign-in-user-avatar"><img class="user-avatar" src="{{Auth::user()->image}}" alt="Avatar"></div></a> 
                        <ul class="sub-menu-info">
                            <li><a href="{{route('profile')}}"><i class="fa fa-user" aria-hidden="true"></i>  My Account</a></li>
                            <li><a href="#"><i class="fa fa-check-square-o" aria-hidden="true" style="color: green;"></i>  Apply Jobs</a></li>
                            <li><a href="{{route('logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i>  Log out</a></li>
                        </ul>
                    </li>
                    @else
                    <li><a href="{{route('login')}}" class="login_btn">Sign In</a></li>
                    @endif
                    <li class="employer-site">
                        <a target="_blank" href="https://topdev.vn/employers"><strong class="hidden-xs">Employers</strong><br> <span>Post Job &amp; Find Talents</span></a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </nav>
</div> --}}

