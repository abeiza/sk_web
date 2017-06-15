<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_Google extends CI_Model{
	function __construct() {
		$this->tableName = 'users';
		$this->primaryKey = 'id';
		
		$this->tableName_internal_1 = 'sk_guest';
        $this->primaryKey_internal_1 = 'ObjectID';
        
        $this->tableName_internal_2 = 'sk_guest_profile';
        $this->primaryKey_internal_2 = 'ObjectID';
	}
	public function checkUser($data = array()){
		$this->db->select($this->primaryKey);
		$this->db->from($this->tableName);
		$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
		
		if($prevCheck > 0){
			$prevResult = $prevQuery->row_array();
			$data['modified'] = date("Y-m-d H:i:s");
			$update = $this->db->update($this->tableName,$data,array('id'=>$prevResult['id']));
			$userID = $prevResult['id'];
		}else{
			$data['created'] = date("Y-m-d H:i:s");
			$data['modified'] = date("Y-m-d H:i:s");
			$insert = $this->db->insert($this->tableName,$data);
			$userID = $this->db->insert_id();
		}

		return $userID?$userID:FALSE;
    }
    
    public function checkUser_internal($data_int = array(), $photo){
        $this->db->select($this->primaryKey_internal_1);
        $this->db->from($this->tableName_internal_1);
        $this->db->where(array('oauth_provider'=>$data_int['oauth_provider'],'oauth_uid'=>$data_int['oauth_uid']));
        $prevQuery1 = $this->db->get();
        $prevCheck1 = $prevQuery1->num_rows();
        
        if($prevCheck1 > 0){
            $prevResult1 = $prevQuery1->row_array();
            
            $data_b['guest_profile_name'] = $data_int['guest_name'];
            $data_b['guest_profile_email'] = $data_int['guest_email'];
            $data_b['guest_profile_pict'] = $photo;
            
            $update_int_1 = $this->db->update($this->tableName_internal_1,$data_int,array('ObjectID'=>$prevResult1['ObjectID']));
            $update_int_2 = $this->db->update($this->tableName_internal_2,$data_b,array('ObjectID'=>$prevResult1['ObjectID']));
        }else{
            $data_int['guest_id'] = $this->sk_model->getMaxKodemiddle('sk_guest', 'guest_id', 'GST');
            $data_int['guest_profile_id'] = $this->sk_model->getMaxKodemiddle('sk_guest', 'guest_profile_id', 'GPF');
            
            $data_b['guest_profile_id'] = $data_int['guest_profile_id'];
            $data_b['guest_profile_name'] = $data_int['guest_name'];
            $data_b['guest_profile_email'] = $data_int['guest_email'];
            $data_b['guest_profile_pict'] = $photo;
            
            $insert_int_1 = $this->db->insert($this->tableName_internal_1,$data_int);
            $insert_int_2 = $this->db->insert($this->tableName_internal_2,$data_b);
        }
        
        $query_validation = $this->db->query("select * from sk_guest where oauth_provider = 'google' and oauth_uid = '".$data_int['oauth_uid']."' and guest_status=1");
		foreach($query_validation->result() as $db){
			$sess['loginsuccess'] = 'success';
			$sess['user_id'] = $db->guest_id;
			$sess['user_profile_id'] = $db->guest_profile_id;
			$sess['user_name'] = $db->guest_name;
			$this->session->set_userdata($sess);
			
			date_default_timezone_set('Asia/Jakarta');
			$data['guest_log_date'] = date("Y-m-d H:i:s");
			$this->sk_model->update_data('sk_guest', 'guest_id', $db->guest_id, $data);
		}
    }
}
