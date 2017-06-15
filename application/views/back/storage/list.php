<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/jquery-ui/js/jquery-ui.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/elfinder/js/elfinder.min.js'); ?>"></script>
<script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('#elfinder-tag').elfinder({
                url: '<?php echo base_url('index.php/back/storage/elfinder/'); ?>',
            }).elfinder('instance');
        });
</script>
<main class="mn-inner" style="background-color:#f1f1f1 !important;">
	<div class="row">
		<div class="col s12">
			<div class="page-title"><h5>Storage</h5></div>
		</div>
		<div class="col s12 m12 l12">
			<div class="card">
				<div class="card-content">
					<div class="x_panel">
                        <div class="x_title">
							<h3>Managemant File</h3>
                        </div>
                        <div id="elfinder-tag"></div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</main>