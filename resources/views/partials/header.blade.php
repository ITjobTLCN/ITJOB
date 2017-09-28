<div class="header">
	<nav class="navbar navbar-default" role="navigation" data-spy="affix" data-offset-top="2">
		<div class="wrapper">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu123">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="logo" href="#"><img src="assets/img/logo.png" class="logo" alt="" titl=""/></a>
					<a href="#" class="hamburger"></a>
				</div>
				<div class="collapse navbar-collapse" id="menu123">
					<ul id="menu-header" class="nav navbar-nav navbar-right">
						<li><a href="#">All Jobs</a></li>
						<li><a href="{{route('companies')}}">Company Reviews</a></li>
						<li><a href="#">Post Job</a></li>
						@if(Auth::check())
						<li class="dropdown dropdown-user">
							<a href="{{route('login')}}" class="login_btn dropdown-toggle" data-toggle="dropdown">{{Auth::user()->name}} <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">My Account</a></li>
								<li><a href="#">Apply Jobs</a></li>
								<li><a href="#">Log out</a></li>
							</ul>
						</li>
						@else
						<li><a href="{{route('login')}}" class="login_btn">Sign In</a></li>
						@endif
						<li><a href="{{route('lienhe')}}">Contact</a></li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
</div>