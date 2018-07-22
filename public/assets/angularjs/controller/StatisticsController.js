app.controller('StatisticsController', function ($scope, $http, $timeout, Constant) {
    // Set constant
    $scope.constant = Constant;
    // Load default data
    $scope.typeApp = 'week';
    $scope.typeJob = 'week';
    $scope.typeUser = 'week';
    $scope.day = (new Date).getDate();
    $scope.month = (new Date).getMonth() + 1;
    $scope.year = (new Date).getFullYear();

    $scope.init = function() {
        $scope.loadStatisticApps();
        $scope.loadStatisticJobs();
        $scope.loadStatisticUsers();
        $scope.loadStatisticEmpSkills();

    }

    $scope.convertDate = function(date) {
        var dd = date.getDate();
        var mm = date.getMonth() + 1;
        var yyyy = date.getFullYear();
        return `${yyyy}-${mm}-${dd}`;
    }

    $scope.loadStatisticApps = function() {
        $http({
            method: 'GET',
            url: 'admin/ngstatisticapps',
            params: {
                type: $scope.typeApp,
                day: $scope.day,
                month: $scope.month,
                year: $scope.year,
            },
            dataType: 'json'
        }).then(function (response) {
            // Load chart
            $scope.loadBarChart('appplicationChart', 'appplicationBoxChart',
                response.data.data, response.data.labels, '#3c8dbc', 0);
        }, function (error) {
            alert(error.message);
        });
    }

    $scope.loadStatisticJobs = function () {
        $http({
            method: 'GET',
            url: 'admin/ngstatisticjobs',
            params: {
                type: $scope.typeJob,
                day: $scope.day,
                month: $scope.month,
                year: $scope.year,
            },
            dataType: 'json'
        }).then(function (response) {
            // Load chart
            $scope.loadBarChart('jobChart', 'jobBoxChart',
                response.data.data, response.data.labels, '#dd4b39', 0);
        }, function (error) {
            alert(error.message);
        });
    }

    $scope.loadStatisticUsers = function () {
        $http({
            method: 'GET',
            url: 'admin/ngstatisticusers',
            params: {
                type: $scope.typeUser,
                day: $scope.day,
                month: $scope.month,
                year: $scope.year,
            },
            dataType: 'json'
        }).then(function (response) {
            // Load chart
            $scope.loadDoubleChart('userChart', 'userBoxChart',
                response.data.data, response.data.data2, response.data.labels, '#dd4b39', 1);
        }, function (error) {
            alert(error.message);
        });
    }

    $scope.loadStatisticEmpSkills = function () {
        $http({
            method: 'GET',
            url: 'admin/ngstatisticempskills',
            dataType: 'json'
        }).then(function (response) {
            // Load chart
            $scope.loadPieChart('#skillEmpChart', response.data);
        }, function (error) {
            alert(error.message);
        });
        $http({
            method: 'GET',
            url: 'admin/ngstatisticjobskills',
            dataType: 'json'
        }).then(function (response) {
            // Load chart
            $scope.loadPieChart('#skillJobChart', response.data);
        }, function (error) {
            alert(error.message);
        });
    }

    // Load single chart
    $scope.loadBarChart = function (child, parent, data, label, color, type) {
        $(`#${child}`).remove();
        $(`#${parent}`).append(`<canvas id="${child}" style="height:230px"><canvas>`);
        var areaChartData = {
            labels: label,
            datasets: [
                {
                    // label: 'Digital Goods',
                    // fillColor: 'rgba(60,141,188,0.9)',
                    // strokeColor: 'rgba(60,141,188,0.8)',
                    // pointColor: '#3b8bba',
                    // pointStrokeColor: 'rgba(60,141,188,1)',
                    // pointHighlightFill: '#fff',
                    // pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: data
                }
            ]
        }
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $(`#${child}`).get(0).getContext('2d');
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        barChartData.datasets[0].fillColor = color;
        barChartData.datasets[0].strokeColor = color;
        barChartData.datasets[0].pointColor = color;
        var barChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true
        }

        barChartOptions.datasetFill = false;
        switch (type) {
            case 0:
                barChart.Bar(barChartData, barChartOptions);
                break;
            case 1:
                barChart.Line(barChartData, barChartOptions);
                break;
            default:
                barChart.Bar(barChartData, barChartOptions);
                break;
        }
    };

    // Load double chart
    $scope.loadDoubleChart = function (child, parent, data, data2, label, color, type) {
        $(`#${child}`).remove();
        $(`#${parent}`).append(`<canvas id="${child}" style="height:230px"><canvas>`);
        var areaChartData = {
            labels: label,
            datasets: [
                {
                    label: 'Digital Goods',
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: data
                },
                {
                    label: 'Digital Goods',
                    fillColor: 'rgba(60,141,188,0.9)',
                    strokeColor: 'rgba(60,141,188,0.8)',
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: data2
                }
            ]
        }
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */
        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $(`#${child}`).get(0).getContext('2d');
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        barChartData.datasets[0].fillColor = color;
        barChartData.datasets[0].strokeColor = color;
        barChartData.datasets[0].pointColor = color;
        var barChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true
        }

        barChartOptions.datasetFill = false;
        switch (type) {
            case 0:
                barChart.Bar(barChartData, barChartOptions);
                break;
            case 1:
                barChart.Line(barChartData, barChartOptions);
                break;
            default:
                barChart.Bar(barChartData, barChartOptions);
                break;
        }
    };

    // Load bar chart
    $scope.loadPieChart = function (element, data) {
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $(element).get(0).getContext('2d')
        var pieChart = new Chart(pieChartCanvas)
        var PieData = data;
        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: '#fff',
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: 'easeOutBounce',
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions)
    }


    // Init datetime picker
    $('#statistic_app_datepicker, #statistic_job_datepicker, #statistic_user_datepicker').datepicker({
        autoclose: true,
        format: 'mm/dd/yyyy',
        todayHighlight: true
    })

    // Choose date start from datepicker for application
    $scope.set_date_chart = function (type) {
        var date_value;
        switch (type) {
            case Constant.CHART_APPLICATION:
                date_value = Date.parse($('#statistic_app_datepicker').val());
                if (isNaN(date_value) == false) {
                    var date = new Date(date_value);
                    $scope.day = date.getDate();
                    $scope.month = date.getMonth() + 1;
                    $scope.year = date.getFullYear();
                    // Reload chart
                    $scope.loadStatisticApps();
                } else {
                    alert('Date invalid');
                }
                break;
            case Constant.CHART_JOB:
                date_value = Date.parse($('#statistic_job_datepicker').val());
                if (isNaN(date_value) == false) {
                    var date = new Date(date_value);
                    $scope.day = date.getDate();
                    $scope.month = date.getMonth() + 1;
                    $scope.year = date.getFullYear();
                    // Reload chart
                    $scope.loadStatisticJobs();
                } else {
                    alert('Date invalid');
                }
                break;
            case Constant.CHART_ACTIVE_USER:
                date_value = Date.parse($('#statistic_user_datepicker').val());
                if (isNaN(date_value) == false) {
                    var date = new Date(date_value);
                    $scope.day = date.getDate();
                    $scope.month = date.getMonth() + 1;
                    $scope.year = date.getFullYear();
                    // Reload chart
                    $scope.loadStatisticUsers();
                } else {
                    alert('Date invalid');
                }
                break;
            default:
                return;
        }
    }
});
