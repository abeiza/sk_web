<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Add Form</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<form action="<?php echo base_url();?>index.php/back/page/add/" method="post">
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
								<div class="col s12">
									<label for="desc">Full Description</label>
									<div class="validation-notif"><?php echo (form_error('desc') == '' or form_error('desc') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('desc'); ?></div>
									
									<textarea for="desc" name="desc" id="desc"></textarea>
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
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/page/">Back</a>
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