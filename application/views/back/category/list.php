<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Category Tables</h5>
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
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/category/add_form/">Add New Category</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>#ID</td>
								<td>Category Name</td>
								<td>Kanal</td>
								<td>Posted By</td>
								<td>Modify Date</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_category->num_rows() < 1){
									
								}else{
									foreach($get_category->result() as $ctg){
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/category/edit_form/".$ctg->category_id."' title='Edit'>".$ctg->category_id."</a></td>";
										echo "<td class='name' >".$ctg->category_name."</td>";
										echo "<td class='desc'>".$ctg->kanal_name."</td>";
										echo "<td class='posted'>".$ctg->user_back_name."</td>";
										echo "<td class='date'>".date("d M Y H:i:s", strtotime($ctg->category_modify_date))."</td>";
										echo "<td class='status'>";
										if($ctg->category_status=='1')
										{
											echo 'Active';
										}else{
											echo 'Not Active';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/category/delete/".$ctg->category_id."' title='Delete'><i class='material-icons'>delete</i></a></td>";
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
		<?php echo $this->session->flashdata('category_result')?>
		<div class="col s12 m12 l12 posting-list">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/category/add_form/">Add New Category</a>
					<?php 
						if($get_category_list->num_rows() < 1){
							
						}else{
							foreach($get_category_list->result() as $ctg1){
								echo "<div style='margin:10px 0;padding:5px 0px;border-bottom:1px solid #ddd'>";
								echo "<a href='".base_url()."index.php/back/category/edit_form/".$ctg1->category_id."' title='Edit'>".$ctg1->category_id."</a>";
								echo "<div><h3 style='font-size:20px;color:#000;margin:10px 0;'>".$ctg1->category_name."</h3></div>";
								echo "<div><span>Kanal : ".$ctg1->kanal_name."</span></div>";
								echo "<div><span>Created By : ".$ctg1->user_back_name."</span></div>";
								echo "<div><span>Created Date : ".date("d M Y H:i:s", strtotime($ctg1->category_modify_date))."</span></div>";
								echo "<div><span> Status : ";
								if($ctg1->category_status=='1')
								{
									echo 'Active';
								}else{
									echo 'Not Active';
								}
								echo "</span></div>";
								echo "<div><span><a href='".base_url()."index.php/back/category/delete/".$ctg1->category_id."' title='Delete'><i class='material-icons'>delete</i></a></span></div>";
								echo "</div>";
							}
						}
					?>
				</div>
			</div>
		</div>
	
	</div>
</main>