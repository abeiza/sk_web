<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class General extends CI_Controller{
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
				
				$query = $this->db->query("select * from sk_info_web where ObjectID = 1");
				if($query->num_rows() == 0)
				{
					$data['title'] = '';
					$data['tagline'] = '';
					$data['light'] = '';
					$data['dark'] = '';
					
				}else{
					foreach($query->result() as $info){
						$data['title'] = $info->info_title;
						$data['tagline'] = $info->info_tagline;
						$data['light'] = $info->info_logo_light;
						$data['dark'] = $info->info_logo_dark;
					}
				}
				
				$data['error'] = '';
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/info/edit_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/post/bottom_post');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function act_change_pict(){
			$configu['upload_path'] = './uploads/info/';
			$configu['upload_url'] = base_url().'uploads/info/';
			$configu['allowed_types'] = 'gif|jpeg|jpg|png';
			$configu['max_size'] = '1000000';
			$configu['max_width'] = '1000000';
			$configu['max_height'] = '1000000';
			
			$this->load->library('upload',$configu);
			
			if (!$this->upload->do_upload('pict'))
			{
				$data['error'] = "<div id='notif1' style='width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>".$this->upload->display_errors()."</span></div></div>";
				
				$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
				foreach($query1->result() as $sess){
					$data['id'] = $sess->profile_back_id;
					$data['full'] = $sess->profile_back_name_full;
					$data['nick'] = $sess->profile_back_nick;
					$data['pict'] = $sess->profile_back_pict;
					$data['email'] = $sess->profile_back_email;
				}
				
				$query = $this->db->query("select * from sk_info_web where ObjectID = 1");
				if($query->num_rows() == 0)
				{
					$data['title'] = '';
					$data['tagline'] = '';
					$data['light'] = '';
					$data['dark'] = '';
					
				}else{
					foreach($query->result() as $info){
						$data['title'] = $info->info_title;
						$data['tagline'] = $info->info_tagline;
						$data['light'] = $info->info_logo_light;
						$data['dark'] = $info->info_logo_dark;
					}
				}
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/info/edit_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/post/bottom_post');
			}
			else
			{
				$upload_data = $this->upload->data();
				
				$id = 1;
				$data['info_logo_light'] = $upload_data['file_name'];

				$edit_data1 = $this->sk_model->update_data('sk_info_web','ObjectID',$id,$data);
				if($edit_data1){
					$this->session->set_flashdata('info_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Berhasil<br/><span style='font-size:11px;'>Logo web telah terupdate!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/general/');
				}else{
					$this->session->set_flashdata('info_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Ubah Foto Profil Gagal<br/><span style='font-size:11px;'>Mohon coba lagi dengan foto yang lain!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/general/');
				}
			}
		}
		
		function edit(){
				$id = 1;
				$data['info_title'] = $this->input->post('title');
				$data['info_tagline'] = $this->input->post('tagline');
		
				$add_data = $this->sk_model->update_data('sk_info_web', 'ObjectID', $id, $data);
				
				if(!$add_data){
					$this->session->set_flashdata('info_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/general/');
				}else{
					$this->session->set_flashdata('info_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/general/');
				}		
		}
		
		
	}
/*end of file General.php*/
/*Location:.application/controllers/back/Posting.php*/