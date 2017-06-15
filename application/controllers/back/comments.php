<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Comments extends CI_Controller{
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
				
				
				$list['get_post'] = $this->db->query("select sk_post.post_id, comment_post_date, post_title, user_back_name, post_modify_date, post_shrt_desc, category_name, kanal_name, flag_name, post_posted_by, post_status, count(comment_id) as Co from sk_kanal, sk_post, sk_category, sk_user_back, sk_flag_post, sk_comment where sk_kanal.kanal_id = sk_category.kanal_id and sk_comment.post_id = sk_post.post_id and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.flag_id = sk_flag_post.flag_id and sk_post.category_id = sk_category.category_id group by post_id, post_title, post_title, post_shrt_desc, category_name, flag_name, post_posted_by, post_status order by count(comment_id) desc");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/comments/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/comments/bottom_comments');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function list_by(){
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
				
				
				$list['get_post'] = $this->db->query("select sk_post.post_id, comment_post_date, post_title, user_back_name, post_modify_date, post_shrt_desc, category_name, kanal_name, flag_name, post_posted_by, post_status, count(comment_id) as Co from sk_kanal, sk_post, sk_category, sk_user_back, sk_flag_post, sk_comment where sk_kanal.kanal_id = sk_category.kanal_id and sk_comment.post_id = sk_post.post_id and sk_user_back.user_back_id = sk_post.post_posted_by and sk_post.flag_id = sk_flag_post.flag_id and sk_post.category_id = sk_category.category_id and sk_kanal.kanal_id = '".$kanal."' group by post_id, post_title, post_title, post_shrt_desc, category_name, flag_name, post_posted_by, post_status order by count(comment_id) desc");
				
				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/comments/list',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/comments/bottom_comments');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function list_comments($post){
			$cek = $this->session->userdata('login_session');
			if($cek){
				$post = $this->uri->segment(4);
				$query1 = $this->db->query("select * from sk_profile_back where user_back_id='".$this->session->userdata('id')."'");
				foreach($query1->result() as $sess){
					$data['id'] = $sess->profile_back_id;
					$data['full'] = $sess->profile_back_name_full;
					$data['nick'] = $sess->profile_back_nick;
					$data['pict'] = $sess->profile_back_pict;
					$data['email'] = $sess->profile_back_email;
				}
				
				$list['query_comment_post'] = $this->db->query("select sk_guest.guest_name, sk_comment.comment_flag, sk_guest_profile.guest_profile_pict, sk_comment.comment_id, sk_comment.comment_post_date, sk_comment.comment_text, sk_comment.comment_order, sk_comment.comment_ref_id, sk_comment.comment_id from sk_comment, sk_post, sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_id = '".$post."' order by sk_comment.comment_ref_id desc, sk_comment.comment_id");

				$this->load->view('back/global/top');
				$this->load->view('back/global/header',$data);
				$this->load->view('back/comments/list_comment',$list);
				$this->load->view('back/global/footer');
				$this->load->view('back/comments/bottom_comments');
			}else{
				$this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		
		function delete_comments($post, $cmd){
			$cmd = $this->uri->segment(5);
			$post = $this->uri->segment(4);
			
			$delete = $this->db->query("delete from sk_comment where comment_id='".$cmd."' or comment_ref_id='".$cmd."'");
			if(!$delete){
				$this->session->set_flashdata('comment_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Sorry, your entry was failed<br/><span style='font-size:11px;'>Please try again!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/comments/list_comments/'.$post.'/');
			}else{
				$this->session->set_flashdata('comment_result',"<div id='notif' style='z-index:999999999;width:100%;height:100%;display:flex;position:fixed;left:0;top:0;'><div style='font-size:14px;color:#fff;padding:10px 25px;margin:auto;border-radius:2px;background-color:rgb(50,50,50);'>Success<br/><span style='font-size:11px;'>Delete data was successfully!</span></div></div>");
				Header('Location:'.base_url().'index.php/back/comments/list_comments/'.$post.'/');
			}
		}
		
	}
/*end of file Comments.php*/
/*Location:.application/controllers/back/Posting.php*/