<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Dashboard extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
				foreach($query1->result() as $sess){
					$data['id'] = $sess->profile_back_id;
					$data['full'] = $sess->profile_back_name_full;
					$data['nick'] = $sess->profile_back_nick;
					$data['pict'] = $sess->profile_back_pict;
					$data['email'] = $sess->profile_back_email;
				}
				
				$data['c_post'] = $this->db->query("SELECT post_id FROM sk_post where Year(post_modify_date) = year(CURRENT_DATE()) and Month(post_modify_date) = month(CURRENT_DATE())");
				$data['c_pict'] = $this->db->query("SELECT pict_id FROM sk_photo where Year(pict_modify_date) = year(CURRENT_DATE()) and Month(pict_modify_date) = month(CURRENT_DATE())");
				$data['c_video'] = $this->db->query("SELECT video_id FROM sk_video where Year(video_modify_date) = year(CURRENT_DATE()) and Month(video_modify_date) = month(CURRENT_DATE())");
				$data['c_counter'] = $this->db->query("SELECT distinct counter_ip FROM sk_log_counter WHERE counter_date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND counter_date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY ORDER BY counter_date ASC");
				
				$data['comment'] = $this->db->query("select comment_id, comment_post_date, comment_text, post_id, guest_name, guest_profile_pict from sk_comment, sk_guest, sk_guest_profile where sk_guest.guest_profile_id=sk_guest_profile.guest_profile_id and sk_comment.guest_id = sk_guest.guest_id order by comment_id desc limit 5");
				
				$data['list_posted'] = $this->db->query("select post_id, post_title, post_shrt_desc, kanal_name, category_name, user_back_name, post_status, post_modify_date  
				from sk_post, sk_category, sk_user_back , sk_kanal 
				where sk_post.post_posted_by = '".$this->session->userdata('id')."' and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.flag_id = 'FLG00002' and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.category_id = sk_category.category_id 
				order by post_modify_date desc Limit 5 ");
				
				$data['today'] = $this->db->query("SELECT counter_ip, date(counter_date), count(ObjectID) as jml FROM sk_log_counter where date(counter_date) =  date(now()) group by counter_ip, date(counter_date)");
				$data['yesterday'] = $this->db->query("SELECT counter_ip, date(counter_date), count(ObjectID) as jml FROM sk_log_counter where date(counter_date) = subdate(date(now()),1) group by counter_ip, date(counter_date)");
				$data['this_week'] = $this->db->query("SELECT counter_ip, date(counter_date), count(ObjectID) as jml FROM sk_log_counter where WEEK(date(counter_date)) = WEEK(date(now())) group by counter_ip, date(counter_date)");
				$data['last_week'] = $this->db->query("SELECT counter_ip, date(counter_date), count(ObjectID) as jml FROM sk_log_counter where WEEK(date(counter_date)) = WEEK(subdate(date(now()),7)) group by counter_ip, date(counter_date)");
				$data['this_month'] = $this->db->query("SELECT counter_ip, date(counter_date), count(ObjectID) as jml FROM sk_log_counter where MONTH(date(counter_date))  = MONTH(date(now())) AND YEAR(date(counter_date)) = YEAR(date(now())) group by counter_ip, date(counter_date)");
				$data['last_month'] = $this->db->query("SELECT counter_ip, date(counter_date), count(ObjectID) as jml FROM sk_log_counter where YEAR(date(counter_date)) = YEAR(DATE_SUB(date(now()), interval 1 month)) AND MONTH(date(counter_date))  = MONTH(DATE_SUB(date(now()), interval 1 month)) group by counter_ip, date(counter_date)");
				$data['all'] = $this->db->query("SELECT counter_ip, date(counter_date), count(ObjectID) as jml FROM sk_log_counter group by counter_ip, date(counter_date)");
                
                $data['c_browser_firefox'] = $this->db->query("select ObjectID from sk_log_counter where counter_browser='Firefox' and (Year(counter_date) = year(CURRENT_DATE()) and Month(counter_date) = month(CURRENT_DATE()))");
                $data['c_browser_ie'] = $this->db->query("select ObjectID from sk_log_counter where counter_browser='IE' and (Year(counter_date) = year(CURRENT_DATE()) and Month(counter_date) = month(CURRENT_DATE()))");
                $data['c_browser_chrome'] = $this->db->query("select ObjectID from sk_log_counter where counter_browser='Chrome/Opera' and (Year(counter_date) = year(CURRENT_DATE()) and Month(counter_date) = month(CURRENT_DATE()))");
                $data['c_browser_others'] = $this->db->query("select ObjectID from sk_log_counter where counter_browser!='Chrome/Opera' and counter_browser!='IE' and counter_browser!='Firefox' and (Year(counter_date) = year(CURRENT_DATE()) and Month(counter_date) = month(CURRENT_DATE()))");
                $data['c_browser_all'] = $this->db->query("select ObjectID from sk_log_counter where (Year(counter_date) = year(CURRENT_DATE()) and Month(counter_date) = month(CURRENT_DATE()))");
                
                				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/dashboard/dashboard');
				$this->load->view('back/global/footer');
				$this->load->view('back/global/bottom_dashboard');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
	}
/*end of file Dashboard.php*/
/*Location:.application/controllers/back/Dashboard.php*/