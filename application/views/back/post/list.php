<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Post Tables</h5>
				<label for="kanal">Choose Kanal : </label>
				<select for="kanal" name="kanal" id="kanal-id">
					<?php 
						if($get_kanal->num_rows() == 0){
							echo "<option value='' selected disabled> Kanal Data </option>";
						}else{
							echo "<option value='' selected disabled> Kanal Data </option>";
							echo "<option value='all'";
							echo $this->uri->segment(4) == ''? 'selected "> All </option>"':'"> All </option>"';
							foreach($get_kanal->result() as $ctg){
								echo "<option value='".$ctg->kanal_id."'";
								echo $this->uri->segment(4) == $ctg->kanal_id ? " selected>".$ctg->kanal_name."</option>":">".$ctg->kanal_name."</option>";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="col s12 m12 l12 posting-table">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/posting/add_form/">Add New Post</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>#ID</td>
								<td>Title</td>
								<td>Kanal</td>
								<td>Category</td>
								<td>Posted By</td>
								<td>Modify Date</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_post->num_rows() < 1){
									
								}else{
									foreach($get_post->result() as $post){
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/posting/edit_form/".$post->post_id."' title='Edit'>".$post->post_id."</a></td>";
										echo "<td class='name' >".$post->post_title."</td>";
										echo "<td class='kanal'>".$post->kanal_name."</td>";
										echo "<td class='category'>".$post->category_name."</td>";
										echo "<td class='posted_by'>".$post->user_back_name."</td>";
										echo "<td class='date'>".date("d M Y H:i:s", strtotime($post->post_modify_date))."</td>";
										echo "<td class='status'>";
										if($post->post_status=='1')
										{
											echo 'Publish';
										}else if($post->post_status == '2'){
											echo 'Spam';
										}else{
											echo 'Draft';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/posting/delete/".$post->post_id."' title='Delete'><i class='material-icons'>delete</i></a></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
					</table>
				    
				</div>
			</div>
		</div>
		<?php echo $this->session->flashdata('post_result')?>
		<div class="col s12 m12 l12 posting-list">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/posting/add_form/">Add New Post</a>
    		        <div style="margin:20px 0px;">
    			        <?php 
    						if($get_post_list->num_rows() < 1){
    							
    						}else{
    							foreach($get_post->result() as $post){
    							    echo "<div style='margin:10px 0;padding:5px 0px;border-bottom:1px solid #ddd'>";
    								echo "<a href='".base_url()."index.php/back/posting/edit_form/".$post->post_id."' title='Edit'>".$post->post_id."</a>";
    								echo "<div><h3 style='font-size:20px;color:#000;margin:10px 0;'>".$post->post_title."</h3></div>";
    								echo "<div><span>Kanal : ".$post->kanal_name."</span></div>";
    								echo "<div><span>Category : ".$post->category_name."</span></div>";
    								echo "<div><span>Posted By :".$post->user_back_name."</span></div>";
    								echo "<div><span>Create Date : ".date("d M Y H:i:s", strtotime($post->post_modify_date))."</span></div>";
    								echo "<div>Status : <span>";
    								if($post->post_status=='1')
    								{
    									echo 'Publish';
    								}else if($post->post_status == '2'){
    									echo 'Spam';
    								}else{
    									echo 'Draft';
    								}
    								echo "</span></div>";
    								echo "<div><a href='".base_url()."index.php/back/posting/delete/".$post->post_id."' title='Delete'><i class='material-icons'>delete</i></a></div>";
    							    echo "</div>";
    							}
    						}
    					?>
    			    </div>
    			</div>
			</div>
		</div>
	</div>
</main>