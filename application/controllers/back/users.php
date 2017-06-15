<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Users extends CI_Controller{
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
				
				if($this->session->userdata('lv') == 'POT00003'){
					$list['get_users'] = $this->db->query("select * from sk_user_back where user_back_level = 'POT00002' order by objectID desc");
				}else{
					$list['get_users'] = $this->db->query("select * from sk_user_back where user_back_level != 'POT00001' order by objectID desc");
				}
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/users/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/users/bottom_users');
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
				$this->load->view('back/users/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/users/bottom_users');
			}
		}
	
		function add(){
			$this->form_validation->set_rules('name','name','trim|required|max_length[50]');
			$this->form_validation->set_rules('username','username','trim|required|max_length[30]');
			$this->form_validation->set_rules('password','password','trim|required|max_length[30]');
			$this->form_validation->set_rules('conf','confirm password','matches[password]');
			
			if($this->form_validation->run() == false){
				$this->add_form();
			}else{				
				$cek_account = $this->db->query("select * from sk_user_back where user_back_username='".$this->input->post('username')."' and user_back_password='".$this->input->post('password')."'");
				if($cek_account->num_rows() == 0){
					$data['user_back_id'] = $this->sk_model->getMaxKode('sk_user_back', 'user_back_id', 'USR');
					$data['user_back_name'] = $this->input->post('name');
					$data['user_back_username'] = $this->input->post('username');
					$data['user_back_password'] = $this->input->post('password');
					$data['user_back_level'] = "POT00002";
					if($this->input->post('status') != 1){
						$status = 0;
					}else{
						$status = 1;
					}
					$data['user_back_status'] = $status;
					
					$data1['profile_back_id'] = $this->sk_model->getMaxKode('sk_profile_back', 'profile_back_id', 'PRF');
					$data1['user_back_id'] = $data['user_back_id'];
			
					$add_data = $this->sk_model->insert_data('sk_user_back', $data);
					$add_data1 = $this->sk_model->insert_data('sk_profile_back', $data1);
				
					if(!$add_data and !$add_data1){
						$this->session->set_flashdata('users_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/users/');
					}else{
						$this->session->set_flashdata('users_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/users/');
					}
				}else{
					$this->session->set_flashdata('users_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Username or Password was not available<br/><span style='font-size:11px;'>Please change your username or password!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/users/');
				}
			}
		}
		
		function edit_form($id){
			$id = $this->uri->segment(4);
			$users_read = $this->db->query("select * from sk_user_back where user_back_id='".$id."'");
			foreach($users_read->result() as $db){
				$data['id'] = $db->user_back_id;
				$data['name'] = $db->user_back_name;
				$data['username'] = $db->user_back_username;
				$data['password'] = $db->user_back_password;
				$data['status'] = $db->user_back_status;
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
			$this->load->view('back/users/edit_form',$data);
			$this->load->view('back/global/footer');
			$this->load->view('back/users/bottom_users');
		}
		
		function edit($id){
			$this->form_validation->set_rules('name','name','trim|required|max_length[50]');
			$this->form_validation->set_rules('username','username','trim|required|max_length[30]');
			$this->form_validation->set_rules('password','password','trim|required|max_length[30]');
			$this->form_validation->set_rules('conf','confirm password','matches[password]');
			
			if($this->form_validation->run() == false){
				$this->edit_form($this->uri->segment(4));
			}else{
				$id = $this->uri->segment(4);
				$data['user_back_name'] = $this->input->post('name');
				$data['user_back_username'] = $this->input->post('username');
				$data['user_back_password'] = $this->input->post('password');
				if($this->input->post('status') != 1){
					$status = 0;
				}else{
					$status = 1;
				}
				$data['user_back_status'] = $status;
		
				$add_data = $this->sk_model->update_data('sk_user_back', 'user_back_id', $id, $data);
				
				if(!$add_data){
					$this->session->set_flashdata('users_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/users/edit_form/'.$id);
				}else{
					$this->session->set_flashdata('users_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/users/');
				}		
			}
		}
		
		function delete($id){
			$id = $this->uri->segment(4);
			
			$delete = $this->db->query("delete from sk_user_back where user_back_id='".$id."'");
			if(!$delete){
				$this->session->set_flashdata('users_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/users/');
			}else{
				$this->session->set_flashdata('users_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/users/');
			}
		}
		
	}
/*end of file Users.php*/
/*Location:.application/controllers/back/Posting.php*/