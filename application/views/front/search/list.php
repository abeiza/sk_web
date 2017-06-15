	<!-- block-wrapper-section
			================================================== -->
		<section class="block-wrapper">
			<div class="container">
				<div class="row"  id="block-container">
					<div class="col-xs-7 col-sm-8 col-md-9 artikel-desc">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 artikel-desc">
							<!-- grid box -->
							<div class="grid-box">
								<div class="title-section">
									<h1><span style="color:#333;text-transform:none !important;">Hasil Pencarian  "<?php echo $word;?>"</span></h1>
								</div>
								<?php foreach($get_data->result() as $list){?>
								<div class="news-post article-post list-regular margin-bottom-0 box1">
									<div class="row">
										<div class="col-xs-4 col-sm-3 col-md-3 padding-right-0">
											<div class="post-gallery">
												<div class="background-img-berita" style="margin:auto;background-image:url('<?php echo base_url();?>uploads/post/original/<?php echo $list->post_thumb;?>');"></div>
												
												<!--<img alt="" src="<?php //echo base_url();?>uploads/post/original/<?php //echo $list->post_thumb;?>">-->
											</div>
										</div>
										<div class="col-xs-8 col-sm-9 col-md-9">
											<div class="post-content">
												<h2><a href="<?php echo base_url()?>index.php/berita/artikel/<?php echo $list->post_url;?>"><?php echo $list->post_title;?></a></h2>
												<ul class="post-tags">
													<li><span class="category-label"><?php echo $list->kanal_name;?></span></li>
													<li><i class="fa fa-clock-o"></i><?php echo date('d M Y H:i',strtotime($list->post_modify_date));?></li>
													<li><i class="fa fa-user"></i>by <a href="#"><?php echo $list->profile_back_name_full;?></a></li>
												</ul>
												<p class="desc"><?php echo $list->post_shrt_desc;?></p>
											</div>
										</div>
									</div>
								</div>
								<?php }?>	
							</div>
							<!-- End grid box -->
							</div>
						</div>	
					</div>

					<div class="col-xs-5 col-sm-4 col-md-3 side-right">

						<!-- sidebar -->
						<div class="sidebar">

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
													<h2><a href="single-post.html"><?php echo $pop->post_title;?></a></h2>
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
													<h2><a href="single-post.html"><?php echo $com->post_title;?></a></h2>
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
											if($pop->position_id == 'PSB00008'){
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