@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="widget wblue">
				<div class="widget-head">
			  <div class="pull-left">Modify DataType</div>
			  <div class="widget-icons pull-right">
				<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
				<a href="#" class="wclose"><i class="fa fa-times"></i></a>
			  </div>
			  <div class="clearfix"></div>
			</div>
			<div class="widget-content">
			  <div class="padd">
				<!-- Form starts.  -->

					<form class="form-horizontal" role="form" method="post" action="/datatypes">
						<input type="hidden" name="_token" value="{{csrf_token()}}" />
						<div class="form-group">
						  <label class="col-md-2 control-label">Name</label>
						  <div class="col-md-8">
							<input type="text" name="name" class="form-control" value="{{$datatype_details->name}}">
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-2 control-label">Snap Time Value</label>
						  <div class="col-md-1">
							<input type="text" name="snap_time_value" class="form-control" value="{{$datatype_details->snap_time_value}}">
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-2 control-label">Snap Time Frame</label>
						  <div class="col-md-8">
							<select name="snap_time_frame">
								<option></option>
								<option @if($datatype_details->snap_time_frame == 'hour') selected="selected" @endif >hour</option>
								<option @if($datatype_details->snap_time_frame == 'day') selected="selected" @endif >day</option>
								<option @if($datatype_details->snap_time_frame == 'week') selected="selected" @endif >week</option>
								<option @if($datatype_details->snap_time_frame == 'month') selected="selected" @endif >month</option>
							</select>
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-2 control-label">Retention Value</label>
						  <div class="col-md-1">
							<input type="text" name="retention_time_value" class="form-control" value="{{$datatype_details->retention_time_value}}">
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-2 control-label">Retention Frame</label>
						  <div class="col-md-8">
							<select name="retention_time_frame">
								<option></option>
								<option @if($datatype_details->retention_time_frame == 'hour') selected="selected" @endif >hour</option>
								<option @if($datatype_details->retention_time_frame == 'day') selected="selected" @endif >day</option>
								<option @if($datatype_details->retention_time_frame == 'week') selected="selected" @endif >week</option>
								<option @if($datatype_details->retention_time_frame == 'month') selected="selected" @endif >month</option>
							</select>
						  </div>
						</div>

						<input type="submit" value="Update DataType" class="btn btn-success" />

					</form>
			  </div>
			</div>
		</div>
	</div>	
</div> 
@stop