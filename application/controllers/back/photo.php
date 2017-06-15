<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Photo extends CI_Controller{
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
					$list['get_photo'] = $this->db->query("
					select pict_id, pict_title, kanal_name, category_name, pict_create_date, pict_modify_date, pict_status, user_back_name 
					from sk_photo, sk_category, sk_user_back , sk_kanal 
					where sk_photo.pict_posted_by = '".$this->session->userdata('id')."' and sk_category.kanal_id = sk_kanal.kanal_id and sk_user_back.user_back_id = sk_photo.pict_posted_by and sk_photo.category_id = sk_category.category_id 
					order by sk_photo.pict_posted_by desc");
				}else{
					$list['get_photo'] = $this->db->query("
					select pict_id, pict_title, kanal_name, category_name, pict_create_date, pict_modify_date, pict_status, user_back_name 
					from sk_photo, sk_category, sk_user_back , sk_kanal 
					where sk_category.kanal_id = sk_kanal.kanal_id and sk_user_back.user_back_id = sk_photo.pict_posted_by and sk_photo.category_id = sk_category.category_id 
					order by sk_photo.pict_posted_by desc");
				}
				
				$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal where kanal_status = '1' order by kanal_name");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/photo/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/photo/bottom_photo');
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
					$list['get_photo'] = $this->db->query("select pict_id, pict_title, pict_create_date, kanal_name, category_name, pict_modify_date, pict_status, user_back_name 
					from sk_photo, sk_category, sk_user_back , sk_kanal 
					where sk_photo.pict_posted_by = '".$this->session->userdata('id')."' and sk_category.kanal_id = sk_kanal.kanal_id and sk_category.kanal_id = '".$kanal."' and sk_user_back.user_back_id = sk_photo.pict_posted_by and sk_photo.category_id = sk_category.category_id 
					order by sk_photo.pict_posted_by desc");
				}else{
					$list['get_photo'] = $this->db->query("select pict_id, pict_title, pict_create_date, kanal_name, category_name, pict_modify_date, pict_status, user_back_name 
					from sk_photo, sk_category, sk_user_back , sk_kanal 
					where sk_category.kanal_id = sk_kanal.kanal_id and sk_category.kanal_id = '".$kanal."' and sk_user_back.user_back_id = sk_photo.pict_posted_by and sk_photo.category_id = sk_category.category_id 
					order by sk_photo.pict_posted_by desc");
				}
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/photo/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/photo/bottom_photo');
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
				$this->load->view('back/photo/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/photo/bottom_photo');
			}
		}
	
		function add(){
			$this->form_validation->set_rules('title','title','trim|required|max_length[225]');
			$this->form_validation->set_rules('short','short descriptions','trim|required');
			$this->form_validation->set_rules('desc','descriptions','trim|required');
			$this->form_validation->set_rules('category','category','required');
			$this->form_validation->set_rules('tag','tag focus','required');
			if($this->form_validation->run() == false){
				$this->add_form();
			}else{
				$title_post = trim($this->input->post('title'));
				$title_url = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $title_post);
				$data['pict_id'] = $this->sk_model->getMaxKodelong('sk_photo', 'pict_id', 'PCT');
				$data['pict_title'] = $this->input->post('title');
				$data['pict_short_desc'] = $this->input->post('short');
				$data['pict_desc'] = $this->input->post('desc');
				$data['category_id'] = $this->input->post('category');
				$data['pict_posted_by'] = $this->session->userdata('id');
				$data['pict_create_date'] = date("Y-m-d H:i:s");
				$data['pict_url'] = str_replace(' ', '+', $title_url);
				$data['pict_keywords'] = $this->input->post('key');
				$data['tag_id'] = $this->input->post('tag');
				$data['pict_status'] = $this->input->post('status');
			
				$add_data = $this->sk_model->insert_data('sk_photo', $data);
			
				if(!$add_data){
					$this->session->set_flashdata('photo_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/photo/');
				}else{
					$this->session->set_flashdata('photo_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/photo/');
				}
			}
		}
		
		function edit_form($id){
			$id = $this->uri->segment(4);
			$photo_read = $this->db->query("select * from sk_photo where pict_id='".$id."'");
			foreach($photo_read->result() as $db){
				$data['id'] = $db->pict_id;
				$data['title'] = $db->pict_title;
				$data['short'] = $db->pict_short_desc;
				$data['desc'] = $db->pict_desc;
				$data['cat'] = $db->category_id;
				$data['status'] = $db->pict_status;
				$data['key'] = $db->pict_keywords;
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
			$this->load->view('back/photo/edit_form',$data);
			$this->load->view('back/global/footer');
			$this->load->view('back/photo/bottom_photo');
		}
		
		function edit($id){
			$this->form_validation->set_rules('title','title','trim|required|max_length[225]');
			$this->form_validation->set_rules('short','short','trim|required');
			$this->form_validation->set_rules('desc','desc','trim|required');
			$this->form_validation->set_rules('category','category','required');
			$this->form_validation->set_rules('tag','tag focus','required');
			
			if($this->form_validation->run() == false){
				$this->edit_form($this->uri->segment(4));
			}else{
				$id = $this->uri->segment(4);
				$title_post = trim($this->input->post('title'));
				$title_url = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $title_post);
				$data['pict_title'] = $this->input->post('title');
				$data['pict_short_desc'] = $this->input->post('short');
				$data['pict_desc'] = $this->input->post('desc');
				$data['category_id'] = $this->input->post('category');
				//$data['pict_posted_by'] = $this->session->userdata('id');
				$data['pict_modify_date'] = date("Y-m-d H:i:s");
				$data['pict_url'] = str_replace(' ', '+', $title_url);;
				$data['pict_keywords'] = $this->input->post('key');
				$data['tag_id'] = $this->input->post('tag');
				$data['pict_status'] = $this->input->post('status');
		
				$add_data = $this->sk_model->update_data('sk_photo', 'pict_id', $id, $data);
				
				if(!$add_data){
					$this->session->set_flashdata('photo_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/photo/edit_form/'.$id);
				}else{
					$this->session->set_flashdata('photo_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/photo/edit_form/'.$id);
				}	
			}
		}
		
		function delete($id){
			$id = $this->uri->segment(4);
			
			$delete = $this->db->query("delete from sk_photo where pict_id='".$id."'");
			if(!$delete){
				$this->session->set_flashdata('photo_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/photo/');
			}else{
				$this->session->set_flashdata('photo_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/photo/');
			}
		}
		
		function list_image($pict){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$pict = $this->uri->segment(4);
				$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
				foreach($query1->result() as $sess){
					$data['id'] = $sess->profile_back_id;
					$data['full'] = $sess->profile_back_name_full;
					$data['nick'] = $sess->profile_back_nick;
					$data['pict'] = $sess->profile_back_pict;
					$data['email'] = $sess->profile_back_email;
				}
				
				$list['get_photo'] = $this->db->query("
				select * 
				from sk_photo, sk_photo_detail, sk_user_back 
				where sk_photo.pict_id = '".$pict."' and sk_user_back.user_back_id = sk_photo.pict_posted_by and sk_photo.pict_id = sk_photo_detail.ref_pict_id 
				order by sk_photo_detail.ObjectID desc");
				
				$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal where kanal_status = '1' order by kanal_name");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/photo_detail/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/photo_detail/bottom_photo_detail');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
	
		function add_form_detail($pict){
			$cek = $this->session->userdata('login_session');
			if(!$cek){
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}else{
				$pict = $this->uri->segment(4);
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
				$this->load->view('back/photo_detail/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/photo_detail/bottom_photo_detail');
			}
		}
	
		function add_detail_photo($pict){
			$cek = $this->session->userdata('login_session');
			if(!$cek){
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}else{
				$this->form_validation->set_rules('short','short desc','trim|required|max_length[225]');
				
				if(empty($_FILES['pict']['name'])){
					$this->form_validation->set_rules('pict', 'image', 'required');
				}
				
				if($this->form_validation->run() == false){
					$this->add_form_detail($this->uri->segment(4));
				}else{
					$pict = $this->uri->segment(4);
					$configu['upload_path'] = './uploads/pict/original/';
					$configu['upload_url'] = base_url().'uploads/pict/original/';
					$configu['allowed_types'] = 'gif|jpeg|jpg|png';
					$configu['max_size'] = '10000';
					//$configu['max_width'] = '800';
					//$configu['max_height'] = '500';
					$configu['max_width'] = '100000';
					$configu['max_height'] = '100000';
					
					$this->load->library('upload',$configu);
					
					if (!$this->upload->do_upload('pict'))
					{
						
						$data['error'] = "<div id='notif1' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>".$this->upload->display_errors()."</span></div></div>";
						
						$pict = $this->uri->segment(4);
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
						$this->load->view('back/photo_detail/add_form',$data);
						$this->load->view('back/global/footer');
						$this->load->view('back/photo_detail/bottom_photo_detail');
					}
					else
					{
						$upload_data = $this->upload->data();
					
						$config1['image_library'] = 'GD2';
						$config1['source_image'] = $upload_data['full_path'];
						$config1['new_image'] = 'uploads/pict/thumb/'.$upload_data['file_name'];
						//$config1['create_thumb'] = TRUE;
						$config1['maintain_ratio'] = TRUE;
						$config1['width'] = 254;
						$config1['height'] = 100;

						$this->load->library('image_lib', $config1);

						if(!$this->image_lib->resize()){
							echo $this->image_lib->display_errors();
						}
						$data['ref_pict_id'] = $pict;
						$data['pict_detail_short_desc'] = $this->input->post('short');
						$data['pict_detail_url'] = $upload_data['file_name'];
						$data['pict_detail_posted_by'] = $this->session->userdata('id');
						$data['pict_detail_create_date'] = date("Y-m-d H:i:s");
				
						$add_data = $this->sk_model->insert_data('sk_photo_detail', $data);
					
						if(!$add_data){
							$this->session->set_flashdata('photo_detail_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/photo/list_image/'.$this->uri->segment(4));
						}else{
							$this->session->set_flashdata('photo_detail_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/photo/list_image/'.$this->uri->segment(4));
						}
					}
				}
			}
		}
		
		function edit_photo_detail($pict,$obj){
			$pict = $this->uri->segment(4);
			$obj = $this->uri->segment(5);
			$photo_read = $this->db->query("select * from sk_photo_detail where ref_pict_id='".$pict."' and ObjectID = '".$obj."'");
			foreach($photo_read->result() as $db){
				$data['id'] = $db->ref_pict_id;
				$data['pict2'] = $db->pict_detail_url;
				$data['short'] = $db->pict_detail_short_desc;
			}
			
			$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
			foreach($query1->result() as $sess){
				$data['id'] = $sess->profile_back_id;
				$data['full'] = $sess->profile_back_name_full;
				$data['nick'] = $sess->profile_back_nick;
				$data['pict'] = $sess->profile_back_pict;
				$data['email'] = $sess->profile_back_email;
			}
				
			$data['error'] = '';
			$this->load->view('back/global/top');
			$this->load->view('back/global/header',$data);
			$this->load->view('back/photo_detail/edit_form',$data);
			$this->load->view('back/global/footer');
			$this->load->view('back/photo_detail/bottom_photo_detail');
		}
		
		function edit_detail_photo($pict1,$obj){
			$cek = $this->session->userdata('login_session');
			if(!$cek){
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}else{
				$pict1 = $this->uri->segment(4);
				$obj = $this->uri->segment(5);
			
				$this->form_validation->set_rules('short','short desc','trim|required|max_length[225]');
				
				if($this->form_validation->run() == false){
					$this->edit_photo_detail($this->uri->segment(4),$this->uri->segment(5));
				}else{
					if(empty($_FILES['pict']['name'])){
						
						$id = $obj;
						$data['ref_pict_id'] = $pict;
						$data['pict_detail_short_desc'] = $this->input->post('short');
						$data['pict_detail_posted_by'] = $this->session->userdata('id');
						$data['pict_detail_modified_date'] = date("Y-m-d H:i:s");
				
						$add_data = $this->sk_model->update_data('sk_photo_detail', 'ObjectID', $id, $data);
						
						if(!$add_data){
							$this->session->set_flashdata('photo_detail_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/photo/edit_photo_detail/'.$pict1.'/'.$id);
						}else{
							$this->session->set_flashdata('photo_detail_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/photo/edit_photo_detail/'.$pict1.'/'.$id);
						}	
					}else{
						$configu['upload_path'] = './uploads/pict/original/';
						$configu['upload_url'] = base_url().'uploads/pict/original/';
						$configu['allowed_types'] = 'gif|jpeg|jpg|png';
						$configu['max_size'] = '10000';
						//$configu['max_width'] = '800';
						//$configu['max_height'] = '500';
						$configu['max_width'] = '100000';
					    $configu['max_height'] = '100000';
						
						
						$this->load->library('upload',$configu);
						
						if (!$this->upload->do_upload('pict'))
						{
							$data['error'] = "<div id='notif1' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>".$this->upload->display_errors()."</span></div></div>";
							
							$pict = $this->uri->segment(4);
							$obj = $this->uri->segment(5);
							$photo_read = $this->db->query("select * from sk_photo_detail where ref_pict_id='".$pict."' and ObjectID = '".$obj."'");
							foreach($photo_read->result() as $db){
								$data['id'] = $db->ref_pict_id;
								$data['pict2'] = $db->pict_detail_url;
								$data['short'] = $db->pict_detail_short_desc;
							}
							
							$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
							foreach($query1->result() as $sess){
								$data['id'] = $sess->profile_back_id;
								$data['full'] = $sess->profile_back_name_full;
								$data['nick'] = $sess->profile_back_nick;
								$data['pict'] = $sess->profile_back_pict;
								$data['email'] = $sess->profile_back_email;
							}
								
							$this->load->view('back/global/top');
							$this->load->view('back/global/header',$data);
							$this->load->view('back/photo_detail/edit_form',$data);
							$this->load->view('back/global/footer');
							$this->load->view('back/photo_detail/bottom_photo_detail');
							
						}
						else
						{
							$upload_data = $this->upload->data();
						
							$config1['image_library'] = 'GD2';
							$config1['source_image'] = $upload_data['full_path'];
							$config1['new_image'] = 'uploads/pict/thumb/'.$upload_data['file_name'];
							//$config1['create_thumb'] = TRUE;
							$config1['maintain_ratio'] = TRUE;
							$config1['width'] = 254;
							$config1['height'] = 100;

							$this->load->library('image_lib', $config1);

							if(!$this->image_lib->resize()){
								echo $this->image_lib->display_errors();
							}
							
							$id = $this->uri->segment(5);
							$data['ref_pict_id'] = $pict1;
							$data['pict_detail_short_desc'] = $this->input->post('short');
							$data['pict_detail_url'] = $upload_data['file_name'];
							$data['pict_detail_posted_by'] = $this->session->userdata('id');
							$data['pict_detail_create_date'] = date("Y-m-d H:i:s");
							
							$add_data = $this->sk_model->update_data('sk_photo_detail', 'ObjectID', $id, $data);
					
							if(!$add_data){
								$this->session->set_flashdata('photo_detail_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
								Header('Location:'.base_url().'index.php/back/photo/edit_photo_detail/'.$pict1.'/'.$id);
							}else{
								$this->session->set_flashdata('photo_detail_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
								Header('Location:'.base_url().'index.php/back/photo/edit_photo_detail/'.$pict1.'/'.$id);
							}							
						}
					}
				}
			}
		}
		
		function delete_detail_photo($pict1, $obj){
			$cek = $this->session->userdata('login_session');
			if(!$cek){
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}else{
				$id = $this->uri->segment(5);
				$pict1 = $this->uri->segment(4);
				
				$delete = $this->db->query("delete from sk_photo_detail where ObjectID='".$id."'");
				if(!$delete){
					$this->session->set_flashdata('photo_detail_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/photo/list_image/'.$pict1);
				}else{
					$this->session->set_flashdata('photo_detail_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/photo/list_image/'.$pict1);
				}
			}
		}
	}
/*end of file Posting.php*/
/*Location:.application/controllers/back/Posting.php*/