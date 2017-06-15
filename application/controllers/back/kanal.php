<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Kanal extends CI_Controller{
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
				
				$list['get_kanal'] = $this->db->query("select kanal_id, kanal_name, kanal_desc, user_back_name, kanal_modify_date, kanal_status 
				from sk_kanal, sk_user_back where sk_user_back.user_back_id = sk_kanal.kanal_posted_by order by kanal_id desc");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/kanal/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/kanal/bottom_kanal');
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
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/kanal/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/kanal/bottom_kanal');
			}
		}
	
		function add(){
			$this->form_validation->set_rules('name','title','trim|required|max_length[30]');
			if($this->form_validation->run() == false){
				$this->add_form();
			}else{
				if(empty($_FILES['logo']['name'])){
					$data['kanal_id'] = $this->sk_model->getMaxKode('sk_kanal', 'kanal_id', 'KNL');
					$data['kanal_name'] = $this->input->post('name');
					$data['kanal_desc'] = $this->input->post('desc');
					$data['kanal_background'] = $this->input->post('background');
					$data['kanal_posted_by'] = $this->session->userdata('id');
					$data['kanal_modify_date'] = date("Y-m-d H:i:s");
					if($this->input->post('status') != 1){
						$status = 0;
					}else{
						$status = 1;
					}
					$data['kanal_status'] = $status;
			
					$add_data = $this->sk_model->insert_data('sk_kanal', $data);
				
					if(!$add_data){
						$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/kanal/');
					}else{
						$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/kanal/');
					}
				}else{
					$configu['upload_path'] = './uploads/kanal/original/';
					$configu['upload_url'] = base_url().'uploads/kanal/original/';
					$configu['allowed_types'] = 'gif|jpeg|jpg|png';
					$configu['max_size'] = '10000';
					$configu['max_width'] = '10000';
					$configu['max_height'] = '10000';
					
					$this->load->library('upload',$configu);
					
					if (!$this->upload->do_upload('logo'))
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
						
						$this->load->view('back/global/top');
						$this->load->view('back/global/header',$data);
						$this->load->view('back/kanal/add_form',$data);
						$this->load->view('back/global/footer');
						$this->load->view('back/kanal/bottom_kanal');
					}
					else
					{
						$upload_data = $this->upload->data();
					
						$config1['image_library'] = 'GD2';
						$config1['source_image'] = $upload_data['full_path'];
						$config1['new_image'] = 'uploads/kanal/thumb/'.$upload_data['file_name'];
						//$config1['create_thumb'] = TRUE;
						$config1['maintain_ratio'] = TRUE;
						$config1['width'] = 320;
						$config1['height'] = 50;

						$this->load->library('image_lib', $config1);

						if(!$this->image_lib->resize()){
							echo $this->image_lib->display_errors();
						}
						
						$data['kanal_id'] = $this->sk_model->getMaxKode('sk_kanal', 'kanal_id', 'KNL');
						$data['kanal_name'] = $this->input->post('name');
						$data['kanal_desc'] = $this->input->post('desc');
						$data['kanal_background'] = $this->input->post('background');
						$data['kanal_logo'] = $upload_data['file_name'];
						$data['kanal_posted_by'] = $this->session->userdata('id');
						$data['kanal_modify_date'] = date("Y-m-d H:i:s");
						if($this->input->post('status') != 1){
							$status = 0;
						}else{
							$status = 1;
						}
						$data['kanal_status'] = $status;
				
						$add_data = $this->sk_model->insert_data('sk_kanal', $data);
					
						if(!$add_data){
							$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/kanal/');
						}else{
							$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/kanal/');
						}
					}
				}
			}
		}
		
		function edit_form($id){
			$id = $this->uri->segment(4);
			$kanal_read = $this->db->query("select * from sk_kanal where kanal_id='".$id."'");
			foreach($kanal_read->result() as $db){
				$data['id'] = $db->kanal_id;
				$data['name'] = $db->kanal_name;
				$data['desc'] = $db->kanal_desc;
				$data['background'] = $db->kanal_background;
				$data['status'] = $db->kanal_status;
				$data['logo'] = $db->kanal_logo;
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
			$this->load->view('back/kanal/edit_form',$data);
			$this->load->view('back/global/footer');
			$this->load->view('back/kanal/bottom_kanal');
		}
		
		function edit($id){
		$this->form_validation->set_rules('name','title','trim|required|max_length[30]');
			
			if($this->form_validation->run() == false){
				$this->edit_form($this->uri->segment(4));
			}else{
				if(empty($_FILES['logo']['name'])){
					
					$id = $this->uri->segment(4);
					$data['kanal_name'] = $this->input->post('name');
					$data['kanal_desc'] = $this->input->post('desc');
					$data['kanal_background'] = $this->input->post('background');
					$data['kanal_posted_by'] = $this->session->userdata('id');
					$data['kanal_modify_date'] = date("Y-m-d H:i:s");
					if($this->input->post('status') != 1){
						$status = 0;
					}else{
						$status = 1;
					}
					$data['kanal_status'] = $status;
			
					$add_data = $this->sk_model->update_data('sk_kanal', 'kanal_id', $id, $data);
					
					if(!$add_data){
						$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/kanal/');
					}else{
						$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/kanal/');
					}	
				}else{
					$configu['upload_path'] = './uploads/kanal/original/';
					$configu['upload_url'] = base_url().'uploads/kanal/original/';
					$configu['allowed_types'] = 'gif|jpeg|jpg|png';
					$configu['max_size'] = '10000';
					$configu['max_width'] = '10000';
					$configu['max_height'] = '10000';
					
					$this->load->library('upload',$configu);
					
					if (!$this->upload->do_upload('logo'))
					{
						$id = $this->uri->segment(4);
						$kanal_read = $this->db->query("select * from sk_kanal where kanal_id='".$id."'");
						foreach($kanal_read->result() as $db){
							$data['id'] = $db->kanal_id;
							$data['name'] = $db->kanal_name;
							$data['desc'] = $db->kanal_desc;
							$data['background'] = $db->kanal_background;
							$data['status'] = $db->kanal_status;
							$data['logo'] = $db->kanal_logo;
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
					
						$this->load->view('back/global/top');
						$this->load->view('back/global/header',$data);
						$this->load->view('back/kanal/edit_form',$data);
						$this->load->view('back/global/footer');
						$this->load->view('back/kanal/bottom_kanal');
					}
					else
					{
						$upload_data = $this->upload->data();
					
						$config1['image_library'] = 'GD2';
						$config1['source_image'] = $upload_data['full_path'];
						$config1['new_image'] = 'uploads/kanal/thumb/'.$upload_data['file_name'];
						//$config1['create_thumb'] = TRUE;
						$config1['maintain_ratio'] = TRUE;
						$config1['width'] = 320;
						$config1['height'] = 50;

						$this->load->library('image_lib', $config1);

						if(!$this->image_lib->resize()){
							echo $this->image_lib->display_errors();
						}
						
						$id = $this->uri->segment(4);
						$data['kanal_name'] = $this->input->post('name');
						$data['kanal_desc'] = $this->input->post('desc');
						$data['kanal_background'] = $this->input->post('background');
						$data['kanal_logo'] = $upload_data['file_name'];
						$data['kanal_posted_by'] = $this->session->userdata('id');
						$data['kanal_modify_date'] = date("Y-m-d H:i:s");
						if($this->input->post('status') != 1){
							$status = 0;
						}else{
							$status = 1;
						}
						$data['kanal_status'] = $status;
						
						$add_data = $this->sk_model->update_data('sk_kanal', 'kanal_id', $id, $data);
				
						if(!$add_data){
							$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/kanal/');
						}else{
							$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/kanal/');
						}							
					}
				}
			}
		}
		
		function delete($id){
			$id = $this->uri->segment(4);
			
			$delete = $this->db->query("delete from sk_kanal where kanal_id='".$id."'");
			if(!$delete){
				$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/kanal/');
			}else{
				$this->session->set_flashdata('kanal_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/kanal/');
			}
		}
		
	}
/*end of file Kanal_Side.php*/
/*Location:.application/controllers/back/Kanal_Side.php*/