<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Photo Detail Tables</h5>
			</div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/photo/add_form_detail/<?php echo $this->uri->segment(4);?>">Add New Image</a>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/photo/">Back</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>Edit</td>
								<td>Image</td>
								<td>Short Desc</td>
								<td>Posted By</td>
								<td>Modify Date</td>
								<td>Delete</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_photo->num_rows() < 1){
									
								}else{
									foreach($get_photo->result() as $ph){
										echo "<tr>";
										echo "<td class='id'></a><a href='".base_url()."index.php/back/photo/edit_photo_detail/".$this->uri->segment(4)."/".$ph->ObjectID."' title='Edit'><i class='material-icons'>edit</i></a></td>";
										echo "<td class='image' ><img style='width:280px' src='".base_url().'uploads/pict/original/'.$ph->pict_detail_url."' /></td>";
										echo "<td class='short'>".$ph->pict_detail_short_desc."</td>";
										echo "<td class='posted_by'>".$ph->user_back_name."</td>";
										if($ph->pict_detail_modify_date == '' or $ph->pict_detail_modify_date == null){
											echo "<td class='date'>".date("d M Y H:i:s", strtotime($ph->pict_detail_create_date))."</td>";
										}else{
											echo "<td class='date'>".date("d M Y H:i:s", strtotime($ph->pict_detail_modify_date))."</td>";
										}										
										echo "<td class='status'><a href='".base_url()."index.php/back/photo/delete_detail_photo/".$this->uri->segment(4)."/".$ph->ObjectID."' title='Delete'><i class='material-icons'>delete</i></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
						<?php echo $this->session->flashdata('photo_detail_result')?>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>