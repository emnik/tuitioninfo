<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Guardian_profile_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


	function get_guardian_user_details($user_id)
	{
		$q= $this
			->db
			->select(array('user.surname','user.name'))
			->from('user')
			->where('user.id', $user_id)
			->limit(1)
			->get();
			
		if ($q->num_rows > 0)
		{
			return $q->row_array();
		}
		return false;
	}



	function get_reg_ids($user_id)
	//property_id now is reg_id
	{
		$q= $this
			->db
			->select('member.property_id')
			->from('member')
			->join('user', 'user.id = member.user_id')
			->where('user.id', $user_id)
			->get();
			
		if ($q->num_rows > 0)
		{
			/*return $q;*/
			foreach ($q->result_array() as $row)
			{
				$reg_ids[] = $row['property_id'];
			}
			return $reg_ids;
		}
		return false;
	}
	

	function get_guardian_profile($reg_id)
	//if multiple reg_ids we need just one of them as all will result the same data!
	{
		$this->db->select(array('registration.fathers_name' , 'registration.mothers_name', 'registration.address', 'contact.fathers_mobile', 'contact.mothers_mobile', 'contact.home_tel', 'contact.work_tel'));
		$this->db->from('registration');
		$this->db->join('contact','registration.id=contact.reg_id', 'left');
		$this->db->where('registration.id',$reg_id);
				
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$guardian_profile[] = $row;
			}
			return $guardian_profile;
		}
		else 
		{
			return false;
		}
	} 
	
	
		function get_guardian_member_profile($member_id) 
	{
		$this->db->select(array('registration.surname' , 'registration.name'));
		$this->db->from('registration');
		$this->db->where('registration.id',$member_id);
		$this->db->limit(1);
				
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			return $query->row_array();
		}
		else 
		{
			return false;
		}
	} 
	
	
	
	
}
