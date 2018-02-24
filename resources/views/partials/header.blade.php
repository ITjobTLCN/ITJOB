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

            <li><a href="{{route('contact')}}">Contact</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="search hidden-xs"><a href="{{route('alljobs')}}""><i class="fa fa-search"></i></a></li>
            @if(Auth::check())
             {{--  <li class="dropdown" id="markasread" onclick="markNotificationAsRead({{count(auth()->user()->unreadnotifications)}})">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                     <span class="glyphicon glyphicon-globe"></span> Notifications <span class="badge">{{count(auth()->user()->unreadnotifications)}}</span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    @forelse(auth()->user()->unreadnotifications as $notification)
                    <li class="notification-all">
                      @include('partials.notification.'.snake_case(class_basename($notification->type)))
                      
                    </li>
                    @empty
                      <li class="notification-all"><a href="">No new notification</a></li>
                    @endforelse
                   @foreach(auth()->user()->notifications as $notification)
                    <li >
                      @if($notification->read_at!=null)
                        @include('partials.notification.'.snake_case(class_basename($notification->type)))
                      @endif
                    </li>
                    @endforeach
                </ul>
            </li>  --}}
            <li>
                <a href="#">{{Auth::user()->name}} <span class="caret"></span> <div class="sign-in-user-avatar">
                    @if(Auth::user()->password !="")
                    <img src="uploads/user/avatar/{{Auth::user()->image}}" alt="" class="user-avatar img-responsive" width="150px" height="150px">
                    @else
                    <img src="{{Auth::user()->image}}" alt="" class="user-avatar img-responsive" width="150px" height="150px">
                    @endif
                </div></a> 
                <ul class="sub-menu-info">
                    <li><a href="{{route('profile')}}"><i class="fa fa-user" aria-hidden="true"></i>  My Account</a></li>
                    <li><a href="{{route('jobApplications')}}"><i class="fa fa-check-square-o" aria-hidden="true" style="color: green;"></i>  Apply Jobs</a></li>
                    <li><a href="{{route('logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i>  Log out</a></li>
                </ul>
            </li>
            @else
            <li class="sign-in text-center"><a href="{{route('login')}}">Sign In</a>
                @endif
            </li>
            <li class="employer_site text-center"><a href="{{route('getemp')}}">
                Post Job
            </a>
        </li>
    </ul>


</div>
<!--/.nav-collapse -->
</div>
<!--/.container-fluid -->
</nav>


</div>