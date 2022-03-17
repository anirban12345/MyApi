<?php
class Sectionmodel extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
    }
	
	public function get_complain_division_section($array,$orderfield,$order)
	{
		$this->db->select('d1.*');
		$this->db->from('divisions d1');				
		$this->db->join('divisions d2','d1.d_id=d2.d_parent_id');				
		$this->db->where($array);
		$this->db->order_by($orderfield,$order);				
		$this->query=$this->db->get();		
		return $this->query->result();  
	}
}

?>