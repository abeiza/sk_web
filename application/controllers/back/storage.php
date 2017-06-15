<?php 
	if(!defined('BASEPATH'))exit("No direct script access allowed");
	
	class Storage extends CI_Controller{
		public function __construct()
		{
		    parent::__construct();
		    date_default_timezone_set('Asia/Jakarta');
		}
		     
		public function index()
		{
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
    			$this->load->view('back/storage/list');
    			$this->load->view('back/global/footer');
    			$this->load->view('back/storage/bottom_storage');
			}else{
			    $this->load->view('back/global/top');
				$this->load->view('back/login/login');
				$this->load->view('back/global/bottom');
			}
		}
		     
		public function elfinder()
		{
		    require_once './assets/elfinder/php/elFinderConnector.class.php';
		    require_once './assets/elfinder/php/elFinder.class.php';
		    require_once './assets/elfinder/php/elFinderVolumeDriver.class.php';
		    require_once './assets/elfinder/php/elFinderVolumeLocalFileSystem.class.php';
		     
		    $conn = new elFinderConnector(new elFinder(array(
		        'roots'=>array(
		            array(
		                'driver'=>'LocalFileSystem',
		                'path'=>'./uploads/',
		                'URL'=>base_url('uploads').'/',
		            )
		        )
		    )));
		    $conn->run();
		}
	}