<div class="mn-content fixed-sidebar">
            <header class="mn-header navbar-fixed">
                <nav class="cyan darken-1">
                    <div class="nav-wrapper row">
                        <section class="material-design-hamburger navigation-toggle">
                            <a href="javascript:void(0)" data-activates="slide-out" class="show-on-large material-design-hamburger__icon reverse-icon">
                                <span class="material-design-hamburger__layer"></span>
                            </a>
                        </section>
                        <div class="header-title col s3 m3 desktop-ver">      
                            <span class="chapter-title">Suarakaryanews.com</span>
                        </div>
                        <div class="header-title col s3 m3 mobile-ver">      
                            <span class="chapter-title">SK</span>
                        </div>
						<style>
							::-webkit-input-placeholder { /* WebKit, Blink, Edge */
								color:    green !important;
							}
							:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
							   color:    green !important;
							   opacity:  1;
							}
							::-moz-placeholder { /* Mozilla Firefox 19+ */
							   color:    green !important;
							   opacity:  1;
							}
							:-ms-input-placeholder { /* Internet Explorer 10-11 */
							   color:    green !important;
							}
						</style>
                        <form class="left search col s6 hide-on-small-and-down">
                            <div class="input-field">
                                <input id="search" type="search" placeholder="" autocomplete="off">
                                <label for="search" class="active"><i class="material-icons search-icon">search</i></label>
                            </div>
                            <a href="javascript: void(0)" class="close-search"><i class="material-icons">close</i></a>
                        </form>
						<ul class="right col s9 m3 nav-right-menu">
                            <li>
								<a class="waves-effect waves-grey btn-flat" href="<?php echo base_url();?>index.php/back/login/logout_act/">Sign Out</a>
							</li>
						</ul>
                    </div>
                </nav>
            </header>
			<aside id="slide-out" class="side-nav white fixed">
                <div class="side-nav-wrapper">
                    <div class="sidebar-profile">
                        <div class="sidebar-profile-image">
							<?php 
								if($pict == '' or $pict == null){
							?>
									 <img src="<?php echo base_url();?>assets/img/profile-image.png" class="circle" alt="">
							<?php
								}else{
							?>
									<img src="<?php echo base_url();?>uploads/profile/<?php echo $pict;?>" class="circle" alt="">
							<?php		
								}
							?>
                        </div>
                        <div class="sidebar-profile-info">
                            <a href="javascript:void(0);" class="account-settings-link">
                                <p><?php echo $nick;?> (<?php 
								$lv_qry = $this->db->query("select level_name from sk_level where level_id='".$this->session->userdata('lv')."'"); 
								foreach($lv_qry->result() as $lvl){
									echo $lvl->level_name;
								}
								?>)</p>
                                <span><?php echo $email;?><i class="material-icons right">arrow_drop_down</i></span>
                            </a>
                        </div>
                    </div>
                    <div class="sidebar-account-settings" style="display: none;">
                        <ul>
                            <li class="no-padding">
                                <a class="waves-effect waves-grey"><i class="material-icons">edit</i>Profile</a>
                            </li>
                            <li class="no-padding">
                                <a class="waves-effect waves-grey"><i class="material-icons">lock</i>Privacy Account</a>
                            </li>
                            <li class="divider"></li>
                            <li class="no-padding">
                                <a href="<?php echo base_url();?>index.php/back/login/logout_act/" class="waves-effect waves-grey"><i class="material-icons">exit_to_app</i>Sign Out</a>
                            </li>
                        </ul>
                    </div>
                <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
                    <li class="no-padding <?php if($this->uri->segment(2) == 'dashboard') echo 'active';?>"><a href="<?php echo base_url().'index.php/back/dashboard/';?>" class="waves-effect waves-grey <?php if($this->uri->segment(2) == 'dashboard') echo 'active';?>" href="http://steelcoders.com/alpha/v1.2/index.html"><i class="material-icons">dashboard</i>Dashboard</a></li>
                    <?php 
					if($this->session->userdata('lv') == 'POT00001'){
					?>
					<li class="no-padding <?php if($this->uri->segment(2) == 'kanal') echo 'active';?>"><a href="<?php echo base_url().'index.php/back/kanal/';?>" class="collapsible-header waves-effect waves-grey <?php if($this->uri->segment(2) == 'kanal') echo 'active';?>"><i class="material-icons">subtitles</i>Kanal</a></li>
					<?php
					}
					?><li class="no-padding <?php if($this->uri->segment(2) == 'category' or $this->uri->segment(2) == 'tag' or $this->uri->segment(2) == 'page' or $this->uri->segment(2) == 'posting') echo 'active';?>">
                        <a class="collapsible-header waves-effect waves-grey <?php if($this->uri->segment(2) == 'category' or $this->uri->segment(2) == 'tag' or $this->uri->segment(2) == 'page' or $this->uri->segment(2) == 'posting') echo 'active';?>"><i class="material-icons">description</i>News<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                        <div class="collapsible-body" style="">
                            <ul>
                                <li><a href="<?php echo base_url().'index.php/back/category/';?>">Category</a></li>
                                <li><a href="<?php echo base_url().'index.php/back/tag/';?>">Tag</a></li>
								<li><a href="<?php echo base_url().'index.php/back/posting/';?>">Post</a></li>
								<li><a href="<?php echo base_url().'index.php/back/page/';?>">Page</a></li>
                            </ul>
                        </div>
                    </li>
					<li class="no-padding <?php if($this->uri->segment(2) == 'video' or $this->uri->segment(2) == 'photo') echo 'active';?>">
                        <a class="collapsible-header waves-effect waves-grey <?php if($this->uri->segment(2) == 'video' or $this->uri->segment(2) == 'photo') echo 'active';?>"><i class="material-icons">perm_media</i>Media<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                        <div class="collapsible-body" style="">
                            <ul>
                                <li><a href="<?php echo base_url().'index.php/back/video/';?>">Video</a></li>
                                <li><a href="<?php echo base_url().'index.php/back/photo/';?>">Photo</a></li>
                            </ul>
                        </div>
                    </li>
					<?php 
					if($this->session->userdata('lv') == 'POT00001' or $this->session->userdata('lv') == 'POT00003' ){
					?>
					<li class="no-padding <?php if($this->uri->segment(2) == 'comment') echo 'active';?>"><a href="<?php echo base_url().'index.php/back/comments/';?>" class="collapsible-header waves-effect waves-grey"><i class="material-icons">question_answer</i>Comments</a></li>
					<li class="no-padding <?php if($this->uri->segment(2) == 'advertisement' or $this->uri->segment(2) == 'menu') echo 'active';?>">
                        <a class="collapsible-header waves-effect waves-grey <?php if($this->uri->segment(2) == 'advertisement' or $this->uri->segment(2) == 'menu') echo 'active';?>"><i class="material-icons">view_quilt</i>Appearance<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                        <div class="collapsible-body" style="">
                            <ul>
                                <li><a href="<?php echo base_url().'index.php/back/advertisement/';?>">Advertisement List</a></li>
								<li><a href="<?php echo base_url().'index.php/back/adventorial/';?>">Advertorial List</a></li>
                                <li><a href="<?php echo base_url().'index.php/back/advertisement/layout/home/home/';?>">Advertisement Layout</a></li>
								<?php 
								if($this->session->userdata('lv') == 'POT00001'){
								?>
								<li><a href="<?php echo base_url().'index.php/back/menu/';?>">Menu</a></li>
								<?php 
								}
								?>
                            </ul>
                        </div>
                    </li>
                    <li class="no-padding <?php if($this->uri->segment(2) == 'comment') echo 'active';?>"><a href="<?php echo base_url().'index.php/back/storage/';?>" class="collapsible-header waves-effect waves-grey"><i class="material-icons">perm_media</i>Management File</a></li>
                    <li class="no-padding <?php if($this->uri->segment(2) == 'general' or $this->uri->segment(2) == 'users') echo 'active';?>">
                        <a class="collapsible-header waves-effect waves-grey <?php if($this->uri->segment(2) == 'general' or $this->uri->segment(2) == 'users') echo 'active';?>"><i class="material-icons">settings</i>Settings<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                        <div class="collapsible-body" style="">
                            <ul>
								<?php 
								if($this->session->userdata('lv') == 'POT00001'){
								?>
								<li><a href="<?php echo base_url().'index.php/back/general/';?>">General</a></li>
								<li><a href="<?php echo base_url().'index.php/back/contact/';?>">Contact</a></li>
								<?php 
								}
								?>
								<li><a href="<?php echo base_url().'index.php/back/users/';?>">Users</a></li>
								<?php 
								if($this->session->userdata('lv') == 'POT00001'){
								?>
                                <li><a href="<?php echo base_url().'index.php/back/users/role_access/';?>">Role Access</a></li>
								<?php 
								}
								?>
                            </ul>
                        </div>
                    </li>
					<?php 
					}
					?>
				</ul>
                <div class="footer">
                    <p class="copyright">suarakaryanews.com</p>
                    <a href="http://steelcoders.com/alpha/v1.2/index.html#!">Privacy</a> &amp; <a href="http://steelcoders.com/alpha/v1.2/index.html#!">Terms</a>
                </div>
                </div>
            </aside>
            