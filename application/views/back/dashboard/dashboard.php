            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	        <script type="text/javascript">
    			$(function(){
    				$('#container1').highcharts({
    					title: {
    						text: 'HIT Counter by Browser',
    						x: -20 //center
    					},
    					subtitle: {
    						text: 'www.suarakaryanews.com',
    						x: -20
    					},
    					xAxis: {
    						categories: [<?php 
    						$categories = null;
    						$query = $this->db->query("select distinct date(counter_date) as Tgl from sk_log_counter where date(counter_date) >= subdate(date(now()),INTERVAL 10 DAY) order by date(counter_date) desc");
    						foreach($query->result() as $db){
    							$categories .= "'".date('d M',strtotime($db->Tgl))."',";
    						}
    						echo $categories;
    				?>]
    					},
    					yAxis: {
    						title: {
    							text: 'HIT (Click)'
    						},
    						plotLines: [{
    							value: 0,
    							width: 1,
    							color: '#808080'
    						}]
    					},
    					tooltip: {
    						valueSuffix: ' sessions'
    					},
    					legend: {
    						layout: 'horizontal',
    						align: 'center',
    						verticalAlign: 'bottom',
    						borderWidth: 1
    					},
    					series: [<?php 
    						$status = array('Chrome/Opera','Firefox','IE','');
    						foreach($status as $st){
    							echo "{ 
    							name:"; 
    							if($st == 'Chrome/Opera'){
    								echo "'Chrome/Opera' ,";
    							}else if($st == 'Firefox'){
    								echo "'Firefox' ,";
    							}else if($st == 'IE'){
    								echo "'IE' ,";
    							}else{
    								echo "'Others' ,";
    							}
    							$query = $this->db->query("select distinct date(counter_date) as Tgl from sk_log_counter where date(counter_date) >= subdate(date(now()),INTERVAL 10 DAY) order by date(counter_date) desc");
    							echo "
    							data: [";
    							foreach($query->result() as $db){
    								$query2 = $this->db->query("select count(ObjectID) as jumlah from sk_log_counter where date(counter_date) = '".$db->Tgl."' and counter_browser='".$st."'");
    								foreach($query2->result() as $db2){
    									echo $db2->jumlah.',';
    								}
    							}
    							echo "]";
    							echo "
    							},
    							";
    						}
    					?>]
    				});
    			});
    		</script>
	        <script src="<?php echo base_url();?>assets/highchart/js/highcharts.js"></script>
	        <script src="<?php echo base_url();?>assets/highchart/js/modules/exporting.js"></script>
            <main class="mn-inner inner-active-sidebar" style="background-color:#f1f1f1;">
                <div class="middle-content">
                    <div class="row no-m-t no-m-b">
                    <div class="col s12 m12 l3">
                        <div class="card stats-card">
                            <div class="card-content">
                                <span class="card-title">GUEST</span>
                                <span class="stats-counter"><span class="counter"><?php echo $c_counter->num_rows();?></span><small>This week</small></span>
                            </div>
                            <div id="sparkline-bar"><canvas width="254" height="40" style="display: inline-block; width: 254px; height: 40px; vertical-align: top;"></canvas></div>
                        </div>
                    </div>
                        <div class="col s12 m12 l3">
                        <div class="card stats-card">
                            <div class="card-content">
                                <span class="card-title">POSTING</span>
                                <span class="stats-counter"><span class="counter"><?php echo $c_post->num_rows();?></span><small>This month</small></span>
                            </div>
                            <div id="sparkline-line"><canvas width="269" height="45" style="display: inline-block; width: 269px; height: 45px; vertical-align: top;"></canvas></div>
                        </div>
                    </div>
                    <div class="col s12 m12 l3">
                        <div class="card stats-card">
                            <div class="card-content">
                                <span class="card-title">PHOTOS</span>
                                <span class="stats-counter"><span class="counter"><?php echo $c_pict->num_rows();?></span><small>This month</small></span>
                            </div>
                            <div class="progress stats-card-progress">
                                <div class="determinate" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l3">
                        <div class="card stats-card">
                            <div class="card-content">
                                <span class="card-title">VIDEOS</span>
                                <span class="stats-counter"><span class="counter"><?php echo $c_video->num_rows();?></span><small>This month</small></span>
                            </div>
                            <div class="progress stats-card-progress">
                                <div class="determinate" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row no-m-t no-m-b">
                        <div class="col s12 m12 l8">
                            <div class="card visitors-card">
                                <div class="card-content">
                                    <span class="card-title">Statistic Guest<span class="secondary-title">Showing stats from the last week</span></span>
                                    <div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto;background-color:#fff;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m12 l4">
                            <div class="card server-card">
                                <div class="card-content">
                                <div class="card-options">
                                    <ul>
                                        <li class="red-text"><span class="badge blue-grey lighten-3">This Month</span></li>
                                    </ul>
                                </div>
                                    <span class="card-title">Trading Browser</span>
                                    <div class="server-load row">
                                        <div class="server-stat col s4">
                                            <p><?php echo number_format($c_browser_all->num_rows(),0);?></p>
                                            <span>Total Session</span>
                                        </div>
                                        <!--<div class="server-stat col s4">
                                            <p>320GB</p>
                                            <span>Space</span>
                                        </div>
                                        <div class="server-stat col s4">
                                            <p>57.4%</p>
                                            <span>CPU</span>
                                        </div>-->
                                    </div>
                                    <div class="stats-info">
                                        <ul>
                                            <li>Mozilla Firefox<div class="percent-info green-text right"><?php echo number_format($c_browser_firefox->num_rows(),0);?></div></li>
                                            <li>Chrome / Opera<div class="percent-info green-text right"><?php echo number_format($c_browser_chrome->num_rows(),0);?></div></li>
                                            <li>Internet Exprorer<div class="percent-info green-text right"><?php echo number_format($c_browser_ie->num_rows(),0);?></div></li>
                                            <li>Others<div class="percent-info green-text right"><?php echo number_format($c_browser_others->num_rows(),0);?></div></li>
                                        </ul>
                                    </div>
                                    <!--<div id="flotchart2" style="padding: 0px; position: relative;"><canvas class="flot-base" width="225" height="120" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 225px; height: 120px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 37px; top: 103px; left: 15px; text-align: center;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 37px; top: 103px; left: 51px; text-align: center;">10</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 37px; top: 103px; left: 91px; text-align: center;">20</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 37px; top: 103px; left: 131px; text-align: center;">30</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 37px; top: 103px; left: 171px; text-align: center;">40</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 37px; top: 103px; left: 211px; text-align: center;">50</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 90px; left: 6px; text-align: right;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 60px; left: 0px; text-align: right;">25</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 30px; left: 0px; text-align: right;">50</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 1px; left: 0px; text-align: right;">75</div></div></div><canvas class="flot-overlay" width="225" height="120" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 225px; height: 120px;"></canvas></div>
                                -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-m-t no-m-b">
                        <div class="col s12 m12 l12">
                            <div class="card invoices-card">
                                <div class="card-content">
                                <span class="card-title">LAST POSTING</span>
                                <table class="responsive-table bordered">
                                    <thead>
                                        <tr>
                                            <th data-field="title">Title</th>
                                            <th data-field="kanal">Kanal</th>
                                            <th data-field="posted">Posted</th>
                                            <th data-field="date">Date</th>
                                            <th data-field="status">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($list_posted->result() as $pst){
                                        ?>
                                            <tr>
                                                <td><?php echo $pst->post_title;?></td>
                                                <td><?php echo $pst->kanal_name;?></td>
                                                <td><?php echo $pst->user_back_name;?></td>
                                                <td><?php echo date('d-m-Y H:s:i', strtotime($pst->post_modify_date));?></td>
                                                <td><?php 
                                                    if($pst->post_status == '1'){
                                                        echo 'publish';
                                                    }else if($pst->post_status == '0'){
                                                        echo 'draft';
                                                    }else{
                                                        echo 'spam';
                                                    }
                                                ?></td>
                                            </tr>
                                        <?php 
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="inner-sidebar">
                    
                    <span class="inner-sidebar-title">Last Comments</span>
                    <div class="message-list">
                    <?php 
                        foreach($comment->result() as $cmd){
                    ?>
                        <div class="info-item message-item">
                            <a href="<?php echo base_url().'index.php/back/comments/list_comments/'.$cmd->post_id;?>">
                            <?php if ($cmd->guest_profile_pict == '' or $cmd->guest_profile_pict == null){?>
                            <img class="circle" src="<?php echo base_url().'assets/img/profile-image.png';?>" alt="">
                            <?php }else if(substr($cmd->guest_profile_pict,0,4) == 'http'){?>
                            <img class="circle" src="<?php echo $cmd->guest_profile_pict;?>" alt="">
                            <?php }else{?>
                            <img class="circle" src="<?php echo base_url().'uploads/user/original/'.$cmd->guest_profile_pict;?>" alt="">
                            <?php }?>
                            <div class="message-info">
                                <div class="message-author"><?php echo $cmd->guest_name;?></div>
                                <small><?php echo date('d-m-Y', strtotime($cmd->comment_post_date));?></small>
                            </div>
                            </a>
                        </div>
                    <?php
                        }
                    ?>
                    </div>
                    
                    <span class="inner-sidebar-title">Counter Hit</span>
                    <span class="info-item">Today<span class="new badge"><?php echo number_format($today->num_rows(),0);?></span></span>
                    <div class="inner-sidebar-divider"></div>
                    <span class="info-item">Yesterday<span class="new badge"><?php echo number_format($yesterday->num_rows(),0);?></span></span>
                    <div class="inner-sidebar-divider"></div>
                    <span class="info-item">This Week<span class="new badge"><?php echo number_format($this_week->num_rows(),0);?></span></span>
                    <div class="inner-sidebar-divider"></div>
                    <span class="info-item">Last Week<span class="new badge"><?php echo number_format($last_week->num_rows(),0);?></span></span>
                    <div class="inner-sidebar-divider"></div>
                    <span class="info-item">This Month<span class="new badge"><?php echo number_format($this_month->num_rows(),0);?></span></span>
                    <div class="inner-sidebar-divider"></div>
                    <span class="info-item">Last Month<span class="new badge"><?php echo number_format($last_month->num_rows(),0);?></span></span>
                    <div class="inner-sidebar-divider"></div>
                    <span class="info-item">All<span class="new badge"><?php echo number_format($all->num_rows(),0);?></span></span>
                    <div class="inner-sidebar-divider"></div>
                    
                    <span style="display:none;" class="inner-sidebar-title">Stats <i class="material-icons">trending_up</i></span>
                    <div style="display:none;" class="sidebar-radar-chart"><canvas id="radar-chart" width="170" height="140" style="width: 170px; height: 140px;"></canvas></div>
                </div>
            </main>
            