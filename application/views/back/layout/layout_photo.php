<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Layout - Photo</h5>
				<div class="row">
					<div class="col s5">
						<label for="kanal">Choose Layout : </label>
						<select for="kanal" name="layout" id="layout-id">
							<option value="" disabled selected>Layout Data</option>
							<option value="home" <?php echo $this->uri->segment(4) == 'home'?'selected':'';?>>Home</option>
							<option value="single-news" <?php echo $this->uri->segment(4) == 'single-news'?'selected':'';?>>Single - News</option>
							<option value="video" <?php echo $this->uri->segment(4) == 'video'?'selected':'';?>>Video</option>
							<option value="single-video" <?php echo $this->uri->segment(4) == 'single-video'?'selected':'';?>>Single - Video</option>
							<option value="photo" <?php echo $this->uri->segment(4) == 'photo'?'selected':'';?>>Photo</option>
							<option value="single-photo" <?php echo $this->uri->segment(4) == 'single-photo'?'selected':'';?>>Single - Photo</option>
						</select>
					</div>
					<div class="col s5">
						<label for="kanal">Choose Kanal : </label>
						<select for="kanal" name="kanal" id="kanal-id">
							<?php 
								if($get_kanal->num_rows() == 0){
									echo "<option value='' selected disabled> Kanal Data </option>";
								}else{
									echo "<option value='' selected disabled> Kanal Data </option>";
									echo "<option value='home' id='home'";
									echo ($this->uri->segment(5) == '' or $this->uri->segment(5) == null or $this->uri->segment(5) == 'home') == true?'selected ">Home</option>"':'">Home</option>"';
									foreach($get_kanal->result() as $ctg){
										echo "<option value='".$ctg->kanal_id."' id=".$ctg->kanal_name."";
										echo $this->uri->segment(5) == $ctg->kanal_id ? " selected>".$ctg->kanal_name."</option>":">".$ctg->kanal_name."</option>";
									}
								}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content" style="width:100%;height:2135px;float:left;background-color:#fff;">
					<span class="card-title">Kanal : <span id="kanal-name"><i><?php if($this->uri->segment(5) == '' or $this->uri->segment(5) == 'home' or $this->uri->segment(5) == null){echo 'Home';}else{foreach($get_kanal->result() as $ctg1){ echo $ctg1->kanal_id == $this->uri->segment(5)?$ctg1->kanal_name:'';}}?></i></span></span>
					<div style="width:100%;background-color:#f1f1f1;height:35px;float:left;"></div>
					
					<div style="width:12.5%;float:left;height:600px;">
						<div style="width:100%;height:100%;float:left;display:flex;margin:auto;"></div>
					</div>
					
					
					<div style="width:75%;float:left;height:450px;">
						<div style="width:100%;float:left;height:80px;">
							<div style="width:20%;background-color:#f1f1f1;height:100%;float:left;"></div>
							<div style="width:80%;float:left;height:100%;">
								<?php if($get_top_img == ''){?>
									<div id="lbl-top" style="border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;"><span style="height:40px;margin:auto;font-size:12px;text-align:center"><strong style="color:#000">(Top Banner)</strong><br/>Click to Choose Banner<br/><strong id="get-top-side"></strong></span></div>
								<?php }else{?>
									<div id="lbl-top" style="background-position-x: center;background-position-y: center;background-size:contain;background-repeat:no-repeat;background-color:rgba(255,255,255,0.1);background-image:url('<?php echo base_url().'uploads/advertise/original/'.$get_top_img;?>');border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;">
										<div style="width:100%;height:100%;background-color:rgba(0,0,0,0.5);float:left;display:flex;margin:auto;">
											<span style="height:40px;margin:auto;font-size:12px;color:#fff;text-align:center"><strong style="color:#fff">(Top Banner)</strong><br/>Click to Choose Banner<br/><strong id="get-top-side"></strong></span>
										</div>
									</div>
								<?php }?>
								<input type="hidden" id="top-banner"/>
							</div>
						</div>
						
						<div style="width:100%;float:left;height:70px;">
							<div style="width:100%;background-color:#f1f1f1;height:100%;float:left;"></div>
						</div>
						
						<div style="width:100%;float:left;height:70px;">
							<div id="lbl-main" style="border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;"><span style="height:40px;margin:auto;font-size:12px;text-align:center"><strong style="color:#000">(Main Banner)</strong><br/>Click to Choose Banner<br/><strong id="get-main-side"></strong></span></div>
							<input type="hidden" id="main-banner"/>
						</div>
						
						<div style="width:100%;float:left;height:200px;">
							<div style="width:75%;height:100%;float:left;">
								<div style="width:100%;background-color:#f1f1f1;height:300px;float:left;"></div>
								
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								
								
								<div style="width:100%;float:left;height:80px;">
								<?php if($get_horizontal1_img == ''){?>
									<div id="lbl-horizontal1" style="border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;"><span style="height:50px;margin: auto;font-size:12px;text-align:center"><strong style="color:#000">(Horizontal Banner 1)</strong><br/>Click to Choose Banner<br/><strong id="get-horizontal1-side"></strong></span></div>
								<?php }else{?>
									<div id="lbl-horizontal1" style="background-position-x: center;background-position-y: center;background-size:contain;background-repeat:no-repeat;background-color:rgba(255,255,255,0.1);background-image:url('<?php echo base_url().'uploads/advertise/original/'.$get_horizontal1_img;?>');border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;">
										<div style="width:100%;height:100%;background-color:rgba(0,0,0,0.5);float:left;display:flex;margin:auto;">
											<span style="height:50px;margin: auto;font-size:12px;text-align:center;color:#fff;"><strong style="color:#fff">(Horizontal Banner 1)</strong><br/>Click to Choose Banner<br/><strong id="get-horizontal1-side"></strong></span>
										</div>
									</div>
								<?php }?>
									<input type="hidden" id="horizontal1-banner"/>
								</div>
								
								
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								
								
								<div style="width:100%;float:left;height:80px;">
								<?php if($get_horizontal2_img == ''){?>
									<div id="lbl-horizontal2" style="border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;"><span style="height:50px;margin: auto;font-size:12px;text-align:center"><strong style="color:#000">(Horizontal Banner 2)</strong><br/>Click to Choose Banner<br/><strong id="get-horizontal2-side"></strong></span></div>
								<?php }else{?>
									<div id="lbl-horizontal2" style="background-position-x: center;background-position-y: center;background-size:contain;background-repeat:no-repeat;background-color:rgba(255,255,255,0.1);background-image:url('<?php echo base_url().'uploads/advertise/original/'.$get_horizontal2_img;?>');border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;">
										<div style="width:100%;height:100%;background-color:rgba(0,0,0,0.5);float:left;display:flex;margin:auto;">
											<span style="height:50px;margin: auto;font-size:12px;text-align:center;color:#fff;"><strong style="color:#fff">(Horizontal Banner 2)</strong><br/>Click to Choose Banner<br/><strong id="get-horizontal2-side"></strong></span>
										</div>
									</div>
								<?php }?>
									<input type="hidden" id="horizontal2-banner"/>
								</div>
								
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								<div style="width:25%;float:left;">
									<div style="margin:2%;width:96%;background-color:#f1f1f1;height:80px;float:left;"></div>
								</div>
								
								<div style="width:100%;float:left;height:500px;">
									<?php if($get_mobile_img == ''){?>
										<div id="lbl-mobile" style="border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;"><span style="height:50px;margin: auto;font-size:12px;text-align:center"><strong style="color:#000">(Mobile Banner)</strong><br/>Click to Choose Banner<br/><strong id="get-pop-side"></strong></span></div>
									<?php }else{?>
										<div id="lbl-mobile" style="background-position-x: center;background-position-y: center;background-size:contain;background-repeat:no-repeat;background-color:rgba(255,255,255,0.1);background-image:url('<?php echo base_url().'uploads/advertise/original/'.$get_mobile_img;?>');border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;">
											<div style="width:100%;height:100%;background-color:rgba(0,0,0,0.5);float:left;display:flex;margin:auto;">
												<span style="height:50px;margin: auto;font-size:12px;text-align:center;color:#fff"><strong style="color:#fff">(Mobile Banner)</strong><br/>Click to Choose Banner<br/><strong id="get-pop-side"></strong></span>
											</div>
										</div>
									<?php }?>
									<input type="hidden" id="mobile-banner"/>
								</div>
							</div>
							<div style="width:25%;height:100%;float:left;">
								<div style="width:100%;float:left;height:200px;">
									<?php if($get_cright1_img == ''){?>
										<div id="lbl-cright1" style="border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;"><span style="height:20px;margin:auto;font-size:12px;text-align:center"><strong style="color:#000">(Right Content Banner 1)</strong><br/>Click to Choose Banner<br/><strong id="get-cright1-side"></strong></span></div>
									<?php }else{?>
										<div id="lbl-cright1" style="background-position-x: center;background-position-y: center;background-size:contain;background-repeat:no-repeat;background-color:rgba(255,255,255,0.1);background-image:url('<?php echo base_url().'uploads/advertise/original/'.$get_cright1_img;?>');border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;">
												<div style="width:100%;height:100%;background-color:rgba(0,0,0,0.5);float:left;display:flex;margin:auto;">	
													<span style="height:20px;margin:auto;font-size:12px;text-align:center;color:#fff;"><strong style="color:#fff">(Right Content Banner 1)</strong><br/>Click to Choose Banner<br/><strong id="get-cright1-side"></strong></span>
												</div>
										</div>
									<?php }?>
									<input type="hidden" id="cright1-banner"/>
								</div>
								<div style="width:100%;float:left;height:200px;">
									<?php if($get_cright2_img == ''){?>
										<div id="lbl-cright2" style="border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;"><span style="height:20px;margin:auto;font-size:12px;text-align:center"><strong style="color:#000">(Right Content Banner 2)</strong><br/>Click to Choose Banner<br/><strong id="get-cright2-side"></strong></span></div>
									<?php }else{?>
										<div id="lbl-cright2" style="background-position-x: center;background-position-y: center;background-size:contain;background-repeat:no-repeat;background-color:rgba(255,255,255,0.1);background-image:url('<?php echo base_url().'uploads/advertise/original/'.$get_cright2_img;?>');border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;">
												<div style="width:100%;height:100%;background-color:rgba(0,0,0,0.5);float:left;display:flex;margin:auto;">	
													<span style="height:20px;margin:auto;font-size:12px;text-align:center;color:#fff;"><strong style="color:#fff">(Right Content Banner 2)</strong><br/>Click to Choose Banner<br/><strong id="get-cright2-side"></strong></span>
												</div>
										</div>	
									<?php }?>
									<input type="hidden" id="cright2-banner"/>
								</div>
								<div style="width:100%;float:left;height:200px;">
									<?php if($get_cright3_img == ''){?>
										<div id="lbl-cright3" style="border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;"><span style="height:20px;margin:auto;font-size:12px;text-align:center"><strong style="color:#000">(Right Content Banner 3)</strong><br/>Click to Choose Banner<br/><strong id="get-cright3-side"></strong></span></div>
									<?php }else{?>
										<div id="lbl-cright3" style="background-position-x: center;background-position-y: center;background-size:contain;background-repeat:no-repeat;background-color:rgba(255,255,255,0.1);background-image:url('<?php echo base_url().'uploads/advertise/original/'.$get_cright3_img;?>');border:1px dotted #f1f1f1;width:100%;height:100%;float:left;display:flex;margin:auto;">
												<div style="width:100%;height:100%;background-color:rgba(0,0,0,0.5);float:left;display:flex;margin:auto;">	
													<span style="height:20px;margin:auto;font-size:12px;text-align:center;color:#fff;"><strong style="color:#fff">(Right Content Banner 3)</strong><br/>Click to Choose Banner<br/><strong id="get-cright3-side"></strong></span>
												</div>
										</div>									
									<?php }?>
									<input type="hidden" id="cright3-banner"/>
								</div>
							</div>
						</div>
					</div>
					
					
					<div style="width:12.5%;float:left;height:600px;">
						<div style="width:100%;height:100%;float:left;display:flex;margin:auto;"></div>
					</div>
				
				</div>
			</div>
		</div>
	</div>
