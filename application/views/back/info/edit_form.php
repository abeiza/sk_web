<script src="<?php echo base_url();?>assets/js/front/jquery.min.js"></script>
<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>General Settings</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<?php echo $error;?>
					<form enctype="multipart/form-data" action="<?php echo base_url();?>index.php/back/general/edit/" method="post">
					<div class="row">
						<div class="col m12">
							<div class="row">
								<div class="col m12 s12">
									<label for="kanalName">Web Title</label>
									<div class="validation-notif"><?php echo (form_error('title') == '' or form_error('title') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('title'); ?></div>
									<input id="title" name="title" type="text" class="required validate" value="<?php echo $title;?>" aria-required="true">
								</div>
								<div class="col s12">
									<label for="descKanal">Tagline</label>
									<textarea name="tagline" id="desc"> <?php echo $tagline;?></textarea>
								</div>
								<div class="col s6" style="margin-top:20px;">
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/dashboard/">Back</a>
									<button type="submit" class="waves-effect waves-light btn teal">Save</button>
								</div>
								<?php echo form_close();?>
								
								
								
								
								
								
								
								
								
								
								
								
								
								<div class="col s6" style="margin-top:30px;">
								<form name="photo" style="text-align:center;display:inline-block" id="imageUploadForm" enctype="multipart/form-data" action="<?php echo base_url();?>index.php/back/general/act_change_pict/" method="post">
									<label>Logo Website: </label>
									<label for="ImageBrowse" style="width:100px;margin:0;cursor:pointer;">
												
										<?php 
											if($light == null or $light == ''){
										?>
											<img src="<?php echo base_url();?>assets/img/profile-image-2.png" style="opacity:0.8;width:150px"/>
										<?php
											}else{
										?>
											<img src="<?php echo base_url();?>uploads/info/<?php echo $light;?>" style="opacity:0.8;width:150px"/>
										<?php
											}
										?>
									
										<i style="background: #f9f9f9;padding: 5px;border-radius: 100%;opacity: 0.5;margin-left: -30px;margin-top: 20px;" class="material-icons">camera</i>
									</label>
									<input id="ImageBrowse" type="file" name="pict" style="display: none;"/>
									<input type="submit" name="upload" value="Upload" style="display:none;"/>
								</form>
								</div>
							</div>
						</div>
					</div>
					<?php echo $this->session->flashdata('info_result')?>
					<?php echo $error;?>
					<script>
					$(function(){
						$("#ImageBrowse").on("change", function() {
							$("#imageUploadForm").submit();
						});
					});
					</script>
				</div>
			</div>
		</div>
	</div>
</div>