	<script>
		function formatMonth(m){
			var monthNames = [
				"Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Des"
			];
			
			return monthNames[m];
		}
	</script>
	<script>
		$(document).ready(function() {
			var page = 1;
            $(window).scroll(function () {
                $('#more').hide();
                //$('#no-more').hide();

                if($(window).scrollTop() + $(window).height() == $(document).height()) {

                    $('#more').hide();
                    //$('#no-more').hide();

      
					  var first_a = $('#first').val();
					  if(first_a > 40){
						$('#no-more').fadeIn();
					  }else{
						$('#more').fadeIn();
						var first = $('#first').val();
						var limit = $('#limit').val();
						
						var first1 = $('#first1').val();
						var limit1 = $('#limit1').val();
						
						var first2 = $('#first2').val();
						var limit2 = $('#limit2').val();
                        $.ajax({
                            url:"../../berita/get_data/",
							//url:"<?php echo base_url();?>/index.php/berita/get_data/",
							cache:false,
							data: {
							   start : first,
							   limit : limit,
							   start1 : first1,
							   limit1 : limit1,
							   start2 : first2,
							   limit2 : limit2
							},
							type: "POST",
							dataType: 'json',
							success:function(result){
									$.each(result, function(i, data){
										if(data.flag_id == 'FLG00001'){
											if(data.post_direct == '1'){
												$('.container-berita').append(
												"<div class='news-post article-post list-adventorial margin-bottom-0 box1'><div class='row'><div class='col-xs-4 col-sm-3 col-md-3 padding-right-0'><div class='post-gallery'><div class='background-img-berita' style='background-image:url("+'"'+"<?php echo base_url();?>uploads/post/original/"+data.post_thumb+""+'"'+");'></div></div></div><div class='col-xs-8 col-sm-9 col-md-9'> <div class='post-content'><h2><a href='"+data.post_url+"' style='color:#fff;'>"+data.post_title+"</a></h2><ul class='post-tags'><li><span class='category-label'>"+data.flag_name+"</span></li><li><i class='fa fa-clock-o'></i>"+data.post_modify_date.substr(8,2)+" "+formatMonth(data.post_modify_date.substr(5,2).valueOf()-1)+" "+data.post_modify_date.substr(0,4)+" "+data.post_modify_date.substr(11,5)+"</li><li><i class='fa fa-user'></i>by <a href='#'>"+data.profile_back_name_full+"</a></li></ul><p class='desc'>"+data.post_shrt_desc.substring(0,85)+"..."+"</p></div></div></div></div>");
											}else{
												$('.container-berita').append(
												"<div class='news-post article-post list-adventorial margin-bottom-0 box1'><div class='row'><div class='col-xs-4 col-sm-3 col-md-3 padding-right-0'><div class='post-gallery'><div class='background-img-berita' style='background-image:url("+'"'+"<?php echo base_url();?>uploads/post/original/"+data.post_thumb+""+'"'+");'></div></div></div><div class='col-xs-8 col-sm-9 col-md-9'> <div class='post-content'><h2><a href='<?php echo base_url();?>index.php/berita/artikel/"+data.post_url+"' style='color:#fff;'>"+data.post_title+"</a></h2><ul class='post-tags'><li><span class='category-label'>"+data.flag_name+"</span></li><li><i class='fa fa-clock-o'></i>"+data.post_modify_date.substr(8,2)+" "+formatMonth(data.post_modify_date.substr(5,2).valueOf()-1)+" "+data.post_modify_date.substr(0,4)+" "+data.post_modify_date.substr(11,5)+"</li><li><i class='fa fa-user'></i>by <a href='#'>"+data.profile_back_name_full+"</a></li></ul><p class='desc'>"+data.post_shrt_desc.substring(0,85)+"..."+"</p></div></div></div></div>");
											}
											//$(document.body).trigger("sticky_kit:recalc");
											$('#warta-daerah').sticky('#grid-haha');
											$('#warta-daerah').css("left","171px;");
											$('#sorot-berita').sticky('#block-container');
										}else if(data.flag_id == 'adv'){
											$('.container-berita').append(
											"<a href='"+data.post_url+"'><div class='news-post article-post box1' style='padding:10px;margin-bottom:0;background-color:#f6f6f6;'><img src='<?php echo base_url();?>uploads/advertise/original/"+data.post_thumb+"'/></div></a>");
										}else{
											$('.container-berita').append(
											"<div class='news-post article-post list-regular margin-bottom-0 box1'> <div class='row'><div class='col-xs-4 col-sm-3 col-md-3 padding-right-0'><div class='post-gallery'><div class='background-img-berita' style='background-image:url("+'"'+"<?php echo base_url();?>uploads/post/original/"+data.post_thumb+""+'"'+");'></div></div></div><div class='col-xs-8 col-sm-9 col-md-9'> <div class='post-content'><h2><a href='<?php echo base_url();?>index.php/berita/artikel/"+data.post_url+"'>"+data.post_title+"</a></h2><ul class='post-tags'><li><span class='category-label'>"+data.kanal_name+"</span></li><li><i class='fa fa-clock-o'></i>"+data.post_modify_date.substr(8,2)+" "+formatMonth(data.post_modify_date.substr(5,2).valueOf()-1)+" "+data.post_modify_date.substr(0,4)+" "+data.post_modify_date.substr(11,5)+"</li><li><i class='fa fa-user'></i>by <a href='#'>"+data.profile_back_name_full+"</a></li></ul><p class='desc'>"+data.post_shrt_desc.substring(0,85)+"..."+"</p></div></div></div></div>");
											//$(document.body).trigger("sticky_kit:recalc");
											$('#warta-daerah').sticky('#grid-haha');
											$('#sorot-berita').sticky('#block-container');
										}
									});
									
									
									
									first_v = parseInt($('#first').val());
									limit_v = parseInt($('#limit').val());
									$('#first').val( first_v+limit_v );
									
									first_vi = parseInt($('#first1').val());
									limit_vi = parseInt($('#limit1').val());
									$('#first1').val( first_vi+limit_vi );
									
									first_vii = parseInt($('#first2').val());
									limit_vii = parseInt($('#limit2').val());
									$('#first2').val( first_vii+limit_vii );
									$('#more').fadeOut();
							}
                        });
					  }
                    //}
                }
            });
		});
		</script>
	<!-- block-wrapper-section
			================================================== -->
				<?php 
					foreach($query_adv->result() as $pop){
						if($pop->position_id == 'PSB00011'){
				?>
				<div id="main-adv-fixed" style="position:fixed;width:100%;height:100%;top:0;left:0;background:rgba(0,0,0,0.4);z-index:9999999;display:flex;">
        			<div style="float:left;margin:auto;width:45%;">
        				<div>
        					<a id="main-adv-close" style="background:#fff;color:#333;padding:5px;border-radius:3px 3px 0 0;font-size:12px;text-decoration:none;cursor:pointer;"><span class="fa fa-close"></span> Close</a>
        				</div>
				        <a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
				    </div>
		        </div>
				<?php 
						}
					}
				?>
		<div id="iklan" class="advertisement-fixed-left">
				<?php 
				foreach($query_adv->result() as $pop){
					if($pop->position_id == 'PSB00003'){
				?>
					<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
				<?php 
						}
					}
				?>
		</div>
		<div id="iklan" class="advertisement-fixed-right">
				<?php 
				foreach($query_adv->result() as $pop){
					if($pop->position_id == 'PSB00004'){
				?>
				<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
				<?php 
						}
					}
				?>
		</div>
		<section class="block-wrapper">
			<div class="container">
				<div class="row"  id="block-container">
					<div class="col-xs-7 col-sm-8 col-md-9" id="left-side">
						<div class="block-content headline-news-box">

							<!-- grid box -->
							<div class="grid-box margin-0 margin-bottom-0">
								<div class="row widget-politik">
									<div class="col-xs-12 col-sm-2 col-md-2 head-news">
										<h1 class="headline-title">HEADLINE NEWS >></h1>
									</div>
									<div class="col-xs-12 col-sm-10 col-md-10 margin-0 padding-0">
										<!-- Carousel box -->
										<div class="carousel-box owl-wrapper">

											<div id="owl-cour" class="owl-carousel" data-num="4">
											<?php 
													foreach($get_headline->result() as $hdl){
												?>
													<div class="item news-post image-post3">
														<div class="img-owl-carousel background-img-headline" style="background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $hdl->post_thumb;?>');"></div>
														<!--<img class="img-owl-carousel" src="<?php //echo base_url();?>uploads/post/thumb/<?php //echo $hdl->post_thumb;?>" alt="">-->
														<div class="hover-box">
															<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $hdl->post_url;?>"><?php echo $hdl->post_title;?></a></h2>
														</div>
													</div>
											<?php												
													}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- block content -->
						<div class="block-content margin-top-5">
							<div class="grid-box row margin-bottom-5">
								<div class="image-slider widget-politik">
									<ul class="bxslider">
										<?php 
											foreach($get_main->result() as $main){
										?>
										<li>
											<div class="news-post image-post">
												<div class="img-full-width img-main" style="height:510px;background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $main->post_thumb;?>');background-color:#333;background-size: auto 100%;background-position-x: 50%;background-repeat: no-repeat;"></div>
														
												<!--<img style="height:510px;" src="<?php echo base_url();?>uploads/post/original/<?php echo $main->post_thumb;?>" alt="">-->
												<div class="hover-box">
													<div class="inner-hover">
														<a class="category-post tech" href="#"><?php echo $main->kanal_name;?></a>
														<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $main->post_url;?>"><?php echo $main->post_title;?></a></h2>
														<p><?php echo $main->post_shrt_desc;?></p>
													</div>
												</div>
											</div>
										</li>
										<?php												
													}
										?>
									</ul>
								</div>
							</div>
							<!-- grid-box -->
							<div class="grid-box">
								<div class="row" id="grid-haha">
									<section>
									<div class="col-xs-5 col-sm-4 col-md-4.5 padding-full-0 box-side">
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
										<div class="widget review-widget widget-politik">
											<a style="text-decoration:none;" href="<?php echo base_url().'index.php/berita/kanal/politik/';?>"><h1 class="margin-top-0 title-warta-daerah">Politik</h1></a>
											<ul class="review-posts-list main-news-warta margin-bottom-5">
												<?php 
													foreach($get_politik->result() as $plt){
												?>
												<li class="list-main-warta">
													<img class="img-full-width" src="<?php echo base_url();?>uploads/post/original/<?php echo $plt->post_thumb;?>" alt="">
													<div class="post-content div-main-warta">
														<h2 class="title-main-warta"><a class="hover" href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $plt->post_url;?>"><?php echo $plt->post_title;?></a></h2>
														<span class="posted-main-warta"><i class="fa fa-clock-o margin-right-5"></i><?php echo date('d M Y H:i',strtotime($plt->post_modify_date));?></span>
													</div>
												</li>
												<?php
													break;
													}
												?>
												
												<?php 
													$i = 1;
													foreach($get_politik->result() as $plt){
														if($i == 1){
															$i++;
														}else{
												?>
												<li class="list-warta">
													<div class="box-list-warta">
														<img class="img-list-warta" src="<?php echo base_url();?>uploads/post/original/<?php echo $plt->post_thumb;?>" alt="">
														<div class="box-list-desc">
															<h2 class="title-warta"><a class="hover" href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $plt->post_url;?>"><?php echo substr($plt->post_title, 0,40).'...';?></a></h2>
														</div>
													</div>
												</li>
												<?php
														$i++;
														}
													}
												?>
											</ul>
										</div>
										<div class="advertisement padding-full-0 img-adv-full">
											<div class="desktop-advert">
												<?php 
													foreach($query_adv->result() as $pop){
														if($pop->position_id == 'PSB00006'){
												?>
												<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									            <?php 
														}
													}
												?>
											</div>
										</div>
										
										<div id="warta-daerah">
											<div class="widget review-widget col-warta">
												<a style="text-decoration:none;" href="<?php echo base_url().'index.php/berita/kanal/warta daerah/';?>"><h1 class="margin-top-0 title-warta-daerah">WARTA DAERAH</h1></a>
												<ul class="review-posts-list main-news-warta margin-bottom-5">
													<?php 
														foreach($get_warta->result() as $wrt){
													?>
													<li class="list-main-warta">
														<img class="img-full-width" src="<?php echo base_url();?>uploads/post/original/<?php echo $wrt->post_thumb;?>" alt="">
														<div class="post-content div-main-warta">
															<h2 class="title-main-warta"><a class="hover" href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $wrt->post_url;?>"><?php echo $wrt->post_title;?></a></h2>
															<span class="posted-main-warta"><i class="fa fa-clock-o margin-right-5"></i><?php echo date('d M Y H:i',strtotime($wrt->post_modify_date));?></span>
														</div>
													</li>
													<?php
														break;
														}
													?>
													
													<?php 
														$i = 1;
														foreach($get_warta->result() as $wrt){
														if($i == 1){
															$i++;
														}else{
													?>
													<li class="list-warta">
														<div class="box-list-warta">
															<img class="img-list-warta" src="<?php echo base_url();?>uploads/post/original/<?php echo $wrt->post_thumb;?>" alt="">
															<div class="box-list-desc">
																<h2 class="title-warta padding-right-0"><a style="float:left;width:100%" class="hover" href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $wrt->post_url;?>"><?php echo substr($wrt->post_title, 0,45).'...';?></a></h2>
															</div>
														</div>
													</li>
													<?php
														}
														}
													?>
												</ul>
											</div>
											
											<div class="advertisement padding-full-0 img-adv-full adv-side-content-left">
												<div class="desktop-advert">
													<?php 
														foreach($query_adv->result() as $pop){
															if($pop->position_id == 'PSB00007'){
													?>
													<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									                <?php 
															}
														}
													?>
												</div>
											</div>
										</div>
										
										
									</div>
									</section>
									<div class="col-xs-7 col-sm-8 col-md-8 div-berita">
										<div class="margin-top-10 box-berita" id="content">
											<div class="title-section margin-top-10-minus orange-title">
												<h1><span class="world del-border">Berita</span></h1>
											</div>
											<div class="container-berita">
											<?php 
												$i = 1;
												$limit = 0;
												$limit_adv = 0;
												$offset = 1;
												//$offset2 = 11;
												foreach($get_list->result() as $li){
													if($i == 2){
														$get_adv = $this->db->query("select * from sk_post, sk_profile_back, sk_category,sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00001' and sk_post.post_status='1' order by post_modify_date desc limit $limit, $offset");
														foreach($get_adv->result() as $list){
											?>
											<div class="news-post article-post list-adventorial margin-bottom-0 box1">
												<div class="row">
													<div class="col-xs-4 col-sm-3 col-md-3 padding-right-0">
														<div class="post-gallery">
															<div class="background-img-berita" style="background-size:cover;background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $list->post_thumb;?>');"></div>
															<!--<img alt="" src="<?php //echo base_url();?>uploads/post/original/<?php //echo $list->post_thumb;?>">-->
														</div>
													</div>
													<div class="col-xs-8 col-sm-9 col-md-9">
														<div class="post-content">
															<h2><a class="hover-black" href="<?php echo $list->post_direct == '1'?$list->post_url:base_url().'index.php/berita/artikel/'.$list->post_url;?>"><?php echo $list->post_title;?></a></h2>
															<ul class="post-tags">
																<li><span class="category-label">Advertorial</span></li>
																<li style="color:#fff;"><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($list->post_modify_date));?></li>
																<!--<li style="color:#fff;"><i class="fa fa-user"></i>by <a href="#"><?php echo $list->profile_back_name_full;?></a></li>-->
															</ul>
															<p class="desc"><?php echo substr($list->post_shrt_desc,0,85).'...';?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="news-post article-post list-regular margin-bottom-0 box1">
												<div class="row">
													<div class="col-xs-4 col-sm-3 col-md-3 padding-right-0">
														<div class="post-gallery">
															<div class="background-img-berita" style="background-size:cover;background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $li->post_thumb;?>');"></div>
															
															<!--<img alt="" src="<?php //echo base_url();?>uploads/post/original/<?php //echo $list->post_thumb;?>">-->
														</div>
													</div>
													<div class="col-xs-8 col-sm-9 col-md-9">
														<div class="post-content">
															<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $li->post_url;?>"><?php echo $li->post_title;?></a></h2>
															<ul class="post-tags">
																<li><span class="category-label"><a style="color:#FD8E23;" href="<?php echo base_url();?>index.php/berita/key_index/<?php echo $li->kanal_name;?>"><?php echo $li->kanal_name;?></a></span></li>
																<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($li->post_modify_date));?></li>
																<!--<li><i class="fa fa-user"></i>by <a href="#"><?php echo $li->profile_back_name_full;?></a></li>-->
															</ul>
															<p class="desc"><?php echo substr($li->post_shrt_desc,0,85).'...';?></p>
														</div>
													</div>
												</div>
											</div>
											<?php
														}
														$limit++;
														$i++;
													}
													else if(($i % 5) == 0){
														$get_adv = $this->db->query("select * from sk_post, sk_profile_back, sk_category,sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00001' and sk_post.post_status='1' order by post_modify_date desc limit $limit, $offset");
														foreach($get_adv->result() as $list){
											?>
											<div class="news-post article-post list-adventorial margin-bottom-0 box1">
												<div class="row">
													<div class="col-xs-4 col-sm-3 col-md-3 padding-right-0">
														<div class="post-gallery">
															<div class="background-img-berita" style="background-size:cover;background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $list->post_thumb;?>');"></div>
															<!--<img alt="" src="<?php //echo base_url();?>uploads/post/original/<?php //echo $list->post_thumb;?>">-->
														</div>
													</div>
													<div class="col-xs-8 col-sm-9 col-md-9">
														<div class="post-content">
															<h2><a class="hover-black" href="<?php echo $list->post_direct == '1'?$list->post_url:base_url().'index.php/berita/artikel/'.$list->post_url;?>"><?php echo $list->post_title;?></a></h2>
															<ul class="post-tags">
																<li><span class="category-label">Advertorial</span></li>
																<li style="color:#fff;"><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($list->post_modify_date));?></li>
																<!--<li style="color:#fff;"><i class="fa fa-user"></i>by <a href="#"><?php echo $list->profile_back_name_full;?></a></li>-->
															</ul>
															<p class="desc"><?php echo substr($list->post_shrt_desc,0,85).'...';?></p>
														</div>
													</div>
												</div>
											</div>
											<div class="news-post article-post list-regular margin-bottom-0 box1">
												<div class="row">
													<div class="col-xs-4 col-sm-3 col-md-3 padding-right-0">
														<div class="post-gallery">
															<div class="background-img-berita" style="background-size:cover;background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $li->post_thumb;?>');"></div>
															
															<!--<img alt="" src="<?php //echo base_url();?>uploads/post/original/<?php //echo $list->post_thumb;?>">-->
														</div>
													</div>
													<div class="col-xs-8 col-sm-9 col-md-9">
														<div class="post-content">
															<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $li->post_url;?>"><?php echo $li->post_title;?></a></h2>
															<ul class="post-tags">
																<li><span class="category-label"><a style="color:#FD8E23;" href="<?php echo base_url();?>index.php/berita/key_index/<?php echo $li->kanal_name;?>"><?php echo $li->kanal_name;?></a></span></li>
																<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($li->post_modify_date));?></li>
																<!--<li><i class="fa fa-user"></i>by <a href="#"><?php echo $li->profile_back_name_full;?></a></li>-->
															</ul>
															<p class="desc"><?php echo substr($li->post_shrt_desc,0,85).'...';?></p>
														</div>
													</div>
												</div>
											</div>
											<?php
														}
														$limit++;
													$i++;
													}else if(($i % 7) == 0){
														$get_adv = $this->db->query("select * from sk_adv where position_id='PSB00015' and adv_status='1' order by ObjectID desc limit $limit_adv, $offset");
														foreach($get_adv->result() as $adv){
											?>
											<div class="news-post article-post box1" style="padding:10px;margin-bottom:0;background-color:#f6f6f6;">
												<a href="<?php echo $adv->adv_link;?>"><img src="<?php echo base_url();?>uploads/advertise/original/<?php echo $adv->adv_pict;?>" /></a>
											</div>
											<div class="news-post article-post list-regular margin-bottom-0 box1">
												<div class="row">
													<div class="col-xs-4 col-sm-3 col-md-3 padding-right-0">
														<div class="post-gallery">
															<div class="background-img-berita" style="background-size:cover;background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $li->post_thumb;?>');"></div>
															
															<!--<img alt="" src="<?php //echo base_url();?>uploads/post/original/<?php //echo $list->post_thumb;?>">-->
														</div>
													</div>
													<div class="col-xs-8 col-sm-9 col-md-9">
														<div class="post-content">
															<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $li->post_url;?>"><?php echo $li->post_title;?></a></h2>
															<ul class="post-tags">
																<li><span class="category-label"><a style="color:#FD8E23;" href="<?php echo base_url();?>index.php/berita/key_index/<?php echo $li->kanal_name;?>"><?php echo $li->kanal_name;?></a></span></li>
																<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($li->post_modify_date));?></li>
																<!--<li><i class="fa fa-user"></i>by <a href="#"><?php echo $li->profile_back_name_full;?></a></li>-->
															</ul>
															<p class="desc"><?php echo substr($li->post_shrt_desc,0,85).'...';?></p>
														</div>
													</div>
												</div>
											</div>
											<?php
														}
														$limit_adv++;
													$i++;
													}else{
											?>
											<div class="news-post article-post list-regular margin-bottom-0 box1">
												<div class="row">
													<div class="col-xs-4 col-sm-3 col-md-3 padding-right-0">
														<div class="post-gallery">
															<div class="background-img-berita" style="background-size:cover;background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $li->post_thumb;?>');"></div>
															
															<!--<img alt="" src="<?php //echo base_url();?>uploads/post/original/<?php //echo $list->post_thumb;?>">-->
														</div>
													</div>
													<div class="col-xs-8 col-sm-9 col-md-9">
														<div class="post-content">
															<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $li->post_url;?>"><?php echo $li->post_title;?></a></h2>
															<ul class="post-tags">
																<li><span class="category-label"><a style="color:#FD8E23;" href="<?php echo base_url();?>index.php/berita/key_index/<?php echo $li->kanal_name;?>"><?php echo $li->kanal_name;?></a></span></li>
																<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($li->post_modify_date));?></li>
																<!--<li><i class="fa fa-user"></i>by <a href="#"><?php echo $li->profile_back_name_full;?></a></li>-->
															</ul>
															<p class="desc"><?php echo substr($li->post_shrt_desc,0,85).'...';?></p>
														</div>
													</div>
												</div>
											</div>
											<?php
													$i++;
													}
												}
											?>
											</div>
										</div>
										<div class="center-button margin-0 margin-top-10 margin-bottom-10">
											<a href="<?php echo base_url().'index.php/berita/key_index/Nasional/';?>" id="no-more" class="no-more"><i class="fa fa-refresh"></i> More News</a>
											<a href="#" id="more" style="background-color:#FD8E23;color:#fff;border-color:#FD8E23;"><i class="fa fa-spinner fa-spin"></i> Load Data</a>
											
											<input type="hidden" id="first" value="14" />
											<input type="hidden" id="limit" value="5" >
											
											<input type="hidden" id="first1" value="3" />
											<input type="hidden" id="limit1" value="1" >
											
											<input type="hidden" id="first2" value="2" />
											<input type="hidden" id="limit2" value="1" >
										</div>
									</div>
								</div>
							</div>
							<!-- End grid-box -->
							
						</div>
						<!-- End block content -->
					</div>

					<div class="col-xs-5 col-sm-4 col-md-3 side-right" id="right-side">

						<!-- sidebar -->
						<div class="sidebar" id="sidebar">

							<div class="advertisement padding-full-0 img-adv-full">
								<div class="desktop-advert">
									<?php 
										foreach($query_adv->result() as $pop){
											if($pop->position_id == 'PSB00008'){
									?>
									<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									<?php 
											}
										}
									?>
								</div>
							</div>

							<div class="widget tab-posts-widget widget-popular">

								<ul class="nav nav-tabs" id="myTab">
									<li class="active">
										<a href="#option1" data-toggle="tab" style="font-size:12px;">Most Popular</a>
									</li>
									<li>
										<a href="#option2" data-toggle="tab" style="font-size:12px;">Most Commented</a>
									</li>
								</ul>

								<div class="tab-content">
									<div class="tab-pane active" id="option1">
										<ul class="list-posts">
											<?php 
												foreach($get_popular->result() as $pop){
											?>
											<li>
												<div class="post-content">
													<h2><a href="<?php echo base_url();?>index.php/berita/artikel/<?php echo $pop->post_url;?>"><?php echo $pop->post_title;?></a></h2>
													<ul class="post-tags">
														<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i', strtotime($pop->post_modify_date));?></li>
													</ul>
												</div>
											</li>
											<?php 
												}
											?>
										</ul>
									</div>
									<div class="tab-pane" id="option2">
										<ul class="list-posts">
											<?php 
												foreach($get_commended->result() as $com){
											?>
											<li>
												<div class="post-content">
													<h2><a href="<?php echo base_url();?>index.php/berita/artikel/<?php echo $com->post_url;?>"><?php echo $com->post_title;?></a></h2>
													<ul class="post-tags">
														<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i', strtotime($com->post_modify_date));?></li>
													</ul>
												</div>
											</li>
											<?php 
												}
											?>
										</ul>										
									</div>
								</div>
							</div>

							<div class="advertisement padding-full-0 img-adv-full">
								<div class="desktop-advert">
									<?php 
										foreach($query_adv->result() as $pop){
											if($pop->position_id == 'PSB00009'){
									?>
									<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									<?php 
											}
										}
									?>
								</div>
							</div>
							
							<div class="widget post-widget widget-popular">
								<div class="title-section margin-top-0 title-video">
									<h1><span class="world blue-title">Video</span></h1>
								</div>
								<?php
								    if($get_video->num_rows() == 0){
								        
								    }else{
								        foreach($get_video->result() as $vd){
								?>
								<div class="news-post video-post" style="margin-bottom:5px;">
									<iframe width="100%" height="250px" src="<?php echo $vd->video_link;?>" frameborder="0" allowfullscreen></iframe>
									<a href="<?php echo $vd->video_link;?>" class="video-link"><i class="fa fa-play-circle-o"></i></a>
									<div class="hover-box">
										<h2><a href="<?php echo base_url().'index.php/berita/video_detail/'.$vd->video_url;?>"><?php echo $vd->video_title;?></a></h2>
										<ul class="post-tags">
											<li><i class="fa fa-clock-o"></i><?php echo date('d M Y, H:i',strtotime($vd->video_modify_date));?></li>
										</ul>
									</div>
								</div>
								<?php 
								        }
								    }
								?>
							</div>
							
							<div class="widget post-widget widget-popular">
								<div class="title-section margin-top-0 title-video">
									<h1><span class="world blue-title">Civil Journalism</span></h1>
								</div>
								<div class="news-post image-post2 background-white">
									<?php 
										foreach($get_civil->result() as $cvl){
									?>
									<div class="news-post article-post margin-bottom-5">
										<div class="row">
											<div class="col-sm-12">
												<div class="post-gallery">
													<img alt="" src="<?php echo base_url();?>uploads/post/original/<?php echo $cvl->post_thumb;?>">
												</div>
											</div>
											<div class="col-sm-12">
												<div class="post-content">
													<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $cvl->post_url;?>"><?php echo $cvl->post_title;?></a></h2>
													<ul class="post-tags">
														<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($cvl->post_modify_date));?></li>
														<li><i class="fa fa-user"></i>by <a href="#"><?php echo $cvl->profile_back_name_full;?></a></li>
													</ul>
													<p><?php echo substr($cvl->post_shrt_desc,0,150).'...';?></p>
												</div>
											</div>
										</div>
									</div>
									<?php
										}
									?>
								</div>
							</div>		
							
							<div class="advertisement padding-full-0 img-adv-full">
								<div class="desktop-advert">
									<?php 
										foreach($query_adv->result() as $pop){
											if($pop->position_id == 'PSB00010'){
									?>
									<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									<?php 
											}
										}
									?>
								</div>
							</div>
							
							<div class="widget recent-comments-widget widget-popular" id="sorot-berita">
								<div class="title-section margin-top-0 title-video">
									<h1><span class="world blue-title">Sorot Berita</span></h1>
								</div>
								<div class="news-post image-post2 background-white">
									<div class="news-post article-post" data-num="1">
											<?php 
												$s = 1;
												foreach($get_sorot->result() as $sor){
											?>
											<div class="row">
												<div class="col-xs-3 col-sm-3 col-md-3">
													<div class="padding-left-40p">
														<div class="numb-sorot"><?php echo $s++;?></div>
													</div>
												</div>
												<div class="col-xs-9 col-sm-9 col-md-9 padding-left-0" style="margin-top:12px;">
													<div>
														<p class="desc-sorot">
															<a class="hover" href="<?php echo base_url();?>index.php/berita/tag/<?php echo $sor->tag_name; ?>"><?php echo $sor->tag_name;?></a>
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
				</div>
			</div>
		</section>
		<!-- End block-wrapper-section -->
		