<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Category extends CI_Controller{
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
				
				$list['get_category'] = $this->db->query("select  category_id, category_name, kanal_name, user_back_name, category_modify_date, category_status 
				from sk_kanal, sk_user_back, sk_category where sk_user_back.user_back_id = sk_kanal.kanal_posted_by and sk_category.kanal_id = sk_kanal.kanal_id order by category_id desc");
				
				$list['get_category_list'] = $this->db->query("select  category_id, category_name, kanal_name, user_back_name, category_modify_date, category_status 
				from sk_kanal, sk_user_back, sk_category where sk_user_back.user_back_id = sk_kanal.kanal_posted_by and sk_category.kanal_id = sk_kanal.kanal_id order by category_id desc limit 100");
				
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/category/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/category/bottom_category');
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
				
				$list['get_category'] = $this->db->query("select  category_id, category_name, kanal_name, user_back_name, category_modify_date, category_status 
				from sk_kanal, sk_user_back, sk_category where sk_kanal.kanal_id = '".$kanal."' and sk_user_back.user_back_id = sk_kanal.kanal_posted_by and sk_category.kanal_id = sk_kanal.kanal_id order by category_id desc");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/category/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/category/bottom_category');
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
				
				$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal where kanal_status = '1' order by kanal_name");
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/category/add_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/category/bottom_category');
			}
		}
	
		function add(){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$this->form_validation->set_rules('name','title','trim|required|max_length[150]');
				$this->form_validation->set_rules('kanal','kanal','required');
				
				if($this->form_validation->run() == false){
					$this->add_form();
				}else{
		
					$data['category_id'] = $this->sk_model->getMaxKode('sk_category', 'category_id', 'CTG');
					$data['kanal_id'] = $this->input->post('kanal');
					$data['category_name'] = $this->input->post('name');
					$data['category_desc'] = $this->input->post('desc');
					$data['category_modify_date'] = date("Y-m-d H:i:s");
					$data['category_posted_by'] = $this->session->userdata('id');
					
					if($this->input->post('status') != 1){
						$status = 0;
					}else{
						$status = 1;
					}
					$data['category_status'] = $status;
			
					$add_data = $this->sk_model->insert_data('sk_category', $data);
					
					if(!$add_data){
						$this->session->set_flashdata('category_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/category/');
					}else{
						$this->session->set_flashdata('category_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Insert data was successfully!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/category/');
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
				$category_read = $this->db->query("select * from sk_category where category_id='".$id."'");
				foreach($category_read->result() as $db){
					$data['id'] = $db->category_id;
					$data['kanal'] = $db->kanal_id;
					$data['name'] = $db->category_name;
					$data['desc'] = $db->category_desc;
					$data['status'] = $db->category_status;
				}
				
				$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
				foreach($query1->result() as $sess){
					$data['id'] = $sess->profile_back_id;
					$data['full'] = $sess->profile_back_name_full;
					$data['nick'] = $sess->profile_back_nick;
					$data['pict'] = $sess->profile_back_pict;
					$data['email'] = $sess->profile_back_email;
				}
				
				$data['get_kanal'] = $this->db->query("select kanal_id, kanal_name from sk_kanal where kanal_status = '1' order by kanal_name");
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/category/edit_form',$data);
				$this->load->view('back/global/footer');
				$this->load->view('back/category/bottom_category');
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
				$this->form_validation->set_rules('kanal','kanal','required');
				
				if($this->form_validation->run() == false){
					$this->edit_form($this->uri->segment(4));
				}else{
					$id = $this->uri->segment(4);
					$data['kanal_id'] = $this->input->post('kanal');
					$data['category_name'] = $this->input->post('name');
					$data['category_desc'] = $this->input->post('desc');
					$data['category_modify_date'] = date("Y-m-d H:i:s");
					$data['category_posted_by'] = $this->session->userdata('id');
					
					if($this->input->post('status') != 1){
						$status = 0;
					}else{
						$status = 1;
					}
					$data['category_status'] = $status;
			
					$add_data = $this->sk_model->update_data('sk_category', 'category_id', $id, $data);
					
					if(!$add_data){
						$this->session->set_flashdata('category_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/category/');
					}else{
						$this->session->set_flashdata('category_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Update data was successfully!</span></div></div>");
						Header('Location:'.base_url().'index.php/back/category/');
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
				
				$delete = $this->db->query("delete from sk_category where category_id='".$id."'");
				if(!$delete){
					$this->session->set_flashdata('category_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/category/');
				}else{
					$this->session->set_flashdata('category_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
					Header('Location:'.base_url().'index.php/back/category/');
				}
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
	}
/*end of file Category_Side.php*/
/*Location:.application/controllers/back/Category_Side.php*/