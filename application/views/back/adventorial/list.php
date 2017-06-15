<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Advertorial Tables</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/adventorial/add_form/">Add New Adventorial</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>#ID</td>
								<td>Title</td>
								<td>Short Desc</td>
								<td>Posted By</td>
								<td>Modify Date</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_adventorial->num_rows() < 1){
									
								}else{
									foreach($get_adventorial->result() as $adventorial){
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/adventorial/edit_form/".$adventorial->post_id."' title='Edit'>".$adventorial->post_id."</a></td>";
										echo "<td class='title' >".$adventorial->post_title."</td>";
										echo "<td class='short'>".$adventorial->post_shrt_desc."</td>";
										echo "<td class='posted_by'>".$adventorial->user_back_name."</td>";
										echo "<td class='date'>".date("d M Y H:i:s", strtotime($adventorial->post_modify_date))."</td>";
										echo "<td class='status'>";
										if($adventorial->post_status=='1')
										{
											echo 'Publish';
										}else if($adventorial->post_status == '2'){
											echo 'Spam';
										}else{
											echo 'Draft';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/adventorial/delete/".$adventorial->post_id."' title='Delete'><i class='material-icons'>delete</i></a></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
						<?php echo $this->session->flashdata('adventorial_result')?>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>