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
					<form enctype="multipart/form-data" action="<?php echo base_url();?>index.php/back/Kanal_Side/edit/<?php echo $this->uri->segment(4);?>" method="post">
					<div class="row">
						<div class="col m12">
							<div class="row">
								<div class="col m12 s12">
									<label for="kanalName">Kanal Name</label>
									<input id="kanalName" name="name" type="text" class="required validate" value="<?php echo $name;?>" aria-required="true">
								</div>
								<div class="col s12">
									<label for="descKanal">Description</label>
									<textarea name="desc"> <?php echo $desc;?></textarea>
								</div>
								<div class="col m6 s12">
									<label for="backGround">Background-color</label>
									<input id="backGround" name="background" type="text" class="required validate"  value="<?php echo $background;?>" aria-required="true">
								</div>
								<div class="col m6 s12" style="margin-top:30px;">
									<div>
										<?php 
											if($logo == '' or $logo == null){
												echo "<div style='margin-bottom:10px;width:300px;background-color:#aaa;height:50px;'></div>";
											}else{
												echo "<img style='margin-bottom:10px;' src='".base_url()."uploads/kanal/thumb/".$logo."' />";
											}
										?>
									</div>
									<label for="logoPict">Logo Picture : </label>
									<input id="logoPict" name="logo" type="file" class="required validate" aria-required="true">
								</div>
								<div class="col s12">
									<label for="logoPict">Status : </label>
									<div class="switch m-b-md">
										<label>
											<input type="checkbox" name="status" value="1" <?php echo $status == '1'?'checked':'';?>>
											<span class="lever"></span>
											Active
										</label>
									</div>
								</div>
								<div class="col s12">
									<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/kanal_side/">Back</a>
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