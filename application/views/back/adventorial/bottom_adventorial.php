<!-- Javascripts -->
        <script src="<?php echo base_url();?>assets/js/jquery-2.2.0.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/DataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/plug/tinymce/tinymce.min.js"></script>
		<script>
			tinymce.init({
			  selector: '#desc',
			  height: 250,
			  theme: 'modern',
			  plugins: [
				'advlist autolink lists link image charmap print preview hr anchor pagebreak',
				'searchreplace wordcount visualblocks visualchars code fullscreen',
				'insertdatetime media nonbreaking save table contextmenu directionality',
				'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
			  ],
			  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
			  image_advtab: true,
			  templates: [
				{ title: 'Test template 1', content: 'Test 1' },
				{ title: 'Test template 2', content: 'Test 2' }
			  ],
			  content_css: [
				'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
				'//www.tinymce.com/css/codepen.min.css'
			  ]
			 });
		</script>
		<script>
		$(document).ready(function() {
			$('#kanal-list').DataTable({
				order: [[ 0, 'desc' ]]
			});
			
			$('#kanal-id').change(function(){
				var kanal = $('#kanal-id').val();
				if(kanal == 'all'){
					window.location = "<?php echo base_url();?>index.php/back/posting/";
				}else{
					window.location = "<?php echo base_url();?>index.php/back/posting/list_by/"+kanal;
				}
			});
		} );
		</script>
		<script>
		$(document).ready(function(){
			$("#notif").click(function(){
				$("#notif").fadeOut();
			});
			
			$("#notif1").click(function(){
				$("#notif1").fadeOut();
			});
		});
		</script>
        <script src="<?php echo base_url();?>assets/js/materialize.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/materialPreloader.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.blockui.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.waypoints.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.counterup.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.sparkline.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/chart.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.flot.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.flot.time.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.flot.symbol.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.flot.resize.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.flot.tooltip.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/curvedLines.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.peity.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/alpha.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/dashboard.js"></script>
       
    
<div class="hiddendiv common"></div></body></html>