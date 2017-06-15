<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta tags-->
    <meta charset="utf-8">
    <meta property="og:type" content="page">
	<meta property="og:site_name" content="suarakaryanews.com">
	<meta property="og:title" content="<?php echo $title_main;?>">
	<meta property="og:description" content="<?php echo $short_main;?>">
	<meta property="og:image" content="<?php echo $img;?>"/>
	<meta property="og:image:secure_url" content="<?php echo $img;?>" />
	<meta name="description" content="<?php echo $short_main; ?>">
	<meta name="author" content="<?php echo $posted_main;?>">
	<meta name="language" content="Indonesia">
	<meta name="robots" content="index, follow">
	<meta name="keywords" content="<?php echo $key_main;?>">
	<meta name="copyright" content="suarakaryanews.com">

    <title>suarakaryanews.com</title>

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
	
	<script src="<?php echo base_url();?>assets/js/front/jquery.min.js"></script>
	<script>
		$(function(){
			$("#login-btn").click(function(){
				$("#box-pop-up").fadeIn();
				$("#box-pop-up").css("display","flex");
				$("#login-pop").css("display","flex");
			});
			
			$("#daftar-btn").click(function(){
				$("#box-pop-up").fadeIn();
				$("#box-pop-up").css("display","flex");
				$("#reg-pop").css("display","flex");
			});
			
			$("#login-close").click(function(){
				$("#box-pop-up").fadeOut();
				$("#box-pop-up").css("display","none");
				$("#login-pop").css("display","none");
			});
			
			$("#reg-close").click(function(){
				$("#box-pop-up").fadeOut();
				$("#box-pop-up").css("display","none");
				$("#reg-pop").css("display","none");
			});
			
			$("#forget-close").click(function(){
				$("#box-pop-up").fadeOut();
				$("#box-pop-up").css("display","none");
				$("#forget-pop").css("display","none");
			});
			
			$("#daftar-login").click(function(){
				$("#login-pop").css("display","none");
				$("#box-pop-up").fadeIn();
				$("#box-pop-up").css("display","flex");
				$("#reg-pop").css("display","flex");
			});
			
			$("#kembali-login").click(function(){
				$("#forget-pop").css("display","none");
				$("#box-pop-up").fadeIn();
				$("#box-pop-up").css("display","flex");
				$("#login-pop").css("display","flex");
			});
			
			$("#btn-forget").click(function(){
				$("#login-pop").css("display","none");
				$("#box-pop-up").fadeIn();
				$("#box-pop-up").css("display","flex");
				$("#forget-pop").css("display","flex");
			});
			
			$("#notif-reg").click(function(){
				$('#name_reg').val('');
				$('#email_reg').val('');
				$('#username_reg').val('');
				$('#password_reg').val('');
				$('#konfirmasi_reg').val('');
				$('#agree').prop('checked', false); 
				$("#notif-reg").fadeOut();
			});
			
			$("#notif-login").click(function(){
				$("#notif-login").fadeOut();
			});
			
			$("#notif-forget").click(function(){
				$("#notif-forget").fadeOut();
			});
			
			$("#notif-forget").click(function(){
				$("#notif-forget").fadeOut();
			});
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
	<title>suarakaryanews.com</title>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-98791902-1', 'auto');
      ga('send', 'pageview');
    
    </script>
</head>
<script>
	$(function() {
		$('#login-act').click(function(){
			 $(".loading-login").fadeIn();
			 var username = $('#username').val();
			 var password = $('#password').val();
			 $.ajax({
				url:"./index.php/berita/get_validation_login/",
				cache:false,
				data: {
				   username : username,
				   password : password
				},
				type: "POST",
				dataType: 'json',
				success:function(result){
					if(result.status == 'success'){
						$("#notif-login span").remove();
						$(".loading-login").fadeOut();
						location.reload();
						
					}else if(result.status == 'logged'){
						$("#notif-login span").remove();
						$(".loading-login").fadeOut();
						location.reload();
						
					}else if(result.status == 'invalid'){
						$("#notif-login span").remove();
						$(".loading-login").fadeOut();
						$("#notif-login").css("display","flex");
						$("#notif-login").append('<span class="notif-box">Maaf, Username atau Password yang Anda Masukkan Salah</span>');
						
					}else{
						$("#notif-login span").remove();
						$(".loading-login").fadeOut();
						$("#notif-login").css("display","flex");
						$("#notif-login").append('<span  class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
						
					}
				}
			});
		});
		
		$('#forget-act').click(function(){
			 $(".loading-forget").fadeIn();
			 var email_forget = $('#email-forget').val();
			 $.ajax({
				url:"./index.php/berita/get_forget_account/",
				cache:false,
				data: {
				   email_forget : email_forget
				},
				type: "POST",
				dataType: 'json',
				success:function(result){
					if(result.status == 'success'){
						$("#notif-forget span").remove();
						$(".loading-forget").fadeOut();
						$("#notif-forget").css("display","flex");
						$("#notif-forget").append('<span class="notif-box">Data password anda telah kami reset dan telah kami kirimkan ke email anda.</span>');
						
						
					}else if(result.status == 'logged'){
						$("#notif-forget span").remove();
						$(".loading-forget").fadeOut();
						location.reload();
						
					}else if(result.status == 'invalid'){
						$("#notif-forget span").remove();
						$(".loading-forget").fadeOut();
						$("#notif-forget").css("display","flex");
						$("#notif-forget").append('<span class="notif-box">Maaf, Email yang Anda Masukkan Tidak Terdaftar</span>');
						
					}else{
						$("#notif-forget span").remove();
						$(".loading-forget").fadeOut();
						$("#notif-forget").css("display","flex");
						$("#notif-forget").append('<span  class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
						
					}
				}
			});
		});

		$('#reg-act').click(function(){
			 $(".loading-reg").fadeIn();
			 var name_reg = $('#name_reg').val();
			 var email_reg = $('#email_reg').val();
			 var username_reg = $('#username_reg').val();
			 var password_reg = $('#password_reg').val();
			 var konfirmasi_reg = $('#konfirmasi_reg').val();
			 var agree = $('#agree:checked').val();
			 
			 $.ajax({
				url:"./index.php/berita/get_add_account/",
				cache:false,
				data: {
				   name_reg : name_reg,
				   email_reg : email_reg,
				   username_reg : username_reg,
				   password_reg : password_reg,
				   konfirmasi_reg : konfirmasi_reg,
				   agree : agree
				},
				type: "POST",
				dataType: 'json',
				success:function(result){
					if(result.status == 'success'){
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						$("#notif-reg").css("display","flex");
						$("#notif-reg").append('<span class="notif-box">Link activation telah kami kirimkan ke email anda<br/>Silahkan kembali ke email anda untuk mengaktifkan account anda.</span>');
						//location.reload();
						
					}else if(result.status == 'logged'){
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						//location.reload();
						
					}else if(result.status == 'available'){
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						$("#notif-reg").css("display","flex");
						$("#notif-reg").append('<span class="notif-box">Maaf, Username atau Password sudah digunakan. Silahkan cari Username atau Password lain</span>');
						
					}else if(result.status == 'invalid'){
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						$("#notif-reg").css("display","flex");
						$("#notif-reg").append('<span class="notif-box">Maaf, Username atau Password yang Anda Masukkan Salah</span>');
						
					}else{
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						$("#notif-reg").css("display","flex");
						$("#notif-reg").append('<span class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
						
					}
				}
			});
		});
	});
	</script>
<body class="body-box">
	<div id="box-pop-up" style="background-color:rgba(225,225,225,0.3);position:fixed;top:0;left:0;width:100%;height:100%;z-index:9999999;display:flex;align-items:center;display:none;">
		<div id="login-pop" style="width:500px;background-color:#fff;margin:auto;display:none;">
			<?php 
				$attibute = array("style"=>"padding:30px");
				echo form_open("",$attibute);
			?>
				<div style="text-align:right;">
					<span id="login-close" class="fa fa-close"></span>
				</div>
				<div class="title-section margin-top-0">
					<h1><span>Login</span></h1>
				</div>
				<div class="row">
					<div  class="col-xs-6 col-sm-6 col-md-6">
						<span style="font-size:12px;">Sambungkan ke sosial media</span>
						<div>
							<a href="<?php 
							if($this->uri->segment(4) != ''){
							    echo base_url().'index.php/berita/loginFacebook/berita/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';
							}else if($this->uri->segment(2) == '' or $this->uri->segment(2) == null){
							    echo base_url().'index.php/berita/loginFacebook/berita/none/none/none/';
							}else if($this->uri->segment(3) == '' or $this->uri->segment(3) == null){
							    echo base_url().'index.php/berita/loginFacebook/berita/'.$this->uri->segment(2).'/none/none/';
							}else{
							    echo base_url().'index.php/berita/loginFacebook/berita/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/none/';
							}
							//echo $login_url;
							//echo base_url().'index.php/berita/loginFacebook/'.$url_d;
							?>" style="background-color:#1854dd;color:#fff;padding:10px;width:100%;float:left;margin-top:5px;border-radius:5px;font-size:12px;"><span class="fa fa-facebook margin-right-5"></span>Facebook</a>
						</div>
						<div>
							<a href="<?php 
							if($this->uri->segment(4) != ''){
							    echo base_url().'index.php/berita/loginGoogle/berita/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';
							}else if($this->uri->segment(2) == '' or $this->uri->segment(2) == null){
							    echo base_url().'index.php/berita/loginGoogle/berita/none/none/none/';
							}else if($this->uri->segment(3) == '' or $this->uri->segment(3) == null){
							    echo base_url().'index.php/berita/loginGoogle/berita/'.$this->uri->segment(2).'/none/none/';
							}else{
							    echo base_url().'index.php/berita/loginGoogle/berita/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/none/';
							}
							//echo $login_url;
							//echo base_url().'index.php/berita/loginFacebook/'.$url_d;
							?>" style="background-color:#f14133;color:#fff;padding:10px;width:100%;float:left;margin-top:5px;border-radius:5px;font-size:12px;"><span class="fa fa-google-plus margin-right-5"></span>Google</a>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6" style="border-left: 1px dotted #777;">
						<div>
							<label for="username" style="font-size:12px !important">Username</label>
							<input id="username" class="form-input" type="text" name="username" placeholder="Username" />
						</div>
						<div>
							<label for="password" style="font-size:12px !important">Password</label>
							<input id="password" class="form-input" type="password" name="username" placeholder="Password" />
						</div>
						<div>
							<a id="btn-forget" style="width:50%;display:inline-block;font-size:12px!important;">Lupa Password?</a>
							<ul class="list-login txt-rigth margin-top-20">
								<li class="padding-right-5"><a id="daftar-login" style="font-size:12px!important;">Daftar</a></li>
								<li style="border-left:1px dotted #777;" class="padding-left-10"><a class="login-btn" id="login-act" style="font-size:12px!important;">Login</a></li>
							</ul>
						</div>
						<div class="loading-login"><i class="fa fa-circle-o-notch fa-spin"></i> Loading . . .</div>
						<div id="notif-login"></div>
					</div>
				</div>
			<?php echo form_close();?>
		</div>
		<div id="forget-pop" style="width:500px;background-color:#fff;margin:auto;display:none;">
			<?php 
				$attibute = array("style"=>"padding:30px;width:100%;");
				echo form_open("",$attibute);
			?>
				<div style="text-align:right;">
					<span id="forget-close" class="fa fa-close"></span>
				</div>
				<div class="title-section margin-top-0">
					<h1><span>Lupa Password</span></h1>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div>
							<label for="email" style="font-size:12px !important">Your Email</label>
							<input id="email-forget" class="form-input" type="text" name="email" placeholder="e.g email@domain.com" />
						</div>
						<div class="loading-forget"><i class="fa fa-spinner fa-spin"></i> Loading . . .</div>
						<div>
							<ul class="list-login txt-rigth margin-top-20 img-full-width">
								<li class="padding-right-5"><a id="kembali-login" style="font-size:12px!important;">Kembali</a></li>
								<li style="border-left:1px dotted #777;" class="padding-left-10"><a class="login-btn" id="forget-act" style="font-size:12px!important;">Kirim</a></li>
							</ul>
						</div>
						<div id="notif-forget"></div>
					</div>
				</div>
			<?php echo form_close();?>
		</div>
		<div id="reg-pop" style="width:70%;background-color:#fff;margin:auto;display:none;">
			<?php 
				$attibute = array("style"=>"padding:30px;width:100%;");
				echo form_open("",$attibute);
			?>
				<div style="text-align:right;">
					<span id="reg-close" class="fa fa-close"></span>
				</div>
				<div class="title-section margin-top-0">
					<h1><span>Registrasi</span></h1>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6" style="border-right: 1px dotted #777;">
						<div>
							<label for="name" style="font-size:12px !important">Nama Lengkap</label>
							<input id="name_reg" class="form-input" type="text" name="name" placeholder="Nama Lengkap" />
						</div>
						<div>
							<label for="email" style="font-size:12px !important">Email</label>
							<input id="email_reg" class="form-input" type="text" name="email" placeholder="Email" />
						</div>
						<div>
							<label for="username" style="font-size:12px !important">Username</label>
							<input id="username_reg" class="form-input" type="text" name="username" placeholder="Username" />
						</div>
						<div>
							<label for="password" style="font-size:12px !important">Password</label>
							<input id="password_reg" class="form-input" type="password" name="password" placeholder="Password" />
						</div>
						<div>
							<label for="konfirmasi" style="font-size:12px !important">Konfimasi Password</label>
							<input id="konfirmasi_reg" class="form-input" type="password" name="email" placeholder="Konfirmasi" />
						</div>
						<div>
							<input id="agree" type="checkbox" name="agree" value="1" style="padding-top:2px;"/>
							<label for="agree" style="font-size:12px !important">Saya Menyetujui</label>
						</div>
						<div class="txt-rigth">
							<a class="login-btn" id="reg-act" style="font-size:12px!important;">Kirim</a>
						</div>
						<div class="loading-reg"><i class="fa fa-spinner fa-spin"></i> Loading . . .</div>
					</div>
					<div  class="col-xs-12 col-sm-6 col-md-6">
						<span style="font-size:12px;">Sambungkan ke sosial media</span>
						<div>
							<a href="<?php 
							if($this->uri->segment(4) != ''){
							    echo base_url().'index.php/berita/loginFacebook/berita/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';
							}else if($this->uri->segment(2) == '' or $this->uri->segment(2) == null){
							    echo base_url().'index.php/berita/loginFacebook/berita/none/none/none/';
							}else if($this->uri->segment(3) == '' or $this->uri->segment(3) == null){
							    echo base_url().'index.php/berita/loginFacebook/berita/'.$this->uri->segment(2).'/none/none/';
							}else{
							    echo base_url().'index.php/berita/loginFacebook/berita/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/none/';
							}
							//echo $login_url;
							//echo base_url().'index.php/berita/loginFacebook/'.$url_d;
							?>" style="background-color:#1854dd;color:#fff;padding:10px;width:100%;float:left;margin-top:5px;border-radius:5px;font-size:12px;"><span class="fa fa-facebook margin-right-5"></span>Facebook</a>
						</div>
						<div>
							<a href="<?php 
						    if($this->uri->segment(4) != ''){
							    echo base_url().'index.php/berita/loginGoogle/berita/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';
							}else if($this->uri->segment(2) == '' or $this->uri->segment(2) == null){
							    echo base_url().'index.php/berita/loginGoogle/berita/none/none/none/';
							}else if($this->uri->segment(3) == '' or $this->uri->segment(3) == null){
							    echo base_url().'index.php/berita/loginGoogle/berita/'.$this->uri->segment(2).'/none/none/';
							}else{
							    echo base_url().'index.php/berita/loginGoogle/berita/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/none/';
							}
							//echo $login_url;
							//echo base_url().'index.php/berita/loginFacebook/'.$url_d;
							?>" style="background-color:#f14133;color:#fff;padding:10px;width:100%;float:left;margin-top:5px;border-radius:5px;font-size:12px;"><span class="fa fa-google-plus margin-right-5"></span>Google</a>
						</div>
					</div>
					<div id="notif-reg"></div>
				</div>
			<?php echo form_close();?>
		</div>
	</div>
<!-- Top line -->
				<div class="top-line">
					<div class="container container-extends">
						<div class="row">
							<div class="col-xs-3 col-sm-3 col-md-3">
								<ul class="top-line-list">
									<li id="logo-kanal"><a><img src="<?php echo base_url();?>assets/img/icon.png" alt="" width="30"></a><i class="fa fa-chevron-down padding-left-10 color-arrow-bottom"></i></li>
									<li id="datetime-kanal"><span class="time-now"><?php echo date("D ,d M Y / H:i");?></span></li>
								</ul>
							</div>	
							<div class="widget search-widget col-xs-6 col-sm-6 col-md-6">
								<!--<form role="search" class="search-form" action="berita/search/" method="post">-->
								<?php 
									$attribute = array("role"=>"search","class"=>"search-form");
									echo form_open('berita/search_process/', $attribute);?>
									<input type="text" id="search" name="search" placeholder="Search here">
									<button type="submit" id="search-submit"><i class="fa fa-search"></i></button>
								</form>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-3">
								<ul class="top-line-list txt-rigth">
									<li><a style="color:#333;" id="daftar-btn">Daftar</a></li>
									<li><a id="login-btn" class="login-btn">Masuk</a></li>
								</ul>
							</div>
							
						</div>
					</div>
				</div>
<div class="boxed">
	<!-- Container -->
	<div id="container">