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
        date_default_timezone_set('Asia/Kolkata');
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
        if(!empty($_FILES)){ 
            // File upload configuration 
            //$uploadPath = '../../../home/ddsw/Anirban/document_scan/';
            $uploadPath = './uploadfiles/'; 
            $filename= $_FILES["userfile"]["name"];
			$file_ext = ".JPG";
            $config['file_name'] = time().'.'.$file_ext;
            $config['allowed_types']= 'gif|jpg|png';
            $config['upload_path'] = $uploadPath;             
            $this->load->library('upload', $config); 
            $this->upload->initialize($config); 
            
            if($this->upload->do_upload('userfile')){ 
                $fileData = $this->upload->data(); 
                //$uploadData['file_name'] = $fileData['file_name']; 
                //$uploadData['uploaded_on'] = date("Y-m-d H:i:s");    
				$data = $this->input->post();        
				$data['ps_image']=base_url().'uploadfiles/'.$fileData['file_name'];
                $data['ps_datetime']=date('Y-m-d H:i');
                $data['ps_flag']=1;
                $data['ps_ip']=$this->input->ip_address();;
				$this->Globalmodel->savedata('pstation',$data);
				//$this->response(['PS created successfully.'], REST_Controller::HTTP_OK);  
                $msg='PS created successfully.';
				print_r($msg);                
            }
            else
            {
                $error = $this->upload->display_errors();
				print_r($error);                                
            }                         
        }      
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



