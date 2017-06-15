<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Login extends CI_Controller{
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
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/dashboard/dashboard');
				$this->load->view('back/global/footer');
				$this->load->view('back/global/bottom');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function login_act(){
			$this->form_validation->set_rules('username','username','trim|required');
			$this->form_validation->set_rules('password','password','trim|required');
			if($this->form_validation->run() == false){
				$this->index();
			}else{
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$validation = $this->sk_model->validation_login($username,$password);
				if($validation->num_rows() == 0){
					$this->session->set_flashdata('login_result',"<div id='notif' style='padding-left:17%;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your data was invalid<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/login/');
				}else{
					foreach($validation->result() as $log){
						$login_data['obj'] = $log->objectID;
						$login_data['id'] = $log->user_back_id;
						$login_data['lv'] = $log->user_back_level;
						$login_data['log'] = $log->user_back_logdate;
						$login_data['login_session'] = 'sukses_login';
						$this->session->set_userdata($login_data);
					}
					$data['user_back_logdate'] = date("Y-m-d H:i:s");
					$set_log = $this->sk_model->update_data('sk_user_back', 'user_back_id', $this->session->userdata("id"), $data);
					
					Header('Location:'.base_url().'index.php/back/dashboard/');
				}
			}
		}
		
		public function logout_act(){
			$this->session->sess_destroy();
			$cek = $this->session->userdata('login_session');
			if($cek){
				$this->session->set_flashdata('login_result',"<div id='notif' style='padding-left:17%;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Thank you<br/><span style='font-size:11px;'>For your coming</span></div></div>");
				Header('Location:'.base_url().'index.php/back/login/');
			}else{
				$this->session->set_flashdata('login_result',"<div id='notif' style='padding-left:17%;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your data was invalid<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/login/');
			}
		}
	}
/*end of file Login.php*/
/*Location:.application/controllers/back/login.php*/