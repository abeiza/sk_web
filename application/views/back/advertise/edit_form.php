<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Edit Form</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<?php echo $error;?>
					<form enctype="multipart/form-data" action="<?php echo base_url();?>index.php/back/advertisement/edit/<?php echo $this->uri->segment(4);?>" method="post">
					<div class="row">
						<div class="col m12">
							<div class="row">
								<div class="col m12 s12">
									<label for="title">Advertisement Title</label>
									<div class="validation-notif"><?php echo (form_error('title') == '' or form_error('title') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('title'); ?></div>
									
									<input id="title" name="title" type="text" class="required validate" aria-required="true" value="<?php echo $title;?>">
								</div>
								<div class="col s12">
									<label for="short">Short Description</label>
									<div class="validation-notif"><?php echo (form_error('short') == '' or form_error('short') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('short'); ?></div>
									
									<textarea for="short" name="short" style="height:150px;"><?php echo $short;?></textarea>
								</div>
								<div class="col s12" style="margin-top:30px;margin-bottom:10px;">
									<?php 
										if($pict2 == '' or $pict2 == null){
											
											echo "<div style='height:50px;width:100%;background:#aaa;'></div>";
											
										}else{
											
											echo "<div style='width:100%;background-color:#f9f9f9;text-align:center;padding-top:10px;'><img src='".base_url()."uploads/advertise/original/".$pict2."' /></div>";
											
										}
									?>
									<label for="pict">Pict : </label>
									<div class="validation-notif"><?php echo (form_error('pict') == '' or form_error('pict') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('pict'); ?></div>
									
									<input id="pict" name="pict" type="file" class="required validate" aria-required="true" value="<?php echo $pict;?>">
								</div>
								<div class="col m12 s12">
									<label for="link">Advertisement Link</label>
									
									<input id="link" name="link" type="text" class="required validate" aria-required="true" value="<?php echo $link;?>">
								</div>
								<div class="col s12">
									<label for="desc">Description</label>
									<textarea name="desc" id="desc"><?php echo $desc;?></textarea>
								</div>
								<div class="col s12 m6'">
									<div class="col s12 m6">
										<label for="kanal">Kanal</label>
										<div class="validation-notif"><?php echo (form_error('kanal') == '' or form_error('kanal') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('kanal'); ?></div>
										
										<select name="kanal" id="kanal">
											<?php 
												if($kanal->num_rows() == 0){
													echo "<option value='' disabled selected> Select Kanal </option>";
												}else{
													echo "<option value='' disabled selected> Select Kanal </option>";
											?>
													<option value='home' <?php echo $kanal1 == 'home'?'selected':'';?>>Home</option>";
											<?php
													foreach($kanal->result() as $knl){
											?>
											<option value='<?php echo $knl->kanal_id; ?>' <?php echo $kanal1 == $knl->kanal_id?'selected':'';?>><?php echo $knl->kanal_name; ?></option>
											<?php
													}
												}
											?>
										</select>
									</div>
									<div class="col s12 m6">
										<label for="tag">Adv Position</label>
										<div class="validation-notif"><?php echo (form_error('position') == '' or form_error('position') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('position'); ?></div>
										
										<select name="position" id="position">
											<?php 
												if($position->num_rows() == 0){
													echo "<option value='' disabled selected> Select Position </option>";
												}else{
													echo "<option value='' disabled selected> Select Position </option>";
													foreach($position->result() as $pst){
											?>
											<option value='<?php echo $pst->position_id; ?>' <?php echo $position1 == $pst->position_id?'selected':'';?>><?php echo $pst->position_name;?></option>
											<?php
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col s3">
									<label for="status">Status : </label>
									<select name="status" id="status">
										<option value="0" <?php echo $status == '0'?'selected':'';?>>Draft</option>
										<option value="1" <?php echo $status == '1'?'selected':'';?>>Publish</option>
										<option value="2" <?php echo $status == '2'?'selected':'';?>>Spam</option>
									</select>
								</div>
								<div class="col s12">
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/advertisement/">Back</a>
									<button type="submit" class="waves-effect waves-light btn teal">Save</button>
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close();?>
					<?php echo $this->session->flashdata('adv_result')?>
				</div>
			</div>
		</div>
	</div>
</div>