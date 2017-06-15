<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Contact Settings</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<?php echo $error;?>
					<form enctype="multipart/form-data" action="<?php echo base_url();?>index.php/back/contact/edit/" method="post">
					<div class="row">
						<div class="col m12">
							<div class="row">
								<div class="col m12 s12">
									<label for="kanalName">Company Name</label>
									<div class="validation-notif"><?php echo (form_error('name') == '' or form_error('name') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('name'); ?></div>
									<input id="name" name="name" type="text" class="required validate" value="<?php echo $name;?>" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="kanalName">Phone 1</label>
									<div class="validation-notif"><?php echo (form_error('telp1') == '' or form_error('telp1') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('telp1'); ?></div>
									<input id="telp1" name="telp1" type="text" class="required validate" value="<?php echo $telp1;?>" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="kanalName">Phone 2</label>
									<div class="validation-notif"><?php echo (form_error('telp2') == '' or form_error('telp2') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('telp2'); ?></div>
									<input id="telp2" name="telp2" type="text" class="required validate" value="<?php echo $telp2;?>" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="kanalName">Phone 3</label>
									<div class="validation-notif"><?php echo (form_error('telp3') == '' or form_error('telp3') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('telp3'); ?></div>
									<input id="telp3" name="telp3" type="text" class="required validate" value="<?php echo $telp3;?>" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="kanalName">Fax</label>
									<div class="validation-notif"><?php echo (form_error('fax') == '' or form_error('fax') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('fax'); ?></div>
									<input id="fax" name="fax" type="text" class="required validate" value="<?php echo $fax;?>" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="kanalName">Email</label>
									<div class="validation-notif"><?php echo (form_error('email') == '' or form_error('email') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('email'); ?></div>
									<input id="email" name="email" type="text" class="required validate" value="<?php echo $email;?>" aria-required="true">
								</div>
								<div class="col s12">
									<label for="descKanal">Address</label>
									<textarea name="address" id="desc"> <?php echo $address;?></textarea>
								</div>
								
								<span class="card-title">Social Media</span>
								<div class="col m12 s12">
									<label for="kanalName">Facebook</label>
									<div class="validation-notif"><?php echo (form_error('facebook') == '' or form_error('facebook') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('facebook'); ?></div>
									<input id="title" name="title" type="text" class="required validate" value="<?php echo $facebook;?>" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="kanalName">Twitter</label>
									<div class="validation-notif"><?php echo (form_error('twitter') == '' or form_error('twitter') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('twitter'); ?></div>
									<input id="twitter" name="twitter" type="text" class="required validate" value="<?php echo $twitter;?>" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="kanalName">Google +</label>
									<div class="validation-notif"><?php echo (form_error('google') == '' or form_error('google') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('google'); ?></div>
									<input id="google" name="google" type="text" class="required validate" value="<?php echo $google;?>" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="kanalName">Instagram</label>
									<div class="validation-notif"><?php echo (form_error('instagram') == '' or form_error('instagram') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('instagram'); ?></div>
									<input id="instagram" name="instagram" type="text" class="required validate" value="<?php echo $instagram;?>" aria-required="true">
								</div>
								<div class="col m12 s12">
									<label for="kanalName">Youtube</label>
									<div class="validation-notif"><?php echo (form_error('youtube') == '' or form_error('youtube') == null) == true ? '':'<i class="material-icons" style="float:left;">info_outline</i>' . form_error('youtube'); ?></div>
									<input id="youtube" name="youtube" type="text" class="required validate" value="<?php echo $youtube;?>" aria-required="true">
								</div>
								
								<div class="col s12">
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/dashboard/">Back</a>
									<button type="submit" class="waves-effect waves-light btn teal">Save</button>
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close();?>
					<?php echo $this->session->flashdata('contact_result')?>
				</div>
			</div>
		</div>
	</div>
</div>