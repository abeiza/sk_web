<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Test extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function index(){
		    var_dump(date('c', strtotime('2017-06-02 16:08:17')));
		}
	}