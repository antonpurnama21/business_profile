<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $titleWeb ?></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/dashboards/css/icons/icomoon/styles.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/dashboards/css/bootstrap.css');?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/dashboards/css/core.css');?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/dashboards/css/components.css');?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/dashboards/css/colors.css');?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('assets/dashboards/js/plugins/notifications/sweetalert2.css');?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
	<?php if(isset($_CSS) and !empty($_CSS)) echo $_CSS; ?>
	<!-- Core JS files -->
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/loaders/pace.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/core/libraries/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/core/libraries/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/loaders/blockui.min.js'); ?>"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/ui/moment/moment.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/ui/nicescroll.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/notifications/jgrowl.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/notifications/sweetalert2.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/pages/notif.js'); ?>"></script>
	<?php if(isset($_JS) and !empty($_JS)) echo $_JS; ?>

	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/core/app.js'); ?>"></script>

	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/pages/layout_fixed_custom.js'); ?>"></script>

	<script type="text/javascript" src="<?= base_url('assets/dashboards/js/plugins/ui/ripple.min.js'); ?>"></script>
	<!-- /theme JS files -->
	<link rel="shortcut icon" href="<?= base_url('assets/dashboards/images/cbn-shortcut.png'); ?>" />
	<style type="text/css">
		label {
	display: inline;
}

.regular-checkbox {
	display: none;
}

.regular-checkbox + label {
	background-color: #fafafa;
	border: 1px solid #cacece;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
	padding: 9px;
	border-radius: 3px;
	display: inline-block;
	position: relative;
}

.regular-checkbox + label:active, .regular-checkbox:checked + label:active {
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
}

.regular-checkbox:checked + label {
	background-color: #e9ecee;
	border: 1px solid #adb8c0;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
	color: #99a1a7;
}

.regular-checkbox:checked + label:after {
	content: '\2714';
	font-size: 14px;
	position: absolute;
	top: 0px;
	left: 3px;
	color: #99a1a7;
}


.big-checkbox + label {
	padding: 18px;
}

.big-checkbox:checked + label:after {
	font-size: 28px;
	left: 6px;
}

.tag {
	font-family: Arial, sans-serif;
	width: 200px;
	position: relative;
	top: 5px;
	font-weight: bold;
	text-transform: uppercase;
	display: block;
	float: left;
}

.radio-1 {
	width: 193px;
}

.button-holder {
	float: left;
}

/* RADIO */

.regular-radio {
	display: none;
}

.regular-radio + label {
	-webkit-appearance: none;
	background-color: #fafafa;
	border: 1px solid #cacece;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
	padding: 9px;
	border-radius: 50px;
	display: inline-block;
	position: relative;
}

.regular-radio:checked + label:after {
	content: ' ';
	width: 12px;
	height: 12px;
	border-radius: 50px;
	position: absolute;
	top: 3px;
	background: #99a1a7;
	box-shadow: inset 0px 0px 10px rgba(0,0,0,0.3);
	text-shadow: 0px;
	left: 3px;
	font-size: 32px;
}

.regular-radio:checked + label {
	background-color: #e9ecee;
	color: #99a1a7;
	border: 1px solid #adb8c0;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1), inset 0px 0px 10px rgba(0,0,0,0.1);
}

.regular-radio + label:active, .regular-radio:checked + label:active {
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
}

.big-radio + label {
	padding: 16px;
}

.big-radio:checked + label:after {
	width: 24px;
	height: 24px;
	left: 4px;
	top: 4px;
}
	</style>

	<!-- Kode menampilkan peringatan untuk mengaktifkan javascript-->
	<div align="center"><noscript>
	   <div style="position:fixed; top:0px; left:0px; z-index:3000; height:100%; width:100%; background-color:#FFFFFF">
	   <div style="font-family: Arial; font-size: 17px; background-color:#00bbf9; padding: 11pt;">Mohon aktifkan javascript pada browser untuk mengakses halaman ini!</div></div>
	</noscript></div>
	 
	<!--Kode untuk mencegah seleksi teks, block teks dll.-->
	<script type="text/javascript">
	function disableSelection(e){if(typeof e.onselectstart!="undefined")e.onselectstart=function(){return false};else if(typeof e.style.MozUserSelect!="undefined")e.style.MozUserSelect="none";else e.onmousedown=function(){return false};e.style.cursor="default"}window.onload=function(){disableSelection(document.body)}
	</script>
	 
	<!--Kode untuk mematikan fungsi klik kanan di blog-->
	<script type="text/javascript">
	function mousedwn(e){try{if(event.button==2||event.button==3)return false}catch(e){if(e.which==3)return false}}document.oncontextmenu=function(){return false};document.ondragstart=function(){return false};document.onmousedown=mousedwn
	</script>
	 
	<style type="text/css">
	* : (input, textarea) {
	    -webkit-touch-callout: none;
	    -webkit-user-select: none;
	 
	}
	</style>
	<style type="text/css">
	img {
	     -webkit-touch-callout: none;
	     -webkit-user-select: none;
	    }
	</style>
	 
	<!--Kode untuk mencegah shorcut keyboard, view source dll.-->
	<script type="text/javascript">
	window.addEventListener("keydown",function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){e.preventDefault()}});document.keypress=function(e){if(e.ctrlKey&&(e.which==65||e.which==66||e.which==67||e.which==73||e.which==80||e.which==83||e.which==85||e.which==86)){}return false}
	</script>
	<script type="text/javascript">
	document.onkeydown=function(e){e=e||window.event;if(e.keyCode==123||e.keyCode==18){return false}}
	</script>
	
</head>

<body class="navbar-top">
	

	<!-- Main navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top bg-indigo-800">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?=base_url()?>dashboard"><img src="<?= base_url('assets/dashboards/images/internship.png'); ?>" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

			</ul>

			<div class="navbar-right">
				<p class="navbar-text">Welcome, <?= $sesi['sess_name'] ?></p>
				<p class="navbar-text"><span class="label bg-success-400">online</span></p>
				

			</div>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main sidebar-default sidebar-fixed">
				<div class="sidebar-content">


					<!-- Main navigation -->
					<?php $this->load->view('partials/sidebar'); ?>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - <?= $breadcrumb[0] ?></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?= base_url() ?>"><i class="icon-home2 position-left"></i> Dashboard</a></li>
							<li><?= $breadcrumb[0] ?></li>
							<li class="active"><?= $breadcrumb[1] ?></li>
						</ul>

						<ul class="breadcrumb-elements">
							<li><a href="#"><i class="icon-calendar position-left"></i> <?= date('d F Y'); ?></a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-gear position-left"></i>
									Setting
									<span class="caret"></span>
								</a>

								<ul class="dropdown-menu dropdown-menu-right">
									<li><a href="<?= base_url('auth/logout') ?>"><i class="icon-exit"></i> Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div id="content" class="content">

					<!-- Dashboard content -->
					
					<?= $body ?>
					<!-- /dashboard content -->


					<!-- Footer -->
					<?php $this->load->view('partials/footer'); ?>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
	<div id="tampilModal"></div>
</body>
<script type="text/javascript" charset="utf-8" async defer>
	<?php if(has_alert()):?>
    <?php foreach(has_alert() as $key => $message):
        if ($key == 'bg-danger') { $head = 'Error'; } elseif ($key == 'bg-info') { $head = 'Information'; } elseif ($key == 'bg-success') { $head = 'Success'; } else { $head = 'Warning'; }
    ?>
        notif('<?= $head ?>','<?= $message ?>','<?= $key ?>');
    <?php endforeach; ?>
    <?php endif; ?>
</script>


</html>