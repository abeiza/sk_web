<style>
	#toast-container{
		display:none !important;
	}
</style>
<div class="mn-content valign-wrapper" style="background-color:#ffb618 !important">
	<main class="mn-inner container">
		<div class="valign">
			<div class="row">
				  <div class="col s12 m6 l4 offset-l4 offset-m3">
					  <div class="card white darken-1">
						  <div class="card-content ">
							  <span class="card-title">Sign In</span>
							   <div class="row">   
							   <?php echo form_open('back/login/login_act/');?>
									<div class="col s12">
									   <div class="input-field col s12">
									   <div style="color:#ff8f00 !important;font-size:12px;"><?php echo form_error('username'); ?></div>
										   <input id="username" name="username" type="text" class="validate">
										   <label for="username">Username</label>
									   </div>
									   <div class="input-field col s12">
									   <div style="color:#ff8f00 !important;font-size:12px;"><?php echo form_error('password'); ?></div>
										   <input id="password" name="password" type="password" class="validate">
										   <label for="password">Password</label>
									   </div>
									   <div class="col s12 right-align m-t-sm">
										   <button type="submit" class="waves-effect waves-light btn teal">sign in</button>
									   </div>
								   </div>
							  <?php echo form_close();?>
							  <?php echo $this->session->flashdata('login_result')?>
							  </div>
						  </div>
					  </div>
				  </div>
			</div>
		</div>
	</main>
</div>