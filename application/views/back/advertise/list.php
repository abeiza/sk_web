<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Advertisement Tables (Master)</h5>
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
					<a class="waves-effect waves-light btn teal" href="<?php echo base_url();?>index.php/back/advertisement/add_form/">Add New Advertisement</a>
					<table id="kanal-list" style="width:100% !important;">
						<thead style="font-weight:bold;">
							<tr>
								<td>#ID</td>
								<td>Title Advertisement</td>
								<td>Kanal</td>
								<td>Short Desc</td>
								<td>Position</td>
								<td>Status</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
								if($get_adv->num_rows() < 1){
									
								}else{
									foreach($get_adv->result() as $adv){
										if($adv->kanal_name == ''){
											$kanal_name = 'Home';
										}else{
											$kanal_name = $adv->kanal_name;
										}
										 
										echo "<tr>";
										echo "<td class='id'><a href='".base_url()."index.php/back/advertisement/edit_form/".$adv->adv_id."' title='Edit'>".$adv->adv_id."</a></td>";
										echo "<td class='title' >".$adv->adv_title."</td>";
										echo "<td class='kanal'>".$kanal_name."</td>";
										echo "<td class='short'>".$adv->adv_short_desc."</td>";
										echo "<td class='position'>".$adv->position_name."</td>";
										echo "<td class='status'>";
										if($adv->adv_status=='1')
										{
											echo 'Pubish';
										}
										else if($adv->adv_status=='2')
										{
											echo 'Spam';
										}else{
											echo 'Draft';
										}
										echo "</td>";
										echo "<td class='status'><a href='".base_url()."index.php/back/advertisement/delete/".$adv->adv_id."' title='Delete'><i class='material-icons'>delete</i></a></td>";
										echo "</tr>";
									}
								}
							?>
						</tbody>
						<div class="pagination"></div>
						<?php echo $this->session->flashdata('adv_result')?>
					</table>
				</div>
			</div>
		</div>
	</div>
</main>