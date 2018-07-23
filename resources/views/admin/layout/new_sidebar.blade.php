<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="uploads/avatar/{{Auth::user()->avatar}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name}}</p>
                <a href="#">
                    <i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active">
                <a href="admin/statistics">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user-circle-o"></i>
                    <span>Accounts &amp; Roles</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active">
                        <a href="admin/users">
                        <!-- <a href="javascript:void(0)" onclick="$('#king-content').load('admin/users');"> -->
                            <i class="fa fa-users"></i> Accounts</a>
                    </li>
                    <li>
                        <a href="admin/roles">
                        <i class="fa fa-user-secret"></i> Roles</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-building-o"></i>
                    <span>Employers</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active">
                        <a href="admin/employers">
                            <i class="fa fa-user-circle"></i> Employers</a>
                    </li>
                    <li>
                        <a href="admin/masters-employees">
                        <i class="fa fa-user-circle-o"></i> Masters &amp; Employees</a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Jobs &amp; applications</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="admin/jobs">
                            <i class="fa fa-building"></i> Jobs</a>
                    </li>
                    <li>
                        <a href="admin/applications">
                            <i class="fa fa-file"></i> Applications</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{route('commingSoon')}}">
                    <i class="fa fa-th"></i>
                    <span>Notification</span>
                </a>
            </li>
            <!-- <li>
                <a href="assets/template/adminlte/pages/calendar.html">
                    <i class="fa fa-calendar"></i>
                    <span>Calendar</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-red">3</small>
                        <small class="label pull-right bg-blue">17</small>
                    </span>
                </a>
            </li>
            <li>
                <a href="assets/template/adminlte/pages/mailbox/mailbox.html">
                    <i class="fa fa-envelope"></i>
                    <span>Mailbox</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-yellow">12</small>
                        <small class="label pull-right bg-green">16</small>
                        <small class="label pull-right bg-red">5</small>
                    </span>
                </a>
            </li> -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
