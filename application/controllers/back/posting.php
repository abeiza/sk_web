<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Posting extends CI_Controller{
		function __construct(){
			parent::__construct();
			date_default_timezone_set('Asia/Jakarta');
			
			// Load facebook library
    		$this->load->library('facebook');
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
				
				if($this->session->userdata('lv') == 'POT00002'){
					$list['get_post'] = $this->db->query("select post_id, post_title, post_shrt_desc, kanal_name, category_name, user_back_name, post_status, post_modify_date  
					from sk_post, sk_category, sk_user_back , sk_kanal 
					where sk_post.post_posted_by = '".$this->session->userdata('id')."' and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.flag_id = 'FLG00002' and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.category_id = sk_category.category_id 
					order by post_modify_date desc");
					
					$list['get_post_list'] = $this->db->query("select post_id, post_title, post_shrt_desc, kanal_name, category_name, user_back_name, post_status, post_modify_date  
					from sk_post, sk_category, sk_user_back , sk_kanal 
					where sk_post.post_posted_by = '".$this->session->userdata('id')."' and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.flag_id = 'FLG00002' and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.category_id = sk_category.category_id 
					order by post_modify_date desc Limit 100 ");
				}else{
					$list['get_post'] = $this->db->query("select post_id, post_title, post_shrt_desc, kanal_name, category_name, user_back_name, post_status, post_modify_date  
					from sk_post, sk_category, sk_user_back , sk_kanal 
					where sk_category.kanal_id = sk_kanal.kanal_id and sk_post.flag_id = 'FLG00002' and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.category_id = sk_category.category_id 
					order by post_modify_date desc");
					
					$list['get_post_list'] = $this->db->query("select post_id, post_title, post_shrt_desc, kanal_name, category_name, user_back_name, post_status, post_modify_date  
					from sk_post, sk_category, sk_user_back , sk_kanal 
					where sk_category.kanal_id = sk_kanal.kanal_id and sk_post.flag_id = 'FLG00002' and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.category_id = sk_category.category_id 
					order by post_modify_date desc Limit 100");
				}
				
				$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal where kanal_status = '1' order by kanal_name");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/post/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/post/bottom_post');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function list_by($kanal){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$kanal = $this->uri->segment(4);
				$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
				foreach($query1->result() as $sess){
					$data['id'] = $sess->profile_back_id;
					$data['full'] = $sess->profile_back_name_full;
					$data['nick'] = $sess->profile_back_nick;
					$data['pict'] = $sess->profile_back_pict;
					$data['email'] = $sess->profile_back_email;
				}
				
				$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal where kanal_status = '1' order by kanal_name");
				
				if($this->session->userdata('lv') == 'POT00002'){
					$list['get_post'] = $this->db->query("select post_id, post_title, kanal_name, post_shrt_desc, category_name, user_back_name, post_status, post_modify_date  
					from sk_post, sk_category, sk_user_back, sk_kanal   
					where sk_post.post_posted_by = '".$this->session->userdata('id')."' and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_id = '".$kanal."' and sk_post.flag_id = 'FLG00002' and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.category_id = sk_category.category_id 
					order by post_modify_date desc");
					
					$list['get_post_list'] = $this->db->query("select post_id, post_title, kanal_name, post_shrt_desc, category_name, user_back_name, post_status, post_modify_date  
					from sk_post, sk_category, sk_user_back, sk_kanal   
					where sk_post.post_posted_by = '".$this->session->userdata('id')."' and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_id = '".$kanal."' and sk_post.flag_id = 'FLG00002' and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.category_id = sk_category.category_id 
					order by post_modify_date desc limit 100 ");
				}else{
					$list['get_post'] = $this->db->query("select post_id, post_title, kanal_name, post_shrt_desc, category_name, user_back_name, post_status, post_modify_date  
					from sk_post, sk_category, sk_user_back, sk_kanal   
					where sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_id = '".$kanal."' and sk_post.flag_id = 'FLG00002' and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.category_id = sk_category.category_id 
					order by post_modify_date desc");
					
					$list['get_post_list'] = $this->db->query("select post_id, post_title, kanal_name, post_shrt_desc, category_name, user_back_name, post_status, post_modify_date  
					from sk_post, sk_category, sk_user_back, sk_kanal   
					where sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_id = '".$kanal."' and sk_post.flag_id = 'FLG00002' and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.category_id = sk_category.category_id 
					order by post_modify_date desc limit 100 ");
				}
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/post/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/post/bottom_post');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function add_form(){
			$cek = $this->session->userdata('login_session');
			if(!$cek){
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}else{
				$data['error']= '';
				$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
				foreach($query1->result() as $sess){
					$data['id'] = $sess->profile_back_id;
					$data['full'] = $sess->profile_back_name_full;
					$data['nick'] = $sess->profile_back_nick;
					$data['pict'] = $sess->profile_back_pict;
					$data['email'] = $sess->profile_back_email;
				}
				
				$data['category'] = $this->db->query("select kanal_name, category_id, category_name from sk_kanal, sk_category where sk_kanal.kanal_id = sk_category.kanal_id and sk_category.category_status = '1' order by sk_kanal.kanal_name, sk_category.category_name");
				$data['tag'] = $this->db->query("select tag_id, tag_name from sk_tag where tag_status = '1' order by tag_modify_date desc");
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/post/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/post/bottom_post');
			}
		}
	
		function add(){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$this->form_validation->set_rules('title','title','trim|required|max_length[225]');
				$this->form_validation->set_rules('short','short descriptions','trim|required');
				$this->form_validation->set_rules('desc','descriptions','trim|required');
				$this->form_validation->set_rules('category','category','required');
				$this->form_validation->set_rules('tag','tag focus','required');
				
				if(empty($_FILES['pict']['name'])){
					$this->form_validation->set_rules('pict', 'image logo', 'required');
				}
				
				if($this->form_validation->run() == false){
					$this->add_form();
				}else{
					$configu['upload_path'] = './uploads/post/original/';
					$configu['upload_url'] = base_url().'uploads/post/original/';
					$configu['allowed_types'] = 'gif|jpeg|jpg|png';
					$configu['max_size'] = '10000';
					$configu['max_width'] = '100000';
					$configu['max_height'] = '100000';
					
					$this->load->library('upload',$configu);
					
					if (!$this->upload->do_upload('pict'))
					{
						$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
						foreach($query1->result() as $sess){
							$data['id'] = $sess->profile_back_id;
							$data['full'] = $sess->profile_back_name_full;
							$data['nick'] = $sess->profile_back_nick;
							$data['pict'] = $sess->profile_back_pict;
							$data['email'] = $sess->profile_back_email;
						}
						
						$data['error'] = "<div id='notif1' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>".$this->upload->display_errors()."</span></div></div>";
						
						$data['category'] = $this->db->query("select kanal_name, category_id, category_name from sk_kanal, sk_category where sk_kanal.kanal_id = sk_category.kanal_id order by sk_kanal.kanal_name, sk_category.category_name");
						$data['tag'] = $this->db->query("select tag_id, tag_name from sk_tag order by tag_modify_date desc");
					
						$this->load->view('back/global/top');
						$this->load->view('back/global/header',$data);
						$this->load->view('back/post/add_form',$data);
						$this->load->view('back/global/footer');
						$this->load->view('back/post/bottom_post');
						
					} else {
					    
						$upload_data = $this->upload->data();
					
						$config1['image_library'] = 'GD2';
						$config1['source_image'] = $upload_data['full_path'];
						$config1['new_image'] = 'uploads/post/thumb/'.$upload_data['file_name'];
						//$config1['create_thumb'] = TRUE;
						$config1['maintain_ratio'] = TRUE;
						$config1['width'] = 600;

						$this->load->library('image_lib', $config1);
						$this->image_lib->initialize($config1);
						
						if(!$this->image_lib->resize()){
							echo $this->image_lib->display_errors();
							
						} else {
						    
						    $title_post = trim($this->input->post('title'));
    						$title_url = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $title_post);
    						$data['post_id'] = $this->sk_model->getMaxKodelong('sk_post', 'post_id', 'POS');
    						$data['post_title'] = $this->input->post('title');
    						$data['post_shrt_desc'] = $this->input->post('short');
    						$data['post_desc'] = $this->input->post('desc');
    						$data['category_id'] = $this->input->post('category');
    						$data['post_pict'] = $upload_data['file_name'];
    						$data['post_thumb'] = $upload_data['file_name'];
    						$data['post_posted_by'] = $this->session->userdata('id');
    						$data['post_modify_date'] = date("Y-m-d H:i:s");
    						$data['post_url'] = str_replace(' ', '+', $title_url);
    						$data['post_pdf'] = $this->input->post('pdf');
    						$data['post_keywords'] = $this->input->post('key');
    						$data['tag_id'] = $this->input->post('tag');
    						$data['flag_id'] = 'FLG00002';
    						$data['post_status'] = $this->input->post('status');
    				
    						$add_data = $this->sk_model->insert_data('sk_post', $data);
    						
    						
    						if($data['post_status'] == '1'){
    						    
    						    //POSTING FACEBOOK
    						    $post_id = $data['post_id'];
    						    $get_post_article = $this->db->query("select post_id, post_title, post_shrt_desc, post_pict, post_url  
                                                    from sk_post where post_id = '".$post_id."'");
                                foreach($get_post_article->result() as $post_article){
                                    //$get_post_pict = $post_article->post_pict;
                                    $get_post_title = $post_article->post_title;
                                    $get_post_url = $post_article->post_url;
                                    $get_post_shrt_desc = $post_article->post_shrt_desc;
                                }
                                
        						$userAccessToken = 'EAAEPgdYZAvawBADMZBL3ZBqv6NyUHRlBESoGXYf3KoNQjDJfA7MF9gkndVTbpZCI2cmk7Nv5pSUmvsmFntO5yHeM1IZB5oxVi9MGl5xjkDjl05pzITE0XMhw9t0Tx7Gd3JKETdlhKUd5MnWbOLJe11bHxnbU2rW0ZD';
        						$page_id = '1298010740253719';
        						$get_url = 'http://m.suarakaryanews.com/index.php/berita/artikel/'.$get_post_url;
        						
        						$data['message'] = $get_post_title;
        						$data['name'] = 'Suara Karya News';
        						$data['link'] = $get_url;
        						$data['description'] = $get_post_shrt_desc;
        						$data['access_token'] = $userAccessToken;
                                $post_url = 'https://graph.facebook.com/'.$page_id.'/feed';
                                
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $post_url);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,5);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                $return = curl_exec($ch);
                                curl_close($ch);
                                
    						    //POSTING TWITTER
                                require_once('./assets/codebird-php-develop/src/codebird.php');
                                 
                                \Codebird\Codebird::setConsumerKey("VqFzLQJRfIxX0Mbt9HO4VxeNX", "ko5FfipdHY6VN1MJMSMBcvh3MoW2YmbaHpRwJh7hafYTO9z1Vp");
                                $cb = \Codebird\Codebird::getInstance();
                                $cb->setToken("862295903951929344-nYPh4FWe0myoVdNEF9qkxFtHcxwN7n5", "jd1SjHaqBxByUxzFk8lY7keElT6dvJXSjbl97aDGVK27l");
                                 
                                $params_twit = array(
                                  'status' => $data['post_title'].' http://suarakaryanews.com/index.php/berita/artikel/'.$data['post_url'],
                                  'media[]' => 'http://suarakaryanews.com/uploads/post/original/'.$data['post_pict'],
                                );
                                $cb->statuses_updateWithMedia($params_twit);
    						}
    					
    						if(!$add_data){
    							$this->session->set_flashdata('post_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
    							Header('Location:'.base_url().'index.php/back/posting/');
    						}else{
    							$this->session->set_flashdata('post_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
    							Header('Location:'.base_url().'index.php/back/posting/');
    						}
						}
					}
				}
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		/*function facebookAutoPost(){
		    require_once "./assets/src/facebook.php"; // set the right path

		    $configu = array();
            $configu['appId'] = '298525293919660';
            $configu['secret'] = 'c0b68e90eca3a7bfbe1e094aff585ffd';
            $configu['fileUpload'] = false; // optional
            $fb = new Facebook($configu);
             
            $params = array(
              "access_token" => "EAAEPgdYZAvawBAJrR684nUZCDXHAJno5sQ1do9jo4MvcWufYVaLXgzGOd0AHDgV1LbbPaXZATAzBy51NpZBAkVJhpsZBQQkGjZBYId8sUs2ZBt6g0dBnKiuJdnw12BJQ3PrJOIDqAZC5sUM7BX3chnVABpv3QW0u34gZD", // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
              "message" => "Bom Bunuh Diri di Manchester Ancaman Bagi Kemanusiaan",
              "link" => "http://suarakaryanews.com/index.php/berita/artikel/Bom+Bunuh+Diri+di+Manchester+Ancaman+Bagi+Kemanusiaan",
              "picture" => "http://suarakaryanews.com/uploads/post/original/Novanto.jpg",
              "name" => "Bom Bunuh Diri di Manchester Ancaman Bagi Kemanusiaan",
              "caption" => "www.suarakaryanews.com",
              "description" => "JAKARTA (Suara Karya): Duka kembali menyelimuti dunia, khususnya Kota Manchester, Inggris. Kurang lebih 20 orang tewas dan 50 orang lainnya luka-luka akibat ledakan bom yang mengguncang Manchester Arena dan sekitarnya pada Senin 22 Mei 2017 waktu setempat."
            );
            
            /*$params = array(
              // this is the access token for Fan Page
              "access_token" => "EAAEPgdYZAvawBAJrR684nUZCDXHAJno5sQ1do9jo4MvcWufYVaLXgzGOd0AHDgV1LbbPaXZATAzBy51NpZBAkVJhpsZBQQkGjZBYId8sUs2ZBt6g0dBnKiuJdnw12BJQ3PrJOIDqAZC5sUM7BX3chnVABpv3QW0u34gZD",
              "message" => "Bom Bunuh Diri di Manchester Ancaman Bagi Kemanusiaan \nJAKARTA (Suara Karya): Duka kembali menyelimuti dunia, khususnya Kota Manchester, Inggris. Kurang lebih 20 orang tewas dan 50 orang lainnya luka-luka akibat ledakan bom yang mengguncang Manchester Arena dan sekitarnya pada Senin 22 Mei 2017 waktu setempat.\n http://suarakaryanews.com/index.php/berita/artikel/Bom+Bunuh+Diri+di+Manchester+Ancaman+Bagi+Kemanusiaan",
              "source" => "@" . "/uploads/post/original/Novanto.jpg", // ATTENTION give the PATH not URL
            );*/
            
            // post to Facebook
            // see: https://developers.facebook.com/docs/reference/php/facebook-api/
            
            /*$post_url = 'https://graph.facebook.com/1298010740253719/feed';
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $post_url);
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              $return = curl_exec($ch);
              curl_close($ch);
            
            try {
              $ret = $fb->api('/1298010740253719/feed', 'POST', $params);
              echo 'Successfully posted to Facebook';
            } catch(Exception $e) {
              echo $e->getMessage();
            }
		}*/
		
		function twitAutoPost(){
		    // require codebird
            require_once('./assets/codebird-php-develop/src/codebird.php');
             
            \Codebird\Codebird::setConsumerKey("VqFzLQJRfIxX0Mbt9HO4VxeNX", "ko5FfipdHY6VN1MJMSMBcvh3MoW2YmbaHpRwJh7hafYTO9z1Vp");
            $cb = \Codebird\Codebird::getInstance();
            $cb->setToken("862295903951929344-nYPh4FWe0myoVdNEF9qkxFtHcxwN7n5", "jd1SjHaqBxByUxzFk8lY7keElT6dvJXSjbl97aDGVK27l");
             
            $params = array(
              'status' => 'Auto Post on Twitter with PHP http://goo.gl/OZHaQD #php #twitter',
              'media[]' => base_url().'uploads/advertise/original/WhatsApp_Image_2017-05-06_at_9.14_.51_PM_.jpeg'
            );
            $reply = $cb->statuses_updateWithMedia($params);
		}
		
		function fb_token(){
		    print_r($_GET);
		}
		
		function edit_form($id){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$id = $this->uri->segment(4);
				$post_read = $this->db->query("select * from sk_post where post_id='".$id."'");
				foreach($post_read->result() as $db){
					$data['id'] = $db->post_id;
					$data['title'] = $db->post_title;
					$data['short'] = $db->post_shrt_desc;
					$data['desc'] = $db->post_desc;
					$data['cat'] = $db->category_id;
					$data['pict2'] = $db->post_pict;
					$data['status'] = $db->post_status;
					$data['key'] = $db->post_keywords;
					$data['tag'] = $db->tag_id;
					$data['pdf'] = $db->post_pdf;
				}
				
				$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
				foreach($query1->result() as $sess){
					$data['id'] = $sess->profile_back_id;
					$data['full'] = $sess->profile_back_name_full;
					$data['nick'] = $sess->profile_back_nick;
					$data['pict'] = $sess->profile_back_pict;
					$data['email'] = $sess->profile_back_email;
				}
				
				$data['category'] = $this->db->query("select kanal_name, category_id, category_name from sk_kanal, sk_category where sk_kanal.kanal_id = sk_category.kanal_id and sk_category.category_status = '1' order by sk_kanal.kanal_name, sk_category.category_name");
				$data['tag2'] = $this->db->query("select tag_id, tag_name from sk_tag where tag_status = '1' order by tag_modify_date desc");
					
				$data['error'] = '';
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/post/edit_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/post/bottom_post');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function edit($id){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$this->form_validation->set_rules('title','title','trim|required|max_length[225]');
				$this->form_validation->set_rules('short','short','trim|required');
				$this->form_validation->set_rules('desc','desc','trim|required');
				$this->form_validation->set_rules('category','category','required');
				$this->form_validation->set_rules('tag','tag focus','required');
				
				if($this->form_validation->run() == false){
					$this->edit_form($this->uri->segment(4));
				}else{
					if(empty($_FILES['pict']['name'])){
						
						$id = $this->uri->segment(4);
						$title_post = trim($this->input->post('title'));
						$title_url = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $title_post);
						$data['post_title'] = $this->input->post('title');
						$data['post_shrt_desc'] = $this->input->post('short');
						$data['post_desc'] = $this->input->post('desc');
						$data['category_id'] = $this->input->post('category');
						//$data['post_posted_by'] = $this->session->userdata('id');
						$data['post_pdf'] = $this->input->post('pdf');
						$data['post_modify_date'] = date("Y-m-d H:i:s");
						$data['post_url'] = str_replace(' ', '+', $title_url);;
						$data['post_keywords'] = $this->input->post('key');
						$data['tag_id'] = $this->input->post('tag');
						$data['post_status'] = $this->input->post('status');
				
						$add_data = $this->sk_model->update_data('sk_post', 'post_id', $id, $data);
						
						if(!$add_data){
							$this->session->set_flashdata('post_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/posting/edit_form/'.$id);
						}else{
							$this->session->set_flashdata('post_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/posting/edit_form/'.$id);
						}	
					}else{
						$configu['upload_path'] = './uploads/post/original/';
						$configu['upload_url'] = base_url().'uploads/post/original/';
						$configu['allowed_types'] = 'gif|jpeg|jpg|png';
						$configu['max_size'] = '10000';
						$configu['max_width'] = '100000';
						$configu['max_height'] = '100000';
						
						$this->load->library('upload',$configu);
						
						if (!$this->upload->do_upload('pict'))
						{
							$id = $this->uri->segment(4);
							$post_read = $this->db->query("select * from sk_post where post_id='".$id."'");
							foreach($post_read->result() as $db){
								$data['id'] = $db->post_id;
								$data['title'] = $db->post_title;
								$data['short'] = $db->post_shrt_desc;
								$data['desc'] = $db->post_desc;
								$data['category'] = $db->category_id;
								$data['pict2'] = $db->post_pict;
								$data['status'] = $db->post_status;
								$data['key'] = $db->post_keywords;
								$data['tag'] = $db->tag_id;
							    $data['pdf'] = $db->post_pdf;
							    
							}
							
							$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
							foreach($query1->result() as $sess){
								$data['id'] = $sess->profile_back_id;
								$data['full'] = $sess->profile_back_name_full;
								$data['nick'] = $sess->profile_back_nick;
								$data['pict'] = $sess->profile_back_pict;
								$data['email'] = $sess->profile_back_email;
							}
							
							$data['error'] = "<div id='notif1' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>".$this->upload->display_errors()."</span></div></div>";
						
							$data['category'] = $this->db->query("select kanal_name, category_id, category_name from sk_kanal, sk_category where sk_kanal.kanal_id = sk_category.kanal_id order by sk_kanal.kanal_name, sk_category.category_name");
							$data['tag'] = $this->db->query("select tag_id, tag_name from sk_tag order by tag_modify_date desc");
				
							$this->load->view('back/global/top');
							$this->load->view('back/global/header',$data);
							$this->load->view('back/post/edit_form',$data);
							$this->load->view('back/global/footer');
							$this->load->view('back/post/bottom_post');
						}
						else
						{
							$upload_data = $this->upload->data();
						
							$config1['image_library'] = 'GD2';
							$config1['source_image'] = $upload_data['full_path'];
							$config1['new_image'] = 'uploads/post/thumb/'.$upload_data['file_name'];
							//$config1['create_thumb'] = TRUE;
							$config1['maintain_ratio'] = TRUE;
							$config1['width'] = 254;
							$config1['height'] = 100;

							$this->load->library('image_lib', $config1);

							if(!$this->image_lib->resize()){
								echo $this->image_lib->display_errors();
							}
							
							$id = $this->uri->segment(4);
							$title_post = trim($this->input->post('title'));
							$title_url = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $title_post);
							$data['post_title'] = $this->input->post('title');
							$data['post_shrt_desc'] = $this->input->post('short');
							$data['post_desc'] = $this->input->post('desc');
							$data['category_id'] = $this->input->post('category');
							$data['post_pict'] = $upload_data['file_name'];
							$data['post_thumb'] = $upload_data['file_name'];
							$data['post_posted_by'] = $this->session->userdata('id');
							$data['post_modify_date'] = date("Y-m-d H:i:s");
							$data['post_pdf'] = $this->input->post('pdf');
							$data['post_url'] = str_replace(' ', '+', $title_url);;
							$data['post_keywords'] = $this->input->post('key');
							$data['tag_id'] = $this->input->post('tag');
							$data['post_status'] = $this->input->post('status');
							
							$add_data = $this->sk_model->update_data('sk_post', 'post_id', $id, $data);
							
							//POSTING FACEBOOK
    						if($data['post_status'] == '1'){
    						    
    						    //POSTING FACEBOOK
    						    $post_id = $id;
    						    $get_post_article = $this->db->query("select post_id, post_title, post_shrt_desc, post_pict, post_url  
                                                    from sk_post where post_id = '".$post_id."'");
                                foreach($get_post_article->result() as $post_article){
                                    //$get_post_pict = $post_article->post_pict;
                                    $get_post_title = $post_article->post_title;
                                    $get_post_url = $post_article->post_url;
                                    $get_post_shrt_desc = $post_article->post_shrt_desc;
                                }
                                
        						$userAccessToken = 'EAAEPgdYZAvawBADMZBL3ZBqv6NyUHRlBESoGXYf3KoNQjDJfA7MF9gkndVTbpZCI2cmk7Nv5pSUmvsmFntO5yHeM1IZB5oxVi9MGl5xjkDjl05pzITE0XMhw9t0Tx7Gd3JKETdlhKUd5MnWbOLJe11bHxnbU2rW0ZD';
        						$get_url = base_url().'index.php/berita/artikel/'.$get_post_url;
                                $param = [
                                    'message'       => $get_post_title,
                                    'name'          => 'Suara Karya News',
                                    'link'          => $get_url,
                                    'description'   => $get_post_shrt_desc,
                                ];
                                $this->facebook->share_fb($param, $userAccessToken);
                                
                                //POSTING TWITTER
                                require_once('./assets/codebird-php-develop/src/codebird.php');
                                 
                                \Codebird\Codebird::setConsumerKey("VqFzLQJRfIxX0Mbt9HO4VxeNX", "ko5FfipdHY6VN1MJMSMBcvh3MoW2YmbaHpRwJh7hafYTO9z1Vp");
                                $cb = \Codebird\Codebird::getInstance();
                                $cb->setToken("862295903951929344-nYPh4FWe0myoVdNEF9qkxFtHcxwN7n5", "jd1SjHaqBxByUxzFk8lY7keElT6dvJXSjbl97aDGVK27l");
                                 
                                $params_twit = array(
                                  'status' => $data['post_title'].' http://suarakaryanews.com/index.php/berita/artikel/'.$data['post_url'],
                                  'media[]' => 'http://suarakaryanews.com/uploads/post/original/'.$data['post_pict'],
                                );
                                $cb->statuses_updateWithMedia($params_twit);
    						}
					
							if(!$add_data){
								$this->session->set_flashdata('post_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
								Header('Location:'.base_url().'index.php/back/posting/edit_form/'.$id);
							}else{
								$this->session->set_flashdata('post_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
								Header('Location:'.base_url().'index.php/back/posting/edit_form/'.$id);
							}							
						}
					}
				}
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function delete($id){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$id = $this->uri->segment(4);
				
				$delete = $this->db->query("delete from sk_post where post_id='".$id."'");
				if(!$delete){
					$this->session->set_flashdata('post_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/posting/');
				}else{
					$this->session->set_flashdata('post_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/posting/');
				}
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
	}
/*end of file Posting.php*/
/*Location:.application/controllers/back/Posting.php*/