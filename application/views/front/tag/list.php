<!-- block-wrapper-section
			================================================== -->
		<section class="block-wrapper margin-top-5">
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
											if($pop->position_id == 'PSB00008'){
									?>
									<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									<?php 
											}
										}
									?>
								</div>
							</div>
							
							<div class="widget recent-comments-widget widget-popular">
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
												
							<div class="advertisement padding-full-0 img-adv-full">
								<div class="desktop-advert">
									
									<img src="<?php echo base_url();?>uploads/advertise/original/olx_adv.png" class="img-full-width" alt="">
								</div>
								<div class="tablet-advert">
									
									<img src="<?php echo base_url();?>uploads/advertise/original/olx_adv.png" alt="">
								</div>
								<div class="mobile-advert">
									
									<img src="<?php echo base_url();?>uploads/advertise/original/olx_adv.png" alt="">
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
							
						</div>
						<!-- End sidebar -->

					</div>
					</section>
					<div class="col-xs-7 col-sm-8 col-md-9 artikel-desc">

						<!-- block content -->
						<div class="block-content">

							<!-- grid box -->
							<div class="grid-box">
								<div class="title-section">
									<h1><span>Tag : <?php echo urldecode($this->uri->segment(3));?></span></h1>
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
						<!-- End block content -->

					</div>
				</div>

			</div>
		</section>
		<!-- End block-wrapper-section -->