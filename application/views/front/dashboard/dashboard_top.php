<!doctype html>
<html lang="en" class="no-js">
<head>
	<title>suarakaryanews.com</title>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,400italic' rel='stylesheet' type='text/css'>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/bootstrap.min.css" media="screen">	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/jquery.bxslider.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/font-awesome.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/magnific-popup.css" media="screen">	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/owl.carousel.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/owl.theme.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/ticker-style.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/style.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/extends.css" media="screen">
	
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/jquery.min.js"></script>
	<script type="text/javascript">
		$(function(){
			if($(window).width() >= 1024){
				$(function(){
					$('#owl-cour').attr("data-num", "3");
				})
			}else{
				$(function(){
					$('#owl-cour').attr("data-num", "4");
				})
			}
		});
	</script>
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url();?>assets/img/fav/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url();?>assets/img/fav/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url();?>assets/img/fav/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url();?>assets/img/fav/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>assets/img/fav/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url();?>assets/img/fav/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url();?>assets/img/fav/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url();?>assets/img/fav/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>assets/img/fav/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url();?>assets/img/fav/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>assets/img/fav/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url();?>assets/img/fav/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/img/fav/favicon-16x16.png">
	<link rel="manifest" href="<?php echo base_url();?>assets/img/fav/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo base_url();?>assets/img/fav/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
</head>
<body class="body-box">
<!-- Top line -->
				<div class="top-line">
					<div class="container container-extends">
						<div class="row">
							<div class="col-xs-3 col-sm-3 col-md-3">
								<ul class="top-line-list">
									<li id="logo-kanal"><a><img src="<?php echo base_url();?>assets/img/icon.png" alt="" width="30"></a><i class="fa fa-chevron-down padding-left-10 color-arrow-bottom"></i></li>
									<li><span class="time-now"><?php echo date("D ,d M Y / H:i");?></span></li>
								</ul>
							</div>	
							<div class="widget search-widget col-xs-6 col-sm-6 col-md-6">
								<form role="search" class="search-form">
									<input type="text" id="search" name="search" placeholder="Search here">
									<button type="submit" id="search-submit"><i class="fa fa-search"></i></button>
								</form>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-3">
								<ul class="top-line-list txt-rigth">
									<li><a href="#">Admin</a></li>
									<li><a href="#" class="login-btn" style="background-color:#FD8E23;">Log Out</a></li>
								</ul>
							</div>
							
						</div>
					</div>
				</div>
<div class="boxed">
	<!-- Container -->
	<div id="container">