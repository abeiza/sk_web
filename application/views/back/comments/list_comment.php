<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Comments</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content" style="width:100%;float:left;background-color:#fff;">
					<span class="card-title" style="float:Left;width:100%;">Basic Tables</span>
					<div style="width:100%;float:left;">
						<a class="waves-effect waves-light btn teal" style="float:left;" href="<?php echo base_url();?>index.php/back/comments/">Back</a>
					</div>
					<div style="padding:20px 0;float:left;width:100%;">
						<ul style="float:left;width:100%;">
						<?php 
						if($query_comment_post->num_rows == 0){
						?>
							<li style="float:left;width:100%;text-align:center;">
								Comment is not Available
							</li>
						<?php
						}else{
							foreach($query_comment_post->result() as $cmd){
								if($cmd->comment_order == 1){
									if($cmd->guest_profile_pict == null or $cmd->guest_profile_pict == ''){
						?>
							<li style="float:left;width:100%;">
								<div style="width:100%;float:left;border-bottom:1px solid #f1f1f1;">
									<div style="width:100px;float:left;height:100px;padding:10px;">
										<img src="<?php echo base_url().'assets/img/profile-image.png';?>" style="width:75px;height:75px;float:left;"/>
									</div>
									<div style="width:auto;float:left;">
										<h6 style="font-weight:bold;"><?php echo $cmd->guest_name;?></h6>
										<span><?php echo date('d M Y H:s:i', strtotime($cmd->comment_post_date))?></span>
										<p><?php echo $cmd->comment_text;?></p>
										<a href="<?php echo base_url().'index.php/back/comments/delete_comments/'.$this->uri->segment(4).'/'.$cmd->comment_id.'/';?>"><span>Delete</span></a>
										<?php 
											if($cmd->comment_flag == 0){
										?>
										<span style="background-color:#ffb618 !important;color:#fff;padding:5px;border-radius:3px;">New</span>
										<?php 
											}
										?>
									</div>
								</div>
							</li>
						<?php
									}else{
						?>
							<li style="float:left;width:100%;">
								<div style="width:100%;float:left;border-bottom:1px solid #f1f1f1;">
									<div style="width:100px;float:left;height:100px;padding:10px;">
										<img src="<?php echo base_url().'uploads/user/original/'.$cmd->guest_profile_pict;?>" style="width:75px;height:75px;float:left;border-radius:100%;"/>
									</div>
									<div style="width:auto;float:left;">
										<h6 style="font-weight:bold;"><?php echo $cmd->guest_name;?></h6>
										<span><?php echo date('d M Y H:s:i', strtotime($cmd->comment_post_date))?></span>
										<p><?php echo $cmd->comment_text;?></p>
										<a href="<?php echo base_url().'index.php/back/comments/delete_comments/'.$this->uri->segment(4).'/'.$cmd->comment_id.'/';?>"><span>Delete</span></a>
										<?php 
											if($cmd->comment_flag == 0){
										?>
										<span style="background-color:#ffb618 !important;color:#fff;padding:5px;border-radius:3px;">New</span>
										<?php 
											}
										?>
									</div>
								</div>
							</li>
						<?php
									}
								}else{
									if($cmd->guest_profile_pict == null or $cmd->guest_profile_pict == ''){
						?>
							<li style="width:100%;float:left;padding:10px 0;">
								<div style="padding-left:10%;width:90%;">
									<div style="width:100px;float:left;height:100px;padding:10px;">
										<img src="<?php echo base_url().'assets/img/profile-image.png';?>" style="width:75px;height:75px;float:left;"/>
									</div>
									<div style="width:auto;float:left;">
										<h6 style="font-weight:bold;"><?php echo $cmd->guest_name;?></h6>
										<span><?php echo date('d M Y H:s:i', strtotime($cmd->comment_post_date))?></span>
										<p><?php echo $cmd->comment_text;?></p>
										<a href="<?php echo base_url().'index.php/back/comments/delete_comments/'.$this->uri->segment(4).'/'.$cmd->comment_id.'/';?>"><span>Delete</span></a>
										<?php 
											if($cmd->comment_flag == 0){
										?>
										<span style="background-color:#ffb618 !important;color:#fff;padding:5px;border-radius:3px;">New</span>
										<?php 
											}
										?>
									</div>
								</div>
							</li>
						<?php
									}else{
						?>
							<li style="width:100%;float:left;padding:10px 0;">
								<div style="padding-left:10%;width:90%;">
									<div style="width:100px;float:left;height:100px;padding:10px;">
										<img src="<?php echo base_url().'uploads/user/original/'.$cmd->guest_profile_pict;?>" style="width:75px;height:75px;float:left;border-radius:100%;"/>
									</div>
									<div style="width:auto;float:left;">
										<h6 style="font-weight:bold;"><?php echo $cmd->guest_name;?></h6>
										<span><?php echo date('d M Y H:s:i', strtotime($cmd->comment_post_date))?></span>
										<p><?php echo $cmd->comment_text;?></p>
										<a href="<?php echo base_url().'index.php/back/comments/delete_comments/'.$this->uri->segment(4).'/'.$cmd->comment_id.'/';?>"><span>Delete</span></a>
										<?php 
											if($cmd->comment_flag == 0){
										?>
										<span style="background-color:#ffb618 !important;color:#fff;padding:5px;border-radius:3px;">New</span>
										<?php 
											}
										?>
									</div>
								</div>
							</li>
						<?php
									}
								}
							}
							
							$query_update_flag = $this->db->query("update sk_comment set comment_flag = '1' where post_id = '".$this->uri->segment(4)."'");
						}
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php echo $this->session->flashdata('comment_result')?>