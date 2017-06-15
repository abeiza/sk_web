<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Adventorial extends CI_Controller{
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
				
				$list['get_adventorial'] = $this->db->query("select post_id, post_title, post_shrt_desc, user_back_name, post_status, post_modify_date  
				from sk_post, sk_user_back  
				where sk_post.flag_id = 'FLG00001' and sk_user_back.user_back_id = sk_post.post_posted_by  
				order by post_posted_by desc");
				
				$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal where kanal_status = '1' order by kanal_name");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/adventorial/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/adventorial/bottom_adventorial');
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
				$this->load->view('back/adventorial/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/adventorial/bottom_adventorial');
			}
		}
	
		function add(){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$this->form_validation->set_rules('title','title','trim|required|max_length[225]');
				$this->form_validation->set_rules('short','short descriptions','trim|required');
				
				if(empty($_FILES['pict']['name'])){
					$this->form_validation->set_rules('pict', 'image logo', 'required');
				}
				
				if($this->form_validation->run() == false){
					$this->add_form();
				}else{
					$configu['upload_path'] = './uploads/advertise/original/';
					$configu['upload_url'] = base_url().'uploads/advertise/original/';
					$configu['allowed_types'] = 'gif|jpeg|jpg|png';
					$configu['max_size'] = '10000';
					//$configu['max_width'] = '800';
					//$configu['max_height'] = '450';
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
						
						$this->load->view('back/global/top');
						$this->load->view('back/global/header',$data);
						$this->load->view('back/adventorial/add_form',$data);
						$this->load->view('back/global/footer');
						$this->load->view('back/adventorial/bottom_adventorial');
					}
					else
					{
						$upload_data = $this->upload->data();
					
						$config1['image_library'] = 'GD2';
						$config1['source_image'] = $upload_data['full_path'];
						$config1['new_image'] = 'uploads/advertise/thumb/'.$upload_data['file_name'];
						//$config1['create_thumb'] = TRUE;
						$config1['maintain_ratio'] = TRUE;
						$config1['width'] = 254;
						$config1['height'] = 100;

						$this->load->library('image_lib', $config1);

						if(!$this->image_lib->resize()){
							echo $this->image_lib->display_errors();
						}
						$title_post = trim($this->input->post('title'));
						$title_url = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $title_post);
						$data['post_id'] = $this->sk_model->getMaxKode('sk_post', 'post_id', 'POS');
						$data['post_title'] = $this->input->post('title');
						$data['post_shrt_desc'] = $this->input->post('short');
						$data['post_desc'] = $this->input->post('desc');
						$data['category_id'] = 'CTG00001';
						$data['post_pict'] = $upload_data['file_name'];
						$data['post_thumb'] = $upload_data['file_name'];
						if($this->input->post('direct') == '0' or $this->input->post('direct') == '' or $this->input->post('direct') == null){
							$data['post_url'] = str_replace(' ', '+', $title_url);
							$data['post_direct'] = '0';
						}else{
							$data['post_url'] = $this->input->post('direct');
							$data['post_direct'] = '1';
						}
						$data['post_posted_by'] = $this->session->userdata('id');
						$data['post_modify_date'] = date("Y-m-d H:i:s");
						$data['flag_id'] = 'FLG00001';
						$data['post_status'] = $this->input->post('status');
				
						$add_data = $this->sk_model->insert_data('sk_post', $data);
					
						if(!$add_data){
							$this->session->set_flashdata('adventorial_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/adventorial/');
						}else{
							$this->session->set_flashdata('adventorial_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/adventorial/');
						}
					}
				}
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
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
					if($db->post_direct == '1'){
						$data['direct'] = $db->post_url;
					}else{
						$data['direct'] = '';
					}
					$data['desc'] = $db->post_desc;
					$data['pict2'] = $db->post_pict;
					$data['status'] = $db->post_status;
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
				$this->load->view('back/adventorial/edit_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/adventorial/bottom_adventorial');
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
						$data['category_id'] = 'CTG00001';
						if($this->input->post('direct') == '0' or $this->input->post('direct') == '' or $this->input->post('direct') == null){
							$data['post_url'] = str_replace(' ', '+', $title_url);
							$data['post_direct'] = '0';
						}else{
							$data['post_url'] = $this->input->post('direct');
							$data['post_direct'] = '1';
						}
						$data['post_posted_by'] = $this->session->userdata('id');
						$data['post_modify_date'] = date("Y-m-d H:i:s");
						$data['post_status'] = $this->input->post('status');
				
						$add_data = $this->sk_model->update_data('sk_post', 'post_id', $id, $data);
						
						if(!$add_data){
							$this->session->set_flashdata('adventorial_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/adventorial/edit_form/'.$id);
						}else{
							$this->session->set_flashdata('adventorial_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
							Header('Location:'.base_url().'index.php/back/adventorial/edit_form/'.$id);
						}	
					}else{
						$configu['upload_path'] = './uploads/post/original/';
						$configu['upload_url'] = base_url().'uploads/oost/original/';
						$configu['allowed_types'] = 'gif|jpeg|jpg|png';
						$configu['max_size'] = '10000';
						//$configu['max_width'] = '800';
						//$configu['max_height'] = '450';
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
								$data['pict2'] = $db->post_pict;
								$data['status'] = $db->post_status;
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
							$this->load->view('back/adventorial/edit_form',$data);
							$this->load->view('back/global/footer');
							$this->load->view('back/adventorial/bottom_adventorial');
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
							$data['post_pict'] = $upload_data['file_name'];
							$data['post_thumb'] = $upload_data['file_name'];
							$data['post_posted_by'] = $this->session->userdata('id');
							$data['category_id'] = 'CTG00001';
							if($this->input->post('direct') == '0' or $this->input->post('direct') == '' or $this->input->post('direct') == null){
								$data['post_url'] = str_replace(' ', '+', $title_url);
								$data['post_direct'] = '0';
							}else{
								$data['post_url'] = $this->input->post('direct');
								$data['post_direct'] = '1';
							}
							$data['post_modify_date'] = date("Y-m-d H:i:s");
							$data['post_status'] = $this->input->post('status');
							
							$add_data = $this->sk_model->update_data('sk_post', 'post_id', $id, $data);
					
							if(!$add_data){
								$this->session->set_flashdata('adventorial_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
								Header('Location:'.base_url().'index.php/back/adventorial/edit_form/'.$id);
							}else{
								$this->session->set_flashdata('adventorial_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
								Header('Location:'.base_url().'index.php/back/adventorial/edit_form/'.$id);
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
					$this->session->set_flashdata('adventorial_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/adventorial/');
				}else{
					$this->session->set_flashdata('adventorial_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/adventorial/');
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