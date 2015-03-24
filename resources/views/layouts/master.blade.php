<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>XSnap Courier</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Your description">
		<meta name="keywords" content="Your,Keywords">
		<meta name="author" content="ResponsiveWebInc">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<!-- Bootstrap CSS -->
		<link href="{{URL::asset('css/bootstrap.min.css')}}" rel="stylesheet">
		<!-- jQuery UI -->
		<link rel="stylesheet" href="{{URL::asset('css/jquery-ui.css')}}"> 
		<!-- Font awesome CSS -->
		<link href="{{URL::asset('css/font-awesome.min.css')}}" rel="stylesheet">		
		<!-- Custom CSS -->
		<link href="{{URL::asset('css/style.css')}}" rel="stylesheet">
		<!-- Widgets stylesheet -->
		<link href="{{URL::asset('css/widgets.css')}}" rel="stylesheet">   

		 <script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }"></script>


          	<script src="{{URL::asset('js/jquery.js')}}"></script>
			<script src="//code.highcharts.com/highcharts.js"></script>
			<script src="//code.highcharts.com/highcharts-more.js"></script>
			<script src="//code.highcharts.com/modules/solid-gauge.js"></script>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="#">
	</head>
	
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
			<div class="container">
				<!-- Menu button for smallar screens -->
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="{{\URL::to('/')}}" class="navbar-brand"><span style="color:orange"><strong>X</strong></span><span class="bold">Snap</span>Courier</a>
				</div>
				<!-- Site name for smallar screens -->
				<!-- Navigation starts -->
				<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">     
					<!-- Links -->
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">            
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								 Admin <b class="caret"></b>  
							</a>
							<!-- Dropdown menu -->
							<ul class="dropdown-menu">
							<li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
							<li><a href="#"><i class="fa fa-cogs"></i> Settings</a></li>
							<li><a href="/logout"><i class="fa fa-power-off"></i> Logout</a></li>
							</ul>
						</li>
					</ul>
					<!-- Notifications -->
					
				</nav>
			</div>
		</div>

		<!-- Main content starts -->
		<div class="content">
			<!-- Sidebar -->
			<div class="sidebar">
				<div class="sidebar-dropdown"><a href="#">Navigation</a></div>
				<div class="sidebar-inner">
					
					<!--- Sidebar navigation -->
					<!-- If the main navigation has sub navigation, then add the class "has_submenu" to "li" of main navigation. -->
					<ul class="navi">
						<!-- Use the class nred, ngreen, nblue, nlightblue, nviolet or norange to add background color. You need to use this in <li> tag. -->

						<li class="nred @if(\Request::segment('1') == 'dashboard' || ! \Request::segment('1') ) current @endif"><a href="/"><i class="fa fa-desktop"></i> Dashboard</a></li>
						<li class="ngreen @if(\Request::segment('1') == 'volumes') current @endif"><a href="/volumes"><i class="fa fa-bar-chart-o"></i> Volumes </a></li>
						<li class="norange @if(\Request::segment('1') == 'datatypes') current @endif"><a href="/datatypes"><i class="fa fa-sitemap"></i> Data Types</a></li>
					</ul>
					<!--/ Sidebar navigation -->

					<!-- Date -->
					<div class="sidebar-widget">
						<div id="todaydate"></div>
					</div>
				</div>
			</div>
			<!-- Sidebar ends -->

			<!-- Main bar -->
			<div class="mainbar">
      
				<!-- Page heading -->
				<div class="page-head">
				<!-- Page heading -->
				@if( \Request::segment('1') )
					<h2 class="pull-left">{{ucfirst(\Request::segment('1'))}} </h2>
				@else
					<h2 class="pull-left"> Dashboard </h2>
				@endif
					<!-- Breadcrumb -->
					<div class="bread-crumb pull-right">
					  <a href="index.html"><i class="fa fa-home"></i> Home</a> 
					  <!-- Divider -->
					  <span class="divider">/</span> 
					  @if( \Request::segment('1') )
						<a href="#" class="bread-current">{{ucfirst(\Request::segment('1'))}} </a>
					 @else
						<a href="#" class="bread-current"> Dashboard </a>
					 @endif
					</div>
					<div class="clearfix"></div>
				</div><!--/ Page heading ends -->
				<!-- Matter -->
				<div class="matter">
					<div class="container">
						<!-- Today status. jQuery Sparkline plugin used. -->
						@yield('content')
					</div>
				</div><!--/ Matter ends -->
			</div><!--/ Mainbar ends -->	    	
			<div class="clearfix"></div>
		</div><!--/ Content ends -->



		<!-- Scroll to top -->
		<span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 

		<!-- Javascript files -->

		<!-- Bootstrap JS -->
		<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
		<!-- jQuery UI -->
		<script src="{{URL::asset('js/jquery-ui.min.js')}}"></script> 
		<!-- jQuery Flot -->

		
		<!-- Sparklines -->
		<script src="{{URL::asset('js/sparklines.js')}}"></script> 
		<!-- Respond JS for IE8 -->
		<script src="{{URL::asset('js/respond.min.js')}}"></script>
		<!-- HTML5 Support for IE -->
		<script src="{{URL::asset('js/html5shiv.js')}}"></script>
		<!-- Custom JS -->
		<script src="{{URL::asset('js/custom.js')}}"></script>
		
		<!-- Script for this page -->
		<script src="{{URL::asset('js/sparkline-index.js')}}"></script>
		
		<script>
		var disabledDays = [ <?php echo App\Snapshot::snapshotDates() ?>];
		jQuery(document).ready(function() { 
		    $( "#todaydate").datepicker({ 
		        dateFormat: 'yy-mm-dd',
		        beforeShowDay: function(date) {
		            var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
		            for (i = 0; i < disabledDays.length; i++) {
		            	/*console.log(y + '-' + m + '-' + d);
		            	console.log($.inArray(y + '-' + m + '-' + d,disabledDays)); */
		                if($.inArray(y + '-' + (m + 1) + '-' + d,disabledDays) > 0 ) {
		                    //return [false];
		                    return [true, 'ui-snap-day', ''];
		                }
		            }
		            return [true];

		        }
		    });
		});

		</script>
		
	</body>
</html>
