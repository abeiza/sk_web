<!-- block-wrapper-section
			================================================== -->
			
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/front/jquery-ui.css" media="screen">
		<script src="<?php echo base_url();?>assets/js/front/jquery-ui.js"></script>
		<script>
			function formatMonth(m){
				var monthNames = [
					"Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Des"
				];
				
				return monthNames[m];
			}
		</script>
		<script>
			$(function(){
				$("#filter-date").datepicker(
					{
						dateFormat: 'dd-mm-yy'
					}
				);
				
				$("#filter-date").change(
					function(){
						var dat = $("#filter-date").val().split('-');
						var convdate = dat[2] + '-' + dat[1] + '-' + dat[0] + ' 00:00:00';
						//$("#transdte").val(convdate);
						var kanal = '<?php echo $this->uri->segment(3) == 'artikel'?'none':urldecode($this->uri->segment(3));?>';
						$.ajax({
							url:"<?php echo base_url();?>index.php/berita/get_filter_index_photo/",
							cache:false,
							data: {
							   filter : convdate,
							   kanal : kanal
							},
							type: "POST",
							dataType: 'json',
							success:function(result){
								$('#grid-box-index .autor-list').remove();
								$('#grid-box-index').append('<ul class="autor-list"></ul>');
							
								$.each(result, function(i, data){
									$('#grid-box-index .autor-list').append('<li>'+
										'<a href="<?php echo base_url();?>index.php/berita/foto_detail/'+data.pict_url+'" style="text-decoration:none;">'+
										'<div class="autor-box padding-full-10">'+
											'<div class="autor-content margin-left-0">'+
												'<div style="color:#FD8E23"><span class="padding-right-10">'+data.category_name+'</span><i class="fa fa-clock-o margin-right-5 padding-left-10" style="border-left:1px dotted #777;"></i>'+data.pict_create_date.substr(8,2)+" "+formatMonth(data.pict_create_date.substr(5,2).valueOf()-1)+" "+data.pict_create_date.substr(0,4)+'</div>'+
												'<h4><span>'+data.pict_title+'</span></h4>'+
											'</div>'+
										'</div>'+
										'</a>'+
									'</li>');
								});
							}
						});
					}
				);
			});
		</script>
		<section class="block-wrapper">
			<div class="container">
				<div class="row" id="block-container">
					<section>
					<div class="col-xs-5 col-sm-4 col-md-3 side-left box-side">

						<!-- sidebar -->
						<div class="sidebar">
							<div class="advertisement padding-full-0 img-adv-full">
										<div class="desktop-advert">
											<?php 
												foreach($query_adv->result() as $pop){
													if($pop->position_id == 'PSB00005'){
											?>
											<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									        <?php 
													}
												}
											?>
										</div>
									</div>
							<div class="widget recent-comments-widget widget-popular" id="index-kanal">
								<div class="title-section margin-top-0 title-video">
									<h1><span class="world blue-title">KANAL UTAMA</span></h1>
								</div>
								<div class="news-post image-post2 background-white">
									<div class="news-post article-post margin-bottom-0" data-num="1">
											<?php 
												foreach($get_menu->result() as $menu){
											?>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12">
													<div>
														<p class="desc-sorot">
															<a href="<?php echo base_url();?>index.php/berita/key_index/<?php echo $menu->menu_label;?>" class="hover padding-full-10 <?php echo strtolower(urldecode($this->uri->segment(3))) == strtolower($menu->menu_label)?'color-blue':'';?>" style="float:left;width:100%;padding:5% 10%!important;"><span class="fa fa-angle-double-right margin-right-5"></span><?php echo $menu->menu_label;?></a>
														</p>
													</div>
												</div>
											</div>
											<?php 
												}
											?>
									</div>
								</div>
							</div>
						
						</div>
						<!-- End sidebar -->

					</div>
					</section>
					<div class="col-xs-7 col-sm-8 col-md-9 artikel-desc">

						<!-- block content -->
						<div class="block-content">

							<!-- grid box -->
							<div class="grid-box" id="grid-box-index">
								<div class="title-section">
									<h1><span>Index</span><div style="display:inline-block;"><label for="filter-date" style="font-size:12px;text-transform:none;font-weight:normal;margin:0 10px;">Filter : </label><input type="text" style="width:auto" id="filter-date"/></div></h1>
								</div>

								<ul class="autor-list">
								<?php foreach($get_index->result() as $popo){?>
									<li>
										<a href="<?php echo base_url();?>index.php/berita/artikel/<?php echo $popo->post_url;?>" style="text-decoration:none;">
										<div class="autor-box padding-full-10">
											<div class="autor-content margin-left-0">
												<div style="color:#FD8E23"><span class="padding-right-10"><?php echo $popo->category_name;?></span><i class="fa fa-clock-o margin-right-5 padding-left-10" style="border-left:1px dotted #777;"></i><?php echo date('d M Y', strtotime($popo->post_modify_date));?></div>
												<h4><span><?php echo $popo->post_title;?></span></h4>
											</div>
										</div>
										</a>
									</li>
								<?php }?>
								</ul>
							</div>
							<!-- End grid box -->

						</div>
						<!-- End block content -->

					</div>
				</div>

			</div>
		</section>
		<!-- End block-wrapper-section -->