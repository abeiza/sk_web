<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Advertisement extends CI_Controller{
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
				$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal where kanal_status = '1' order by kanal_name");
				
				$list['get_adv'] = $this->db->query("select adv_id, adv_title, kanal_name, adv_short_desc, position_name, adv_status
				from sk_adv LEFT JOIN sk_kanal ON sk_kanal.kanal_id = sk_adv.kanal_id, sk_user_back, sk_adv_position   
				where sk_user_back.user_back_id = sk_adv.adv_posted_by and sk_adv.position_id = sk_adv_position.position_id 
				order by adv_posted_by desc");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/advertise/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/advertise/bottom_advertise');
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
				
				
				$list['get_adv'] = $this->db->query("select adv_id, adv_title, kanal_name, adv_short_desc, position_name, adv_status
				from sk_adv LEFT JOIN sk_kanal ON sk_kanal.kanal_id = sk_adv.kanal_id, sk_user_back, sk_adv_position   
				where sk_user_back.user_back_id = sk_adv.adv_posted_by and sk_kanal.kanal_id = '".$kanal."' and sk_adv.position_id = sk_adv_position.position_id 
				order by adv_posted_by desc");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/advertise/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/advertise/bottom_advertise');
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
				
				$data['kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
				$data['position'] = $this->db->query("select position_id, position_name from sk_adv_position order by position_name asc");
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/advertise/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/advertise/bottom_advertise');
			}
		}
	
		function add(){
			$this->form_validation->set_rules('title','title','trim|required|max_length[150]');
			$this->form_validation->set_rules('short','short description','trim|required|max_length[225]');
			$this->form_validation->set_rules('kanal','kanal','trim|required');
			$this->form_validation->set_rules('position','position','trim|required');
			
			if(empty($_FILES['pict']['name'])){
				$this->form_validation->set_rules('pict', 'pict', 'required');
			}
			
			if($this->form_validation->run() == false){
				$this->add_form();
			}else{
				$configu['upload_path'] = './uploads/advertise/original/';
				$configu['upload_url'] = base_url().'uploads/advertise/original/';
				$configu['allowed_types'] = 'gif|jpeg|jpg|png';
				$configu['max_size'] = '10000';
				$configu['max_width'] = '10000';
				$configu['max_height'] = '10000';
				
				$this->load->library('upload',$configu);
				
				if (!$this->upload->do_upload('pict'))
				{
					
					$data['error'] = "<div id='notif1' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>".$this->upload->display_errors()."</span></div></div>";
					
					$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
					foreach($query1->result() as $sess){
						$data['id'] = $sess->profile_back_id;
						$data['full'] = $sess->profile_back_name_full;
						$data['nick'] = $sess->profile_back_nick;
						$data['pict'] = $sess->profile_back_pict;
						$data['email'] = $sess->profile_back_email;
					}
					
					$data['kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
					$data['position'] = $this->db->query("select position_id, position_name from sk_adv_position order by position_name asc");
					$this->load->view('back/global/top');
					$this->load->view('back/global/header',$data);
					$this->load->view('back/advertise/add_form',$data);
					$this->load->view('back/global/footer');
					$this->load->view('back/advertise/bottom_advertise');
				}
				else
				{
					$upload_data = $this->upload->data();
				
					$config1['image_library'] = 'GD2';
					$config1['source_image'] = $upload_data['full_path'];
					$config1['new_image'] = 'uploads/advertise/thumb/'.$upload_data['file_name'];
					//$config1['create_thumb'] = TRUE;
					$config1['maintain_ratio'] = TRUE;
					$config1['width'] = 320;
					$config1['height'] = 50;

					$this->load->library('image_lib', $config1);

					if(!$this->image_lib->resize()){
						echo $this->image_lib->display_errors();
					}
					
					$data['adv_id'] = $this->sk_model->getMaxKodelong('sk_adv', 'adv_id', 'ADV');
					$data['adv_title'] = $this->input->post('title');
					$data['adv_short_desc'] = $this->input->post('short');
					$data['adv_desc'] = $this->input->post('desc');
					$data['adv_link'] = $this->input->post('link');
					$data['kanal_id'] = $this->input->post('kanal');
					$data['position_id'] = $this->input->post('position');
					$data['adv_pict'] = $upload_data['file_name'];
					$data['adv_posted_by'] = $this->session->userdata('id');
					$data['adv_posted_date'] = date("Y-m-d H:i:s");
					$data['adv_status'] = $this->input->post('status');
			
					$add_data = $this->sk_model->insert_data('sk_adv', $data);
				
					if(!$add_data){
						$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/advertisement/');
					}else{
						$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/advertisement/');
					}
				}
			}
		}
		
		function edit_form($id){
			$id = $this->uri->segment(4);
			$adv_read = $this->db->query("select * from sk_adv where adv_id='".$id."'");
			foreach($adv_read->result() as $db){
				$data['id'] = $db->adv_id;
				$data['title'] = $db->adv_title;
				$data['short'] = $db->adv_short_desc;
				$data['desc'] = $db->adv_desc;
				$data['pict2'] = $db->adv_pict;
				$data['link'] = $db->adv_link;
				$data['kanal1'] = $db->kanal_id;
				$data['position1'] = $db->position_id;
				$data['status'] = $db->adv_status;
			}
			
			$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
			foreach($query1->result() as $sess){
				$data['id'] = $sess->profile_back_id;
				$data['full'] = $sess->profile_back_name_full;
				$data['nick'] = $sess->profile_back_nick;
				$data['pict'] = $sess->profile_back_pict;
				$data['email'] = $sess->profile_back_email;
			}
			
			$data['kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
			$data['position'] = $this->db->query("select position_id, position_name from sk_adv_position order by position_name asc");
				
			
			$data['error'] = '';
			$this->load->view('back/global/top');
			$this->load->view('back/global/header',$data);
			$this->load->view('back/advertise/edit_form',$data);
			$this->load->view('back/global/footer');
			$this->load->view('back/advertise/bottom_advertise');
		}
		
		function edit($id){
			$this->form_validation->set_rules('title','title','trim|required|max_length[150]');
			$this->form_validation->set_rules('short','short description','trim|required|max_length[225]');
			$this->form_validation->set_rules('kanal','kanal','trim|required');
			$this->form_validation->set_rules('position','position','trim|required');
			
			if($this->form_validation->run() == false){
				$this->edit_form($this->uri->segment(4));
			}else{
				if(empty($_FILES['pict']['name'])){
					
					$id = $this->uri->segment(4);
					$data['adv_title'] = $this->input->post('title');
					$data['adv_short_desc'] = $this->input->post('short');
					$data['adv_desc'] = $this->input->post('desc');
					$data['kanal_id'] = $this->input->post('kanal');
					$data['adv_link'] = $this->input->post('link');
					$data['position_id'] = $this->input->post('position');
					$data['adv_posted_by'] = $this->session->userdata('id');
					$data['adv_posted_date'] = date("Y-m-d H:i:s");
					$data['adv_status'] = $this->input->post('status');
			
					$add_data = $this->sk_model->update_data('sk_adv', 'adv_id', $id, $data);
					
					if(!$add_data){
						$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/advertisement/edit_form/'.$id);
					}else{
						$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/advertisement/edit_form/'.$id);
					}	
				}else{
					$configu['upload_path'] = './uploads/advertise/original/';
					$configu['upload_url'] = base_url().'uploads/advertise/original/';
					$configu['allowed_types'] = 'gif|jpeg|jpg|png';
					$configu['max_size'] = '10000';
					$configu['max_width'] = '10000';
					$configu['max_height'] = '10000';
					
					$this->load->library('upload',$configu);
					
					if (!$this->upload->do_upload('pict'))
					{
						
						$data['error'] = "<div id='notif1' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>".$this->upload->display_errors()."</span></div></div>";
					
						$id = $this->uri->segment(4);
						$adv_read = $this->db->query("select * from sk_adv where adv_id='".$id."'");
						foreach($adv_read->result() as $db){
							$data['id'] = $db->adv_id;
							$data['title'] = $db->adv_title;
							$data['short'] = $db->adv_short_desc;
							$data['link'] = $db->adv_link;
							$data['desc'] = $db->adv_desc;
							$data['pict'] = $db->adv_pict;
							$data['kanal1'] = $db->kanal_id;
							$data['position1'] = $db->position_id;
							$data['status'] = $db->adv_status;
						}
						
						$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
						foreach($query1->result() as $sess){
							$data['id'] = $sess->profile_back_id;
							$data['full'] = $sess->profile_back_name_full;
							$data['nick'] = $sess->profile_back_nick;
							$data['pict'] = $sess->profile_back_pict;
							$data['email'] = $sess->profile_back_email;
						}
						
						$data['kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
						$data['position'] = $this->db->query("select position_id, position_name from sk_adv_position order by position_name asc");
							
						$this->load->view('back/global/top');
						$this->load->view('back/global/header',$data);
						$this->load->view('back/advertise/edit_form',$data);
						$this->load->view('back/global/footer');
						$this->load->view('back/advertise/bottom_advertise');
					}
					else
					{
						$upload_data = $this->upload->data();
					
						$config1['image_library'] = 'GD2';
						$config1['source_image'] = $upload_data['full_path'];
						$config1['new_image'] = 'uploads/advertise/thumb/'.$upload_data['file_name'];
						//$config1['create_thumb'] = TRUE;
						$config1['maintain_ratio'] = TRUE;
						$config1['width'] = 320;
						$config1['height'] = 50;

						$this->load->library('image_lib', $config1);

						if(!$this->image_lib->resize()){
							echo $this->image_lib->display_errors();
						}
						
						$id = $this->uri->segment(4);
						$data['adv_title'] = $this->input->post('title');
						$data['adv_short_desc'] = $this->input->post('short');
						$data['adv_link'] = $this->input->post('link');
						$data['adv_desc'] = $this->input->post('desc');
						$data['kanal_id'] = $this->input->post('kanal');
						$data['position_id'] = $this->input->post('position');
						$data['adv_pict'] = $upload_data['file_name'];
						$data['adv_posted_by'] = $this->session->userdata('id');
						$data['adv_posted_date'] = date("Y-m-d H:i:s");
						$data['adv_status'] = $this->input->post('status');
						$data['adv_pict'] = $upload_data['file_name'];
						
						$add_data = $this->sk_model->update_data('sk_adv', 'adv_id', $id, $data);
				
						if(!$add_data){
							$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/advertisement/edit_form/'.$id);
						}else{
							$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/advertisement/edit_form/'.$id);
						}							
					}
				}
			}
		}
		
		function delete($id){
			$id = $this->uri->segment(4);
			
			$delete = $this->db->query("delete from sk_adv where adv_id='".$id."'");
			if(!$delete){
				$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/advertisement/');
			}else{
				$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/advertisement/');
			}
		}
		
		
		function layout($layout, $kanal){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$layout = $this->uri->segment(4);
				$kanal = $this->uri->segment(5);
				if($layout == 'home'){
					$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
					foreach($query1->result() as $sess){
						$data['id'] = $sess->profile_back_id;
						$data['full'] = $sess->profile_back_name_full;
						$data['nick'] = $sess->profile_back_nick;
						$data['pict'] = $sess->profile_back_pict;
						$data['email'] = $sess->profile_back_email;
					}
					
					$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
					
					$data['get_list_top'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00001' and adv_status = 1");
					$query_top = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00001' and sk_adv_layout.layout_name = 'home'");
					if($query_top->num_rows() == 0){
						$data['get_top'] = "";
						$data['get_top_img'] = "";
					}else{
						foreach($query_top->result() as $top){
							$data['get_top'] = $top->adv_id;
							$data['get_top_img'] = $top->adv_pict;
						}
					}
					
					$data['get_list_left'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00003' and adv_status = 1");
					$query_left = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00003' and sk_adv_layout.layout_name = 'home'");
					if($query_left->num_rows() == 0){
						$data['get_left'] = "";
						$data['get_left_img'] = "";
					}else{
						foreach($query_left->result() as $left){
							$data['get_left'] = $left->adv_id;
							$data['get_left_img'] = $left->adv_pict;
						}
					}
					
					$data['get_list_right'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00004' and adv_status = 1");
					$query_right = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00004' and sk_adv_layout.layout_name = 'home'");
					if($query_right->num_rows() == 0){
						$data['get_right'] = "";
						$data['get_right_img'] = "";
					}else{
						foreach($query_right->result() as $right){
							$data['get_right'] = $right->adv_id;
							$data['get_right_img'] = $right->adv_pict;
						}
					}
					
					$data['get_list_main'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00002' and adv_status = 1");
					$query_main = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00002' and sk_adv_layout.layout_name = 'home'");
					if($query_main->num_rows() == 0){
						$data['get_main'] = "";
						$data['get_main_img'] = "";
					}else{
						foreach($query_main->result() as $main){
							$data['get_main'] = $main->adv_id;
							$data['get_main_img'] = $main->adv_pict;
						}
					}
					
					$data['get_list_cleft1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00005' and adv_status = 1");
					$query_cleft1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00005' and sk_adv_layout.layout_name = 'home'");
					if($query_cleft1->num_rows() == 0){
						$data['get_cleft1'] = "";
						$data['get_cleft1_img'] = "";
					}else{
						foreach($query_cleft1->result() as $cleft1){
							$data['get_cleft1'] = $cleft1->adv_id;
							$data['get_cleft1_img'] = $cleft1->adv_pict;
						}
					}
					
					$data['get_list_cleft2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00006' and adv_status = 1");
					$query_cleft2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00006' and sk_adv_layout.layout_name = 'home'");
					if($query_cleft2->num_rows() == 0){
						$data['get_cleft2'] = "";
						$data['get_cleft2_img'] = "";
					}else{
						foreach($query_cleft2->result() as $cleft2){
							$data['get_cleft2'] = $cleft2->adv_id;
							$data['get_cleft2_img'] = $cleft2->adv_pict;
						}
					}
					
					$data['get_list_cleft3'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00007' and adv_status = 1");
					$query_cleft3 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00007' and sk_adv_layout.layout_name = 'home'");
					if($query_cleft3->num_rows() == 0){
						$data['get_cleft3'] = "";
						$data['get_cleft3_img'] = "";
					}else{
						foreach($query_cleft3->result() as $cleft3){
							$data['get_cleft3'] = $cleft3->adv_id;
							$data['get_cleft3_img'] = $cleft3->adv_pict;
						}
					}
					
					$data['get_list_cright1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00008' and adv_status = 1");
					$query_cright1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00008' and sk_adv_layout.layout_name = 'home'");
					if($query_cright1->num_rows() == 0){
						$data['get_cright1'] = "";
						$data['get_cright1_img'] = "";
					}else{
						foreach($query_cright1->result() as $cright1){
							$data['get_cright1'] = $cright1->adv_id;
							$data['get_cright1_img'] = $cright1->adv_pict;
						}
					}
					
					$data['get_list_cright2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00009' and adv_status = 1");
					$query_cright2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00009' and sk_adv_layout.layout_name = 'home'");
					if($query_cright2->num_rows() == 0){
						$data['get_cright2'] = "";
						$data['get_cright2_img'] = "";
					}else{
						foreach($query_cright2->result() as $cright2){
							$data['get_cright2'] = $cright2->adv_id;
							$data['get_cright2_img'] = $cright2->adv_pict;
						}
					}
					
					$data['get_list_cright3'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00010' and adv_status = 1");
					$query_cright3 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00010' and sk_adv_layout.layout_name = 'home'");
					if($query_cright3->num_rows() == 0){
						$data['get_cright3'] = "";
						$data['get_cright3_img'] = "";
					}else{
						foreach($query_cright3->result() as $cright3){
							$data['get_cright3'] = $cright3->adv_id;
							$data['get_cright3_img'] = $cright3->adv_pict;
						}
					}
					
					$data['get_list_pop'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00011' and adv_status = 1");
					$query_pop = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00011' and sk_adv_layout.layout_name = 'home'");
					if($query_pop->num_rows() == 0){
						$data['get_pop'] = "";
						$data['get_pop_img'] = "";
					}else{
						foreach($query_pop->result() as $pop){
							$data['get_pop'] = $pop->adv_id;
							$data['get_pop_img'] = $pop->adv_pict;
						}
					}
					
					$data['get_list_mobile'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00017' and adv_status = 1");
					$query_mobile = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00017' and sk_adv_layout.layout_name = 'home'");
					if($query_mobile->num_rows() == 0){
						$data['get_mobile'] = "";
						$data['get_mobile_img'] = "";
					}else{
						foreach($query_mobile->result() as $pop){
							$data['get_mobile'] = $pop->adv_id;
							$data['get_mobile_img'] = $pop->adv_pict;
						}
					}
					
					$this->load->view('back/global/top');
					$this->load->view('back/global/header',$data);
					$this->load->view('back/layout/layout_home',$data);
					$this->load->view('back/global/footer');
					$this->load->view('back/layout/bottom_layout');
				}else if($layout == 'single-news'){
					$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
					foreach($query1->result() as $sess){
						$data['id'] = $sess->profile_back_id;
						$data['full'] = $sess->profile_back_name_full;
						$data['nick'] = $sess->profile_back_nick;
						$data['pict'] = $sess->profile_back_pict;
						$data['email'] = $sess->profile_back_email;
					}
					
					$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
					
					$data['get_list_top'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00001' and adv_status = 1");
					$query_top = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00001' and sk_adv_layout.layout_name = 'single-news'");
					if($query_top->num_rows() == 0){
						$data['get_top'] = "";
						$data['get_top_img'] = "";
					}else{
						foreach($query_top->result() as $top){
							$data['get_top'] = $top->adv_id;
							$data['get_top_img'] = $top->adv_pict;
						}
					}
					
					$data['get_list_main'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00002' and adv_status = 1");
					$query_main = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00002' and sk_adv_layout.layout_name = 'single-news'");
					if($query_main->num_rows() == 0){
						$data['get_main'] = "";
						$data['get_main_img'] = "";
					}else{
						foreach($query_main->result() as $main){
							$data['get_main'] = $main->adv_id;
							$data['get_main_img'] = $main->adv_pict;
						}
					}
					
					$data['get_list_cright1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00008' and adv_status = 1");
					$query_cright1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00008' and sk_adv_layout.layout_name = 'single-news'");
					if($query_cright1->num_rows() == 0){
						$data['get_cright1'] = "";
						$data['get_cright1_img'] = "";
					}else{
						foreach($query_cright1->result() as $cright1){
							$data['get_cright1'] = $cright1->adv_id;
							$data['get_cright1_img'] = $cright1->adv_pict;
						}
					}
					
					$data['get_list_cright2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00009' and adv_status = 1");
					$query_cright2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00009' and sk_adv_layout.layout_name = 'single-news'");
					if($query_cright2->num_rows() == 0){
						$data['get_cright2'] = "";
						$data['get_cright2_img'] = "";
					}else{
						foreach($query_cright2->result() as $cright2){
							$data['get_cright2'] = $cright2->adv_id;
							$data['get_cright2_img'] = $cright2->adv_pict;
						}
					}
					
					$data['get_list_cright3'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00010' and adv_status = 1");
					$query_cright3 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00010' and sk_adv_layout.layout_name = 'single-news'");
					if($query_cright3->num_rows() == 0){
						$data['get_cright3'] = "";
						$data['get_cright3_img'] = "";
					}else{
						foreach($query_cright3->result() as $cright3){
							$data['get_cright3'] = $cright3->adv_id;
							$data['get_cright3_img'] = $cright3->adv_pict;
						}
					}
					
					$data['get_list_vertical'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00012' and adv_status = 1");
					$query_vertical = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00012' and sk_adv_layout.layout_name = 'single-news'");
					if($query_vertical->num_rows() == 0){
						$data['get_vertical'] = "";
						$data['get_vertical_img'] = "";
					}else{
						foreach($query_vertical->result() as $vertical){
							$data['get_vertical'] = $vertical->adv_id;
							$data['get_vertical_img'] = $vertical->adv_pict;
						}
					}
					
					$data['get_list_horizontal1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00013' and adv_status = 1");
					$query_horizontal1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00013' and sk_adv_layout.layout_name = 'single-news'");
					if($query_horizontal1->num_rows() == 0){
						$data['get_horizontal1'] = "";
						$data['get_horizontal1_img'] = "";
					}else{
						foreach($query_horizontal1->result() as $horizontal1){
							$data['get_horizontal1'] = $horizontal1->adv_id;
							$data['get_horizontal1_img'] = $horizontal1->adv_pict;
						}
					}
					
					$data['get_list_horizontal2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00014' and adv_status = 1");
					$query_horizontal2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00014' and sk_adv_layout.layout_name = 'single-news'");
					if($query_horizontal2->num_rows() == 0){
						$data['get_horizontal2'] = "";
						$data['get_horizontal2_img'] = "";
					}else{
						foreach($query_horizontal2->result() as $horizontal2){
							$data['get_horizontal2'] = $horizontal2->adv_id;
							$data['get_horizontal2_img'] = $horizontal2->adv_pict;
						}
					}
					
					$data['get_list_mobile'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00017' and adv_status = 1");
					$query_mobile = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00017' and sk_adv_layout.layout_name = 'single-news'");
					if($query_mobile->num_rows() == 0){
						$data['get_mobile'] = "";
						$data['get_mobile_img'] = "";
					}else{
						foreach($query_mobile->result() as $pop){
							$data['get_mobile'] = $pop->adv_id;
							$data['get_mobile_img'] = $pop->adv_pict;
						}
					}
					
					$this->load->view('back/global/top');
					$this->load->view('back/global/header',$data);
					$this->load->view('back/layout/layout_single',$data);
					$this->load->view('back/global/footer');
					$this->load->view('back/layout/bottom_layout');
				}else if($layout == 'single-video'){
					$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
					foreach($query1->result() as $sess){
						$data['id'] = $sess->profile_back_id;
						$data['full'] = $sess->profile_back_name_full;
						$data['nick'] = $sess->profile_back_nick;
						$data['pict'] = $sess->profile_back_pict;
						$data['email'] = $sess->profile_back_email;
					}
					
					$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
					
					$data['get_list_top'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00001' and adv_status = 1");
					$query_top = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00001' and sk_adv_layout.layout_name = 'single-video'");
					if($query_top->num_rows() == 0){
						$data['get_top'] = "";
						$data['get_top_img'] = "";
					}else{
						foreach($query_top->result() as $top){
							$data['get_top'] = $top->adv_id;
							$data['get_top_img'] = $top->adv_pict;
						}
					}
					
					$data['get_list_main'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00002' and adv_status = 1");
					$query_main = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00002' and sk_adv_layout.layout_name = 'single-video'");
					if($query_main->num_rows() == 0){
						$data['get_main'] = "";
						$data['get_main_img'] = "";
					}else{
						foreach($query_main->result() as $main){
							$data['get_main'] = $main->adv_id;
							$data['get_main_img'] = $main->adv_pict;
						}
					}
					
					$data['get_list_cright1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00008' and adv_status = 1");
					$query_cright1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00008' and sk_adv_layout.layout_name = 'single-video'");
					if($query_cright1->num_rows() == 0){
						$data['get_cright1'] = "";
						$data['get_cright1_img'] = "";
					}else{
						foreach($query_cright1->result() as $cright1){
							$data['get_cright1'] = $cright1->adv_id;
							$data['get_cright1_img'] = $cright1->adv_pict;
						}
					}
					
					$data['get_list_cright2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00009' and adv_status = 1");
					$query_cright2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00009' and sk_adv_layout.layout_name = 'single-video'");
					if($query_cright2->num_rows() == 0){
						$data['get_cright2'] = "";
						$data['get_cright2_img'] = "";
					}else{
						foreach($query_cright2->result() as $cright2){
							$data['get_cright2'] = $cright2->adv_id;
							$data['get_cright2_img'] = $cright2->adv_pict;
						}
					}
					
					$data['get_list_cright3'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00010' and adv_status = 1");
					$query_cright3 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00010' and sk_adv_layout.layout_name = 'single-video'");
					if($query_cright3->num_rows() == 0){
						$data['get_cright3'] = "";
						$data['get_cright3_img'] = "";
					}else{
						foreach($query_cright3->result() as $cright3){
							$data['get_cright3'] = $cright3->adv_id;
							$data['get_cright3_img'] = $cright3->adv_pict;
						}
					}
					
					$data['get_list_vertical'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00012' and adv_status = 1");
					$query_vertical = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00012' and sk_adv_layout.layout_name = 'single-video'");
					if($query_vertical->num_rows() == 0){
						$data['get_vertical'] = "";
						$data['get_vertical_img'] = "";
					}else{
						foreach($query_vertical->result() as $vertical){
							$data['get_vertical'] = $vertical->adv_id;
							$data['get_vertical_img'] = $vertical->adv_pict;
						}
					}
					
					$data['get_list_horizontal1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00013' and adv_status = 1");
					$query_horizontal1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00013' and sk_adv_layout.layout_name = 'single-video'");
					if($query_horizontal1->num_rows() == 0){
						$data['get_horizontal1'] = "";
						$data['get_horizontal1_img'] = "";
					}else{
						foreach($query_horizontal1->result() as $horizontal1){
							$data['get_horizontal1'] = $horizontal1->adv_id;
							$data['get_horizontal1_img'] = $horizontal1->adv_pict;
						}
					}
					
					$data['get_list_horizontal2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00014' and adv_status = 1");
					$query_horizontal2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00014' and sk_adv_layout.layout_name = 'single-video'");
					if($query_horizontal2->num_rows() == 0){
						$data['get_horizontal2'] = "";
						$data['get_horizontal2_img'] = "";
					}else{
						foreach($query_horizontal2->result() as $horizontal2){
							$data['get_horizontal2'] = $horizontal2->adv_id;
							$data['get_horizontal2_img'] = $horizontal2->adv_pict;
						}
					}
					
					$data['get_list_mobile'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00017' and adv_status = 1");
					$query_mobile = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00017' and sk_adv_layout.layout_name = 'single-video'");
					if($query_mobile->num_rows() == 0){
						$data['get_mobile'] = "";
						$data['get_mobile_img'] = "";
					}else{
						foreach($query_mobile->result() as $pop){
							$data['get_mobile'] = $pop->adv_id;
							$data['get_mobile_img'] = $pop->adv_pict;
						}
					}
					
					$this->load->view('back/global/top');
					$this->load->view('back/global/header',$data);
					$this->load->view('back/layout/layout_single_video',$data);
					$this->load->view('back/global/footer');
					$this->load->view('back/layout/bottom_layout');
				}else if($layout == 'single-photo'){
					$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
					foreach($query1->result() as $sess){
						$data['id'] = $sess->profile_back_id;
						$data['full'] = $sess->profile_back_name_full;
						$data['nick'] = $sess->profile_back_nick;
						$data['pict'] = $sess->profile_back_pict;
						$data['email'] = $sess->profile_back_email;
					}
					
					$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
					
					$data['get_list_top'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00001' and adv_status = 1");
					$query_top = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00001' and sk_adv_layout.layout_name = 'single-photo'");
					if($query_top->num_rows() == 0){
						$data['get_top'] = "";
						$data['get_top_img'] = "";
					}else{
						foreach($query_top->result() as $top){
							$data['get_top'] = $top->adv_id;
							$data['get_top_img'] = $top->adv_pict;
						}
					}
					
					$data['get_list_main'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00002' and adv_status = 1");
					$query_main = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00002' and sk_adv_layout.layout_name = 'single-photo'");
					if($query_main->num_rows() == 0){
						$data['get_main'] = "";
						$data['get_main_img'] = "";
					}else{
						foreach($query_main->result() as $main){
							$data['get_main'] = $main->adv_id;
							$data['get_main_img'] = $main->adv_pict;
						}
					}
					
					$data['get_list_cright1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00008' and adv_status = 1");
					$query_cright1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00008' and sk_adv_layout.layout_name = 'single-photo'");
					if($query_cright1->num_rows() == 0){
						$data['get_cright1'] = "";
						$data['get_cright1_img'] = "";
					}else{
						foreach($query_cright1->result() as $cright1){
							$data['get_cright1'] = $cright1->adv_id;
							$data['get_cright1_img'] = $cright1->adv_pict;
						}
					}
					
					$data['get_list_cright2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00009' and adv_status = 1");
					$query_cright2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00009' and sk_adv_layout.layout_name = 'single-photo'");
					if($query_cright2->num_rows() == 0){
						$data['get_cright2'] = "";
						$data['get_cright2_img'] = "";
					}else{
						foreach($query_cright2->result() as $cright2){
							$data['get_cright2'] = $cright2->adv_id;
							$data['get_cright2_img'] = $cright2->adv_pict;
						}
					}
					
					$data['get_list_cright3'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00010' and adv_status = 1");
					$query_cright3 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00010' and sk_adv_layout.layout_name = 'single-photo'");
					if($query_cright3->num_rows() == 0){
						$data['get_cright3'] = "";
						$data['get_cright3_img'] = "";
					}else{
						foreach($query_cright3->result() as $cright3){
							$data['get_cright3'] = $cright3->adv_id;
							$data['get_cright3_img'] = $cright3->adv_pict;
						}
					}
					
					$data['get_list_vertical'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00012' and adv_status = 1");
					$query_vertical = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00012' and sk_adv_layout.layout_name = 'single-photo'");
					if($query_vertical->num_rows() == 0){
						$data['get_vertical'] = "";
						$data['get_vertical_img'] = "";
					}else{
						foreach($query_vertical->result() as $vertical){
							$data['get_vertical'] = $vertical->adv_id;
							$data['get_vertical_img'] = $vertical->adv_pict;
						}
					}
					
					$data['get_list_horizontal1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00013' and adv_status = 1");
					$query_horizontal1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00013' and sk_adv_layout.layout_name = 'single-photo'");
					if($query_horizontal1->num_rows() == 0){
						$data['get_horizontal1'] = "";
						$data['get_horizontal1_img'] = "";
					}else{
						foreach($query_horizontal1->result() as $horizontal1){
							$data['get_horizontal1'] = $horizontal1->adv_id;
							$data['get_horizontal1_img'] = $horizontal1->adv_pict;
						}
					}
					
					$data['get_list_horizontal2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00014' and adv_status = 1");
					$query_horizontal2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00014' and sk_adv_layout.layout_name = 'single-photo'");
					if($query_horizontal2->num_rows() == 0){
						$data['get_horizontal2'] = "";
						$data['get_horizontal2_img'] = "";
					}else{
						foreach($query_horizontal2->result() as $horizontal2){
							$data['get_horizontal2'] = $horizontal2->adv_id;
							$data['get_horizontal2_img'] = $horizontal2->adv_pict;
						}
					}
					
					$data['get_list_mobile'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00017' and adv_status = 1");
					$query_mobile = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00017' and sk_adv_layout.layout_name = 'single-photo'");
					if($query_mobile->num_rows() == 0){
						$data['get_mobile'] = "";
						$data['get_mobile_img'] = "";
					}else{
						foreach($query_mobile->result() as $pop){
							$data['get_mobile'] = $pop->adv_id;
							$data['get_mobile_img'] = $pop->adv_pict;
						}
					}
					
					$this->load->view('back/global/top');
					$this->load->view('back/global/header',$data);
					$this->load->view('back/layout/layout_single_photo',$data);
					$this->load->view('back/global/footer');
					$this->load->view('back/layout/bottom_layout');
				}else if($layout == 'video'){
					$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
					foreach($query1->result() as $sess){
						$data['id'] = $sess->profile_back_id;
						$data['full'] = $sess->profile_back_name_full;
						$data['nick'] = $sess->profile_back_nick;
						$data['pict'] = $sess->profile_back_pict;
						$data['email'] = $sess->profile_back_email;
					}
					
					$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
					
					$data['get_list_top'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00001' and adv_status = 1");
					$query_top = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00001' and sk_adv_layout.layout_name = 'video'");
					if($query_top->num_rows() == 0){
						$data['get_top'] = "";
						$data['get_top_img'] = "";
					}else{
						foreach($query_top->result() as $top){
							$data['get_top'] = $top->adv_id;
							$data['get_top_img'] = $top->adv_pict;
						}
					}
					
					$data['get_list_main'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00002' and adv_status = 1");
					$query_main = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00002' and sk_adv_layout.layout_name = 'video'");
					if($query_main->num_rows() == 0){
						$data['get_main'] = "";
						$data['get_main_img'] = "";
					}else{
						foreach($query_main->result() as $main){
							$data['get_main'] = $main->adv_id;
							$data['get_main_img'] = $main->adv_pict;
						}
					}
					
					$data['get_list_cright1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00008' and adv_status = 1");
					$query_cright1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00008' and sk_adv_layout.layout_name = 'video'");
					if($query_cright1->num_rows() == 0){
						$data['get_cright1'] = "";
						$data['get_cright1_img'] = "";
					}else{
						foreach($query_cright1->result() as $cright1){
							$data['get_cright1'] = $cright1->adv_id;
							$data['get_cright1_img'] = $cright1->adv_pict;
						}
					}
					
					$data['get_list_cright2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00009' and adv_status = 1");
					$query_cright2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00009' and sk_adv_layout.layout_name = 'video'");
					if($query_cright2->num_rows() == 0){
						$data['get_cright2'] = "";
						$data['get_cright2_img'] = "";
					}else{
						foreach($query_cright2->result() as $cright2){
							$data['get_cright2'] = $cright2->adv_id;
							$data['get_cright2_img'] = $cright2->adv_pict;
						}
					}
					
					$data['get_list_cright3'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00010' and adv_status = 1");
					$query_cright3 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00010' and sk_adv_layout.layout_name = 'video'");
					if($query_cright3->num_rows() == 0){
						$data['get_cright3'] = "";
						$data['get_cright3_img'] = "";
					}else{
						foreach($query_cright3->result() as $cright3){
							$data['get_cright3'] = $cright3->adv_id;
							$data['get_cright3_img'] = $cright3->adv_pict;
						}
					}
					
					$data['get_list_horizontal1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00013' and adv_status = 1");
					$query_horizontal1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00013' and sk_adv_layout.layout_name = 'video'");
					if($query_horizontal1->num_rows() == 0){
						$data['get_horizontal1'] = "";
						$data['get_horizontal1_img'] = "";
					}else{
						foreach($query_horizontal1->result() as $horizontal1){
							$data['get_horizontal1'] = $horizontal1->adv_id;
							$data['get_horizontal1_img'] = $horizontal1->adv_pict;
						}
					}
					
					$data['get_list_horizontal2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00014' and adv_status = 1");
					$query_horizontal2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00014' and sk_adv_layout.layout_name = 'video'");
					if($query_horizontal2->num_rows() == 0){
						$data['get_horizontal2'] = "";
						$data['get_horizontal2_img'] = "";
					}else{
						foreach($query_horizontal2->result() as $horizontal2){
							$data['get_horizontal2'] = $horizontal2->adv_id;
							$data['get_horizontal2_img'] = $horizontal2->adv_pict;
						}
					}
					
					$data['get_list_mobile'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00017' and adv_status = 1");
					$query_mobile = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00017' and sk_adv_layout.layout_name = 'video'");
					if($query_mobile->num_rows() == 0){
						$data['get_mobile'] = "";
						$data['get_mobile_img'] = "";
					}else{
						foreach($query_mobile->result() as $pop){
							$data['get_mobile'] = $pop->adv_id;
							$data['get_mobile_img'] = $pop->adv_pict;
						}
					}
					
					$this->load->view('back/global/top');
					$this->load->view('back/global/header',$data);
					$this->load->view('back/layout/layout_video',$data);
					$this->load->view('back/global/footer');
					$this->load->view('back/layout/bottom_layout');
				}else if($layout == 'photo'){
					$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
					foreach($query1->result() as $sess){
						$data['id'] = $sess->profile_back_id;
						$data['full'] = $sess->profile_back_name_full;
						$data['nick'] = $sess->profile_back_nick;
						$data['pict'] = $sess->profile_back_pict;
						$data['email'] = $sess->profile_back_email;
					}
					
					$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal order by kanal_name asc");
					
					$data['get_list_top'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00001' and adv_status = 1");
					$query_top = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00001' and sk_adv_layout.layout_name = 'photo'");
					if($query_top->num_rows() == 0){
						$data['get_top'] = "";
						$data['get_top_img'] = "";
					}else{
						foreach($query_top->result() as $top){
							$data['get_top'] = $top->adv_id;
							$data['get_top_img'] = $top->adv_pict;
						}
					}
					
					$data['get_list_main'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00002' and adv_status = 1");
					$query_main = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00002' and sk_adv_layout.layout_name = 'photo'");
					if($query_main->num_rows() == 0){
						$data['get_main'] = "";
						$data['get_main_img'] = "";
					}else{
						foreach($query_main->result() as $main){
							$data['get_main'] = $main->adv_id;
							$data['get_main_img'] = $main->adv_pict;
						}
					}
					
					$data['get_list_cright1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00008' and adv_status = 1");
					$query_cright1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00008' and sk_adv_layout.layout_name = 'photo'");
					if($query_cright1->num_rows() == 0){
						$data['get_cright1'] = "";
						$data['get_cright1_img'] = "";
					}else{
						foreach($query_cright1->result() as $cright1){
							$data['get_cright1'] = $cright1->adv_id;
							$data['get_cright1_img'] = $cright1->adv_pict;
						}
					}
					
					$data['get_list_cright2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00009' and adv_status = 1");
					$query_cright2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00009' and sk_adv_layout.layout_name = 'photo'");
					if($query_cright2->num_rows() == 0){
						$data['get_cright2'] = "";
						$data['get_cright2_img'] = "";
					}else{
						foreach($query_cright2->result() as $cright2){
							$data['get_cright2'] = $cright2->adv_id;
							$data['get_cright2_img'] = $cright2->adv_pict;
						}
					}
					
					$data['get_list_cright3'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00010' and adv_status = 1");
					$query_cright3 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00010' and sk_adv_layout.layout_name = 'photo'");
					if($query_cright3->num_rows() == 0){
						$data['get_cright3'] = "";
						$data['get_cright3_img'] = "";
					}else{
						foreach($query_cright3->result() as $cright3){
							$data['get_cright3'] = $cright3->adv_id;
							$data['get_cright3_img'] = $cright3->adv_pict;
						}
					}
					
					$data['get_list_horizontal1'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00013' and adv_status = 1");
					$query_horizontal1 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00013' and sk_adv_layout.layout_name = 'photo'");
					if($query_horizontal1->num_rows() == 0){
						$data['get_horizontal1'] = "";
						$data['get_horizontal1_img'] = "";
					}else{
						foreach($query_horizontal1->result() as $horizontal1){
							$data['get_horizontal1'] = $horizontal1->adv_id;
							$data['get_horizontal1_img'] = $horizontal1->adv_pict;
						}
					}
					
					$data['get_list_horizontal2'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00014' and adv_status = 1");
					$query_horizontal2 = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00014' and sk_adv_layout.layout_name = 'photo'");
					if($query_horizontal2->num_rows() == 0){
						$data['get_horizontal2'] = "";
						$data['get_horizontal2_img'] = "";
					}else{
						foreach($query_horizontal2->result() as $horizontal2){
							$data['get_horizontal2'] = $horizontal2->adv_id;
							$data['get_horizontal2_img'] = $horizontal2->adv_pict;
						}
					}
					
					$data['get_list_mobile'] = $this->db->query("select adv_id, adv_title from sk_adv where kanal_id = '".$kanal."' and position_id = 'PSB00017' and adv_status = 1");
					$query_mobile = $this->db->query("select sk_adv_layout.adv_id, sk_adv.adv_pict from sk_adv_layout, sk_adv where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.kanal_id='".$kanal."' and sk_adv_layout.position_id = 'PSB00017' and sk_adv_layout.layout_name = 'photo'");
					if($query_mobile->num_rows() == 0){
						$data['get_mobile'] = "";
						$data['get_mobile_img'] = "";
					}else{
						foreach($query_mobile->result() as $pop){
							$data['get_mobile'] = $pop->adv_id;
							$data['get_mobile_img'] = $pop->adv_pict;
						}
					}
					
					$this->load->view('back/global/top');
					$this->load->view('back/global/header',$data);
					$this->load->view('back/layout/layout_photo',$data);
					$this->load->view('back/global/footer');
					$this->load->view('back/layout/bottom_layout');
				}
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		
		function set_banner($layout, $kanal){
			$cek = $this->session->userdata('login_session');
			if(!$cek){
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}else{
				$select = $this->input->post("selected_id");
				$kanal = $this->uri->segment(5);
				$layout = $this->uri->segment(4);
				$position = $this->input->post("position_id");
				
				if($select != 'clear'){
					$cek_query = $this->db->query("select * from sk_adv_layout where kanal_id = '".$kanal."' and position_id = '".$position."' and layout_name='".$layout."'");
					if($cek_query->num_rows() == 0){
						$data['kanal_id'] = $kanal;
						$data['position_id'] = $position;
						$data['layout_name'] = $layout;
						$data['adv_id'] = $select;
						$data['posted_by'] = date('Y-m-d H:i:s');
						$update_query = $this->sk_model->insert_data('sk_adv_layout', $data);
					}else{
						foreach($cek_query->result() as $db){
							$id = $db->ObjectID;
						}
						$data['kanal_id'] = $kanal;
						$data['position_id'] = $position;
						$data['layout_name'] = $layout;
						$data['adv_id'] = $select;
						$data['posted_by'] = date('Y-m-d H:i:s');
						$update_query = $this->sk_model->update_data('sk_adv_layout', 'ObjectID', $id, $data);
					}
					
					if($update_query){
						$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Update Banner was Success<br/><span style='font-size:11px;'>Thank You!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/advertisement/layout/'.$layout.'/'.$kanal);
					}else{
						$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/advertisement/layout/'.$layout.'/'.$kanal);
					}
				}else{
					$update_query = $this->db->query("delete from sk_adv_layout where layout_name = '".$layout."' and kanal_id = '".$kanal."' and position_id = '".$position."'");
					if($update_query){
						$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Update Banner was Success<br/><span style='font-size:11px;'>Thank You!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/advertisement/layout/'.$layout.'/'.$kanal);
					}else{
						$this->session->set_flashdata('adv_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/advertisement/layout/'.$layout.'/'.$kanal);
					}
				}
			}
		}
		
		
		
		
	}
/*end of file Advertising.php*/
/*Location:.application/controllers/back/Posting.php*/