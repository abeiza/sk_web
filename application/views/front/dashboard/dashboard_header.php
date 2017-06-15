<!-- Header
		    ================================================== -->
		<header class="clearfix second-style">
			<!-- Bootstrap navbar -->
			<nav class="navbar navbar-default navbar-static-top" role="navigation">

				
				<!-- Logo & advertisement -->
				<div class="logo-advertisement">
					<div class="container padding-0 background-theme">

						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header col-md-4 padding-0">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							<a class="navbar-brand logo-sk padding-brand-extends" href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/img/logo.png" alt=""></a>
						</div>

						<div class="advertisement advertisement-extends col-md-8 padding-0">
							<div class="desktop-advert img-full-width">
							        <?php 
										foreach($query_adv->result() as $pop){
											if($pop->position_id == 'PSB00012'){
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
				<!-- End Logo & advertisement -->
				<!-- navbar list container -->
				<div class="nav-list-container">
					<div class="container container-extends padding-0">
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse">
							<ul class="nav navbar-left" id="navbar">
								<li><a class="world" href="<?php echo base_url();?>">Home</a></li>
								<?php 
									if($get_menu->num_rows() < 1){
										
									}else{
										foreach($get_menu->result() as $mnu){
								?>
								<li><a class="world" href="index.html"><?php echo $mnu->menu_label;?></a></li>
								<?php 
										}
									}
								?>
								<li class="drop-down"><a class="world" href="<?php echo base_url();?>">Gallery</a>
									<ul class="dropdown-list">
										<li><a href="index.html">Gambar</a></li>
										<li><a href="home2.html">Video</a></li>
									</ul>
								</li>
							</ul>
						</div>
						<!-- /.navbar-collapse -->
					</div>
				</div>
				
				<!-- heading-news-section2
			================================================== -->
				<section class="heading-news2 nav-list-container">

					<div class="container container-extends">
						
						<div class="ticker-news-box ">
							<span class="breaking-news">breaking news</span>
							<ul id="js-news">
								<?php 
											if($get_break->num_rows() < 1){
												
											}else{
												foreach($get_break->result() as $break){
										?>
								<li class="news-item"><span class="time-news"><?php echo date('H:i', strtotime($break->post_modify_date))?></span>  <a href="#"><?php echo $break->post_title;?></li>
								<?php 
												}
											}
								?>
							</ul>
						</div>
					</div>

				</section>
		
				<div class="menu-kanal">
					<ul>
						<?php 
							if($get_menu->num_rows() < 1){
								
							}else{
								foreach($get_menu->result() as $mnu){
						?>
						<li><a class="link"><?php echo $mnu->menu_label;?></a></li>
						<?php 
								}
							}
						?>
					</ul>
				</div>

				<!-- End navbar list container -->

			</nav>
			<!-- End Bootstrap navbar -->

		</header>
		<!-- End Header -->