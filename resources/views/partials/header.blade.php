<div class="header">
    <nav class="navbar navbar-default" role="navigation" data-spy="affix" data-offset-top="2">
            <div class="container">
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
                    <ul id="menu-header" class="nav navbar-nav navbar-right">
                        <li><a href="{{route('alljobs')}}">All Jobs</a></li>
                        <li><a href="{{route('searchCompanies')}}">Company</a></li>
                        <li><a href="">Post Job</a></li>
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
                        <li><a href="{{route('lienhe')}}">Contact</a></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            </div>
    </nav>
</div>
