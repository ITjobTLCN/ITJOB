<div class="header">
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{route('/')}}"><img src="assets/img/logo.png" alt="" height="40px"></a>
      </div>

      <div id="navbar" class="navbar-collapse collapse">
          <ul id="menu-header" class="nav navbar-nav">
            <li><a href="{{route('/')}}">Home</a>
            </li>
            <li><a href="{{route('alljobs')}}">All Jobs</a>
            </li>
            <li><a href="{{route('searchCompanies')}}">Company</a>
            </li>

            <li><a href="{{route('lienhe')}}">Contact</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="search hidden-xs"><a href="{{route('alljobs')}}""><i class="fa fa-search"></i></a></li>
            @if(Auth::check())
            <li>
                <a href="#">{{Auth::user()->name}} <span class="caret"></span> <div class="sign-in-user-avatar">
                    @if(Auth::user()->password !="")
                    <img src="uploads/avatar/{{Auth::user()->image}}" alt="" class="user-avatar img-responsive" width="150px" height="150px">
                    @else
                    <img src="{{Auth::user()->image}}" alt="" class="user-avatar img-responsive" width="150px" height="150px">
                    @endif
                </div></a> 
                <ul class="sub-menu-info">
                    <li><a href="{{route('profile')}}"><i class="fa fa-user" aria-hidden="true"></i>  My Account</a></li>
                    <li><a href="#"><i class="fa fa-check-square-o" aria-hidden="true" style="color: green;"></i>  Apply Jobs</a></li>
                    <li><a href="{{route('logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i>  Log out</a></li>
                </ul>
            </li>
            @else
            <li class="sign-in text-center"><a href="{{route('login')}}">Sign In</a>
                @endif
            </li>
            <li class="employer_site text-center"><a href="#">
                Post Job
            </a>
        </li>
    </ul>

</div>
<!--/.nav-collapse -->
</div>
<!--/.container-fluid -->
</nav>
    {{-- <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="assets/img/logo.png" alt="" height="40px">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul id="menu-header" class="nav navbar-nav">
                    <li><a href="{{route('/')}}">Home</a>
                    </li>
                    <li><a href="{{route('alljobs')}}">All Jobs</a>
                    </li>
                    <li><a href="{{route('searchCompanies')}}">Company</a>
                    </li>

                    <li><a href="{{route('lienhe')}}">Contact</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="sign-in"><a href="#">Sign In</a>
                    </li>
                    <li class="employer_site"><a href="#">
                        <strong>Employers</strong>
                        <br>
                        <span>Post Job to Find Talents</span>
                    </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> --}}
</div>