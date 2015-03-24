@extends('layouts.master')

@section('content')

<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10"> 
		<!-- List starts -->
		<ul class="today-datas">
			<!-- List #1 -->
			<li class="borange">
			  <!-- Graph -->
			  <div class="pull-left"><i class="fa fa-rocket"></i></div>
			  <!-- Text -->
			  <div class="datas-text pull-right"><span class="bold">{{App\libraries\XSnapCourier::getClusterDetails(1)->iops}}</span> Current IOPS </div>

			  <div class="clearfix"></div>
			</li>
			<li class="blightblue">
			  <!-- Graph -->
			  <div class="pull-left"><i class="fa fa-cloud-upload"></i></div>
			  <!-- Text -->
			  <div class="datas-text pull-right"><span class="bold"><?php $target = 'ud-ssd-space-in-use' ?> {{ round(App\libraries\XSnapCourier::getClusterDetails(1)->$target / 1024 / 1024 ) }}</span> Gigabytes Used </div>

			  <div class="clearfix"></div>
			</li>
			
				@if(App\Setting::getSetting('SCHEDULER_ENABLED'))
				<a href="/disable">
				<li class="bgreen">
				@else
				<a href="/enable">
				<li class="bred">
				@endif
				  <!-- Graph -->
				  <div class="pull-left"><i class="fa fa-power-off"></i></div>
				  <!-- Text -->
				  @if(App\Setting::getSetting('SCHEDULER_ENABLED'))
				  <div class="datas-text pull-right"><span class="bold">Active</span> Scheduler is running </div>
				  @else
				  <div class="datas-text pull-right"><span class="bold">Inactive</span> Scheduler is not running </div>
				  @endif
				  

				  <div class="clearfix"></div>
				</li>
			</a>
			<li class="bred">
			  <!-- Graph -->
			  <div class="pull-left"><i class="fa fa-medkit"></i></div>
			  <!-- Text -->
			  <div class="datas-text pull-right"><span class="bold">0</span> Recent Errors </div>

			  <div class="clearfix"></div>
			</li>
		</ul> 
	</div>
	<div class="col-md-1"></div>
</div>

<!-- Graph time! -->
<div class="row">
	<div class="col-md-6">
		<div id="clusterio">
		</div>
		<br />
	</div>

	<div class="col-md-6">
		<div id="clusterspace">
		</div>
		<br />
	</div>

</div>

<div class="row">
	<div class="col-md-6">
		<div class="widget wviolet">
		<!-- Widget title -->
		<div class="widget-head">
		  <div class="pull-left">Volumes</div>
		  <div class="widget-icons pull-right">
			<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
			<a href="#" class="wclose"><i class="fa fa-times"></i></a>
		  </div>
		  <div class="clearfix"></div>
		</div>

		<div class="widget-content">
		  <!-- Widget content -->

		  <table class="table table-bordered table-striped">
		  	<thead>
		  		<tr>
		  			<th> <strong>Volume Name</strong></th>
		  			<th> <strong>Data Type</strong></th>
		  			<th> <strong>Snaps</strong> </th>
		  			<th> <strong>Statistics</strong> </th>
		  			<th> <strong>Actions</strong> </th>
		  		<tr>
		  	</thead>

		  	<tbody>
		  		@foreach($Volumes as $volume)
		  			<tr>
		  				<td> <a class="label label-success" href="/volumes/{{$volume->id}}"> {{$volume->xio_volume_name}} </a> </td>
		  				<td> {{$volume->name}} </td>
		  				<td> @if($volume->snaps_enabled == 1)
		  						Yes
		  					 @else
		  					    No
		  					 @endif
		  			    </td>
		  				<td> @if($volume->statistics_enabled == 1)
		  						Yes
		  					 @else
		  					    No
		  					 @endif
		  			    </td>
		  			    <td> <a class="label label-danger" href="/volumes/snap/{{$volume->id}}"> Awww Snap </a> </td>
		  			</tr>
		  		@endforeach
		  	</tbody>

		  </table>

		  <div class="clearfix"></div>  


		</div>
	  </div>
	</div>	

	<div class="col-md-6">
		<div class="widget wblue">
		<!-- Widget title -->
		<div class="widget-head">
		  <div class="pull-left">Data Types</div>
		  <div class="widget-icons pull-right">
			<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
			<a href="#" class="wclose"><i class="fa fa-times"></i></a>
		  </div>
		  <div class="clearfix"></div>
		</div>

		<div class="widget-content">
		  <!-- Widget content -->
		  <table class="table table-bordered table-striped">
		  	<thead>
		  		<tr>
		  			<th> <strong>Data Type</strong></th>
		  			<th> <strong>Snap Value</strong></th>
		  			<th> <strong>Snap Frame</strong> </th>
		  			<th> <strong>Retention Value</strong> </th>
		  			<th> <strong>Retention Frame</strong> </th>
		  		<tr>
		  	</thead>

		  	<tbody>
		  		@foreach($DataTypes as $dt)
		  			<tr>
		  				<td> <a class="label label-success" href="/datatypes/{{$dt->id}}"> {{$dt->name}} </a> </td>
		  				<td> {{$dt->snap_time_value}} </td>
		  				<td> {{$dt->snap_time_frame}} </td>
		  			    <td> {{$dt->retention_time_value}} </td>
		  			    <td> {{$dt->retention_time_frame}} </td>
		  			</tr>
		  		@endforeach
		  	</tbody>

		  </table>

		  <br />		  
		  <div class="clearfix"></div>
		  	<div class="container">  
		  		<a href="/datatypes/create" class="btn btn-info">Create DataType</a>
			</div>

			<br />
		</div>
	  </div>
	</div>	
</div>

<div class="row">
	<div class="col-md-12">
		<div class="widget worange">
		<!-- Widget title -->
		<div class="widget-head">
		  <div class="pull-left">Active Snapshots</div>
		  <div class="widget-icons pull-right">
			<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
			<a href="#" class="wclose"><i class="fa fa-times"></i></a>
		  </div>
		  <div class="clearfix"></div>
		</div>

		<div class="widget-content">
		  <!-- Widget content -->
		 <table class="table table-striped table-bordered">
		 	<thead>
		 		<tr>
		 			<th> Snapshot ID </th>
		 			<th> Snapshot Name </th>
		 			<th> Created </th>
		 			<th> Action </th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 		@foreach($Snapshots as $snapshot)
		 		<tr>
		 			<td> {{$snapshot->xio_snapshot_id}} </td>
		 			<td> {{$snapshot->name}} </td>
		 			<td> {{$snapshot->created_at}} </td>
		 			<td> <a href="/snapshots/delete/{{$snapshot->id}}" class="label label-danger">Delete</a></td>
		 		</tr>
		 		@endforeach
		 	</tbody>
		 </table>
		  <div class="clearfix"></div>  


		</div>
	  </div>
	</div>
</div>

<script type="text/javascript">
  google.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable(<?php echo $ClusterIO; ?>);

    var options = {
      title: 'XIO IOPS Performance',
      curveType: 'function',
      legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('clusterio'));

    chart.draw(data, options);
  }
</script>

<script type="text/javascript">
  google.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable(<?php echo $ClusterSpace; ?>);

    var options = {
      title: 'XIO Storage Utilization',
      curveType: 'function',
      legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('clusterspace'));

    chart.draw(data, options);
  }
</script>

@stop
