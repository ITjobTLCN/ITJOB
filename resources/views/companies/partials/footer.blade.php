
<footer id="myFooter">
        <div class="container">
        	<div class="row">
        		<div class="col-md-6 col-sm-6 col-xs-12">
        			<div class="row">
        				<div class="col-md-6">
        					<h5>Get started</h5>
		                    <ul class="tag">
		                        <li class="active"><a href="{{route("/")}}">Home</a></li>
		                        <li><a href="{{route('alljobs')}}">All Jobs</a></li>
		                        <li><a href="{{route('searchCompanies')}}">Company Reviews</a></li>
		                        <li><a href="#">Post Job</a></li>
		                        <li><a href="{{route('login')}}">Sign In</a></li>
		                        <li><a href="{{route('lienhe')}}">Contact</a></li>
		                    </ul>
        				</div>
	        			<div class="col-md-6">
		        			<h5>Find Jobs</h5>
                            <ul ng-controller="SkillsController" class="tag">
                                <li ng-repeat="skill in skills"><a href="it-job/search-job/<% skill.alias %>"><% skill.name %></a></li>
                            </ul>
	        			</div>
        			</div>
        			<div class="row">
        				<div class="col-md-6">
                            <h5>Legal</h5>
                            <ul class="tag">
                                <li ><a href="#">Terms of Service</a></li>
                                <li><a href="#">Terms of Use</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                            </ul>
        					
        				</div>
                        <div class="col-md-6">
                            <h5>Connect Us</h5>
                            <div class="social-networks">
                                <a href="#" class="twitter"><img src="{{asset('assets/img/facebook.png')}}" alt=""></a>
                                <a href="#" class="google"><img src="{{asset('assets/img/twitter.png')}}"" alt=""></a>
                                <a href="#" class="google"><img src="{{asset('assets/img/google-plus.png')}}"" alt=""></a>
                                <a href="#" class="google"><img src="{{asset('assets/img/linkedin.png')}}"" alt=""></a>
                            </div>
                        </div>
        			</div>
        		</div>
        		<div class="col-md-6 col-sm-6 col-xs-12">
        			<h5>Find us</h5>
					{{-- <div class="row">
                        <div id="fb-root"></div>
                    <div class="fb-page" data-href="https://www.facebook.com/J-Sneaker-559173257538946/" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" style="margin-bottom: 10px"><blockquote cite="https://www.facebook.com/J-Sneaker-559173257538946/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/J-Sneaker-559173257538946/">J Sneaker</a></blockquote></div>               
                    </div> --}}
                    {{-- <div class="row" id="maps">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.425458654834!2d106.76665741442872!3d10.855209192268092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175279e6cfef82b%3A0x511a6cabdb569c1e!2zMTkgxJDGsOG7nW5nIHPhu5EgOCwgTGluaCBUcnVuZywgVGjhu6cgxJDhu6ljLCBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1506357870186"  width="400px" height="220px" frameborder="0" style="border:0;margin-bottom: 10px" allowfullscreen></iframe>
                    </div> --}}
        			
        		</div>
        		</div>
        	</div>
        </div>
        <div class="footer-copyright">
            <p>2017 Copyright © K.P. </p>
        </div>
        <a href="#0" class="cd-top" data-toggle="tooltip" data-placement="top" title="Back to top">Top</a>
    </footer>
    <script>
    	(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=1572256699473093";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
	</script>
    
    