@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="widget wblue">
				<div class="widget-head">
			  <div class="pull-left">Add a New DataType</div>
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
							<input type="text" name="name" class="form-control">
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-2 control-label">Snap Time Value</label>
						  <div class="col-md-1">
							<input type="text" name="snap_time_value" class="form-control">
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-2 control-label">Snap Time Frame</label>
						  <div class="col-md-8">
							<select name="snap_time_frame">
								<option selected="selected"></option>
								<option>hour</option>
								<option>day</option>
								<option>week</option>
								<option>month</option>
							</select>
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-2 control-label">Retention Value</label>
						  <div class="col-md-1">
							<input type="text" name="retention_time_value" class="form-control">
						  </div>
						</div>

						<div class="form-group">
						  <label class="col-md-2 control-label">Retention Frame</label>
						  <div class="col-md-8">
							<select name="retention_time_frame">
								<option selected="selected"></option>
								<option>hour</option>
								<option>day</option>
								<option>week</option>
								<option>month</option>
							</select>
						  </div>
						</div>

						<input type="submit" value="Create DataType" class="btn btn-success" />

					</form>
			  </div>
			</div>
		</div>
	</div>	
</div> 
@stop