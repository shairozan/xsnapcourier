@extends('layouts.master')

@section('content')

<div class="row">

	<div class="col-md-12">
		<div class="widget worange">
		<!-- Widget title -->
		<div class="widget-head">
		  <div class="pull-left">List of all Volumes</div>
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
		 			<th> Volume ID </th>
		 			<th> Volume Name </th>
		 			<th> Snaps Enabled </th>
		 			<th> Statistics Enabled </th>
		 			<th> Actions </th>
		 		</tr>
		 	</thead>
		 	<tbody>
		 		@foreach($volumes as $volume)
		 		<tr>
		 			<td> {{$volume->xio_volume_id}} </td>
		 			<td> {{$volume->xio_volume_name}} </td>
		 			<td> @if($volume->snaps_enabled == 1) <span class="label label-success">Yes</span>@else <span class="label label-danger">No</span> @endif </td>
		 			<td> @if($volume->statistics_enabled ==1 ) <span class="label label-success">Yes</span> @else <span class="label label-danger">No</span> @endif </td>
		 			<td> <a href="/volumes/{{$volume->id}}" class="label label-warning">Edit</a></td>
		 		</tr>
		 		@endforeach
		 	</tbody>
		 </table>
		  <div class="clearfix"></div>  


		</div>
	  </div>
	</div>
	</div>

</div>

@stop