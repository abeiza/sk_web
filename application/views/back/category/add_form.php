<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Add Form</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<form action="<?php echo base_url();?>index.php/back/category/add/" method="post">
					<div class="row">
						<div class="col m12">
							<div class="row">
								<div class="col m12 s12">
									<label for="categorylName">Category Name</label>
									<div class="validation-notif"><?php echo (form_error('name') == '' or form_error('name') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('name'); ?></div>
									
									<input id="categorylName" name="name" type="text" class="required validate" aria-required="true">
								</div>
								<div class="col s12">
									<label for="categoryDesc">Category Desc</label>
									<textarea id="categoryDesc" name="desc"></textarea>
								</div>
								<div class="col s12">
									<label for="kanal">Kanal</label>
									<div class="validation-notif"><?php echo (form_error('kanal') == '' or form_error('kanal') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('kanal'); ?></div>
									
									<select for="kanal" name="kanal">
										<?php 
											if($get_kanal->num_rows() == 0){
												echo "<option value='' selected disabled> Select Kanal </option>";
											}else{
												echo "<option value='' selected disabled> Select Kanal </option>";
												foreach($get_kanal->result() as $ctg){
													echo "<option value='".$ctg->kanal_id."'>".$ctg->kanal_name."</option>";
												}
											}
										?>
									</select>
								</div>
								<div class="col s12">
									<label for="logoPict">Status : </label>
									<div class="switch m-b-md">
										<label>
											<input type="checkbox" name="status" value="1">
											<span class="lever"></span>
											Active
										</label>
									</div>
								</div>
								<div class="col s12">
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/category/">Back</a>
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