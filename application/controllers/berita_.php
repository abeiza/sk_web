<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Berita extends CI_Controller{
	    //public $user = "";
		function __construct(){
			parent::__construct();
			
    		// Load facebook library
    		$this->load->library('facebook');
    		
    		//Load user model
    		$this->load->model('user');
    		$this->load->model('user_google');
		
		}
		
		function index(){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
		    include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
		    // Google Project API Credentials
    		$clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
    		
    		// Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
                $gClient->authenticate();
                $this->session->set_userdata('token', $gClient->getAccessToken());
                redirect($redirectUrl);
            }
    
            $token = $this->session->userdata('token');
            if (!empty($token)) {
                $gClient->setAccessToken($token);
            }
		    $userData = array();
            $cek = $this->session->userdata('loginsuccess');
			if($cek){
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				$data['logout_link'] = '';
				
				$this->load->view('front/global/top-logged',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_full');
			}else if($this->facebook->is_authenticated()){
			    $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');

                $data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$this->load->view('front/global/top-logged',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_full');
			}else if ($gClient->getAccessToken()) {
			 
                $data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				$userProfile = $google_oauthV2->userinfo->get();
                // Preparing data for database insertion
    			$userData['oauth_provider'] = 'google';
    			$userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['given_name'];
                $userData['last_name'] = $userProfile['family_name'];
                $userData['email'] = $userProfile['email'];
    			$userData['gender'] = null;
    			$userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = $userProfile['link'];
                $userData['picture_url'] = $userProfile['picture'];
                
                $data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'google';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture'];
                
                // Insert or update user data
                $userID = $this->user_google->checkUser($userData);
                $exct = $this->user_google->checkUser_internal($data_int, $photo);
        		
        		// Insert or update user data
                $userID = $this->user_google->checkUser($userData);
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                } else {
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$this->load->view('front/global/top-logged',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_full');
			}else{
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_full');
			} 
		}
		
		function sosmed(){
		    $userData = array();
            $cek = $this->session->userdata('loginsuccess');
			if($cek){
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				$data['logout_link'] = '';
				
				$this->load->view('front/global/top-logged',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_full');
			}else if($this->facebook->is_authenticated()){
			    $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');

                $data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$this->load->view('front/global/top-logged',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_full');
			}else{
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = "";
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_full');
			} 
		}
		
		
		function tab(){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_1024',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_1024');
			}else if($this->facebook->is_authenticated()){
			    
				
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_1024',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_1024');
				
			}else if ($gClient->getAccessToken()) {
                $userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_1024',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_1024');
				
			}else{
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_1024',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_1024');
			}
		}
		
		
		function kanal($name){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$name = urldecode($this->uri->segment(3));
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'kanal, berita, news, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_kanal',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_kanal_full');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$name = urldecode($this->uri->segment(3));
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'kanal, berita, news, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_kanal',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_kanal_full');
			}else if ($gClient->getAccessToken()) {
			    
            	$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
            	
				$name = urldecode($this->uri->segment(3));
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'kanal, berita, news, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_kanal',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_kanal_full');
			}else{
				$name = urldecode($this->uri->segment(3));
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'kanal, berita, news, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_kanal',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_kanal_full');
			}
		}
		
		function kanal_tab($name){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }

		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$name = urldecode($this->uri->segment(3));
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'kanal, berita, news, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_kanal_1024',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_kanal_1024');
			
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
								$name = urldecode($this->uri->segment(3));
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'kanal, berita, news, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_kanal_1024',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_kanal_1024');
				
			}else if ($gClient->getAccessToken()) {
			    
				$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
				$name = urldecode($this->uri->segment(3));
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'kanal, berita, news, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_kanal_1024',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_kanal_1024');
				
			}else{
				$name = urldecode($this->uri->segment(3));
				$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Headline News' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_warta'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id='KNL00010' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				$data['get_politik'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = 'KNL00002' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_civil'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00003' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 6");
				
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.objectID desc limit 3");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_main = $this->db->query("select * from sk_post, sk_profile_back, sk_kanal, sk_category where sk_category.category_id = sk_post.category_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				
				foreach($get_main->result() as $main){
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['kategori'] = $main->kanal_name;
					$data['pict_main'] = $main->post_pict;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['url_main'] = $main->post_url;
					$data['key_main'] = 'kanal, berita, news, suarakarya, suarakaryanews.com';
					$data['img'] = '';
				}
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/home/home_kanal_1024',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom_kanal_1024');
			
			}
		}
		
		
		function artikel($id){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$get_main = $this->db->query("select * from sk_post, sk_category, sk_profile_back where sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 6");
							
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_status='1' and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				if($get_main->num_rows() == 0){
					$data['title_main'] = '';
				}else{
					foreach($get_main->result() as $main){
						$data['title_main'] = $main->post_title;
						$data['id_post'] = $main->post_id;
						$data['short_main'] = $main->post_shrt_desc;
						$data['pict_main'] = $main->post_pict;
						$data['desc_main'] = $main->post_desc;
						$data['posted_main'] = $main->profile_back_name_full;
						$data['date_main'] = $main->post_modify_date;
						$data['key_main'] = $main->post_keywords;
						$data['img'] = "http://suarakaryanews.com/uploads/post/original/".$main->post_pict;
						
						$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-news' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
						
						$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag where sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' and sk_post.post_status='1' order by post_modify_date desc limit 6");
						$query_tag = $this->db->query("select sk_tag.tag_id, sk_tag.tag_name from sk_tag, sk_post where sk_tag.tag_id = sk_post.tag_id and sk_post.post_id = '".$main->post_id."'");
						
						if($query_tag->num_rows() == 0){
							$data['tag_id'] = 'none';
							$data['tag_name'] = 'none';
						}else{
							foreach($query_tag->result() as $tag){
								$data['tag_id'] = $tag->tag_id;
								$data['tag_name'] = $tag->tag_name;
							}
						}
						
						//$max_before = $this->db->query("select product_id, product_url from purb_product where product_id < '".$prd->product_id."' order by product_id desc limit 1");
						$max_before = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_status='1' and sk_post.post_id < '".$main->post_id."' order by post_modify_date desc limit 1");
						if($max_before->num_rows() == 0){
							$data['before'] = null;
						}else{
							foreach($max_before->result() as $before){
								$data['before'] = $before->post_url;
								$data['before_title'] = $before->post_title;
								$data['before_date'] = $before->post_modify_date;
								$data['before_img'] = $before->post_pict;
							}
						}
						
						//$max_after = $this->db->query("select product_id, product_url from purb_product where product_id > '".$prd->product_id."' order by product_id asc limit 1");
						$max_after = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_status='1' and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_id > '".$main->post_id."' order by post_modify_date asc limit 1");
						
						if($max_after->num_rows() == 0){
							$data['after'] = null;
						}else{
							foreach($max_after->result() as $after){
								$data['after'] = $after->post_url;
								$data['after_title'] = $after->post_title;
								$data['after_date'] = $after->post_modify_date;
								$data['after_img'] = $after->post_pict;
							}
						}
					}
				}
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/berita/artikel',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$get_main = $this->db->query("select * from sk_post, sk_category, sk_profile_back where sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_status='1' and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				if($get_main->num_rows() == 0){
					$data['title_main'] = '';
				}else{
					foreach($get_main->result() as $main){
						$data['title_main'] = $main->post_title;
						$data['id_post'] = $main->post_id;
						$data['short_main'] = $main->post_shrt_desc;
						$data['pict_main'] = $main->post_pict;
						$data['desc_main'] = $main->post_desc;
						$data['posted_main'] = $main->profile_back_name_full;
						$data['date_main'] = $main->post_modify_date;
						$data['key_main'] = $main->post_keywords;
						$data['img'] = "http://suarakaryanews.com/uploads/post/original/".$main->post_pict;
						
						$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-news' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
						
						$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag where sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' and sk_post.post_status='1' order by post_modify_date desc limit 6");
						$query_tag = $this->db->query("select sk_tag.tag_id, sk_tag.tag_name from sk_tag, sk_post where sk_tag.tag_id = sk_post.tag_id and sk_post.post_id = '".$main->post_id."'");
						
						if($query_tag->num_rows() == 0){
							$data['tag_id'] = 'none';
							$data['tag_name'] = 'none';
						}else{
							foreach($query_tag->result() as $tag){
								$data['tag_id'] = $tag->tag_id;
								$data['tag_name'] = $tag->tag_name;
							}
						}
						
						//$max_before = $this->db->query("select product_id, product_url from purb_product where product_id < '".$prd->product_id."' order by product_id desc limit 1");
						$max_before = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_status='1' and sk_post.post_id < '".$main->post_id."' order by post_modify_date desc limit 1");
						if($max_before->num_rows() == 0){
							$data['before'] = null;
						}else{
							foreach($max_before->result() as $before){
								$data['before'] = $before->post_url;
								$data['before_title'] = $before->post_title;
								$data['before_date'] = $before->post_modify_date;
								$data['before_img'] = $before->post_pict;
							}
						}
						
						//$max_after = $this->db->query("select product_id, product_url from purb_product where product_id > '".$prd->product_id."' order by product_id asc limit 1");
						$max_after = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_status='1' and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_id > '".$main->post_id."' order by post_modify_date asc limit 1");
						
						if($max_after->num_rows() == 0){
							$data['after'] = null;
						}else{
							foreach($max_after->result() as $after){
								$data['after'] = $after->post_url;
								$data['after_title'] = $after->post_title;
								$data['after_date'] = $after->post_modify_date;
								$data['after_img'] = $after->post_pict;
							}
						}
					}
				}
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/berita/artikel',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
				
			}else if ($gClient->getAccessToken()) {
			    $userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
            	
				$get_main = $this->db->query("select * from sk_post, sk_category, sk_profile_back where sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_status='1' and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				if($get_main->num_rows() == 0){
					$data['title_main'] = '';
				}else{
					foreach($get_main->result() as $main){
						$data['title_main'] = $main->post_title;
						$data['id_post'] = $main->post_id;
						$data['short_main'] = $main->post_shrt_desc;
						$data['pict_main'] = $main->post_pict;
						$data['desc_main'] = $main->post_desc;
						$data['posted_main'] = $main->profile_back_name_full;
						$data['date_main'] = $main->post_modify_date;
						$data['key_main'] = $main->post_keywords;
						$data['img'] = "http://suarakaryanews.com/uploads/post/original/".$main->post_pict;
						
						$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-news' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
						
						$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag where sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' and sk_post.post_status='1' order by post_modify_date desc limit 6");
						$query_tag = $this->db->query("select sk_tag.tag_id, sk_tag.tag_name from sk_tag, sk_post where sk_tag.tag_id = sk_post.tag_id and sk_post.post_id = '".$main->post_id."'");
						
						if($query_tag->num_rows() == 0){
							$data['tag_id'] = 'none';
							$data['tag_name'] = 'none';
						}else{
							foreach($query_tag->result() as $tag){
								$data['tag_id'] = $tag->tag_id;
								$data['tag_name'] = $tag->tag_name;
							}
						}
						
						//$max_before = $this->db->query("select product_id, product_url from purb_product where product_id < '".$prd->product_id."' order by product_id desc limit 1");
						$max_before = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_status='1' and sk_post.post_id < '".$main->post_id."' order by post_modify_date desc limit 1");
						if($max_before->num_rows() == 0){
							$data['before'] = null;
						}else{
							foreach($max_before->result() as $before){
								$data['before'] = $before->post_url;
								$data['before_title'] = $before->post_title;
								$data['before_date'] = $before->post_modify_date;
								$data['before_img'] = $before->post_pict;
							}
						}
						
						//$max_after = $this->db->query("select product_id, product_url from purb_product where product_id > '".$prd->product_id."' order by product_id asc limit 1");
						$max_after = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_status='1' and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_id > '".$main->post_id."' order by post_modify_date asc limit 1");
						
						if($max_after->num_rows() == 0){
							$data['after'] = null;
						}else{
							foreach($max_after->result() as $after){
								$data['after'] = $after->post_url;
								$data['after_title'] = $after->post_title;
								$data['after_date'] = $after->post_modify_date;
								$data['after_img'] = $after->post_pict;
							}
						}
					}
				}
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/berita/artikel',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
				
			}else{
				$get_main = $this->db->query("select * from sk_post, sk_category, sk_profile_back where sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_post.post_status='1' order by post_modify_date desc limit 1");
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri  and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status='1' group by tag_name order by c_counter desc limit 10");
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_status='1' and sk_post.post_url = '".$this->uri->segment(3)."'");
				if($get_main->num_rows() == 0){
					$data['title_main'] = '';
				}else{
					foreach($get_main->result() as $main){
						$data['title_main'] = $main->post_title;
						$data['id_post'] = $main->post_id;
						$data['short_main'] = $main->post_shrt_desc;
						$data['pict_main'] = $main->post_pict;
						$data['desc_main'] = $main->post_desc;
						$data['posted_main'] = $main->profile_back_name_full;
						$data['date_main'] = $main->post_modify_date;
						$data['key_main'] = $main->post_keywords;
						$data['img'] = "http://suarakaryanews.com/uploads/post/original/".$main->post_pict;
						
						$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-news' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
						
						$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag where sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' and sk_post.post_status='1' order by post_modify_date desc limit 6");
						$query_tag = $this->db->query("select sk_tag.tag_id, sk_tag.tag_name from sk_tag, sk_post where sk_tag.tag_id = sk_post.tag_id and sk_post.post_id = '".$main->post_id."'");
						
						if($query_tag->num_rows() == 0){
							$data['tag_id'] = 'none';
							$data['tag_name'] = 'none';
						}else{
							foreach($query_tag->result() as $tag){
								$data['tag_id'] = $tag->tag_id;
								$data['tag_name'] = $tag->tag_name;
							}
						}
						
						//$max_before = $this->db->query("select product_id, product_url from purb_product where product_id < '".$prd->product_id."' order by product_id desc limit 1");
						$max_before = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_status='1' and sk_post.post_id < '".$main->post_id."' order by post_modify_date desc limit 1");
						if($max_before->num_rows() == 0){
							$data['before'] = null;
						}else{
							foreach($max_before->result() as $before){
								$data['before'] = $before->post_url;
								$data['before_title'] = $before->post_title;
								$data['before_date'] = $before->post_modify_date;
								$data['before_img'] = $before->post_pict;
							}
						}
						
						//$max_after = $this->db->query("select product_id, product_url from purb_product where product_id > '".$prd->product_id."' order by product_id asc limit 1");
						$max_after = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_status='1' and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_id > '".$main->post_id."' order by post_modify_date asc limit 1");
						
						if($max_after->num_rows() == 0){
							$data['after'] = null;
						}else{
							foreach($max_after->result() as $after){
								$data['after'] = $after->post_url;
								$data['after_title'] = $after->post_title;
								$data['after_date'] = $after->post_modify_date;
								$data['after_img'] = $after->post_pict;
							}
						}
					}					
				}
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/berita/artikel',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
		
			}
			
              $url_id = base_url().'index.php/berita/artikel/'.$this->uri->segment(3);
              $uri = $this->uri->segment(3);
              
              $browser = $_SERVER['HTTP_USER_AGENT'];
              $chrome = '/Chrome/';
              $firefox = '/Firefox/';
              $ie = '/MSIE/';
              
              if (preg_match($chrome, $browser)){
                $data = "Chrome/Opera";
              }else if (preg_match($firefox, $browser)){
                $data = "Firefox";
              }else if(preg_match($ie, $browser)){
                $data = "IE";
              }else{
                $data = "Others";
              }
              $ipaddress = $_SERVER['REMOTE_ADDR']."";
              $browser = $data;
              $tanggal = date('Y-m-d H:i:s');
              
              if($url_id != '' or $url_id != null or !empty($url_id)){
              $this->db->query("INSERT INTO sk_log_counter (counter_date, counter_ip, counter_browser, counter_url, counter_uri) VALUES 
              ('".$tanggal."','".$ipaddress."','".$browser."','".$url_id."','".$uri."')");  
              }
		}
		
		function get_reaction_post(){
			$url = $this->input->post('url');
			
			
			$senang = 0;
			$terhibur = 0;
			$terinspirasi = 0;
			$tidak_peduli = 0;
			$terganggu = 0;
			$sedih = 0;
			$cemas = 0;
			$marah = 0;
			
			$query = $this->db->query("select sk_reac_article.reaction_id, sk_reaction.reaction_name, count(sk_reac_article.reaction_id) as c_reac from sk_reac_article, sk_reaction, sk_post where sk_reac_article.post_id = sk_post.post_id and sk_reac_article.reaction_id = sk_reaction.reaction_id 
			and sk_post.post_url = '".$url."' group by sk_post.post_url, sk_reac_article.reaction_id, sk_reaction.reaction_name");
			foreach($query->result() as $rct){
				if($rct->reaction_name == 'Senang'){
					$senang = $rct->c_reac;
				}else if($rct->reaction_name == 'Terhibur'){
					$terhibur = $rct->c_reac;
				}else if($rct->reaction_name == 'Terinspirasi'){
					$terinspirasi = $rct->c_reac;
				}else if($rct->reaction_name == 'Tidak Peduli'){
					$tidak_peduli = $rct->c_reac;
				}else if($rct->reaction_name == 'Terganggu'){
					$terganggu = $rct->c_reac;
				}else if($rct->reaction_name == 'Sedih'){
					$sedih = $rct->c_reac;
				}else if($rct->reaction_name == 'Cemas'){
					$cemas = $rct->c_reac;
				}else if($rct->reaction_name == 'Marah'){
					$marah = $rct->c_reac;
				}
			}
			
			
			if($senang == 0){
				$p_senang = 0;
			}else{
				$p_senang = round(($senang / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($terhibur == 0){
				$p_terhibur = 0;
			}else{
				$p_terhibur = round(($terhibur / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($terinspirasi == 0){
				$p_terinspirasi = 0;
			}else{	
				$p_terinspirasi = round(($terinspirasi / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($tidak_peduli == 0){
				$p_tidak_peduli = 0;
			}else{	
				$p_tidak_peduli = round(($tidak_peduli / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($terganggu == 0){
				$p_terganggu = 0;
			}else{	
				$p_terganggu = round(($terganggu / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($sedih == 0){
				$p_sedih = 0;
			}else{	
				$p_sedih = round(($sedih / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($cemas == 0){
				$p_cemas = 0;
			}else{	
				$p_cemas = round(($cemas / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($marah == 0){
				$p_marah = 0;
			}else{	
				$p_marah = round(($marah / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			$data = array(
				'senang' => $p_senang,
				'terhibur' => $p_terhibur,
				'terinspirasi' => $p_terinspirasi,
				'tidak_peduli' => $p_tidak_peduli,
				'terganggu' => $p_terganggu,
				'sedih' => $p_sedih,
				'cemas' => $p_cemas,
				'marah' => $p_marah
			);
				
			echo json_encode($data);
		}
		
		function get_reaction_video(){
			$url = $this->input->post('url');
			
			
			$senang = 0;
			$terhibur = 0;
			$terinspirasi = 0;
			$tidak_peduli = 0;
			$terganggu = 0;
			$sedih = 0;
			$cemas = 0;
			$marah = 0;
			
			$query = $this->db->query("select sk_reac_article.reaction_id, sk_reaction.reaction_name, count(sk_reac_article.reaction_id) as c_reac from sk_reac_article, sk_reaction, sk_video where sk_reac_article.post_id = sk_video.video_id and sk_reac_article.reaction_id = sk_reaction.reaction_id 
			and sk_video.video_url = '".$url."' group by sk_video.video_url, sk_reac_article.reaction_id, sk_reaction.reaction_name");
			foreach($query->result() as $rct){
				if($rct->reaction_name == 'Senang'){
					$senang = $rct->c_reac;
				}else if($rct->reaction_name == 'Terhibur'){
					$terhibur = $rct->c_reac;
				}else if($rct->reaction_name == 'Terinspirasi'){
					$terinspirasi = $rct->c_reac;
				}else if($rct->reaction_name == 'Tidak Peduli'){
					$tidak_peduli = $rct->c_reac;
				}else if($rct->reaction_name == 'Terganggu'){
					$terganggu = $rct->c_reac;
				}else if($rct->reaction_name == 'Sedih'){
					$sedih = $rct->c_reac;
				}else if($rct->reaction_name == 'Cemas'){
					$cemas = $rct->c_reac;
				}else if($rct->reaction_name == 'Marah'){
					$marah = $rct->c_reac;
				}
			}
			
			
			if($senang == 0){
				$p_senang = 0;
			}else{
				$p_senang = ($senang / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($terhibur == 0){
				$p_terhibur = 0;
			}else{
				$p_terhibur = ($terhibur / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($terinspirasi == 0){
				$p_terinspirasi = 0;
			}else{	
				$p_terinspirasi = ($terinspirasi / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($tidak_peduli == 0){
				$p_tidak_peduli = 0;
			}else{	
				$p_tidak_peduli = ($tidak_peduli / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($terganggu == 0){
				$p_terganggu = 0;
			}else{	
				$p_terganggu = ($terganggu / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($sedih == 0){
				$p_sedih = 0;
			}else{	
				$p_sedih = ($sedih / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($cemas == 0){
				$p_cemas = 0;
			}else{	
				$p_cemas = ($cemas / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($marah == 0){
				$p_marah = 0;
			}else{	
				$p_marah = ($marah / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			$data = array(
				'senang' => $p_senang,
				'terhibur' => $p_terhibur,
				'terinspirasi' => $p_terinspirasi,
				'tidak_peduli' => $p_tidak_peduli,
				'terganggu' => $p_terganggu,
				'sedih' => $p_sedih,
				'cemas' => $p_cemas,
				'marah' => $p_marah
			);
				
			echo json_encode($data);
		}
		
		function get_reaction_photo(){
			$url = $this->input->post('url');
			
			
			$senang = 0;
			$terhibur = 0;
			$terinspirasi = 0;
			$tidak_peduli = 0;
			$terganggu = 0;
			$sedih = 0;
			$cemas = 0;
			$marah = 0;
			
			$query = $this->db->query("select sk_reac_article.reaction_id, sk_reaction.reaction_name, count(sk_reac_article.reaction_id) as c_reac from sk_reac_article, sk_reaction, sk_photo where sk_reac_article.post_id = sk_photo.pict_id and sk_reac_article.reaction_id = sk_reaction.reaction_id 
			and sk_photo.pict_url = '".$url."' group by sk_photo.pict_url, sk_reac_article.reaction_id, sk_reaction.reaction_name");
			foreach($query->result() as $rct){
				if($rct->reaction_name == 'Senang'){
					$senang = $rct->c_reac;
				}else if($rct->reaction_name == 'Terhibur'){
					$terhibur = $rct->c_reac;
				}else if($rct->reaction_name == 'Terinspirasi'){
					$terinspirasi = $rct->c_reac;
				}else if($rct->reaction_name == 'Tidak Peduli'){
					$tidak_peduli = $rct->c_reac;
				}else if($rct->reaction_name == 'Terganggu'){
					$terganggu = $rct->c_reac;
				}else if($rct->reaction_name == 'Sedih'){
					$sedih = $rct->c_reac;
				}else if($rct->reaction_name == 'Cemas'){
					$cemas = $rct->c_reac;
				}else if($rct->reaction_name == 'Marah'){
					$marah = $rct->c_reac;
				}
			}
			
			
			if($senang == 0){
				$p_senang = 0;
			}else{
				$p_senang = ($senang / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($terhibur == 0){
				$p_terhibur = 0;
			}else{
				$p_terhibur = ($terhibur / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($terinspirasi == 0){
				$p_terinspirasi = 0;
			}else{	
				$p_terinspirasi = ($terinspirasi / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($tidak_peduli == 0){
				$p_tidak_peduli = 0;
			}else{	
				$p_tidak_peduli = ($tidak_peduli / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($terganggu == 0){
				$p_terganggu = 0;
			}else{	
				$p_terganggu = ($terganggu / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($sedih == 0){
				$p_sedih = 0;
			}else{	
				$p_sedih = ($sedih / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($cemas == 0){
				$p_cemas = 0;
			}else{	
				$p_cemas = ($cemas / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($marah == 0){
				$p_marah = 0;
			}else{	
				$p_marah = ($marah / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			$data = array(
				'senang' => $p_senang,
				'terhibur' => $p_terhibur,
				'terinspirasi' => $p_terinspirasi,
				'tidak_peduli' => $p_tidak_peduli,
				'terganggu' => $p_terganggu,
				'sedih' => $p_sedih,
				'cemas' => $p_cemas,
				'marah' => $p_marah
			);
				
			echo json_encode($data);
		}
		
		
		
		function set_reaction_post(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$reaction = $this->input->post("reac");
				$post_id = $this->input->post("post");
				$query_validation = $this->db->query("select * from sk_reac_article, sk_post where sk_reac_article.guest_id = '".$this->session->userdata('user_id')."' and sk_reac_article.post_id = sk_post.post_id and sk_reac_article.post_id = '".$post_id."'");
				if($query_validation->num_rows() == 0 ){
					$data['reaction_id'] = $reaction;
					$data['post_id'] = $post_id;
					$data['guest_id'] = $this->session->userdata('user_id');
					$data['reac_posted_date'] = date("Y-m-d H:s:i");
					
					$post_reaction = $this->sk_model->insert_data('sk_reac_article', $data);
					if($post_reaction){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}else{
					$dataz = array(
						'status' => 'available',
					);
					echo json_encode($dataz);
				}
			}else{				
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		function set_reaction_video(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$reaction = $this->input->post("reac");
				$video_id = $this->input->post("post");
				$query_validation = $this->db->query("select * from sk_reac_article, sk_video where sk_reac_article.guest_id = '".$this->session->userdata('user_id')."' and sk_reac_article.post_id = sk_video.video_id and sk_reac_article.post_id = '".$video_id."'");
				if($query_validation->num_rows() == 0 ){
					$data['reaction_id'] = $reaction;
					$data['post_id'] = $video_id;
					$data['guest_id'] = $this->session->userdata('user_id');
					$data['reac_posted_date'] = date("Y-m-d H:s:i");
					
					$post_reaction = $this->sk_model->insert_data('sk_reac_article', $data);
					if($post_reaction){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}else{
					$dataz = array(
						'status' => 'available',
					);
					echo json_encode($dataz);
				}
			}else{				
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		function set_reaction_photo(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$reaction = $this->input->post("reac");
				$photo_id = $this->input->post("post");
				$query_validation = $this->db->query("select * from sk_reac_article, sk_photo where sk_reac_article.guest_id = '".$this->session->userdata('user_id')."' and sk_reac_article.post_id = sk_photo.pict_id and sk_reac_article.post_id = '".$photo_id."'");
				if($query_validation->num_rows() == 0 ){
					$data['reaction_id'] = $reaction;
					$data['post_id'] = $photo_id;
					$data['guest_id'] = $this->session->userdata('user_id');
					$data['reac_posted_date'] = date("Y-m-d H:s:i");
					
					$post_reaction = $this->sk_model->insert_data('sk_reac_article', $data);
					if($post_reaction){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}else{
					$dataz = array(
						'status' => 'available',
					);
					echo json_encode($dataz);
				}
			}else{				
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		
		
		function get_comment_post(){
			$url = $this->input->post('url');
			$query_comment_post = $this->db->query("select sk_guest.guest_name, sk_guest_profile.guest_profile_pict, sk_comment.comment_post_date, sk_comment.comment_text, sk_comment.comment_order, sk_comment.comment_ref_id, sk_comment.comment_id from sk_comment, sk_post, sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$url."' order by sk_comment.comment_ref_id desc, sk_comment.comment_id");
			$data_list_a = array();
			
			foreach($query_comment_post->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		function get_comment_video(){
			$url = $this->input->post('url');
			$query_comment_post = $this->db->query("select sk_guest.guest_name, sk_guest_profile.guest_profile_pict, sk_comment.comment_post_date, sk_comment.comment_text, sk_comment.comment_order, sk_comment.comment_ref_id, sk_comment.comment_id from sk_comment, sk_video, sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_comment.post_id = sk_video.video_id and sk_comment.guest_id = sk_guest.guest_id and sk_video.video_url = '".$url."' order by sk_comment.comment_ref_id desc, sk_comment.comment_id");
			$data_list_a = array();
			
			foreach($query_comment_post->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		function get_comment_photo(){
			$url = $this->input->post('url');
			$query_comment_post = $this->db->query("select sk_guest.guest_name, sk_guest_profile.guest_profile_pict, sk_comment.comment_post_date, sk_comment.comment_text, sk_comment.comment_order, sk_comment.comment_ref_id, sk_comment.comment_id from sk_comment, sk_photo, sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_comment.post_id = sk_photo.pict_id and sk_comment.guest_id = sk_guest.guest_id and sk_photo.pict_url = '".$url."' order by sk_comment.comment_ref_id desc, sk_comment.comment_id");
			$data_list_a = array();
			
			foreach($query_comment_post->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		
		
		function set_comment_post(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$this->form_validation->set_rules('comment','komentar','required');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$data['comment_id'] = $this->sk_model->getMaxKodelong('sk_comment', 'comment_id', 'CMD');
					$data['guest_id'] = $this->session->userdata("user_id");
					$data['post_id'] = $this->input->post("post");
					$data['comment_order'] = '1';
					$data['comment_flag'] = '0';
					$data['comment_ref_id'] = $data['comment_id'];
					$data['comment_post_date'] = date('Y-m-d H:s:i');
					$data['comment_text'] = $this->input->post("comment");
					
					$post_comment = $this->sk_model->insert_data('sk_comment', $data);
					if($post_comment){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}
			}else{
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		
		function set_comment_post_tanggapan(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$this->form_validation->set_rules('comment','komentar','required');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$data['comment_id'] = $this->sk_model->getMaxKodelong('sk_comment', 'comment_id', 'CMD');
					$data['guest_id'] = $this->session->userdata("user_id");
					$data['post_id'] = $this->input->post("post");
					$data['comment_order'] = '2';
					$data['comment_flag'] = '0';
					$data['comment_ref_id'] = $this->input->post("id_comment");
					$data['comment_post_date'] = date('Y-m-d H:s:i');
					$data['comment_text'] = $this->input->post("comment");
					
					$post_comment = $this->sk_model->insert_data('sk_comment', $data);
					if($post_comment){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}
			}else{
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		function get_filter_index(){
			$filter = $this->input->post('filter');
			$nama_kanal = $this->input->post('kanal');
			
			$query_check_kanal = $this->db->query("select * from sk_kanal where kanal_name = '".$nama_kanal."'");
			if($query_check_kanal->num_rows() == 0){
				$kanal = 'none';
			}else{
				$kanal = $nama_kanal;
			}
			
			if($kanal == 'none'){
				$query_filter = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_post.post_modify_date) = '".date('Y',strtotime($filter))."' and month(sk_post.post_modify_date) = '".date('m',strtotime($filter))."' and day(sk_post.post_modify_date) = '".date('d',strtotime($filter))."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.post_modify_date desc");
			}else{
				$query_filter = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_post.post_modify_date) = '".date('Y',strtotime($filter))."' and month(sk_post.post_modify_date) = '".date('m',strtotime($filter))."' and day(sk_post.post_modify_date) = '".date('d',strtotime($filter))."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.post_modify_date desc");
			}
			$data_list_a = array();
			
			foreach($query_filter->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		function get_filter_index_video(){
			$filter = $this->input->post('filter');
			$nama_kanal = $this->input->post('kanal');
			
			$query_check_kanal = $this->db->query("select * from sk_kanal where kanal_name = '".$nama_kanal."'");
			if($query_check_kanal->num_rows() == 0){
				$kanal = 'none';
			}else{
				$kanal = $nama_kanal;
			}
			
			if($kanal == 'none'){
				$query_filter = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_video.video_modify_date) = '".date('Y',strtotime($filter))."' and month(sk_video.video_modify_date) = '".date('m',strtotime($filter))."' and day(sk_video.video_modify_date) = '".date('d',strtotime($filter))."' and sk_video.video_status='1' order by sk_video.video_modify_date desc");
			}else{
				$query_filter = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_video.video_modify_date) = '".date('Y',strtotime($filter))."' and month(sk_video.video_modify_date) = '".date('m',strtotime($filter))."' and day(sk_video.video_modify_date) = '".date('d',strtotime($filter))."' and sk_video.video_status='1' order by sk_video.video_modify_date desc");
			}
			$data_list_a = array();
			
			foreach($query_filter->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		function get_filter_index_photo(){
			$filter = $this->input->post('filter');
			$nama_kanal = $this->input->post('kanal');
			
			$query_check_kanal = $this->db->query("select * from sk_kanal where kanal_name = '".$nama_kanal."'");
			if($query_check_kanal->num_rows() == 0){
				$kanal = 'none';
			}else{
				$kanal = $nama_kanal;
			}
			
			if($kanal == 'none'){
				$query_filter = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_photo.pict_create_date) = '".date('Y',strtotime($filter))."' and month(sk_photo.pict_create_date) = '".date('m',strtotime($filter))."' and day(sk_photo.pict_create_date) = '".date('d',strtotime($filter))."' and sk_photo.pict_status='1' order by sk_photo.pict_create_date desc");
			}else{
				$query_filter = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_photo.pict_create_date) = '".date('Y',strtotime($filter))."' and month(sk_photo.pict_create_date) = '".date('m',strtotime($filter))."' and day(sk_photo.pict_create_date) = '".date('d',strtotime($filter))."' and sk_photo.pict_status='1' order by sk_photo.pict_create_date desc");
			}
			$data_list_a = array();
			
			foreach($query_filter->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		
		function video(){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'video' and sk_adv_layout.kanal_id='home'");
				
				$data['get_video_main'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 1, 1");
				
				
				$data['get_video_list1'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 2, 6");
				
				$data['get_video_list2'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 8, 6");
				
				$data['get_video_list3'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 14, 6");
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/video_category',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'video' and sk_adv_layout.kanal_id='home'");
				
				$data['get_video_main'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 1, 1");
				
				
				$data['get_video_list1'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 2, 6");
				
				$data['get_video_list2'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 8, 6");
				
				$data['get_video_list3'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 14, 6");
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/video_category',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if ($gClient->getAccessToken()) {
			    
				$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
            	
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'video' and sk_adv_layout.kanal_id='home'");
				
				$data['get_video_main'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 1, 1");
				
				
				$data['get_video_list1'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 2, 6");
				
				$data['get_video_list2'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 8, 6");
				
				$data['get_video_list3'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 14, 6");
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/video_category',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else{
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'video' and sk_adv_layout.kanal_id='home'");
				
				$data['get_video_main'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 1, 1");
				
				
				$data['get_video_list1'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 2, 6");
				
				$data['get_video_list2'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 8, 6");
				
				$data['get_video_list3'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 14, 6");
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/video_category',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
		}
		
		function video_detail($id){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$id = $this->uri->segment(3);
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				
				$get_video_main = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' and sk_video.video_url = '".$id."' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_video, sk_guest where sk_comment.post_id = sk_video.video_id and sk_comment.guest_id = sk_guest.guest_id and sk_video.video_status='1' and sk_video.video_url = '".$this->uri->segment(3)."'");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				foreach($get_video_main->result() as $main){
					$data['title_main'] = $main->video_title;
					$data['short_main'] = $main->video_short_desc;
					$data['link'] = $main->video_link;
					$data['desc_main'] = $main->video_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->video_modify_date;
					$data['id_post'] = $main->video_id;
					$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-video' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->video_keywords;
					$data['img'] = $main->video_link; 
				}
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/detail',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$id = $this->uri->segment(3);
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				
				$get_video_main = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' and sk_video.video_url = '".$id."' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_video, sk_guest where sk_comment.post_id = sk_video.video_id and sk_comment.guest_id = sk_guest.guest_id and sk_video.video_status='1' and sk_video.video_url = '".$this->uri->segment(3)."'");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				foreach($get_video_main->result() as $main){
					$data['title_main'] = $main->video_title;
					$data['short_main'] = $main->video_short_desc;
					$data['link'] = $main->video_link;
					$data['desc_main'] = $main->video_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->video_modify_date;
					$data['id_post'] = $main->video_id;
					$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-video' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->video_keywords;
					$data['img'] = $main->video_link; 
				}
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/detail',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if ($gClient->getAccessToken()) {
			    
				$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
            	
				$id = $this->uri->segment(3);
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$get_video_main = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' and sk_video.video_url = '".$id."' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_video, sk_guest where sk_comment.post_id = sk_video.video_id and sk_comment.guest_id = sk_guest.guest_id and sk_video.video_status='1' and sk_video.video_url = '".$this->uri->segment(3)."'");
				
				foreach($get_video_main->result() as $main){
					$data['title_main'] = $main->video_title;
					$data['short_main'] = $main->video_short_desc;
					$data['link'] = $main->video_link;
					$data['desc_main'] = $main->video_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->video_modify_date;
					$data['id_post'] = $main->video_id;
					$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-video' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->video_keywords;
					$data['img'] = $main->video_link; 
				}
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/detail',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else{
				$id = $this->uri->segment(3);
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				
				$get_video_main = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' and sk_video.video_url = '".$id."' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_video, sk_guest where sk_comment.post_id = sk_video.video_id and sk_comment.guest_id = sk_guest.guest_id and sk_video.video_status='1' and sk_video.video_url = '".$this->uri->segment(3)."'");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				foreach($get_video_main->result() as $main){
					$data['title_main'] = $main->video_title;
					$data['short_main'] = $main->video_short_desc;
					$data['link'] = $main->video_link;
					$data['desc_main'] = $main->video_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->video_modify_date;
					$data['id_post'] = $main->video_id;
					$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-video' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->video_keywords;
					$data['img'] = $main->video_link; 
				}
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/detail',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
			  $url_id = base_url().'index.php/berita/video_detail/'.$this->uri->segment(3);
              
              $browser = $_SERVER['HTTP_USER_AGENT'];
              $chrome = '/Chrome/';
              $firefox = '/Firefox/';
              $ie = '/MSIE/';
              
              if (preg_match($chrome, $browser)){
                $data = "Chrome/Opera";
              }else if (preg_match($firefox, $browser)){
                $data = "Firefox";
              }else if (preg_match($ie, $browser)){
                $data = "IE";
              }
              
              $ipaddress = $_SERVER['REMOTE_ADDR']."";
              $browser = $data;
              $tanggal = date('Y-m-d H:i:s');
              
              if($url_id != '' or $url_id != null or !empty($url_id)){
              $this->db->query("INSERT INTO sk_log_counter (counter_date, counter_ip, counter_browser, counter_url, counter_uri) VALUES ('".$tanggal."','".$ipaddress."','".$browser."','".$url_id."','".$this->uri->segment(3)."')");  
              }
		}
		
		
		function activate($code_activ){
			$code_activ = $this->uri->segment(3);
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
			
			$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
			$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
			$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
			
			$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
			$query_find_activation = $this->db->query("select * from sk_activate where activate_code = '".$code_activ."'");
			if($query_find_activation->num_rows() == 1){
				foreach($query_find_activation->result() as $act){
					$check_activation = $this->db->query("select * from sk_guest where guest_id='".$act->guest_id."' and guest_status = 0");
					if($check_activation->num_rows() > 0){
						$data_guest['guest_status'] = 1;
						$query_update = $this->sk_model->update_data('sk_guest', 'guest_id', $act->guest_id, $data_guest);
						if($query_update){
							$data['message'] = 'Aktifasi Akun telah berhasil, Silahkan login untuk dapat menggunakan fasilitas kami.';
						}else{
							$data['message'] = 'Maaf, Anda ada kesalahan dalam link aktivasi yang anda gunakan. Mohon coba registrasi ulang.';
						}
					}else{
						$data['message'] = 'Maaf, Kode aktifasi telah expired. <br/>(Akun yang anda aktifasi sudah aktif sebelumnya).';
					}
				}
			}else{
				$data['message'] = 'Maaf, <strong>Link Aktifasi</strong> yang Anda gunakan tidak valid. Mohon dicek kembali.';
			}
			$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
			$data['title_main'] = '';
			$data['short_main'] = '';
			$data['posted_main'] = '';
			$data['key_main'] = '';
			$data['img'] = '';
			
			$this->load->view('front/global/top_other',$data);
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/activate/detail',$data);
			$this->load->view('front/global/footer');
			$this->load->view('front/global/bottom');
		}
		
		function foto(){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'photo' and sk_adv_layout.kanal_id='home'");
					
				$data['get_photo_main'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 1, 3");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['get_photo_list1'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 4, 6");
				
				$data['get_photo_list2'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 10, 6");
				
				$data['get_photo_list3'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 16, 6");
				
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/picture_category',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'photo' and sk_adv_layout.kanal_id='home'");
					
				$data['get_photo_main'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 1, 3");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_photo_list1'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 4, 6");
				
				$data['get_photo_list2'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 10, 6");
				
				$data['get_photo_list3'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 16, 6");
				
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/picture_category',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if ($gClient->getAccessToken()) {   
				$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
            	$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'photo' and sk_adv_layout.kanal_id='home'");
					
				$data['get_photo_main'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 1, 3");
				
				
				$data['get_photo_list1'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 4, 6");
				
				$data['get_photo_list2'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 10, 6");
				
				$data['get_photo_list3'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 16, 6");
				
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/picture_category',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else{
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'photo' and sk_adv_layout.kanal_id='home'");
					
				$data['get_photo_main'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 1, 3");
				
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['get_photo_list1'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 4, 6");
				
				$data['get_photo_list2'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 10, 6");
				
				$data['get_photo_list3'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 16, 6");
				
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/picture_category',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
		}
		
		function foto_detail($id){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$id = $this->uri->segment(3);
				$get_photo_main = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category, sk_profile_back 
					where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' and sk_photo.pict_url = '".$id."' 
					and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_create_date desc");
					
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_photo, sk_guest where sk_comment.post_id = sk_photo.pict_id and sk_comment.guest_id = sk_guest.guest_id and sk_photo.pict_status='1' and sk_photo.pict_url = '".$this->uri->segment(3)."'");
					
				
				foreach($get_photo_main->result() as $main){
					$data['pict_id'] = $main->pict_id;
					$data['id_post'] = $main->pict_id;
					$data['title_main'] = $main->pict_title;
					$data['short_main'] = $main->pict_short_desc;
					$data['desc_main'] = $main->pict_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->pict_create_date;
					
					$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-photo' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->pict_keywords;
					$query_pk_img = $this->db->query("select pict_detail_url from sk_photo_detail where ref_pict_id = '".$main->pict_id."' order by ObjectID limit 1");
					foreach($query_pk_img->result() as $pd_main){
						$data['img'] = base_url().'uploads/pict/original/'. $pd_main->pict_detail_url; 
					}
				}
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/detail',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$id = $this->uri->segment(3);
				$get_photo_main = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category, sk_profile_back 
					where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' and sk_photo.pict_url = '".$id."' 
					and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_create_date desc");
					
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_photo, sk_guest where sk_comment.post_id = sk_photo.pict_id and sk_comment.guest_id = sk_guest.guest_id and sk_photo.pict_status='1' and sk_photo.pict_url = '".$this->uri->segment(3)."'");
					
				
				foreach($get_photo_main->result() as $main){
					$data['pict_id'] = $main->pict_id;
					$data['id_post'] = $main->pict_id;
					$data['title_main'] = $main->pict_title;
					$data['short_main'] = $main->pict_short_desc;
					$data['desc_main'] = $main->pict_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->pict_create_date;
					
					$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-photo' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->pict_keywords;
					$query_pk_img = $this->db->query("select pict_detail_url from sk_photo_detail where ref_pict_id = '".$main->pict_id."' order by ObjectID limit 1");
					foreach($query_pk_img->result() as $pd_main){
						$data['img'] = base_url().'uploads/pict/original/'. $pd_main->pict_detail_url; 
					}
				}
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/detail',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
				
			}else if ($gClient->getAccessToken()) {
	
            	$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
            		
				$id = $this->uri->segment(3);
				$get_photo_main = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category, sk_profile_back 
					where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' and sk_photo.pict_url = '".$id."' 
					and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_create_date desc");
					
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_photo, sk_guest where sk_comment.post_id = sk_photo.pict_id and sk_comment.guest_id = sk_guest.guest_id and sk_photo.pict_status='1' and sk_photo.pict_url = '".$this->uri->segment(3)."'");
					
				
				foreach($get_photo_main->result() as $main){
					$data['pict_id'] = $main->pict_id;
					$data['id_post'] = $main->pict_id;
					$data['title_main'] = $main->pict_title;
					$data['short_main'] = $main->pict_short_desc;
					$data['desc_main'] = $main->pict_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->pict_create_date;
					
					$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-photo' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->pict_keywords;
					$query_pk_img = $this->db->query("select pict_detail_url from sk_photo_detail where ref_pict_id = '".$main->pict_id."' order by ObjectID limit 1");
					foreach($query_pk_img->result() as $pd_main){
						$data['img'] = base_url().'uploads/pict/original/'. $pd_main->pict_detail_url; 
					}
				}
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/detail',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
				
			}else{
				$id = $this->uri->segment(3);
				$get_photo_main = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category, sk_profile_back 
					where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' and sk_photo.pict_url = '".$id."' 
					and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_create_date desc");
					
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_photo, sk_guest where sk_comment.post_id = sk_photo.pict_id and sk_comment.guest_id = sk_guest.guest_id and sk_photo.pict_status='1' and sk_photo.pict_url = '".$this->uri->segment(3)."'");
					
				
				foreach($get_photo_main->result() as $main){
					$data['pict_id'] = $main->pict_id;
					$data['id_post'] = $main->pict_id;
					$data['title_main'] = $main->pict_title;
					$data['short_main'] = $main->pict_short_desc;
					$data['desc_main'] = $main->pict_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->pict_create_date;
					
					$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-photo' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->pict_keywords;
					$query_pk_img = $this->db->query("select pict_detail_url from sk_photo_detail where ref_pict_id = '".$main->pict_id."' order by ObjectID limit 1");
					foreach($query_pk_img->result() as $pd_main){
						$data['img'] = base_url().'uploads/pict/original/'. $pd_main->pict_detail_url; 
					}
				}
			
			    // Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
			
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/detail',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
			  $url_id = base_url().'index.php/berita/foto_detail/'.$this->uri->segment(3);
              
              $browser = $_SERVER['HTTP_USER_AGENT'];
              $chrome = '/Chrome/';
              $firefox = '/Firefox/';
              $ie = '/MSIE/';
              
              if (preg_match($chrome, $browser)){
                $data = "Chrome/Opera";
              }else if (preg_match($firefox, $browser)){
                $data = "Firefox";
              }else if (preg_match($ie, $browser)){
                $data = "IE";
		      }
              $ipaddress = $_SERVER['REMOTE_ADDR']."";
              $browser = $data;
              $tanggal = date('Y-m-d H:i:s');
              
              if($url_id != '' or $url_id != null or !empty($url_id)){
              $this->db->query("INSERT INTO sk_log_counter (counter_date, counter_ip, counter_browser, counter_url, counter_uri) VALUES ('".$tanggal."','".$ipaddress."','".$browser."','".$url_id."','".$this->uri->segment(3)."')");  
              }
		}
		
		function key_index($kanal){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_post.post_modify_date) = '".date('Y')."' and month(sk_post.post_modify_date) = '".date('m')."' and day(sk_post.post_modify_date) = '".date('d')."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by sk_post.post_modify_date desc");
					
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_post.post_modify_date) = '".date('Y')."' and month(sk_post.post_modify_date) = '".date('m')."' and day(sk_post.post_modify_date) = '".date('d')."'  and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by sk_post.post_modify_date desc");
				
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/index/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_post.post_modify_date) = '".date('Y')."' and month(sk_post.post_modify_date) = '".date('m')."' and day(sk_post.post_modify_date) = '".date('d')."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by sk_post.post_modify_date desc");
					
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_post.post_modify_date) = '".date('Y')."' and month(sk_post.post_modify_date) = '".date('m')."' and day(sk_post.post_modify_date) = '".date('d')."'  and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by sk_post.post_modify_date desc");
				
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/index/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
				
			}else if ($gClient->getAccessToken()) {
	
            	$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
	
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_post.post_modify_date) = '".date('Y')."' and month(sk_post.post_modify_date) = '".date('m')."' and day(sk_post.post_modify_date) = '".date('d')."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by sk_post.post_modify_date desc");
					
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_post.post_modify_date) = '".date('Y')."' and month(sk_post.post_modify_date) = '".date('m')."' and day(sk_post.post_modify_date) = '".date('d')."'  and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by sk_post.post_modify_date desc");
				
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/index/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
				
			}else{
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_post.post_modify_date) = '".date('Y')."' and month(sk_post.post_modify_date) = '".date('m')."' and day(sk_post.post_modify_date) = '".date('d')."' and sk_post.flag_id = 'FLG00002' order by sk_post.post_modify_date desc");
					
					$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_post.post_modify_date) = '".date('Y')."' and month(sk_post.post_modify_date) = '".date('m')."' and day(sk_post.post_modify_date) = '".date('d')."' and sk_post.flag_id = 'FLG00002' order by sk_post.post_modify_date desc");
				
					$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/index/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
		}
		
		function key_index_video($kanal){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_video.video_modify_date) = '".date('Y')."' and month(sk_video.video_modify_date) = '".date('m')."' and day(sk_video.video_modify_date) = '".date('d')."' and sk_video.video_status ='1' order by sk_video.video_modify_date desc");
					
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_video.video_modify_date) = '".date('Y')."' and month(sk_video.video_modify_date) = '".date('m')."' and day(sk_video.video_modify_date) = '".date('d')."' and sk_video.video_status ='1' order by sk_video.video_modify_date desc");
				
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_video.video_modify_date) = '".date('Y')."' and month(sk_video.video_modify_date) = '".date('m')."' and day(sk_video.video_modify_date) = '".date('d')."' and sk_video.video_status ='1' order by sk_video.video_modify_date desc");
					
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_video.video_modify_date) = '".date('Y')."' and month(sk_video.video_modify_date) = '".date('m')."' and day(sk_video.video_modify_date) = '".date('d')."' and sk_video.video_status ='1' order by sk_video.video_modify_date desc");
				
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if ($gClient->getAccessToken()) {
	
            	$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
	
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_video.video_modify_date) = '".date('Y')."' and month(sk_video.video_modify_date) = '".date('m')."' and day(sk_video.video_modify_date) = '".date('d')."' and sk_video.video_status ='1' order by sk_video.video_modify_date desc");
					
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_video.video_modify_date) = '".date('Y')."' and month(sk_video.video_modify_date) = '".date('m')."' and day(sk_video.video_modify_date) = '".date('d')."' and sk_video.video_status ='1' order by sk_video.video_modify_date desc");
				
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else{
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_video.video_modify_date) = '".date('Y')."' and month(sk_video.video_modify_date) = '".date('m')."' and day(sk_video.video_modify_date) = '".date('d')."' and sk_video.video_status ='1' order by sk_video.video_modify_date desc");
					
					$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_video.video_modify_date) = '".date('Y')."' and month(sk_video.video_modify_date) = '".date('m')."' and day(sk_video.video_modify_date) = '".date('d')."' and sk_video.video_status ='1' order by sk_video.video_modify_date desc");
				
					$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/video/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
		}
		
		function key_index_photo($kanal){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_photo.pict_create_date) = '".date('Y')."' and month(sk_photo.pict_create_date) = '".date('m')."' and day(sk_photo.pict_create_date) = '".date('d')."' and sk_photo.pict_status ='1' order by sk_photo.pict_create_date desc");
					
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_photo.pict_create_date) = '".date('Y')."' and month(sk_photo.pict_create_date) = '".date('m')."' and day(sk_photo.pict_create_date) = '".date('d')."' and sk_photo.pict_status ='1' order by sk_photo.pict_create_date desc");
				
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_photo.pict_create_date) = '".date('Y')."' and month(sk_photo.pict_create_date) = '".date('m')."' and day(sk_photo.pict_create_date) = '".date('d')."' and sk_photo.pict_status ='1' order by sk_photo.pict_create_date desc");
					
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_photo.pict_create_date) = '".date('Y')."' and month(sk_photo.pict_create_date) = '".date('m')."' and day(sk_photo.pict_create_date) = '".date('d')."' and sk_photo.pict_status ='1' order by sk_photo.pict_create_date desc");
				
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if ($gClient->getAccessToken()) {
	
            	$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
            	$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_photo.pict_create_date) = '".date('Y')."' and month(sk_photo.pict_create_date) = '".date('m')."' and day(sk_photo.pict_create_date) = '".date('d')."' and sk_photo.pict_status ='1' order by sk_photo.pict_create_date desc");
					
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status ='1' group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri and sk_post.flag_id = 'FLG00002' and sk_tag.tag_status ='1' group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_photo.pict_create_date) = '".date('Y')."' and month(sk_photo.pict_create_date) = '".date('m')."' and day(sk_photo.pict_create_date) = '".date('d')."' and sk_photo.pict_status ='1' order by sk_photo.pict_create_date desc");
				
					//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else{
				$artikel = urldecode($this->uri->segment(2));
				if($artikel == 'artikel'){
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_photo.pict_create_date) = '".date('Y')."' and month(sk_photo.pict_create_date) = '".date('m')."' and day(sk_photo.pict_create_date) = '".date('d')."' and sk_photo.pict_status ='1' order by sk_photo.pict_create_date desc");
					
					$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");	
				}else{
					$kanal = urldecode($this->uri->segment(3));
					$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
					$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
					$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
					$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
					$data['get_index'] = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_photo.pict_create_date) = '".date('Y')."' and month(sk_photo.pict_create_date) = '".date('m')."' and day(sk_photo.pict_create_date) = '".date('d')."' and sk_photo.pict_status ='1' order by sk_photo.pict_create_date desc");
				
					$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
					$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
					
				}
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/picture/index_list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
		}
		
		
		function tag($nama){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$nama = urldecode($this->uri->segment(3));
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_tag.tag_name = '".$nama."' order by sk_post.post_modify_date desc");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header2',$data);
				$this->load->view('front/tag/list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				$nama = urldecode($this->uri->segment(3));
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			    $data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_tag.tag_name = '".$nama."' order by sk_post.post_modify_date desc");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header2',$data);
				$this->load->view('front/tag/list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if ($gClient->getAccessToken()) {
	
            	$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
            	$nama = urldecode($this->uri->segment(3));
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_tag.tag_name = '".$nama."' order by sk_post.post_modify_date desc");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header2',$data);
				$this->load->view('front/tag/list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else{
				$nama = urldecode($this->uri->segment(3));
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_tag.tag_name = '".$nama."' order by sk_post.post_modify_date desc");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header2',$data);
				$this->load->view('front/tag/list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
		}
		
		function dashboard(){
		    $cek = $this->session->userdata('loginsuccess');
			if($cek){
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
				$query_account = $this->db->query("select * from sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_guest.guest_id='".$this->session->userdata('user_id')."'");
				foreach($query_account->result() as $acc){
					//$data[''] = $acc->guest_profile_name;
					$data['name'] = $acc->guest_profile_name;
					$data['gender'] = $acc->guest_profile_gender; 
					$data['email'] = $acc->guest_email;
					$data['website'] = $acc->guest_website;
					$data['pict'] = $acc->guest_profile_pict;
					$data['username'] = $acc->guest_username;
					$data['password'] = $acc->guest_password;
				}
				
				$data['error'] = '';
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/dashboard/dashboard_main',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else{
				Header("Location:".base_url());
			}
		}
	
		function act_change_pict(){
			$configu['upload_path'] = './uploads/user/original/';
			$configu['upload_url'] = base_url().'uploads/user/original/';
			$configu['allowed_types'] = 'gif|jpeg|jpg|png';
			$configu['max_size'] = '10000';
			$configu['max_width'] = '10000';
			$configu['max_height'] = '10000';
			
			$this->load->library('upload',$configu);
			
			if (!$this->upload->do_upload('pict'))
			{
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
			
				$query_account = $this->db->query("select * from sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_guest.guest_id='".$this->session->userdata('user_id')."'");
				foreach($query_account->result() as $acc){
					//$data[''] = $acc->guest_profile_name;
					$data['name'] = $acc->guest_profile_name;
					$data['gender'] = $acc->guest_profile_gender; 
					$data['email'] = $acc->guest_email;
					$data['website'] = $acc->guest_website;
					$data['pict'] = $acc->guest_profile_pict;
					$data['username'] = $acc->guest_username;
					$data['password'] = $acc->guest_password;
				}
				
				$data['error'] = "<div id='notif1' style='width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>".$this->upload->display_errors()."</span></div></div>";
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top-logged',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/dashboard/dashboard_main',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
			else
			{
				$upload_data = $this->upload->data();
			
				$config1['image_library'] = 'GD2';
				$config1['source_image'] = $upload_data['full_path'];
				$config1['new_image'] = 'uploads/user/thumb/'.$upload_data['file_name'];
				$config1['maintain_ratio'] = TRUE;
				$config1['width'] = 128;
				$config1['height'] = 128;

				$this->load->library('image_lib', $config1);

				if(!$this->image_lib->resize()){
					echo $this->image_lib->display_errors();
				}
				
				$id = $this->session->userdata('user_id');
				$query_profile_check = $this->db->query("select * from sk_guest where guest_id = '".$id."'");
				foreach($query_profile_check->result() as $prf){
					$id_profile = $prf->guest_profile_id;
				}
				$data['guest_profile_pict'] = $upload_data['file_name'];

				$edit_data1 = $this->sk_model->update_data('sk_guest_profile','guest_profile_id',$id_profile,$data);
				if($edit_data1){
					$this->session->set_flashdata('change_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Berhasil<br/><span style='font-size:11px;'>Foto profil telah terupdate!</span></div></div>");
					Header('Location:'.base_url().'index.php/berita/dashboard/');
				}else{
					$this->session->set_flashdata('change_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>Mohon coba lagi dengan foto yang lain!</span></div></div>");
					Header('Location:'.base_url().'index.php/berita/dashboard/');
				}
			}
		}
	
	
		function search_process(){
			$word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->input->post('search')));
			$url = str_replace(' ', '+', $word);
			header("Location: ".base_url()."index.php/berita/search/".$url); 
		}
		
		function search($word){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
            include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
            // Google Project API Credentials
            $clientId = '669121716175-6im0a9uru5gkrqtshcjvdj3pg4k865k3.apps.googleusercontent.com';
            $clientSecret = 'CnEgeiykCgZTImIH6_sVFVUD';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
			    $data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->uri->segment(3)));
				$data['word'] = $word;
				$url = str_replace(' ', '+', $word);
				$get_main = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
					
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.post_title like '%".$word."%' order by sk_post.post_modify_date desc");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/search/list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    
				// Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->uri->segment(3)));
				$data['word'] = $word;
				$url = str_replace(' ', '+', $word);
				$get_main = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
					
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.post_title like '%".$word."%' order by sk_post.post_modify_date desc");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/search/list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else if ($gClient->getAccessToken()) {
	
            	$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
	
				$word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->uri->segment(3)));
				$data['word'] = $word;
				$url = str_replace(' ', '+', $word);
				$get_main = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
					
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.post_title like '%".$word."%' order by sk_post.post_modify_date desc");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$this->load->view('front/global/top-logged_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/search/list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}else{
				$word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->uri->segment(3)));
				$data['word'] = $word;
				$url = str_replace(' ', '+', $word);
				$get_main = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
				$data['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
					
				$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
				$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
				$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
				
				$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.post_title like '%".$word."%' order by sk_post.post_modify_date desc");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				$data['google_url'] = $gClient->createAuthUrl();
				$data['get_video'] = $this->db->query("select * from sk_video order by video_id desc limit 1");
				$this->load->view('front/global/top_other',$data);
				$this->load->view('front/global/header',$data);
				$this->load->view('front/search/list',$data);
				$this->load->view('front/global/footer');
				$this->load->view('front/global/bottom');
			}
		}
	
		function get_data(){
			$start = $_POST['start'];
			$limit = $_POST['limit'];
			
			$start1 = $_POST['start1'];
			$limit1 = $_POST['limit1'];
			
			$start2 = $_POST['start2'];
			$limit2 = $_POST['limit2'];
			
			$get_list = $this->db->query("select post_title, post_direct, category_name, post_modify_date, post_thumb, post_url, post_shrt_desc, sk_post.flag_id, profile_back_name_full from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id AND sk_post.flag_id = 'FLG00002' and sk_post.post_status = '1' order by post_modify_date desc limit $start, $limit");
			
			$get_list_adventorial = $this->db->query("select post_title, post_direct, post_modify_date, post_thumb, post_url, post_shrt_desc, sk_post.flag_id, flag_name, profile_back_name_full from sk_post, sk_flag_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id AND sk_post.flag_id = 'FLG00001' and sk_post.post_status = '1' AND sk_post.flag_id = sk_flag_post.flag_id order by post_modify_date desc limit $start1, $limit1");
		
			$get_list_adv = $this->db->query("select adv_link as post_title, adv_link as post_direct, adv_link as post_modify_date, adv_pict as post_thumb, adv_link as post_url, adv_link as post_shrt_desc, 'adv' as flag_id, adv_link as flag_name, adv_link as profile_back_name_full from sk_adv where position_id='PSB00015' and adv_status='1' order by ObjectID desc limit $start2, $limit2");
										
			$data_list = array();
			
			foreach($get_list->result() as $grid1){
				$data_list[] = $grid1;
			}
			
			foreach($get_list_adventorial->result() as $grid2){
				$data_list[] = $grid2;
			}
			
			foreach($get_list_adv->result() as $grid3){
				$data_list[] = $grid3;
			}
			echo json_encode($data_list);
		}
		
		function get_data_kanal(){
			$start = $_POST['start'];
			$limit = $_POST['limit'];
			
			$kanal = $_POST['kanal'];
			
			$start1 = $_POST['start1'];
			$limit1 = $_POST['limit1'];
			
			$start2 = $_POST['start2'];
			$limit2 = $_POST['limit2'];
			
			$get_list = $this->db->query("select post_title, post_direct, category_name, post_modify_date, post_thumb, post_url, post_shrt_desc, profile_back_name_full from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name = '".$kanal."' and sk_post.post_status = '1' order by post_modify_date desc limit $start, $limit");
			
			$get_list_adventorial = $this->db->query("select post_title, post_direct, post_modify_date, post_thumb, post_url, post_shrt_desc, sk_post.flag_id, flag_name, profile_back_name_full from sk_post, sk_flag_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_status = '1' AND sk_post.flag_id = 'FLG00001' AND sk_post.flag_id = sk_flag_post.flag_id order by post_modify_date desc limit $start1, $limit1");
		
			$get_list_adv = $this->db->query("select adv_link as post_title, adv_link as post_direct, adv_link as post_modify_date, adv_pict as post_thumb, adv_link as post_url, adv_link as post_shrt_desc, 'adv' as flag_id, adv_link as flag_name, adv_link as profile_back_name_full from sk_adv where position_id='PSB00015' and adv_status='1' order by ObjectID desc limit $start2, $limit2");
			
			
			$data_list = array();
			
			foreach($get_list->result() as $grid1){
				$data_list[] = $grid1;
				
			}
			
			foreach($get_list_adventorial->result() as $grid2){
				$data_list[] = $grid2;
			}
			
			foreach($get_list_adv->result() as $grid3){
				$data_list[] = $grid3;
			}
			echo json_encode($data_list);
		}
	
		function get_validation_login(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$this->form_validation->set_rules('username','username','trim|required');
				$this->form_validation->set_rules('password','password','trim|required');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$username = $this->input->post("username");
					$password = $this->input->post("password");
					$query_validation = $this->db->query("select * from sk_guest where guest_username = '".$username."' and guest_password = '".$password."' and guest_status=1");
					if($query_validation->num_rows() == 0 ){
						$dataz = array(
							'status' => 'invalid',
						);
						echo json_encode($dataz);
					}else{
						foreach($query_validation->result() as $db){
							$sess['loginsuccess'] = 'success';
							$sess['user_id'] = $db->guest_id;
							$sess['user_profile_id'] = $db->guest_profile_id;
							$sess['user_name'] = $db->guest_name;
							$this->session->set_userdata($sess);
							
							date_default_timezone_set('Asia/Jakarta');
							$data['guest_log_date'] = date("Y-m-d H:i:s");
							$this->sk_model->update_data('sk_guest', 'guest_id', $db->guest_id, $data);
							
						}
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}
				}
			}
		}
		
		function get_logout(){
			$this->session->sess_destroy();
			$cek = $this->session->userdata('login_code_ba');
			if($cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		public function logout() {
    		// Remove local Facebook session
    		$this->facebook->destroy_session();
    		// Remove user data from session
    		$this->session->unset_userdata('userData');
    		// Redirect to login page
            redirect('/user_authentication');
        }
		
		function get_add_account(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$this->form_validation->set_rules('name_reg','nama','trim|required');
				$this->form_validation->set_rules('email_reg','email','trim|required');
				$this->form_validation->set_rules('username_reg','username','trim|required');
				$this->form_validation->set_rules('password_reg','password','trim|required');
				$this->form_validation->set_rules('agree','persyaratan','trim|required');
				$this->form_validation->set_rules('konfirmasi_reg','konfirmasi','trim|required|matches[password_reg]');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$name = $this->input->post("name_reg");
					$email = $this->input->post("email_reg");
					$username = $this->input->post("username_reg");
					$password = $this->input->post("password_reg");
					$agree = $this->input->post("agree");
					if($agree > 0 or $agree != '' or $agree != null){
						$query_validation = $this->db->query("select * from sk_guest where (guest_username = '".$username."' and guest_password = '".$password."') or guest_email = '".$email."'");
						if($query_validation->num_rows() == 0 ){
							$data['guest_id'] = $this->sk_model->getMaxKodemiddle('sk_guest', 'guest_id', 'GST');
							$data['guest_profile_id'] = $this->sk_model->getMaxKodemiddle('sk_guest', 'guest_profile_id', 'GPF');
							$data['guest_name'] = $name;
							$data['guest_email'] = $email;
							$data['guest_username'] = $username;
							$data['guest_password'] = $password;
							$data['guest_log_date'] = date('Y-m-d H:s:i');
							$data['guest_status'] = 0;
							
							$data_a['guest_id'] = $data['guest_id'];
							$data_a['activate_code'] = md5($data['guest_password']);
							$data_a['url_activate'] = 'http://suarakaryanews.com/index.php/berita/activate/'.$data_a['activate_code'];
							
							$data_b['guest_profile_id'] = $data['guest_profile_id'];
							$data_b['guest_profile_name'] = $data['guest_name'];
							$data_b['guest_profile_email'] = $data['guest_email'];
							
							$query_insert_data = $this->sk_model->insert_data('sk_guest', $data);
							$query_insert_data_activate = $this->sk_model->insert_data('sk_activate', $data_a);
							$query_insert_data_profile = $this->sk_model->insert_data('sk_guest_profile', $data_b);
							if($query_insert_data and $query_insert_data_activate and $query_insert_data_profile){
								$username = 'no.reply.suarakaryanews';
								$sender_email = 'no.reply.suarakaryanews@gmail.com';
								$user_password = 'su4r4k4ry4news';
								$subject = 'Activation Account (SuarakaryaNews.com)';
								$name = $data['guest_name'];
								$url_activate = $data_a['url_activate'];
								$message = '	<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
														<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
															<tbody>
																<tr style="background-image:url(http://suarakaryanews.com/assets/background.jpg);background-size:cover;">
																	<td style="width:100%;padding:0px;" colspan="2">
																		<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																			<tr>
																				<td><span style="color:#fff;font-family:arial;font-size:12px;margin:0px;margin-left:20px;font-weight:normal;">&nbsp;</span></td>
																				<td style="text-align:right"><h1 style="color:#fff;font-family:Andalus,Arial;font-size:32px;margin:0px;margin-right:20px;font-weight:normal;">#ActivationAccount</h1>
																				<span style="text-align:right;color:#fff;margin-right:20px;font-size:12px;">SuarakaryaNews.com menghadirkan berita-berita teraktual dan terpercaya</span></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td style="width:100%;font-family:calibri;padding:10px;border-bottom:1px solid #f9f9f9;border-top:1px solid #f9f9f9;padding-bottom:30px;padding-top:30px;" colspan="2" align="center">
																		<table style="width:80%;">
																			<tr>
																				<td>
																					<div style="margin-left:10px;color:#999;text-align:center;">
																						<h2>#ActivationAccount</h2>
																						<p>Hallo Mr/Mrs.'.$name.', Silahkan klik link di bawah ini untuk activasi account anda pada SuarakaryaNews.com</p>
																						<p style="margin-top:5px;">'.$url_activate.'</p>
																					</div>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td style="width:100%;font-family:arial;padding:20px;text-align:center;" colspan="2">
																		<span style="color:#999;font-size:12px;">Email ini dibuat secara otomatis, mohon untuk tidak mengirimkan pesan balasan ke email ini.</span>
																	</td>
																</tr>
																<tr style="border-collapse:collapse;background:#f9f9f9;margin:0;padding:0;">
																	<td style="width:100%;">
																		<table style="width:50%;margin:0 auto;">
																			<tr style="text-align:center;">
																				<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
																					<div style="text-align:center;">
																						<img src="http://suarakaryanews.com/assets/img/logo.png" style="padding-left:10px;padding-top:10px;padding-bottom:10px;" width="100"/>
																					</div>
																					<div style="margin-top:-2px;text-align:center;">
																						<span style="color:#999;font-size:11px;">2016 &copy; SuarakaryaNews.com</span>
																					</div>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</tbody>
															</table>
														</div>';
								
								// Configure email library
								$config['protocol'] = 'smtp';
								$config['smtp_host'] = 'ssl://smtp.googlemail.com';
								$config['smtp_port'] = 465;
								$config['smtp_user'] = $sender_email;
								$config['smtp_pass'] = $user_password;
								$config['mailtype'] = 'html';
								$config['charset'] = 'iso-8859-1';
								
								
								// Load email library and passing configured values to email library
								$this->load->library('email', $config);
								$this->email->set_newline("\r\n");
				
								// Sender email address
								$this->email->from($sender_email, $username);
								// Receiver email address
								$this->email->to($data['guest_email']);
								$this->email->cc('evan.abeiza@gmail.com');
								// Subject of email
								$this->email->subject($subject);
								// Message in email
								$this->email->message($message);
								// Action Sending Mesage
								$send_user = $this->email->send();
											
								if($send_user == true){
									$dataz = array(
										'status' => 'success',
									);
									echo json_encode($dataz);
								}
							}else{
								$dataz = array(
									'status' => 'failed',
								);
								echo json_encode($dataz);
							}
						}else{
							$dataz = array(
								'status' => 'available',
							);
							echo json_encode($dataz);
						}
					}else{
						$dataz = array(
							'status' => 'validation',
						);
						echo json_encode($dataz);
					}
				}
			}
		}
	
		function get_forget_account(){
			$this->form_validation->set_rules('email_forget','email','trim|required');
			if($this->form_validation->run() == false){
				$dataz = array(
					'status' => 'validation',
				);
				echo json_encode($dataz);
			}else{
				$email_forget = $this->input->post('email_forget');
				
				$query_forget_check = $this->db->query("select * from sk_guest where guest_email = '".$email_forget."' and guest_status = 1");
				if($query_forget_check->num_rows() == 0){
					$dataz = array(
						'status' => 'invalid',
					);
					echo json_encode($dataz);
				}else{
					foreach($query_forget_check->result() as $fgt){
						$id = $fgt->guest_id;
						$data['guest_username'] = $fgt->guest_id;
						$data['guest_password'] = $fgt->guest_id;
						
						$update_forget = $this->sk_model->update_data('sk_guest', 'guest_id', $id, $data);
						if($update_forget){
							$username = 'no.reply.suarakaryanews';
							$sender_email = 'no.reply.suarakaryanews@gmail.com';
							$user_password = 'su4r4k4ry4news';
							$subject = 'Forget Account (SuarakaryaNews.com)';
							$message = '	<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
													<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
														<tbody>
															<tr style="background-image:url(http://suarakaryanews.com/assets/background.jpg);background-size:cover;">
																<td style="width:100%;padding:0px;" colspan="2">
																	<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																		<tr>
																			<td><span style="color:#fff;font-family:arial;font-size:12px;margin:0px;margin-left:20px;font-weight:normal;">&nbsp;</span></td>
																			<td style="text-align:right"><h1 style="color:#fff;font-family:Andalus,Arial;font-size:32px;margin:0px;margin-right:20px;font-weight:normal;">#ForgetAccount</h1>
																			<span style="text-align:right;color:#fff;margin-right:20px;font-size:12px;">SuarakaryaNews.com menghadirkan berita-berita teraktual dan terpercaya</span></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td style="width:100%;font-family:calibri;padding:10px;border-bottom:1px solid #f9f9f9;border-top:1px solid #f9f9f9;padding-bottom:30px;padding-top:30px;" colspan="2" align="center">
																	<table style="width:80%;">
																		<tr>
																			<td>
																				<div style="margin-left:10px;color:#999;text-align:center;">
																					<h2>#ForgetAccount</h2>
																					<p>Hallo Mr/Mrs.'.$fgt->guest_name.', Berikut data akun anda yang baru. Mohon untuk mereset username dan password anda jika anda telah login dengan data di bawah ini.</p>
																					<p style="margin-top:5px;">Username : '.$data['guest_username'].'</p>
																					<p style="margin-top:5px;">Password : '.$data['guest_password'].'</p>
																				</div>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td style="width:100%;font-family:arial;padding:20px;text-align:center;" colspan="2">
																	<span style="color:#999;font-size:12px;">Email ini dibuat secara otomatis, mohon untuk tidak mengirimkan pesan balasan ke email ini.</span>
																</td>
															</tr>
															<tr style="border-collapse:collapse;background:#f9f9f9;margin:0;padding:0;">
																<td style="width:100%;">
																	<table style="width:50%;margin:0 auto;">
																		<tr style="text-align:center;">
																			<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
																				<div style="text-align:center;">
																					<img src="http://suarakaryanews.com/assets/img/logo.png" style="padding-left:10px;padding-top:10px;padding-bottom:10px;" width="100"/>
																				</div>
																				<div style="margin-top:-2px;text-align:center;">
																					<span style="color:#999;font-size:11px;">2016 &copy; SuarakaryaNews.com</span>
																				</div>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</tbody>
														</table>
													</div>';
							
							// Configure email library
							$config['protocol'] = 'smtp';
							$config['smtp_host'] = 'ssl://smtp.googlemail.com';
							$config['smtp_port'] = 465;
							$config['smtp_user'] = $sender_email;
							$config['smtp_pass'] = $user_password;
							$config['mailtype'] = 'html';
							$config['charset'] = 'iso-8859-1';
							
							
							// Load email library and passing configured values to email library
							$this->load->library('email', $config);
							$this->email->set_newline("\r\n");
			
							// Sender email address
							$this->email->from($sender_email, $username);
							// Receiver email address
							$this->email->to($email_forget);
							$this->email->cc('evan.abeiza@gmail.com');
							// Subject of email
							$this->email->subject($subject);
							// Message in email
							$this->email->message($message);
							// Action Sending Mesage
							$send_user = $this->email->send();
							
							$dataz = array(
								'status' => 'success',
							);
							echo json_encode($dataz);
						}else{
							$dataz = array(
								'status' => 'failed',
							);
							echo json_encode($dataz);
						}
					}
				}
			}
		}
	
		function set_update_profile(){
			$cek = $this->session->userdata('loginsuccess');
			if(!$cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$this->form_validation->set_rules('name_profile','nama','trim|required');
				$this->form_validation->set_rules('email_profile','email','trim|required');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$id = $this->session->userdata('user_id');
					$query_profile_check = $this->db->query("select * from sk_guest where guest_id = '".$id."'");
					foreach($query_profile_check->result() as $prf){
						$id_profile = $prf->guest_profile_id;
					}
					$data['guest_profile_name'] = $this->input->post('name_profile');
					$data1['guest_email'] = $this->input->post('email_profile');
					$data['guest_website'] = $this->input->post('website_profile');

					$edit_data1 = $this->sk_model->update_data('sk_guest_profile','guest_profile_id',$id_profile,$data);
					$edit_data2 = $this->sk_model->update_data('sk_guest','guest_id',$id,$data1);
					if($edit_data1 and $edit_data2){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}
			}
		}
		
		function set_update_password(){
			$cek = $this->session->userdata('loginsuccess');
			if(!$cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$this->form_validation->set_rules('change_username','username','trim|required');
				$this->form_validation->set_rules('change_conf','konfirmasi','trim|matches[change_new]');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$id = $this->session->userdata('user_id');
					
					if($this->input->post('change_new') != '' or $this->input->post('change_new') != null){
						$data['guest_password'] = $this->input->post('change_new');
					}else{
						$data['guest_password'] = $this->input->post('change_password');
					}
					
					$data['guest_username'] = $this->input->post('change_username');
					
					$edit_data1 = $this->sk_model->update_data('sk_guest','guest_id',$id,$data);
					if($edit_data1){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}
			}
		}
	
	}
	
/*End of file berita.php*/
/*Location:.application/controllers/berita.php*/