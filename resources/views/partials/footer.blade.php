<footer id="myFooter">
    <div class="container footer-top">
        <div class="row">
            <div class="col-md-3">
                <h5>Get started</h5>
                <ul class="tag">
                    <li class="active"><a href="{{route("/")}}">Home</a>
                    </li>
                    <li><a href="{{route('alljobs')}}">All Jobs</a>
                    </li>
                    <li><a href="{{route('searchCompanies')}}">Company Reviews</a>
                    </li>
                    <li><a href="#">Post Job</a>
                    </li>
                    <li><a href="{{route('login')}}">Sign In</a>
                    </li>
                    <li><a href="{{route('lienhe')}}">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Find Jobs</h5>
                <ul ng-controller="SkillsController" class="tag">
                    <li ng-repeat="skill in skills">
                        <a href="it-job/search-job/<% skill.alias %>">
                            <% skill.name %>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Legal</h5>
                <ul class="tag">
                    <li><a href="#">Terms of Service</a>
                    </li>
                    <li><a href="#">Terms of Use</a>
                    </li>
                    <li><a href="#">Privacy Policy</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Connect Us</h5>
                <div class="social-networks">
                    <a href="#" class="facebook" title="Facebook"><img src="assets/img/facebook.png" alt="">
                    </a>
                    <a href="#" class="twitter" title="Twitter"><img src="assets/img/twitter.png" alt="">
                    </a>
                    <a href="#" class="google" title="Google"><img src="assets/img/google-plus.png" alt="">
                    </a>
                    <a href="#" class="linkedin" title="Linkedin"><img src="assets/img/linkedin.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="clearfix"></div>
    <div class="footer-copyright text-center">
        <p>2017 Copyright © K.P. </p>
        <p>1 Vo Van Ngan Strees, Binh Tho Ward, Thu Duc District, Ho Chi Minh City, Vietnam</p>
    </div>
    <a href="#0" class="cd-top" title="Back to top">Top</a>
</footer>