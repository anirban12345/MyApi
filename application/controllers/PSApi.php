<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:*");
header("Access-Control-Allow-Headers:*");

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';


class PSApi extends REST_Controller  
{
    //var $permission = array();
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Mailmodel');
        $this->load->model('Sectionmodel');        
        //$this->permission=unserialize($this->session->userdata('userdtls')[0]->ug_permission);
    }

	public function index_get($id = 0)
	{   
        if(!empty($id))
        {
          $data=$this->Globalmodel-> getdata_by_field_array('*','pstation',array('ps_id'=>$id),'ps_name', 'asc');
        }
        else
        {
          $data=$this->Globalmodel-> getdata_by_field_array('*','pstation',array(),'ps_name', 'asc');
        }
        $this->response($data, REST_Controller::HTTP_OK);
	}
     
    public function index_post()
    {   
        $data = $this->input->post();        
        $this->Globalmodel->savedata('pstation',$data);
        $this->response(['PS created successfully.'], REST_Controller::HTTP_OK);        
    }

    public function index_put($id)
    {
        $data = $this->put();
        $this->Globalmodel->updatedata('pstation','ps_id',$id,$data);        
        $this->response(['PS updated successfully.'], REST_Controller::HTTP_OK);        
    }
  
    public function index_delete($id)
    {
        $this->Globalmodel->deletedata('pstation','ps_id',$id);
        $this->response(['PS deleted successfully.'], REST_Controller::HTTP_OK);
    }

    
}   



