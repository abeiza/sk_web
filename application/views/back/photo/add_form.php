<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Add Form</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<?php echo $error;?>
					<form enctype="multipart/form-data" action="<?php echo base_url();?>index.php/back/photo/add/" method="post">
					<div class="row">
						<div class="col m12">
							<div class="row">
								<div class="col m12 s12">
									<label for="title">Title</label>
									<div class="validation-notif"><?php echo (form_error('title') == '' or form_error('title') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('title'); ?></div>
									
									<input id="title" name="title" type="text" class="required validate" aria-required="true">
								</div>
								<div class="col s12">
									<label for="short">Short Description</label>
									<div class="validation-notif"><?php echo (form_error('short') == '' or form_error('short') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('short'); ?></div>
									
									<textarea for="short" name="short" style="height:150px;"></textarea>
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
														echo "<option value='".$ctg->category_id."'>".$ctg->kanal_name." - ".$ctg->category_name."</option>";
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
												if($tag->num_rows() == 0){
													echo "<option value='' disabled selected> Select Tag </option>";
												}else{
													echo "<option value='' disabled selected> Select Tag </option>";
													foreach($tag->result() as $tag){
														echo "<option value='".$tag->tag_id."'>".$tag->tag_name."</option>";
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col s12">
									<label for="desc">Full Description</label>
									<div class="validation-notif"><?php echo (form_error('desc') == '' or form_error('desc') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('desc'); ?></div>
									
									<textarea for="desc" name="desc" id="desc"></textarea>
								</div>
								<div class="col s12">
									<label for="key">Keywords</label>
									<textarea for="key" name="key"></textarea>
								</div>
								<div class="col s3">
									<label for="status">Status : </label>
									<select name="status" id="status">
										<option value="0">Draft</option>
										<option value="1">Publish</option>
										<option value="2">Spam</option>
									</select>
								</div>
								<div class="col s12">
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/photo/">Back</a>
									<button type="submit" class="waves-effect waves-light btn teal">Save</button>
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>