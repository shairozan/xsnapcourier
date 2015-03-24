<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>Login - XSnapCourier</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Your description">
		<meta name="keywords" content="Your,Keywords">
		<meta name="author" content="ResponsiveWebInc">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="css/font-awesome.min.css" rel="stylesheet">		
		<!-- Custom CSS -->
		<link href="css/style.css" rel="stylesheet">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="#">
	</head>
	
	<body>
		
		<!-- Form area -->
		<div class="admin-form">
			<!-- Widget starts -->
			<div class="widget worange">
				<!-- Widget head -->
				<div class="widget-head">
					<i class="fa fa-lock"></i> Login 
				</div>

				<div class="widget-content">
					<div class="padd">

					@if(\Session::has('error'))
						<div class="label label-danger">
							{{\Session::get('error')}}
						</div>
					@endif


						<!-- Login form -->
						<form class="form-horizontal" method="post" action="/dologin">
							<input type="hidden" name="_token" value="{{csrf_token()}}" />
							<!-- Email -->
							<div class="form-group">
								  <label class="control-label col-lg-3" for="inputEmail">Username</label>
								  <div class="col-lg-9">
									<input type="text" class="form-control" id="inputEmail" name="username" placeholder="Domain Username">
								  </div>
							</div>
							<!-- Password -->
							<div class="form-group">
								  <label class="control-label col-lg-3" for="inputPassword">Password</label>
								  <div class="col-lg-9">
									<input type="password" class="form-control" id="inputPassword" name="password" placeholder="Domain Password">
								  </div>
							</div>
							<!-- Remember me checkbox and sign in button -->
							<div class="form-group">
								<div class="col-lg-9 col-lg-offset-3">
									<div class="checkbox">
										<label>
											<input type="checkbox"> Remember me
										</label>
									</div>
								</div>
								<div class="col-lg-9 col-lg-offset-3">
									<button type="submit" class="btn btn-danger">Sign in</button>
									<button type="reset" class="btn btn-default">Reset</button>
								</div>
							</div>
						</form>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="widget-foot">

				</div>
			</div>  
		</div>
	

		<!-- Javascript files -->
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
	</body>	
</html>