<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Users Tables</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/users/add_form/">Add New User</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>#ID</td>
								<td>Name</td>
								<td>Username</td>
								<td>Log Date</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_users->num_rows() < 1){
									
								}else{
									foreach($get_users->result() as $usr){
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/users/edit_form/".$usr->user_back_id."' title='Edit'>".$usr->user_back_id."</a></td>";
										echo "<td class='name' >".$usr->user_back_name."</td>";
										echo "<td class='username'>".$usr->user_back_username."</td>";
										echo "<td class='date'>".$usr->user_back_logdate."</td>";
										echo "<td class='status'>";
										if($usr->user_back_status=='1')
										{
											echo 'Active';
										}else{
											echo 'Not active';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/users/delete/".$usr->user_back_id."' title='Delete'><i class='material-icons'>delete</i></a></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
						<?php echo $this->session->flashdata('users_result')?>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>