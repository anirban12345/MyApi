<?php
class Mailmodel extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
    }
	
	public function get_all_mail($array)
	{
		$this->db->select('*');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');		
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');
		$this->db->where($array);
		$this->db->order_by('mt_date','desc');
		$this->db->order_by('mt_priority','asc');					 									
		$this->query=$this->db->get();		
		return $this->query->result();  
	}

	public function get_current_month_mail($array)
	{
		$this->db->select('*');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');		
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');	
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');	
		$this->db->where($array);	
		$this->db->order_by('mt_date','desc');					
		$this->db->order_by('mt_priority','asc');					
		$this->query=$this->db->get();		
		return $this->query->result();  
	}

	public function get_all_mail_between_date($date1,$date2)
	{
		$this->db->select('*');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');				
		$this->db->where('mt_date>=',$date1);									
		$this->db->where('mt_date<=',$date2);
		$this->db->order_by('mt_date','desc');
		$this->db->order_by('mt_priority','asc');					 																																		
		$this->query=$this->db->get();		
		return $this->query->result();  
	}

	public function get_all_mail_between_date_condition($date1,$date2,$array)
	{
		$this->db->select('*');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');	
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');			
		$this->db->where('mt_date>=',$date1);									
		$this->db->where('mt_date<=',$date2);
		$this->db->where($array);
		$this->db->order_by('mt_date','desc');
		$this->db->order_by('mt_priority','asc');					 		
		$this->query=$this->db->get();		
		return $this->query->result();  
	}

	public function get_complain_comments($array)
	{
		$this->db->select('*');		
		$this->db->from('complain_comments');
		$this->db->join('mail_tracking','complain_comments.cc_mt_id=mail_tracking.mt_id');
		$this->db->join('users','complain_comments.cc_userid=users.u_id');
		$this->db->where($array);
		$this->db->order_by('cc_id','desc');		
		$this->query=$this->db->get();		
		return $this->query->result();  
	}

	// For Column Chart
	public function get_all_complain_status($array)
	{
		
		$this->db->select('MONTH(mt_date) as mt_date,YEAR(mt_date) as year,count(mt_date) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');	
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');	
		$this->db->where($array);
		$this->db->group_by('YEAR(mt_date),MONTH(mt_date)');				
		$this->db->order_by('YEAR(mt_date),MONTH(mt_date)');				
		$this->query=$this->db->get();
		return $this->query->result();  
	}
	public function get_all_dipsosed_status($array)
	{
		
		$this->db->select('MONTH(mt_date) as mt_date,YEAR(mt_date) as year,mt_disposed,count(mt_disposed) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');	
		$this->db->where($array);
		$this->db->group_by('YEAR(mt_date),MONTH(mt_date),mt_disposed');	
		$this->db->order_by('YEAR(mt_date),MONTH(mt_date)');				
		$this->db->having('mt_disposed', 'Yes');
		$this->query=$this->db->get();		
		return $this->query->result();  
	}
	public function get_all_pending_status($array)
	{
		
		$this->db->select('MONTH(mt_date) as mt_date,YEAR(mt_date) as year,mt_disposed,count(mt_disposed) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');						
		$this->db->where($array);
		$this->db->group_by('YEAR(mt_date),MONTH(mt_date),mt_disposed');	
		$this->db->order_by('YEAR(mt_date),MONTH(mt_date)');				
		$this->db->having('mt_disposed', 'No');
		$this->query=$this->db->get();		
		return $this->query->result();  
	}

	public function get_all_dipsose_pending_status($array)
	{
		
		$this->db->select('mt_disposed,count(mt_disposed) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');	
		$this->db->where($array);
		$this->db->group_by('mt_disposed');	
		$this->db->order_by('mt_disposed','desc'); 	
		$this->query=$this->db->get();		
		return $this->query->result();  
	}

	public function get_all_complain_nature($array)
	{
		
		$this->db->select('cn_name,count(cn_name) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');	
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');							
		$this->db->where($array);
		$this->db->group_by('cn_name');			
		$this->query=$this->db->get();		
		return $this->query->result();  
	}
	// For Column Chart

	//current month
	public function get_current_month_complain_nature($array)
	{
		
		$this->db->select('MONTH(mt_date) as mt_date ,YEAR(mt_date) as year, cn_name,count(cn_name) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');
		$this->db->where($array);
		$this->db->group_by('MONTH(mt_date),YEAR(mt_date),cn_name');			
		$this->query=$this->db->get();		
		return $this->query->result();  
	}
	public function get_current_month_dipsose_pending_status($array)
	{
		
		$this->db->select('MONTH(mt_date) as mt_date ,YEAR(mt_date) as year,mt_disposed,count(mt_disposed) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');		
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');		
		$this->db->where($array);
		$this->db->group_by('MONTH(mt_date),YEAR(mt_date),mt_disposed');			
		$this->query=$this->db->get();		
		return $this->query->result();  
	}
	//current month


	//duty officer report 
	public function get_all_complain_duty_officer($array)
	{
		
		$this->db->select('u_title,do_name,count(do_name) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');		
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');
		$this->db->where($array);		
		$this->db->group_by('mt_do_id,u_title');		
		$this->db->order_by('do_name');			
		$this->query=$this->db->get();		
		return $this->query->result();  	
	}

	public function get_all_disposed_duty_officer($array)
	{
		
		$this->db->select('do_name,mt_disposed,count(mt_disposed) as c_d');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');		
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');
		$this->db->where($array);
		$this->db->group_by('do_name,mt_disposed');
		$this->db->having('mt_disposed','Yes');			
		//$this->db->order_by('do_name');			
		$this->query=$this->db->get();		
		return $this->query->result();  	
	}
	public function get_all_pending_duty_officer($array)
	{
		
		$this->db->select('do_name,mt_disposed,count(mt_disposed) as c_p');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');		
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');
		$this->db->where($array);
		$this->db->group_by('do_name,mt_disposed');
		$this->db->having('mt_disposed','No');			
		//$this->db->order_by('do_name');			
		$this->query=$this->db->get();		
		return $this->query->result();  	
	}
	//duty officer report 

	//complain by division
	public function get_complain_division($array)
	{
		$this->db->select('u_title,count(*) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');		
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');
		$this->db->where($array);
		$this->db->group_by('u_title');
		//$this->db->having('mt_disposed','No');			
		//$this->db->order_by('do_name');			
		$this->query=$this->db->get();		
		return $this->query->result();  	
	}
	public function get_disposed_division($array)
	{
		$this->db->select('u_title,count(*) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');		
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');
		$this->db->where($array);
		$this->db->group_by('u_title,mt_disposed');
		$this->db->having('mt_disposed','Yes');			
		//$this->db->order_by('do_name');			
		$this->query=$this->db->get();		
		return $this->query->result();  	
	}
	public function get_pending_division($array)
	{
		$this->db->select('u_title,count(*) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');		
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');
		$this->db->where($array);
		$this->db->group_by('u_title,mt_disposed');
		$this->db->having('mt_disposed','No');			
		//$this->db->order_by('do_name');			
		$this->query=$this->db->get();		
		return $this->query->result();  	
	}
	//complain by division

	// For Calendar Chart
	public function get_all_complain_status_by_date($array)
	{
		
		$this->db->select('mt_date,count(mt_date) as c_c');		
		$this->db->from('mail_tracking');
		$this->db->join('duty_officer','mail_tracking.mt_do_id=duty_officer.do_id');
		$this->db->join('complain_nature','mail_tracking.mt_subject=complain_nature.cn_id');	
		$this->db->join('users','mail_tracking.mt_userid=users.u_id');	
		$this->db->where($array);
		$this->db->group_by('mt_date');	
		$this->db->order_by('mt_date','asc');					
		$this->query=$this->db->get();
		return $this->query->result();  
	}

}

?>