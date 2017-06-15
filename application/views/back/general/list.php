<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Kanal Tables</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/kanal_side/add_form/">Add New Kanal</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>#ID</td>
								<td>Kanal Name</td>
								<td>Description</td>
								<td>Posted By</td>
								<td>Modify Date</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_kanal->num_rows() < 1){
									
								}else{
									foreach($get_kanal->result() as $knl){
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/kanal_side/edit_form/".$knl->kanal_id."' title='Edit'>".$knl->kanal_id."</a></td>";
										echo "<td class='name' >".$knl->kanal_name."</td>";
										echo "<td class='desc'>".$knl->kanal_desc."</td>";
										echo "<td class='posted'>".$knl->user_back_name."</td>";
										echo "<td class='date'>".$knl->kanal_modify_date."</td>";
										echo "<td class='status'>";
										if($knl->kanal_status=='1')
										{
											echo 'Active';
										}else{
											echo 'Inactive';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/kanal_side/delete/".$knl->kanal_id."' title='Delete'><i class='material-icons'>delete</i></a></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
						<?php echo $this->session->flashdata('kanal_result')?>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>