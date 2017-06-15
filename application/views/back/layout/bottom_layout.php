<!-- Javascripts -->
        <script src="<?php echo base_url();?>assets/js/jquery-2.2.0.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/DataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/plug/tinymce/tinymce.min.js"></script>
		<script>
		$(document).ready(function(){
			$("#notif").click(function(){
				$("#notif").fadeOut();
			});
			
			$("#notif1").click(function(){
				$("#notif1").fadeOut();
			});
			
			$("#kanal-id").change(function(){
				$("#kanal-name i").remove();
				$("#kanal-name").append("<i>"+$("#kanal-id option:selected").attr('id')+"</i>");
			});
			
			$("#layout-id").change(function(){
				window.location.href = "<?php echo base_url();?>index.php/back/advertisement/layout/"+$("#layout-id").val()+"/"+$("#kanal-id").val();
			});
			
			$("#kanal-id").change(function(){
				window.location.href = "<?php echo base_url();?>index.php/back/advertisement/layout/"+$("#layout-id").val()+"/"+$("#kanal-id").val();
			});
			
			$("#bg-pop").click(function(){
				$("#bg-pop").fadeOut();
				$("#top-pop").fadeOut();
				$("#left-pop").fadeOut();
				$("#right-pop").fadeOut();
				$("#cleft1-pop").fadeOut();
				$("#cleft2-pop").fadeOut();
				$("#cleft3-pop").fadeOut();
				$("#cright1-pop").fadeOut();
				$("#cright2-pop").fadeOut();
				$("#cright3-pop").fadeOut();
				$("#pop-pop").fadeOut();
				$("#main-pop").fadeOut();
				$("#vertical-pop").fadeOut();
				$("#horizontal1-pop").fadeOut();
				$("#horizontal2-pop").fadeOut();
				$("#mobile-pop").fadeOut();
			});
			
			$("#lbl-left-side").click(function(){
				$("#bg-pop").fadeIn();
				$("#left-pop").fadeIn();
			});
			
			$("#btn-left-pop").click(function(){
				$("#left-side-banner").val($("#select-left-pop").val());
				$("#lbl-left-side span #get-left-side").remove();
				$("#lbl-left-side span").append("<strong id='get-left-side'>"+$("#select-left-pop").val()+"</strong>");
				$("#left-pop").fadeOut();
			});
			
			$("#lbl-top").click(function(){
				$("#bg-pop").fadeIn();
				$("#top-pop").fadeIn();
			});
			
			$("#btn-top-pop").click(function(){
				$("#top-banner").val($("#select-top-pop").val());
				$("#lbl-top span #get-top-side").remove();
				$("#lbl-top span").append("<strong id='get-top-side'>"+$("#select-top-pop").val()+"</strong>");
				$("#top-pop").fadeOut();
			});
			
			$("#lbl-main").click(function(){
				$("#bg-pop").fadeIn();
				$("#main-pop").fadeIn();
			});
			
			$("#btn-main-pop").click(function(){
				$("#main-banner").val($("#select-main-pop").val());
				$("#lbl-main span #get-main-side").remove();
				$("#lbl-main span").append("<strong id='get-main-side'>"+$("#select-main-pop").val()+"</strong>");
				$("#main-pop").fadeOut();
			});
			
			$("#lbl-cleft1").click(function(){
				$("#bg-pop").fadeIn();
				$("#cleft1-pop").fadeIn();
			});
			
			$("#btn-cleft1-pop").click(function(){
				$("#cleft1-banner").val($("#select-cleft1-pop").val());
				$("#lbl-cleft1 span #get-cleft1-side").remove();
				$("#lbl-cleft1 span").append("<strong id='get-cleft1-side'>"+$("#select-cleft1-pop").val()+"</strong>");
				$("#cleft1-pop").fadeOut();
			});
			
			$("#lbl-cleft2").click(function(){
				$("#bg-pop").fadeIn();
				$("#cleft2-pop").fadeIn();
			});
			
			$("#btn-cleft2-pop").click(function(){
				$("#cleft2-banner").val($("#select-cleft2-pop").val());
				$("#lbl-cleft2 span #get-cleft2-side").remove();
				$("#lbl-cleft2 span").append("<strong id='get-cleft2-side'>"+$("#select-cleft2-pop").val()+"</strong>");
				$("#cleft2-pop").fadeOut();
			});
			
			$("#lbl-cleft3").click(function(){
				$("#bg-pop").fadeIn();
				$("#cleft3-pop").fadeIn();
			});
			
			$("#btn-cleft3-pop").click(function(){
				$("#cleft3-banner").val($("#select-cleft3-pop").val());
				$("#lbl-cleft3 span #get-cleft3-side").remove();
				$("#lbl-cleft3 span").append("<strong id='get-cleft3-side'>"+$("#select-cleft3-pop").val()+"</strong>");
				$("#cleft3-pop").fadeOut();
			});
			
			$("#lbl-pop").click(function(){
				$("#bg-pop").fadeIn();
				$("#pop-pop").fadeIn();
			});
			
			$("#btn-pop-pop").click(function(){
				$("#pop-banner").val($("#select-pop-pop").val());
				$("#lbl-pop span #get-pop-side").remove();
				$("#lbl-pop span").append("<strong id='get-pop-side'>"+$("#select-pop-pop").val()+"</strong>");
				$("#pop-pop").fadeOut();
			});
			
			$("#lbl-cright1").click(function(){
				$("#bg-pop").fadeIn();
				$("#cright1-pop").fadeIn();
			});
			
			$("#btn-cright1-pop").click(function(){
				$("#cright1-banner").val($("#select-cright1-pop").val());
				$("#lbl-cright1 span #get-cright1-side").remove();
				$("#lbl-cright1 span").append("<strong id='get-cright1-side'>"+$("#select-cright1-pop").val()+"</strong>");
				$("#cright1-pop").fadeOut();
			});
			
			$("#lbl-cright2").click(function(){
				$("#bg-pop").fadeIn();
				$("#cright2-pop").fadeIn();
			});
			
			$("#btn-cright2-pop").click(function(){
				$("#cright2-banner").val($("#select-cright2-pop").val());
				$("#lbl-cright2 span #get-cright2-side").remove();
				$("#lbl-cright2 span").append("<strong id='get-cright2-side'>"+$("#select-cright2-pop").val()+"</strong>");
				$("#cright2-pop").fadeOut();
			});
			
			$("#lbl-cright3").click(function(){
				$("#bg-pop").fadeIn();
				$("#cright3-pop").fadeIn();
			});
			
			$("#btn-cright3-pop").click(function(){
				$("#cright3-banner").val($("#select-cright3-pop").val());
				$("#lbl-cright3 span #get-cright3-side").remove();
				$("#lbl-cright3 span").append("<strong id='get-cright3-side'>"+$("#select-cright3-pop").val()+"</strong>");
				$("#cright3-pop").fadeOut();
			});
			
			$("#lbl-right-side").click(function(){
				$("#bg-pop").fadeIn();
				$("#right-pop").fadeIn();
			});
			
			$("#btn-right-pop").click(function(){
				$("#right-side-banner").val($("#select-right-pop").val());
				$("#lbl-right-side span #get-right-side").remove();
				$("#lbl-right-side span").append("<strong id='get-right-side'>"+$("#select-right-pop").val()+"</strong>");
				$("#right-pop").fadeOut();
			});
			
			$("#lbl-vertical").click(function(){
				$("#bg-pop").fadeIn();
				$("#vertical-pop").fadeIn();
			});
			
			$("#btn-vertical-pop").click(function(){
				$("#vertical-side-banner").val($("#select-vertical-pop").val());
				$("#lbl-vertical span #get-vertical-side").remove();
				$("#lbl-vertical span").append("<strong id='get-vertical-side'>"+$("#select-vertical-pop").val()+"</strong>");
				$("#vertical-pop").fadeOut();
			});
			
			$("#lbl-horizontal1").click(function(){
				$("#bg-pop").fadeIn();
				$("#horizontal1-pop").fadeIn();
			});
			
			$("#btn-horizontal1-pop").click(function(){
				$("#horizontal1-side-banner").val($("#select-horizontal1-pop").val());
				$("#lbl-horizontal1 span #get-horizontal1-side").remove();
				$("#lbl-horizontal1 span").append("<strong id='get-horizontal1-side'>"+$("#select-horizontal1-pop").val()+"</strong>");
				$("#horizontal1-pop").fadeOut();
			});
			
			$("#lbl-horizontal2").click(function(){
				$("#bg-pop").fadeIn();
				$("#horizontal2-pop").fadeIn();
			});
			
			$("#btn-horizontal2-pop").click(function(){
				$("#horizontal2-side-banner").val($("#select-horizontal2-pop").val());
				$("#lbl-horizontal2 span #get-horizontal2-side").remove();
				$("#lbl-horizontal2 span").append("<strong id='get-horizontal2-side'>"+$("#select-horizontal2-pop").val()+"</strong>");
				$("#horizontal2-pop").fadeOut();
			});
			
			$("#lbl-mobile").click(function(){
				$("#bg-pop").fadeIn();
				$("#mobile-pop").fadeIn();
			});
			
			$("#btn-mobile-pop").click(function(){
				$("#mobile-side-banner").val($("#select-mobile-pop").val());
				$("#lbl-mobile span #get-mobile-side").remove();
				$("#lbl-mobile span").append("<strong id='get-mobile-side'>"+$("#select-mobile-pop").val()+"</strong>");
				$("#mobile-pop").fadeOut();
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