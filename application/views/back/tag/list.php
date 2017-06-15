<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Tag Tables</h5></div>
		</div>
		<div class="col s12 m12 l12 posting-table">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/tag/add_form/">Add New Tag</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>#ID</td>
								<td>Tag Name</td>
								<td>Posted By</td>
								<td>Modify Date</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_tag->num_rows() < 1){
									
								}else{
									foreach($get_tag->result() as $tag){
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/tag/edit_form/".$tag->tag_id."' title='Edit'>".$tag->tag_id."</a></td>";
										echo "<td class='name' >".$tag->tag_name."</td>";
										echo "<td class='posted'>".$tag->user_back_name."</td>";
										echo "<td class='date'>".date("d M Y H:i:s", strtotime($tag->tag_modify_date))."</td>";
										echo "<td class='status'>";
										if($tag->tag_status=='1')
										{
											echo 'Active';
										}else{
											echo 'Not Active';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/tag/delete/".$tag->tag_id."' title='Delete'><i class='material-icons'>delete</i></a></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
						<?php echo $this->session->flashdata('tag_result')?>
					</table>
				</div>
			</div>
		</div>
	    <div class="col s12 m12 l12 posting-list">
			<div class="card">
				<div class="card-content">
					<?php 
						if($get_tag_list->num_rows() < 1){
							
						}else{
							foreach($get_tag_list->result() as $tag){
								echo "<div style='margin:10px 0;padding:5px 0px;border-bottom:1px solid #ddd'>";
								echo "<a href='".base_url()."index.php/back/tag/edit_form/".$tag->tag_id."' title='Edit'>".$tag->tag_id."</a>";
								echo "<div><h3 style='font-size:20px;color:#000;margin:10px 0;'>".$tag->tag_name."</h3></div>";
								echo "<div><span>Created By : ".$tag->user_back_name."</span></div>";
								echo "<div><span>Created Date : ".date("d M Y H:i:s", strtotime($tag->tag_modify_date))."</span></div>";
								echo "<div><span>Status : ";
								if($tag->tag_status=='1')
								{
									echo 'Active';
								}else{
									echo 'Not Active';
								}
								echo "</span></div>";
								echo "<div><span><a href='".base_url()."index.php/back/tag/delete/".$tag->tag_id."' title='Delete'><i class='material-icons'>delete</i></a></span></div>";
								echo "</div>";
							}
						}
					?>
				</div>
			</div>
		</div>
	
	</div>
</main>