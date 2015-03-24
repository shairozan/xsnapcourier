@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="widget wlightblue">
		<!-- Widget title -->
		<div class="widget-head">
		  <div class="pull-left">List of all Data Types</div>
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
		 			<th> Name </th>
		 			<th> Snap Time Value </th>
		 			<th> Snap Time Frame </th>
		 			<th> Retention Time Value </th>
		 			<th> Retention Time Frame </th>
		 			<th> Actions </th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 		@foreach($datatypes as $dt)
		 		<tr>
		 			<td> {{$dt->name}}</td>
		 			<td> {{$dt->snap_time_value}}</td>
		 			<td> {{$dt->snap_time_frame}}</td>
		 			<td> {{$dt->retention_time_value}}</td>
		 			<td> {{$dt->retention_time_frame}}</td>
		 			<td> <a href="/datatypes/{{$dt->id}}" class="label label-warning">Edit</a></td>
		 		</tr>
		 		@endforeach
		 	</tbody>
		 </table>
		  <div class="clearfix"></div>  


		</div>
	  </div>
	</div>
	</div>


@stop