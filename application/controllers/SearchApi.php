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

	 public function get_by_ps_name_filter()
	 {
		 $filter=$this->input->get();
		 $data=$this->Globalmodel-> getdata_by_field_array('*','pstation',array(),'ps_id', 'asc');
		 print_r($data);
	 }

	

	public function get_all_files()
	{
		$dir_name = "uploadfiles/";		
		$images = glob($dir_name."*.JPG");				
		$imgarr=array();
		$i=0;
		foreach($images as $image) 
		{
			$imgarr[$i++]=base_url().$image;			
		}	
		print_r(json_encode($imgarr));	
	}

	public function img_upload()
	{
		$this->load->view('img_upload.php');
	}


}
