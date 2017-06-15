<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Tag extends CI_Controller{
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
				
				$list['get_tag'] = $this->db->query("select tag_id, tag_name, user_back_name, tag_modify_date, tag_status 
				from sk_user_back, sk_tag where sk_tag.tag_posted_by = sk_user_back.user_back_id order by tag_id desc");
				
				$list['get_tag_list'] = $this->db->query("select tag_id, tag_name, user_back_name, tag_modify_date, tag_status 
				from sk_user_back, sk_tag where sk_tag.tag_posted_by = sk_user_back.user_back_id order by tag_id desc limit 100");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/tag/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/tag/bottom_tag');
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
				$this->load->view('back/tag/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/tag/bottom_tag');
			}
		}
	
		function add(){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$this->form_validation->set_rules('name','title','trim|required|max_length[150]');
				
				if($this->form_validation->run() == false){
					$this->add_form();
				}else{
		
					$data['tag_id'] = $this->sk_model->getMaxKode('sk_tag', 'tag_id', 'TAG');
					$data['tag_name'] = $this->input->post('name');
					$data['tag_desc'] = $this->input->post('desc');
					$data['tag_modify_date'] = date("Y-m-d H:i:s");
					$data['tag_posted_by'] = $this->session->userdata('id');
					
					if($this->input->post('status') != 1){
						$status = 0;
					}else{
						$status = 1;
					}
					$data['tag_status'] = $status;
			
					$add_data = $this->sk_model->insert_data('sk_tag', $data);
					
					if(!$add_data){
						$this->session->set_flashdata('tag_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/tag/');
					}else{
						$this->session->set_flashdata('tag_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/tag/');
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
				$tag_read = $this->db->query("select * from sk_tag where tag_id='".$id."'");
				foreach($tag_read->result() as $db){
					$data['id'] = $db->tag_id;
					$data['name'] = $db->tag_name;
					$data['desc'] = $db->tag_desc;
					$data['status'] = $db->tag_status;
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
				$this->load->view('back/tag/edit_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/tag/bottom_tag');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		
		function edit($id){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$this->form_validation->set_rules('name','title','trim|required|max_length[30]');
			
				if($this->form_validation->run() == false){
					$this->edit_form($this->uri->segment(4));
				}else{
					$id = $this->uri->segment(4);
					$data['tag_name'] = $this->input->post('name');
					$data['tag_desc'] = $this->input->post('desc');
					$data['tag_modify_date'] = date("Y-m-d H:i:s");
					$data['tag_posted_by'] = $this->session->userdata('id');
					
					if($this->input->post('status') != 1){
						$status = 0;
					}else{
						$status = 1;
					}
					$data['tag_status'] = $status;
			
					$add_data = $this->sk_model->update_data('sk_tag', 'tag_id', $id, $data);
					
					if(!$add_data){
						$this->session->set_flashdata('tag_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/tag/');
					}else{
						$this->session->set_flashdata('tag_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/tag/');
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
				
				$delete = $this->db->query("delete from sk_tag where tag_id='".$id."'");
				if(!$delete){
					$this->session->set_flashdata('tag_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/tag/');
				}else{
					$this->session->set_flashdata('tag_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/tag/');
				}
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
	}
/*end of file tag.php*/
/*Location:.application/controllers/back/tag.php*/