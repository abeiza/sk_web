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
					<form enctype="multipart/form-data" action="<?php echo base_url();?>index.php/back/video/edit/<?php echo $this->uri->segment(4);?>" method="post">
					<div class="row">
						<div class="col m12">
							<div class="row">
								<div class="col m12 s12">
									<label for="title">Title</label>
									<div class="validation-notif"><?php echo (form_error('title') == '' or form_error('title') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('title'); ?></div>
									<input id="title" name="title" type="text" class="required validate" aria-required="true" value="<?php echo $title;?>">
								</div>
								<div class="col m12 s12">
									<label for="title">Link Video</label>
									<div class="validation-notif"><?php echo (form_error('link') == '' or form_error('link') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('link'); ?></div>
									<input id="link" name="link" type="text" class="required validate" aria-required="true" value="<?php echo $link;?>">
								</div>
								<div class="col s12">
									<label for="short">Short Description</label>
									<div class="validation-notif"><?php echo (form_error('short') == '' or form_error('short') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('short'); ?></div>
									<textarea for="short" name="short"  style="padding:12px;height:150px;"><?php echo $short?></textarea>
								</div>
								<div class="col s12 m6'">
									<div class="col s12 m6">
										<label for="category">Kanal - Category</label>
										<div class="validation-notif"><?php echo (form_error('category') == '' or form_error('category') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('category'); ?></div>
										<select name="category" id="category">
											<?php 
												if($category->num_rows() == 0){
													echo "<option value='' disabled selected> Select Kanal - Category </option>";
												}else{
													echo "<option value='' disabled selected> Select Kanal - Category </option>";
													foreach($category->result() as $ctg){
											?>
													<option value='<?php echo $ctg->category_id; ?>' <?php echo $cat == $ctg->category_id?'selected':'';?>><?php echo $ctg->kanal_name." - ".$ctg->category_name ;?></option>
											<?php
													}
												}
											?>
										</select>
									</div>
									<div class="col s12 m6">
										<label for="tag">Tag Focus</label>
										<div class="validation-notif"><?php echo (form_error('tag') == '' or form_error('tag') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('tag'); ?></div>
										
										<select name="tag" id="tag">
											<?php 
												if($tag2->num_rows() == 0){
													echo "<option value='' disabled selected> Select Tag </option>";
												}else{
													echo "<option value='' disabled selected> Select Tag </option>";
													foreach($tag2->result() as $teg){
											?>
												<option value='<?php echo $teg->tag_id; ?>' <?php echo $tag == $teg->tag_id?'selected':'';?>><?php echo $teg->tag_name;?></option>
											
											<?php		}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col s12">
									<label for="desc">Full Description</label>
									<textarea for="desc" name="desc" id="desc"><?php echo $desc;?></textarea>
								</div>
								<div class="col s12">
									<label for="key">Keywords</label>
									<textarea for="key" name="key"><?php echo $key;?></textarea>
								</div>
								<div class="col s3">
									<label for="status">Status : </label>
									<select name="status" id="status">
										<option value="0" <?php echo $status =='0'?'selected':'';?>>Draft</option>
										<option value="1" <?php echo $status =='1'?'selected':'';?>>Publish</option>
										<option value="2" <?php echo $status =='2'?'selected':'';?>>Spam</option>
									</select>
								</div>
								<div class="col s12">
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/video/">Back</a>
									<button type="submit" class="waves-effect waves-light btn teal">Save</button>
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close();?>
					<?php echo $this->session->flashdata('video_result')?>
				</div>
			</div>
		</div>
	</div>
</div>