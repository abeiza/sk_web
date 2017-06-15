<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Sk_Model extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		public function validation_login($username, $password){
			$query_validasi_login = $this->db->query("select * from sk_user_back where user_back_username='".$username."' and user_back_password='".$password."'");
			return $query_validasi_login;
		}
		
		public function insert_data($table, $data){
			//$this->load->database('default',FALSE,TRUE);
			return $this->db->insert($table,$data);
		}
		
		function update_data($table, $pk, $id, $data){
			//$this->load->database('default',FALSE,TRUE);
			$this->db->where($pk,$id);
			return $this->db->update($table,$data);
		}
		
		function getMaxKode($table, $pk, $kode)
		{
			$q = $this->db->query("select MAX(RIGHT(".$pk.",5)) as kd_max from ".$table."");
			$kd = "";
			if($q->num_rows()>0)
			{
				foreach($q->result() as $k)
				{
					$tmp = ((int)$k->kd_max)+1;
					$kd = sprintf("%05s", $tmp);
				}
			}
			else
			{
				$kd = "00001";
			}	
			return $kode.$kd;
		}
		
		function getMaxKodelong($table, $pk, $kode)
		{
			$q = $this->db->query("select MAX(RIGHT(".$pk.",13)) as kd_max from ".$table."");
			$kd = "";
			if($q->num_rows()>0)
			{
				foreach($q->result() as $k)
				{
					$tmp = ((int)$k->kd_max)+1;
					$kd = sprintf("%013s", $tmp);
				}
			}
			else
			{
				$kd = "0000000000001";
			}	
			return $kode.$kd;
		}
		
		function getMaxKodemiddle($table, $pk, $kode)
		{
			$q = $this->db->query("select MAX(RIGHT(".$pk.",11)) as kd_max from ".$table."");
			$kd = "";
			if($q->num_rows()>0)
			{
				foreach($q->result() as $k)
				{
					$tmp = ((int)$k->kd_max)+1;
					$kd = sprintf("%011s", $tmp);
				}
			}
			else
			{
				$kd = "00000000001";
			}	
			return $kode.$kd;
		}
	}

/*End of file sg_model.php*/
/*Location:.application/model/sg_model.php*/