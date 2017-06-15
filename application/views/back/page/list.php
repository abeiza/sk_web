<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Pages Tables</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<span class="card-title">Basic Tables</span>
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/page/add_form/">Add New Page</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>#ID</td>
								<td>Page Title</td>
								<td>Short Desc</td>
								<td>Posting Date</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_page->num_rows() < 1){
									
								}else{
									foreach($get_page->result() as $pge){
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/page/edit_form/".$pge->page_id."' title='Edit'>".$pge->page_id."</a></td>";
										echo "<td class='title' >".$pge->page_title."</td>";
										echo "<td class='short'>".$pge->page_short."</td>";
										if($pge->page_modify_date == '' or $pge->page_modify_date == null){
											echo "<td class='date'>".date("d M Y H:i:s", strtotime($pge->page_create_date))."</td>";
										}else{
											echo "<td class='date'>".date("d M Y H:i:s", strtotime($pge->page_modify_date))."</td>";
										}
										
										echo "<td class='status'>";
										if($pge->page_status=='1')
										{
											echo 'Publish';
										}else if($pge->page_status=='2'){
											echo 'Spam';
										}else{
											echo 'Draft';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/page/delete/".$pge->page_id."' title='Delete'><i class='material-icons'>delete</i></a></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
						<?php echo $this->session->flashdata('page_result')?>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>