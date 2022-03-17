<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:*");
header("Access-Control-Allow-Headers:*");
defined('BASEPATH') OR exit('No direct script access allowed');

class SearchApi extends CI_Controller 
{
	 //var $permission = array();
	 public function __construct()
	 {
		 parent::__construct();
		 $this->load->model('Mailmodel');
		 $this->load->model('Sectionmodel');        
		 //$this->permission=unserialize($this->session->userdata('userdtls')[0]->ug_permission);
	 }

	 public function get_by_ps_name($ps_name)
	 {   
		 if(!empty($ps_name))
		 {
		   $data=$this->Globalmodel-> getdata_by_field_array('*','pstation',array('ps_name like'=>$ps_name.'%'),'ps_id', 'asc');
		 }        		 
		 print_r(json_encode($data));
	 }
}
