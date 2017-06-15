<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Video extends CI_Controller{
		function __construct(){
			parent::__construct();
			date_default_timezone_set('Asia/Jakarta');
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
					$list['get_video'] = $this->db->query("select video_id, video_title, video_short_desc, kanal_name, category_name, user_back_name, video_status, video_modify_date  
					from sk_video, sk_category, sk_user_back , sk_kanal 
					where sk_video.video_posted_by = '".$this->session->userdata('id')."' and sk_category.kanal_id = sk_kanal.kanal_id and sk_user_back.user_back_id = sk_video.video_posted_by and sk_video.category_id = sk_category.category_id 
					order by video_posted_by desc");
				}else{
					$list['get_video'] = $this->db->query("select video_id, video_title, video_short_desc, kanal_name, category_name, user_back_name, video_status, video_modify_date  
					from sk_video, sk_category, sk_user_back , sk_kanal 
					where sk_category.kanal_id = sk_kanal.kanal_id and sk_user_back.user_back_id = sk_video.video_posted_by and sk_video.category_id = sk_category.category_id 
					order by video_posted_by desc");
				}
				
				$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal where kanal_status = '1' order by kanal_name");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/video/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/video/bottom_video');
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
					$list['get_video'] = $this->db->query("select video_id, video_title, video_short_desc, kanal_name, category_name, user_back_name, video_status, video_modify_date  
					from sk_video, sk_category, sk_user_back , sk_kanal 
					where sk_video.video_posted_by = '".$this->session->userdata('id')."' and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_id = '".$kanal."' and sk_user_back.user_back_id = sk_video.video_posted_by and sk_video.category_id = sk_category.category_id 
					order by video_posted_by desc");
				}else{
					$list['get_video'] = $this->db->query("select video_id, video_title, video_short_desc, kanal_name, category_name, user_back_name, video_status, video_modify_date  
					from sk_video, sk_category, sk_user_back , sk_kanal 
					where sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_id = '".$kanal."' and sk_user_back.user_back_id = sk_video.video_posted_by and sk_video.category_id = sk_category.category_id 
					order by video_posted_by desc");
				}
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/video/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/video/bottom_video');
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
				$this->load->view('back/video/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/video/bottom_video');
			}
		}
	
		function add(){
			$this->form_validation->set_rules('title','title','trim|required|max_length[225]');
			$this->form_validation->set_rules('short','short descriptions','trim|required');
			$this->form_validation->set_rules('link','link','trim|required');
			$this->form_validation->set_rules('desc','descriptions','trim|required');
			$this->form_validation->set_rules('category','category','required');
			$this->form_validation->set_rules('tag','tag focus','required');
			if($this->form_validation->run() == false){
				$this->add_form();
			}else{
				$title_post = trim($this->input->post('title'));
				$title_url = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $title_post);
				$data['video_id'] = $this->sk_model->getMaxKodelong('sk_video', 'video_id', 'VDO');
				$data['video_title'] = $this->input->post('title');
				$data['video_short_desc'] = $this->input->post('short');
				$data['video_desc'] = $this->input->post('desc');
				$data['category_id'] = $this->input->post('category');
				$data['video_posted_by'] = $this->session->userdata('id');
				$data['video_modify_date'] = date("Y-m-d H:i:s");
				$data['video_link'] = $this->session->userdata('link');
				$data['video_url'] = str_replace(' ', '+', $title_url);
				$data['video_keywords'] = $this->input->post('key');
				$data['tag_id'] = $this->input->post('tag');
				$data['video_flag'] = 'FLG00002';
				$data['video_status'] = $this->input->post('status');
			
				$add_data = $this->sk_model->insert_data('sk_video', $data);
			
				if(!$add_data){
					$this->session->set_flashdata('video_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/video/');
				}else{
					$this->session->set_flashdata('video_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/video/');
				}
			}
		}
		
		function edit_form($id){
			$id = $this->uri->segment(4);
			$post_read = $this->db->query("select * from sk_video where video_id='".$id."'");
			foreach($post_read->result() as $db){
				$data['id'] = $db->video_id;
				$data['title'] = $db->video_title;
				$data['short'] = $db->video_short_desc;
				$data['desc'] = $db->video_desc;
				$data['cat'] = $db->category_id;
				$data['link'] = $db->video_link;
				$data['status'] = $db->video_status;
				$data['key'] = $db->video_keywords;
				$data['tag'] = $db->tag_id;
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
			$this->load->view('back/video/edit_form',$data);
			$this->load->view('back/global/footer');
			$this->load->view('back/video/bottom_video');
		}
		
		function edit($id){
			$this->form_validation->set_rules('title','title','trim|required|max_length[225]');
			$this->form_validation->set_rules('short','short','trim|required');
			$this->form_validation->set_rules('link','link','trim|required');
			$this->form_validation->set_rules('desc','desc','trim|required');
			$this->form_validation->set_rules('category','category','required');
			$this->form_validation->set_rules('tag','tag focus','required');
			
			if($this->form_validation->run() == false){
				$this->edit_form($this->uri->segment(4));
			}else{
				$id = $this->uri->segment(4);
				$title_post = trim($this->input->post('title'));
				$title_url = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $title_post);
				$data['video_title'] = $this->input->post('title');
				$data['video_short_desc'] = $this->input->post('short');
				$data['video_desc'] = $this->input->post('desc');
				$data['category_id'] = $this->input->post('category');
				//$data['video_posted_by'] = $this->session->userdata('id');
				$data['video_modify_date'] = date("Y-m-d H:i:s");
				$data['video_link'] = $this->input->post('link');
				$data['video_url'] = str_replace(' ', '+', $title_url);;
				$data['video_keywords'] = $this->input->post('key');
				$data['tag_id'] = $this->input->post('tag');
				$data['video_status'] = $this->input->post('status');
		
				$add_data = $this->sk_model->update_data('sk_video', 'video_id', $id, $data);
				
				if(!$add_data){
					$this->session->set_flashdata('video_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/video/edit_form/'.$id);
				}else{
					$this->session->set_flashdata('video_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/video/edit_form/'.$id);
				}	
			}
		}
		
		function delete($id){
			$id = $this->uri->segment(4);
			
			$delete = $this->db->query("delete from sk_video where video_id='".$id."'");
			if(!$delete){
				$this->session->set_flashdata('video_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/video/');
			}else{
				$this->session->set_flashdata('video_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/video/');
			}
		}
		
	}
/*end of file Posting.php*/
/*Location:.application/controllers/back/Posting.php*/