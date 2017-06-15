<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Video Tables</h5>
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
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/video/add_form/">Add New Video</a>
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
								if($get_video->num_rows() < 1){
									
								}else{
									foreach($get_video->result() as $vi){
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/video/edit_form/".$vi->video_id."' title='Edit'>".$vi->video_id."</a></td>";
										echo "<td class='name' >".$vi->video_title."</td>";
										echo "<td class='kanal'>".$vi->kanal_name."</td>";
										echo "<td class='category'>".$vi->category_name."</td>";
										echo "<td class='posted_by'>".$vi->user_back_name."</td>";
										echo "<td class='date'>".date("d M Y H:i:s", strtotime($vi->video_modify_date))."</td>";
										echo "<td class='status'>";
										if($vi->video_status=='1')
										{
											echo 'Publish';
										}else if($vi->video_status == '2'){
											echo 'Spam';
										}else{
											echo 'Draft';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/video/delete/".$vi->video_id."' title='Delete'><i class='material-icons'>delete</i></a></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
						<?php echo $this->session->flashdata('video_result')?>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>