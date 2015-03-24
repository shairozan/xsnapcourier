@extends('layouts.master')

@section('content')


<br />
@if($volume_utilization)
 <div class="row">
 	<div class="col-md-2 pull-left" id="volume_utilization">
 		
 				<script>
 					$(function () {

						    var gaugeOptions = {

						        chart: {
						            type: 'solidgauge',
						            height: 150
						        },

						        title: null,

						        pane: {
						            center: ['50%', '85%'],
						            size: '100%',
						            startAngle: -90,
						            endAngle: 90,
						            background: {
						                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
						                innerRadius: '60%',
						                outerRadius: '100%',
						                shape: 'arc'
						            }
						        },

						        tooltip: {
						            enabled: false
						        },

						        // the value axis
						        yAxis: {
						            stops: [
						                [0.1, '#55BF3B'], // green
						                [0.8, '#DDDF0D'], // yellow
						                [0.9, '#DF5353'] // red
						            ],
						            lineWidth: 0,
						            minorTickInterval: null,
						            tickPixelInterval: 400,
						            tickWidth: 0,
						            title: {
						                y: -70
						            },
						            labels: {
						                y: 16
						            }
						        },

						        plotOptions: {
						            solidgauge: {
						                dataLabels: {
						                    y: 5,
						                    borderWidth: 0,
						                    useHTML: true
						                }
						            }
						        }
						    };

						    // The speed gauge
						    $('#volume_utilization').highcharts(Highcharts.merge(gaugeOptions, {
						        yAxis: {
						            min: 0,
						            max: 100,
						            title: {
						                text: 'Utilization'
						            }
						        },

						        credits: {
						            enabled: false
						        },

						        series: [{
						            name: 'Utilization',
						            data: [{{$volume_utilization}}],
						            dataLabels: {
						                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
						                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
						                       '<span style="font-size:12px;color:silver">% Used</span></div>'
						            },
						            tooltip: {
						                valueSuffix: '% used'
						            }
						        }]

						    }));

						    // Bring life to the dials
						    setInterval(function () {
						       
						        // RPM
						        chart = $('#volume_utilization').highcharts();
						        
						    }, 2000);
						});
 				</script>
 	</div>
 </div>
 @endif

 <br />

 <div class="row">
 	<div class="col-md-6">
 		<div class="widget wblue">
		<!-- Widget title -->
		<div class="widget-head">
		  <div class="pull-left">Static Details for Volume {{$volume_details->xio_volume_name}} </div>
		  <div class="widget-icons pull-right">
			<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
			<a href="#" class="wclose"><i class="fa fa-times"></i></a>
		  </div>
		  <div class="clearfix"></div>
		</div>

		<div class="widget-content">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th> Name </th>
						<th> XIO ID </th>
						<th> Created </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td> {{$volume_details->xio_volume_name}} </td>
						<td> {{$volume_details->xio_volume_id}} </td>
						<td> {{$volume_details->created_at}} </td>
					</tr>
				<tbody>
			</table>  
		  <div class="clearfix"></div>
		</div>
	  </div>
 	</div>

 	<div class="col-md-6">
		<div class="widget wviolet">
		<!-- Widget title -->
		<div class="widget-head">
		  <div class="pull-left">Variable Details for Volume {{$volume_details->xio_volume_name}}</div>
		  <div class="widget-icons pull-right">
			<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
			<a href="#" class="wclose"><i class="fa fa-times"></i></a>
		  </div>
		  <div class="clearfix"></div>
		</div>

		<div class="widget-content">
		  <!-- Widget content -->

		  <form class="form-horizontal" role="form" method="post" action="/volumes/{{$volume_details->id}}">

						<input type="hidden" name="_token" value="{{csrf_token()}}" />
						<input type="hidden" name="_method" value="put" />

						<div class="form-group">
						  <label class="col-md-4 control-label">Snaps Enabled</label>
						  <div class="col-md-8">
							<select name="snaps_enabled">
								<option value="1"
								@if($volume_details->snaps_enabled == 1)
								 selected="selected"
								@endif
								>Yes</option>
								<option value="0"
								@if($volume_details->snaps_enabled == 0)
								 selected="selected"
								@endif
								>No</option>
							</select>
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-4 control-label">Statistics Enabled</label>
						  <div class="col-md-8">
							<select name="statistics_enabled">
								<option value="1"
								@if($volume_details->statistics_enabled == 1)
								 selected="selected"
								@endif
								>Yes</option>
								<option value="0"
								@if($volume_details->statistics_enabled == 0)
								 selected="selected"
								@endif
								>No</option>
							</select>
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-4 control-label">Data Type</label>
						  <div class="col-md-8">
							<select name="data_type_id">
								@foreach($data_types as $dt)
								<option value="{{$dt->id}}"
									@if($volume_details->data_type_id == $dt->id)
										selected="selected"
									@endif
									>{{$dt->name}}</option>
								@endforeach
							</select>
						  </div>
						</div>

						<input type="submit" value="Update Volume" class="btn btn-success" />

					</form>

		  <div class="clearfix"></div>  


		</div>
	  </div>
	</div>	
	<!-- End Row -->
 </div>



 
@stop