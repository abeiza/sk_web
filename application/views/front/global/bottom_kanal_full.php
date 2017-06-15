	</div>
	<!-- End Container -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/jquery.sticky-kit.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/jquery.migrate.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/jquery.ticker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/jquery.imagesloaded.min.js"></script>
  	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/jquery.isotope.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/owl.carousel.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/retina-1.1.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/front/script.js"></script>
	
	<script type="text/javascript">
		$(function(){
			$("#logo-kanal").click(function(){
				$( ".menu-kanal" ).fadeIn("slow");
			}),$(".menu-kanal").hover(function(){
				
			},function(){
				$( ".menu-kanal" ).fadeOut("slow");
			});
			
			$("#main-adv-close").click(function(){
				$("#main-adv-fixed").fadeOut();
			});
			
		});
	</script>
	<script type="text/javascript">
		if (screen.width <= 750) {
			document.location = 'http://m.suarakaryanews.com/';
		}else if(screen.width <= 1216){
			document.location = 'http://suarakaryanews.com/index.php/berita/kanal_tab/<?php echo $this->uri->segment(3)?>';
		}
	</script>
	<script type="text/javascript">
		$(function(){
			if($(window).width() >= 1024){
				
				$(function(){
					//$("#warta-daerah").trigger("sticky_kit:recalc");
					$('#warta-daerah').sticky('#grid-haha'); // Initialize the sticky scrolling on an item
				});
				
				$(function(){
					$('#sorot-berita').sticky('#block-container'); // Initialize the sticky scrolling on an item
				});
				
				$(function(){
					$('#index-kanal').sticky('#block-container'); // Initialize the sticky scrolling on an item
				});
				
			}
		});
	</script>
</div>
<script>
	function removeDataAttributes(target) {

    var i,
        $target = $(target),
        attrName,
        dataAttrsToDelete = [],
        dataAttrs = $target.get(0).attributes,
        dataAttrsLen = dataAttrs.length;

    // loop through attributes and make a list of those
    // that begin with 'data-'
    for (i=0; i<dataAttrsLen; i++) {
        if ( 'data-' === dataAttrs[i].name.substring(0,5) ) {
            // Why don't you just delete the attributes here?
            // Deleting an attribute changes the indices of the
            // others wreaking havoc on the loop we are inside
            // b/c dataAttrs is a NamedNodeMap (not an array or obj)
            dataAttrsToDelete.push(dataAttrs[i].name);
        }
    }
    // delete each of the attributes we found above
    // i.e. those that start with "data-"
    $.each( dataAttrsToDelete, function( index, attrName ) {
        $target.removeAttr( attrName );
    })
};
</script>
</body>
</html>