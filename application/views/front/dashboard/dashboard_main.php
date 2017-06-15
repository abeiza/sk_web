	<script>
		$(function(){
			$("#notif-prof").click(function(){
				$("#notif-prof").fadeOut();
			});
			
			$("#notif-password").click(function(){
				$("#notif-password").fadeOut();
			});
			
			
			$('#change-prof').click(function(){
				 $(".loading-prof").fadeIn();
				 var name_profile = $('#name-profile').val();
				 var email_profile = $('#email-profile').val();
				 var website_profile = $('#website-profile').val();
				 
				 $.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_update_profile/",
					cache:false,
					data: {
					   name_profile : name_profile,
					   email_profile : email_profile,
					   website_profile : website_profile
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							$("#notif-prof").css("display","flex");
							$("#notif-prof").append('<span class="notif-box">Update profile berhasil dilakukan</span>');
							//location.reload();
							
						}else if(result.status == 'logged'){
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							//location.reload();
							
						}else if(result.status == 'available'){
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							$("#notif-prof").css("display","flex");
							$("#notif-prof").append('<span class="notif-box">Maaf, Username atau Password sudah digunakan. Silahkan cari Username atau Password lain</span>');
							
						}else if(result.status == 'invalid'){
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							$("#notif-prof").css("display","flex");
							$("#notif-prof").append('<span class="notif-box">Maaf, Username atau Password yang Anda Masukkan Salah</span>');
							
						}else{
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							$("#notif-prof").css("display","flex");
							$("#notif-prof").append('<span class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
							
						}
					}
				});
			});
			
			$('#change-password').click(function(){
				 $(".loading-password").fadeIn();
				 var change_username = $('#username-change').val();
				 var change_password = $('#password-change').val();
				 var change_new = $('#new-change').val();
				 var change_conf = $('#conf-change').val();
				 
				 $.ajax({
					url:"<?php echo base_url();?>index.php/berita/set_update_password/",
					cache:false,
					data: {
					   change_username : change_username,
					   change_password : change_password,
					   change_new : change_new,
					   change_conf : change_conf
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							$("#notif-password").css("display","flex");
							$("#notif-password").append('<span class="notif-box">Ubah password berhasil dilakukan</span>');
							//location.reload();
							
						}else if(result.status == 'logged'){
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							//location.reload();
							
						}else if(result.status == 'available'){
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							$("#notif-password").css("display","flex");
							$("#notif-password").append('<span class="notif-box">Maaf, Username atau Password sudah digunakan. Silahkan cari Username atau Password lain</span>');
							
						}else if(result.status == 'invalid'){
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							$("#notif-password").css("display","flex");
							$("#notif-password").append('<span class="notif-box">Maaf, Username atau Password yang Anda Masukkan Salah</span>');
							
						}else{
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							$("#notif-password").css("display","flex");
							$("#notif-password").append('<span class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
							
						}
					}
				});
			});
	
		});
	</script>
<!-- block-wrapper-section
			================================================== -->
		<section class="block-wrapper" id="block-container">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-3 col-md-3 artikel-desc">

						<!-- block content -->
						<div class="block-content">

							<!-- grid box -->
							<div class="grid-box">
								<div class="title-section">
									<h1><span>Profil </span></h1>
								</div>
								
								<div style="text-align:center;">
									<form name="photo" style="text-align:center;display:inline-block" id="imageUploadForm" enctype="multipart/form-data" action="<?php echo base_url();?>index.php/berita/act_change_pict/" method="post">
										<label for="ImageBrowse" style="width:100px;margin:0;cursor:pointer;">
											
											
											<?php 
												if(($pict == null or $pict == '') and substr($pict,0,4) != 'http'){
											?>
												<img src="<?php echo base_url();?>assets/img/profile-image-2.png" style="width:90px;height:90px;opacity:0.8;border:3px solid #fff;border-radius:100%;"/>
											<?php
												}else if(substr($pict,0,4) == 'http'){
											?>
											    <img src="<?php echo $pict;?>" style="width:90px;height:90px;opacity:0.8;border:3px solid #fff;border-radius:100%;"/>
											<?php
												}else{
											?>
												<img src="<?php echo base_url();?>uploads/user/thumb/<?php echo $pict;?>" style="width:90px;height:90px;opacity:0.8;border:3px solid #fff;border-radius:100%;"/>
											<?php
												}
											?>
										
											<i class="fa fa-camera" style="background:#fff;padding:5px;color:#666;border-radius:100%;opacity:0.7;position:absolute;margin-top:60px;margin-left:-30px;"></i>
										</label>
										<input id="ImageBrowse" type="file" name="pict" style="display: none;"/>
										<input type="submit" name="upload" value="Upload" style="display:none;"/>
									</form>
								</div>
								<div>
									<?php echo $this->session->flashdata('change_result')?>
									<?php echo $error;?>
								</div>
								
								<div style="text-align:center;">
									<div style="text-align:left;">
										<label>Nama : </label>
										<input type="text" name="name" value="<?php echo $name;?>"  id="name-profile"/>
									</div>
									<div style="text-align:left;">
										<label style="text-align:left;">Email : </label>
										<input type="text" name="name" value="<?php echo $email;?>"  id="email-profile"/>
									</div>
									<div style="text-align:left;">
										<label style="text-align:left;">Website : </label>
										<input type="text" name="name" value="<?php echo $website;?>"  id="website-profile"/>
									</div>
								</div>
								<div style="margin-top:30px;">
									<a id="change-prof" style="color:#fff;background:#FD8E23;padding:10px;margin-top:50px;">Ubah</a>
									<div class="loading-prof"><i class="fa fa-spinner fa-spin"></i> Loading . . .</div>
									<div id="notif-prof"></div>
								</div>
							</div>
							<!-- End grid box -->

						</div>
						<!-- End block content -->

					</div>

					<div class="col-xs-12 col-sm-9 col-md-9">

						<!-- block content -->
						<div class="block-content">

							<!-- grid box -->
							<div class="grid-box">
								<div class="title-section">
									<h1><span>Ubah Password</span></h1>
								</div>
								<div style="text-align:center;">
									<div style="text-align:left;">
										<label>Username : </label>
										<input type="text" id="username-change" value="<?php echo $username;?>" id="name-profile"/>
									</div>
									<div style="text-align:left;">
										<label style="text-align:left;">Password : </label>
										<input type="password" class="form-input" id="password-change" value="<?php echo $password;?>" id="gender-profile"/>
									</div>
									<div style="text-align:left;">
										<label style="text-align:left;">Password Baru : </label>
										<input type="password" class="form-input" id="new-change" id="email-profile"/>
									</div>
									<div style="text-align:left;">
										<label style="text-align:left;">Konfirmasi Password Baru : </label>
										<input type="password" class="form-input" id="conf-change" id="website-profile"/>
									</div>
								</div>
								<div style="margin-top:30px;">
									<a id="change-password" style="color:#fff;background:#FD8E23;padding:10px;margin-top:50px;">Ubah</a>
									<div class="loading-password"><i class="fa fa-spinner fa-spin"></i> Loading . . .</div>
									<div id="notif-password"></div>
								</div>
							</div>
							<!-- End grid box -->

						</div>
						<!-- End block content -->

					</div>
				</div>

			</div>
		</section>
		<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();   
				
				$("#notif").click(function(){
					$("#notif").fadeOut();
				});
				
				$("#notif1").click(function(){
					$("#notif1").fadeOut();
				});
			});
		
			$("#ImageBrowse").on("change", function() {
				$("#imageUploadForm").submit();
			});
		</script>
		<!-- End block-wrapper-section -->