			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="{{route('getAdminDashboard')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="{{route('getadminusers')}}"><i class="fa fa-fw fa-bar-chart-o"></i> Manage Account</a>
                    </li>
                    <li>
                        <a href="{{route('getadminemps')}}"><i class="fa fa-fw fa-table"></i> Manage Employer</a>
                    </li>
                    <li>
                        <a href="{{route('getadminnotification')}}"><i class="fa fa-fw fa-edit"></i> Notification</a>
                    </li>
                    <li>
                        <a href="{{url('import')}}"><i class="fa fa-fw fa-edit"></i> Import from excel</a>
                    </li>
                   
                    <li>
                        <a href="#"><i class="fa fa-fw fa-dashboard"></i> IT Job Website</a>
                    </li>
                </ul>
            </div>