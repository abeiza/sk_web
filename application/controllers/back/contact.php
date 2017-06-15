<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Contact extends CI_Controller{
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
				
				$query = $this->db->query("select * from sk_contact where ObjectID = 1");
				$query1 = $this->db->query("select * from sk_sosmed where ObjectID = 1");
				if($query->num_rows() == 0)
				{
						$data['name'] = '';
						$data['telp1'] = '';
						$data['telp2'] = '';
						$data['telp3'] = '';
						$data['fax'] = '';
						$data['email'] = '';
						$data['address'] = '';
					
				}else{
					foreach($query->result() as $info){
						$data['name'] = $info->contact_company;
						$data['telp1'] = $info->contact_telp1;
						$data['telp2'] = $info->contact_telp2;
						$data['telp3'] = $info->contact_telp3;
						$data['fax'] = $info->contact_fax;
						$data['email'] = $info->contact_email;
						$data['address'] = $info->contact_address;
					}
				}
				
				if($query1->num_rows() == 0)
				{
						$data['facebook'] = '';
						$data['twitter'] = '';
						$data['google'] = '';
						$data['instagram'] = '';
						$data['youtube'] = '';
					
				}else{
					foreach($query1->result() as $sm){
						$data['facebook'] = $sm->sosmed_facebook;
						$data['twitter'] = $sm->sosmed_twitter;
						$data['google'] = $sm->sosmed_google;
						$data['instagram'] = $sm->sosmed_instagram;
						$data['youtube'] = $sm->sosmed_youtube;
					}
				}
				
				$data['error'] = '';
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/sosmed/edit_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/post/bottom_post');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function edit(){
				$id = 1;
				$data['contact_company'] = $this->input->post('name');
				$data['contact_telp1'] = $this->input->post('telp1');
				$data['contact_telp2'] = $this->input->post('telp2');
				$data['contact_telp3'] = $this->input->post('telp3');
				$data['contact_fax'] = $this->input->post('fax');
				$data['contact_email'] = $this->input->post('email');
				$data['contact_address'] = $this->input->post('address');
				
				$data1['sosmed_facebook'] = $this->input->post('facebook');
				$data1['sosmed_twitter'] = $this->input->post('twitter');
				$data1['sosmed_google'] = $this->input->post('google');
				$data1['sosmed_instagram'] = $this->input->post('instagram');
				$data1['sosmed_youtube'] = $this->input->post('youtube');
		
				$add_data = $this->sk_model->update_data('sk_contact', 'ObjectID', $id, $data);
				$add_data1 = $this->sk_model->update_data('sk_sosmed', 'ObjectID', $id, $data1);
				
				if(!$add_data and !$add_data1){
					$this->session->set_flashdata('contact_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/contact/');
				}else{
					$this->session->set_flashdata('contact_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/contact/');
				}		
		}
	}
/*end of file Contact.php*/
/*Location:.application/controllers/back/Posting.php*/