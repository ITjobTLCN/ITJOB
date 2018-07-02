@extends('admin.layout.new_master')
@section('primary-title') Statistics @endsection
@section('secondary-title') Statistics @endsection
@section('content')
<div ng-controller="StatisticsController">
    <div class="row">
        <div class="col-md-6">
          <!-- BAR CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Applications</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
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
