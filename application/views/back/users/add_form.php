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
					<form enctype="multipart/form-data" action="<?php echo base_url();?>index.php/back/users/add/" method="post">
					<div class="row">
						<div class="col m12">
							<div class="row">
								<div class="col m12 s12">
									<label for="name">Full Name</label>
									<div class="validation-notif"><?php echo (form_error('name') == '' or form_error('name') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('name'); ?></div>
									
									<input id="name" name="name" type="text" class="required validate" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="name">Username</label>
									<div class="validation-notif"><?php echo (form_error('username') == '' or form_error('username') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('username'); ?></div>
									
									<input id="username" name="username" type="text" class="required validate" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="name">Password</label>
									<div class="validation-notif"><?php echo (form_error('password') == '' or form_error('password') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('password'); ?></div>
									
									<input id="password" name="password" type="password" class="required validate" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="name">Confirm Password</label>
									<div class="validation-notif"><?php echo (form_error('conf') == '' or form_error('conf') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('conf'); ?></div>
									
									<input id="conf" name="conf" type="password" class="required validate" aria-required="true">
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
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/users/">Back</a>
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