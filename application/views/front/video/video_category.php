<!-- block-wrapper-section
			================================================== -->
		<section class="block-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xs-7 col-sm-8 col-md-9 artikel-desc">

						<!-- block content -->
						<div class="block-content">

							<!-- grid box -->
							<div class="grid-box margin-bottom-5">
								<div class="title-section">
									<h1><span class="video">video pilihan</span></h1>
								</div>
								<?php 
									foreach($get_video_main->result() as $main){
								?>
								<div class="row margin-top-5">
									<div class="col-md-12">
										<div class="news-post video-post">
											<iframe width="100%" height="450" src="<?php echo $main->video_link?>" frameborder="0" allowfullscreen></iframe>
											<a href="<?php echo $main->video_link?>" class="video-link"><i class="fa fa-play-circle-o"></i></a>
											<div class="hover-box">
												<h2><a href="<?php echo base_url().'index.php/berita/video_detail/'.$main->video_url;?>"><?php echo $main->video_title?></a></h2>
												<ul class="post-tags">
													<li><i class="fa fa-clock-o"></i><?php echo date('d M Y', strtotime($main->video_modify_date))?></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<?php 
									}
								?>
							</div>
							<!-- End grid box -->
						
							<!-- grid box -->
							<div class="grid-box margin-bottom-5">
								<div class="title-section">
									<h1><span class="video">video Terbaru</span></h1>
								</div>

								<div class="row padding-left-5 padding-right-5">
									<?php 
										foreach($get_video_list1->result() as $vid){
									?>
									<div class="col-md-4 padding-full-5">
										<div class="news-post video-post">
											<iframe width="100%" src="<?php echo $vid->video_link?>" frameborder="0" allowfullscreen></iframe>
											<a href="<?php echo $vid->video_link?>" class="video-link"><i class="fa fa-play-circle-o"></i></a>
											<div class="hover-box">
												<h2><a href="<?php echo base_url().'index.php/berita/video_detail/'.$vid->video_url?>"><?php echo $vid->video_title?></a></h2>
												<ul class="post-tags">
													<li><i class="fa fa-clock-o"></i><?php echo date('d M Y', strtotime($vid->video_modify_date))?></li>
												</ul>
											</div>
										</div>
									</div>
									<?php 
										}
									?>
								</div>

							</div>
							<!-- End grid box -->

							<section>
								<div class="container padding-0">
									<!-- google addsense -->
									<div class="advertisement advertisement-extends margin-bottom-0">
										<div class="desktop-advert img-full-width margin-0">
											<?php 
											foreach($query_adv->result() as $pop){
												if($pop->position_id == 'PSB00013'){
											?>
											<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									        <?php 
													}
												}
											?>
										</div>
									</div>
									<!-- End google addsense -->
								</div>
							</section>

							<!-- grid box -->
							<div class="grid-box margin-bottom-5">
								<div class="row padding-left-5 padding-right-5">
									<?php 
										foreach($get_video_list2->result() as $vid2){
									?>
									<div class="col-md-4 padding-full-5">
										<div class="news-post video-post">
											<iframe width="100%" src="<?php echo $vid2->video_link?>" frameborder="0" allowfullscreen></iframe>
											<a href="<?php echo $vid2->video_link?>" class="video-link"><i class="fa fa-play-circle-o"></i></a>
											<div class="hover-box">
												<h2><a href="<?php echo base_url().'index.php/berita/video_detail/'.$vid2->video_url?>"><?php echo $vid2->video_title?></a></h2>
												<ul class="post-tags">
													<li><i class="fa fa-clock-o"></i><?php echo date('d M Y', strtotime($vid2->video_modify_date))?></li>
												</ul>
											</div>
										</div>
									</div>
									<?php 
										}
									?>
								</div>

							</div>
							<!-- End grid box -->

							<section>
								<div class="container padding-0">
									<!-- google addsense -->
									<div class="advertisement advertisement-extends margin-bottom-0">
										<div class="desktop-advert img-full-width margin-0">
											<?php 
											foreach($query_adv->result() as $pop){
												if($pop->position_id == 'PSB00014'){
											?>
											<a href="<?php echo $pop->adv_link;?>"><img style="width:100%;" src="<?php echo base_url();?>uploads/advertise/original/<?php echo $pop->adv_pict;?>" alt=""></a>
									        <?php 
													}
												}
											?>
										</div>
									</div>
									<!-- End google addsense -->
								</div>
							</section>

							<!-- grid box -->
							<div class="grid-box margin-bottom-5">
								<div class="row padding-left-5 padding-right-5">
									<?php 
										foreach($get_video_list3->result() as $vid3){
									?>
									<div class="col-md-4 padding-full-5">
										<div class="news-post video-post">
											<iframe width="100%" src="<?php echo $vid3->video_link?>" frameborder="0" allowfullscreen></iframe>
											<a href="<?php echo $vid3->video_link?>" class="video-link"><i class="fa fa-play-circle-o"></i></a>
											<div class="hover-box">
												<h2><a href="<?php echo base_url().'index.php/berita/video_detail/'.$vid3->video_url?>"><?php echo $vid3->video_title?></a></h2>
												<ul class="post-tags">
													<li><i class="fa fa-clock-o"></i><?php echo date('d M Y', strtotime($vid3->video_modify_date))?></li>
												</ul>
											</div>
										</div>
									</div>
									<?php 
										}
									?>
								</div>

							</div>
							
							<!-- pagination box -->
							<div class="pagination-box" style="text-align:center;">
								<a href="<?php echo base_url();?>index.php/berita/key_index_video/Nasional/" style="padding:5px 10px; border-radius:3px;background:#333;color:#fff;float:left;margin-bottom:10px;text-decoration:none;">More Video</a>
							</div>
							<!-- End Pagination box -->

						</div>
						<!-- End block content -->

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
														<li><i class="fa fa-clock-o"></i><?php echo date('d M Y', strtotime($pop->post_modify_date));?></li>
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
														<li><i class="fa fa-clock-o"></i><?php echo date('d M Y', strtotime($com->post_modify_date));?></li>
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