</main>
<div style="width:100%;position:fixed;height:100%;top:0;left:0;background-color:rgba(255,255,255,0.1);z-index:9999;" id="bg-pop">
	<div id="left-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<select for="kanal" id="select-left-pop">
			<option value="" disabled selected>Layout Data</option>
			<option value="home" <?php echo $this->uri->segment(4) == 'home'?'selected':'';?>>Home</option>
			<option value="single-news" <?php echo $this->uri->segment(4) == 'single-news'?'selected':'';?>>Single - News</option>
			<option value="video" <?php echo $this->uri->segment(4) == 'video'?'selected':'';?>>Video</option>
			<option value="single-video" <?php echo $this->uri->segment(4) == 'single-video'?'selected':'';?>>Single - Video</option>
			<option value="photo" <?php echo $this->uri->segment(4) == 'photo'?'selected':'';?>>Photo</option>
			<option value="single-photo" <?php echo $this->uri->segment(4) == 'single-photo'?'selected':'';?>>Single - Photo</option>
		</select>
		<a class="waves-effect waves-light btn teal" id="btn-left-pop">Selected</a>
	</div>
	
	<div id="right-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<select for="kanal" id="select-right-pop">
			<option value="" disabled selected>Layout Data</option>
			<option value="home" <?php echo $this->uri->segment(4) == 'home'?'selected':'';?>>Home</option>
			<option value="single-news" <?php echo $this->uri->segment(4) == 'single-news'?'selected':'';?>>Single - News</option>
			<option value="video" <?php echo $this->uri->segment(4) == 'video'?'selected':'';?>>Video</option>
			<option value="single-video" <?php echo $this->uri->segment(4) == 'single-video'?'selected':'';?>>Single - Video</option>
			<option value="photo" <?php echo $this->uri->segment(4) == 'photo'?'selected':'';?>>Photo</option>
			<option value="single-photo" <?php echo $this->uri->segment(4) == 'single-photo'?'selected':'';?>>Single - Photo</option>
		</select>
		<a class="waves-effect waves-light btn teal" id="btn-right-pop">Selected</a>
	</div>
	
	<div id="top-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<?php echo form_open('back/advertisement/set_banner/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
		<select for="kanal" id="select-top-pop" name="selected_id">
			<option value="" disabled selected>Layout Data</option>
			<?php 
				foreach($get_list_top->result() as $top){
			?>
				<option value="<?php echo $top->adv_id;?>" <?php echo $top->adv_id == $get_top?'selected':'';?>><?php echo $top->adv_title;?></option>
			<?php
				}
			?>
			<option value="clear">Clear</option>
		</select>
		<input type="hidden" name="position_id" value='PSB00001'/>
		<button type="submit" class="waves-effect waves-light btn teal" id="btn-top-pop">Selected</button>
		<?php echo form_close();?>
	</div>
	
	<div id="main-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<?php echo form_open('back/advertisement/set_banner/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
		<select for="kanal" id="select-top-pop" name="selected_id">
			<option value="" disabled selected>Layout Data</option>
			<?php 
				foreach($get_list_main->result() as $main){
			?>
				<option value="<?php echo $main->adv_id;?>" <?php echo $main->adv_id == $get_main?'selected':'';?>><?php echo $main->adv_title;?></option>
			<?php
				}
			?>
			<option value="clear">Clear</option>
		</select>
		<input type="hidden" name="position_id" value='PSB00002'/>
		<button type="submit" class="waves-effect waves-light btn teal" id="btn-top-pop">Selected</button>
		<?php echo form_close();?>
	</div>
	
	<div id="cleft1-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<select for="kanal" id="select-cleft1-pop">
			<option value="" disabled selected>Layout Data</option>
			<option value="home" <?php echo $this->uri->segment(4) == 'home'?'selected':'';?>>Home</option>
			<option value="single-news" <?php echo $this->uri->segment(4) == 'single-news'?'selected':'';?>>Single - News</option>
			<option value="video" <?php echo $this->uri->segment(4) == 'video'?'selected':'';?>>Video</option>
			<option value="single-video" <?php echo $this->uri->segment(4) == 'single-video'?'selected':'';?>>Single - Video</option>
			<option value="photo" <?php echo $this->uri->segment(4) == 'photo'?'selected':'';?>>Photo</option>
			<option value="single-photo" <?php echo $this->uri->segment(4) == 'single-photo'?'selected':'';?>>Single - Photo</option>
		</select>
		<a class="waves-effect waves-light btn teal" id="btn-cleft1-pop">Selected</a>
	</div>
	
	<div id="cleft2-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<select for="kanal" id="select-cleft2-pop">
			<option value="" disabled selected>Layout Data</option>
			<option value="home" <?php echo $this->uri->segment(4) == 'home'?'selected':'';?>>Home</option>
			<option value="single-news" <?php echo $this->uri->segment(4) == 'single-news'?'selected':'';?>>Single - News</option>
			<option value="video" <?php echo $this->uri->segment(4) == 'video'?'selected':'';?>>Video</option>
			<option value="single-video" <?php echo $this->uri->segment(4) == 'single-video'?'selected':'';?>>Single - Video</option>
			<option value="photo" <?php echo $this->uri->segment(4) == 'photo'?'selected':'';?>>Photo</option>
			<option value="single-photo" <?php echo $this->uri->segment(4) == 'single-photo'?'selected':'';?>>Single - Photo</option>
		</select>
		<a class="waves-effect waves-light btn teal" id="btn-cleft2-pop">Selected</a>
	</div>
	
	<div id="cleft3-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<select for="kanal" id="select-cleft3-pop">
			<option value="" disabled selected>Layout Data</option>
			<option value="home" <?php echo $this->uri->segment(4) == 'home'?'selected':'';?>>Home</option>
			<option value="single-news" <?php echo $this->uri->segment(4) == 'single-news'?'selected':'';?>>Single - News</option>
			<option value="video" <?php echo $this->uri->segment(4) == 'video'?'selected':'';?>>Video</option>
			<option value="single-video" <?php echo $this->uri->segment(4) == 'single-video'?'selected':'';?>>Single - Video</option>
			<option value="photo" <?php echo $this->uri->segment(4) == 'photo'?'selected':'';?>>Photo</option>
			<option value="single-photo" <?php echo $this->uri->segment(4) == 'single-photo'?'selected':'';?>>Single - Photo</option>
		</select>
		<a class="waves-effect waves-light btn teal" id="btn-cleft3-pop">Selected</a>
	</div>
	
	<div id="cright1-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<?php echo form_open('back/advertisement/set_banner/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
		<select for="kanal" id="select-top-pop" name="selected_id">
			<option value="" disabled selected>Layout Data</option>
			<?php 
				foreach($get_list_cright1->result() as $cright1){
			?>
				<option value="<?php echo $cright1->adv_id;?>" <?php echo $cright1->adv_id == $get_cright1?'selected':'';?>><?php echo $cright1->adv_title;?></option>
			<?php
				}
			?>
			<option value="clear">Clear</option>
		</select>
		<input type="hidden" name="position_id" value='PSB00008'/>
		<button type="submit" class="waves-effect waves-light btn teal" id="btn-top-pop">Selected</button>
		<?php echo form_close();?>
	</div>
	
	<div id="cright2-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<?php echo form_open('back/advertisement/set_banner/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
		<select for="kanal" id="select-top-pop" name="selected_id">
			<option value="" disabled selected>Layout Data</option>
			<?php 
				foreach($get_list_cright2->result() as $cright2){
			?>
				<option value="<?php echo $cright2->adv_id;?>" <?php echo $cright2->adv_id == $get_cright2?'selected':'';?>><?php echo $cright2->adv_title;?></option>
			<?php
				}
			?>
			<option value="clear">Clear</option>
		</select>
		<input type="hidden" name="position_id" value='PSB00009'/>
		<button type="submit" class="waves-effect waves-light btn teal" id="btn-top-pop">Selected</button>
		<?php echo form_close();?>
	</div>
	
	<div id="cright3-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<?php echo form_open('back/advertisement/set_banner/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
		<select for="kanal" id="select-top-pop" name="selected_id">
			<option value="" disabled selected>Layout Data</option>
			<?php 
				foreach($get_list_cright3->result() as $cright3){
			?>
				<option value="<?php echo $cright3->adv_id;?>" <?php echo $cright3->adv_id == $get_cright3?'selected':'';?>><?php echo $cright3->adv_title;?></option>
			<?php
				}
			?>
			<option value="clear">Clear</option>
		</select>
		<input type="hidden" name="position_id" value='PSB00010'/>
		<button type="submit" class="waves-effect waves-light btn teal" id="btn-top-pop">Selected</button>
		<?php echo form_close();?>
	</div>
	
	<div id="pop-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<select for="kanal" id="select-pop-pop">
			<option value="" disabled selected>Layout Data</option>
			<option value="home" <?php echo $this->uri->segment(4) == 'home'?'selected':'';?>>Home</option>
			<option value="single-news" <?php echo $this->uri->segment(4) == 'single-news'?'selected':'';?>>Single - News</option>
			<option value="video" <?php echo $this->uri->segment(4) == 'video'?'selected':'';?>>Video</option>
			<option value="single-video" <?php echo $this->uri->segment(4) == 'single-video'?'selected':'';?>>Single - Video</option>
			<option value="photo" <?php echo $this->uri->segment(4) == 'photo'?'selected':'';?>>Photo</option>
			<option value="single-photo" <?php echo $this->uri->segment(4) == 'single-photo'?'selected':'';?>>Single - Photo</option>
		</select>
		<a class="waves-effect waves-light btn teal" id="btn-pop-pop">Selected</a>
	</div>
	
	<div id="horizontal1-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<?php echo form_open('back/advertisement/set_banner/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
		<select for="kanal" id="select-top-pop" name="selected_id">
			<option value="" disabled selected>Layout Data</option>
			<?php 
				foreach($get_list_horizontal1->result() as $horizontal1){
			?>
				<option value="<?php echo $horizontal1->adv_id;?>" <?php echo $horizontal1->adv_id == $get_horizontal1?'selected':'';?>><?php echo $horizontal1->adv_title;?></option>
			<?php
				}
			?>
			<option value="clear">Clear</option>
		</select>
		<input type="hidden" name="position_id" value='PSB00013'/>
		<button type="submit" class="waves-effect waves-light btn teal" id="btn-top-pop">Selected</button>
		<?php echo form_close();?>
	</div>
	
	<div id="horizontal2-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<?php echo form_open('back/advertisement/set_banner/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
		<select for="kanal" id="select-top-pop" name="selected_id">
			<option value="" disabled selected>Layout Data</option>
			<?php 
				foreach($get_list_horizontal2->result() as $horizontal2){
			?>
				<option value="<?php echo $horizontal2->adv_id;?>" <?php echo $horizontal2->adv_id == $get_horizontal2?'selected':'';?>><?php echo $horizontal2->adv_title;?></option>
			<?php
				}
			?>
			<option value="clear">Clear</option>
		</select>
		<input type="hidden" name="position_id" value='PSB00014'/>
		<button type="submit" class="waves-effect waves-light btn teal" id="btn-top-pop">Selected</button>
		<?php echo form_close();?>
	</div>
	<div id="mobile-pop" style="width:30%;padding:30px;text-align:center;height:230px;background-color:#fff;margin:auto;box-shadow:0 2px 2px 0 rgba(0,0,0,.19), 0 3px 1px -2px rgba(0,0,0,.19), 0 1px 5px 0 rgba(0,0,0,.19);">
		<h5 style="width:100%;">Select Banner</h5>
		<?php echo form_open('back/advertisement/set_banner/'.$this->uri->segment(4).'/'.$this->uri->segment(5));?>
		<select for="kanal" id="select-mobile-pop" name="selected_id">
			<option value="" disabled selected>Layout Data</option>
			<?php 
				foreach($get_list_mobile->result() as $mob){
			?>
				<option value="<?php echo $mob->adv_id;?>" <?php echo $mob->adv_id == $get_mobile?'selected':'';?>><?php echo $mob->adv_title;?></option>
			<?php
				}
			?>
			<option value="clear">Clear</option>
		</select>
		<input type="hidden" name="position_id" value='PSB00017'/>
		<button type="submit" class="waves-effect waves-light btn teal" id="btn-mobile-pop">Selected</button>
		<?php echo form_close();?>
	</div>
</div>