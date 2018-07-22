@extends('admin.layout.new_master')
@section('primary-title') Dashboard @endsection
@section('secondary-title') Review all informations of website @endsection
@section('content')
<div ng-controller="StatisticsController" data-ng-init="init()">
  <div class="row">
    <div class="col-lg-3 col-xs-6">
    <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><%useronline%></h3>
          <p>Online</p>
        </div>
        <div class="icon">
          <i class="fa fa-podcast"></i>
        </div>
        <a href="{{route('commingSoon')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><%countallusers%></h3>
          <p>Users</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="{{route('commingSoon')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><%countposted%></h3>

          <p>Posts</p>
        </div>
        <div class="icon">
          <i class="fa fa-newspaper-o"></i>
        </div>
        <a href="{{route('commingSoon')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3><%countapplies%></h3>

          <p>Applications</p>
        </div>
        <div class="icon">
          <i class="fa fa-file-code-o"></i>
        </div>
        <a href="{{route('commingSoon')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>

  <div class="row">
      <div class="col-md-6">
        <!-- BAR CHART -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Applications applied</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div>
              <span>Choose type: </span>
              <select name="typeApp" ng-model="typeApp" ng-change="loadStatisticApps()">
                <option value="week">Week</option>
                <option value="year">Year</option>
              </select>
              <button class="btn btn-info pull-right" ng-click="set_date_chart(0)"><span class="glyphicon glyphicon-search"></span></button>
              <div class="input-group date pull-right" style="width: 250px">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="statistic_app_datepicker">
              </div>
            </div>
            <div class="chart" id="appplicationBoxChart">
              <canvas id="appplicationChart" style="height:230px"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
      <!-- /.col (RIGHT) -->
      <div class="col-md-6">
        <!-- BAR CHART -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Job posted</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div>
              <span>Choose type: </span>
              <select name="typeApp" ng-model="typeJob" ng-change="loadStatisticJobs()">
                <option value="week">Week</option>
                <option value="year">Year</option>
              </select>
              <button class="btn btn-info pull-right" ng-click="set_date_chart(1)"><span class="glyphicon glyphicon-search"></span></button>
              <div class="input-group date pull-right" style="width: 250px">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="statistic_job_datepicker">
              </div>
            </div>
            <div class="chart" id="jobBoxChart">
              <canvas id="jobChart" style="height:230px"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>

      <div class="col-md-6">
        <!-- BAR CHART -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Active user and Register user </h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div>
              <span>Choose type: </span>
              <select name="typeUser" ng-model="typeUser" ng-change="loadStatisticUsers()">
                <option value="week">Week</option>
                <option value="year">Year</option>
              </select>
              <button class="btn btn-info pull-right" ng-click="set_date_chart(2)"><span class="glyphicon glyphicon-search"></span></button>
              <div class="input-group date pull-right" style="width: 250px">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="statistic_user_datepicker">
              </div>
            </div>
              <p style="margin-top: 16px;">Show daily/monthly of active user <small class="label bg-red">&nbsp;</small> or register user<small class="label bg-blue">&nbsp;</small>.</p>
            <div class="chart" id="userBoxChart">
              <canvas id="userChart" style="height:230px"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
      <!-- /.col (RIGHT) -->

      <div class="col-md-6">
        <!-- PIE CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title"> Ratio of employers skill </h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
              <p> Show ratio skills of all employer</p>
            <div class="chart">
              <canvas id="skillEmpChart" style="height:265px"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col (RIGHT) -->

      <div class="col-md-6">
        <!-- PIE CHART -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"> Ratio of jobs skill </h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
              <p> Show ratio skills of all jobs</p>
            <div class="chart">
              <canvas id="skillJobChart" style="height:265px"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col (RIGHT) -->
    </div>
    <!-- /.row -->
</div>
@endsection
@section('script')
<script src="assets/angularjs/controller/StatisticsController.js"></script>
<!-- ChartJS -->
<script src="assets/template/adminlte/bower_components/chart.js/Chart.js"></script>

@endsection
