<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Page extends CI_Controller{
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
				
				$list['get_page'] = $this->db->query("select  page_id, page_title, page_short, user_back_name, page_modify_date, page_create_date, page_status 
				from sk_user_back, sk_page order by page_id desc");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/page/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/page/bottom_page');
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
				$this->load->view('back/page/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/page/bottom_page');
			}
		}
	
		function add(){
			$this->form_validation->set_rules('title','title','trim|required|max_length[150]');
			$this->form_validation->set_rules('short','short description','trim|required|max_length[225]');
			$this->form_validation->set_rules('desc','description','trim|required');
			
			if($this->form_validation->run() == false){
				$this->add_form();
			}else{
	
				$data['page_id'] = $this->sk_model->getMaxKode('sk_page', 'page_id', 'PGE');
				$data['page_title'] = $this->input->post('title');
				$data['page_short'] = $this->input->post('short');
				$data['page_desc'] = $this->input->post('desc');
				$data['page_create_date'] = date("Y-m-d H:i:s");
				
				if($this->input->post('status') != 1){
					$status = 0;
				}else{
					$status = 1;
				}
				$data['page_status'] = $status;
		
				$add_data = $this->sk_model->insert_data('sk_page', $data);
				
				if(!$add_data){
					$this->session->set_flashdata('page_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/page/');
				}else{
					$this->session->set_flashdata('page_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/page/');
				}
			}
		}
		
		function edit_form($id){
			$id = $this->uri->segment(4);
			$page_read = $this->db->query("select * from sk_page where page_id='".$id."'");
			foreach($page_read->result() as $db){
				$data['id'] = $db->page_id;
				$data['title'] = $db->page_title;
				$data['short'] = $db->page_short;
				$data['desc'] = $db->page_desc;
				$data['status'] = $db->page_status;
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
			$this->load->view('back/page/edit_form',$data);
			$this->load->view('back/global/footer');
			$this->load->view('back/page/bottom_page');
		}
		
		function edit($id){
			$this->form_validation->set_rules('title','title','trim|required|max_length[150]');
			$this->form_validation->set_rules('short','short description','trim|required|max_length[225]');
			$this->form_validation->set_rules('desc','description','trim|required');
		
			if($this->form_validation->run() == false){
				$this->edit_form($this->uri->segment(4));
			}else{
				$id = $this->uri->segment(4);
				$data['page_title'] = $this->input->post('title');
				$data['page_short'] = $this->input->post('short');
				$data['page_desc'] = $this->input->post('desc');
				$data['page_modify_date'] = date("Y-m-d H:i:s");
				
				if($this->input->post('status') != 1){
					$status = 0;
				}else{
					$status = 1;
				}
				$data['page_status'] = $status;
		
				$add_data = $this->sk_model->update_data('sk_page', 'page_id', $id, $data);
				
				if(!$add_data){
					$this->session->set_flashdata('page_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/page/');
				}else{
					$this->session->set_flashdata('page_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/page/');
				}	
			}
		}
		
		function delete($id){
			$id = $this->uri->segment(4);
			
			$delete = $this->db->query("delete from sk_page where page_id='".$id."'");
			if(!$delete){
				$this->session->set_flashdata('page_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/page/');
			}else{
				$this->session->set_flashdata('page_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/page/');
			}
		}
		
	}
/*end of file tag.php*/
/*Location:.application/controllers/back/tag.php*/