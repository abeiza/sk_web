<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Edit Images</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<?php echo $error;?>
					<form enctype="multipart/form-data" action="<?php echo base_url();?>index.php/back/photo/edit_detail_photo/<?php echo $this->uri->segment(4);?>/<?php echo $this->uri->segment(5);?>" method="post">
					<div class="row">
						<div class="col m12">
							<div class="row">
								<div class="col m6 s12" style="margin-top:30px;margin-bottom:10px;width:100%;">
									<?php 
										if($pict2 == '' or $pict2 == null){
											
											echo "<div style='height:50px;width:100%;background:#aaa;'></div>";
											
										}else{
											
											echo "<div style='margin-bottom:10px;width:100%;background-color:#f9f9f9;text-align:center;'><img src='".base_url()."uploads/pict/original/".$pict2."' /></div>";
											
										}
									?>
									<label for="pict">Pict : </label>
									<div class="validation-notif"><?php echo (form_error('pict') == '' or form_error('pict') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('pict'); ?></div>
									
									<input id="pict" name="pict" type="file" class="required validate" aria-required="true">
								</div>
								<div class="col s12">
									<label for="short">Short Description</label>
									<div class="validation-notif"><?php echo (form_error('short') == '' or form_error('short') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('short'); ?></div>
									<textarea for="short" name="short"  style="padding:12px;height:150px;"><?php echo $short?></textarea>
								</div>
								<div class="col s12">
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/photo/list_image/<?php echo $this->uri->segment(4);?>">Back</a>
									<button type="submit" class="waves-effect waves-light btn teal">Save</button>
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close();?>
					<?php echo $this->session->flashdata('photo_result')?>
				</div>
			</div>
		</div>
	</div>
</div>