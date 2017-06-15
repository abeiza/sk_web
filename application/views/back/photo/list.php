<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Photo Tables</h5>
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
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/photo/add_form/">Add New Photo</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>#ID</td>
								<td>Title</td>
								<td>Category</td>
								<td>Kanal</td>
								<td>Posted By</td>
								<td>Modify Date</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_photo->num_rows() < 1){
									
								}else{
									foreach($get_photo->result() as $ph){
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/photo/edit_form/".$ph->pict_id."' title='Edit'>".$ph->pict_id."</a></td>";
										echo "<td class='title' >".$ph->pict_title."</td>";
										echo "<td class='category'>".$ph->category_name."</td>";
										echo "<td class='kanal'>".$ph->kanal_name."</td>";
										echo "<td class='posted_by'>".$ph->user_back_name."</td>";
										if($ph->pict_modify_date == '' or $ph->pict_modify_date == null){
											echo "<td class='date'>".date("d M Y H:i:s", strtotime($ph->pict_create_date))."</td>";
										}else{
											echo "<td class='date'>".date("d M Y H:i:s", strtotime($ph->pict_modify_date))."</td>";
										}
										
										echo "<td class='status'>";
										if($ph->pict_status=='1')
										{
											echo 'Publish';
										}else if($ph->pict_status == '2'){
											echo 'Spam';
										}else{
											echo 'Draft';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/photo/delete/".$ph->pict_id."' title='Delete'><i class='material-icons'>delete</i></a><a href='".base_url()."index.php/back/photo/list_image/".$ph->pict_id."' title='Edit'><i class='material-icons'>edit</i></a></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
						<?php echo $this->session->flashdata('photo_result')?>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>