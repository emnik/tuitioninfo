<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin_home_model extends CI_Model
{
    function __construct() 
    {
          parent::__construct();
    }
 

	public function get_users()
	{
		
		$q = $this
			->db
			->select(array('user.id', 'user.surname', 'user.name', 'user.username', 'user.group_id', 'group.name as groupname', 'user.expires'))
			->from('user')
			->join('group', 'user.group_id = group.id')
			->get();
		
		if ($q->num_rows() > 0)
		{
			foreach ($q->result_array() as $row)
			{
					$users_data[] = $row;
			}
			return $users_data; 
		}
		else
		{
			return false;
		}
	} 	


	function get_user($user_id)
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
	

	public function get_members($user_id, $group_id)
	{
		
		$this->db->select(array('surname', 'name'));
		$this->db->from('member');
		
		switch ($group_id)
		{
			case '2': //parent
			case '4': //or student
				$this->db->join('registration', 'member.property_id = registration.id');
				break;
			case '3': //tutor
				$this->db->join('employee', 'member.property_id = employee.id');
		}
			
		$this->db->where('user_id', $user_id);
		
		$q = $this->db->get();
		
		if ($q->num_rows() > 0)
		{
			foreach ($q->result_array() as $row)
			{
					$members_data[] = $row;
			}
			return $members_data; 
		}
		else
		{
			return false;
		}
	} 	


	public function get_groups()
	{
		
		$q = $this
			->db
			->select(array('group.id','group.name'))
			->order_by('group.name')
			->get('group');
		
		if ($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
					$groups_data[$row->id] = $row->name;
			}
			return $groups_data; 
		}
		else
		{
			return false;
		}
	} 	
	
	
	function get_members_dropdown_data($group_id, $surname=null, $name=null)
	{

		$this->load->model('admin/admin_students_model');
		$min_reg_id = $this->admin_students_model->get_min_schoolyear_reg_id();
	
		switch ($group_id)
		
		{
			case '3': //tutor
				$this->db->select(array('employee.id','employee.surname', 'employee.name'));
				$this->db->from('employee');
			
				if (empty($surname)==false){
				$this->db->where('employee.surname', $surname);}
			
				if (empty($name)==false){
				$this->db->where('employee.name', $name);}
				
				$this->db->where('employee.active', '1');
				$this->db->where('employee.is_tutor', '1');
				$this->db->order_by('employee.surname', 'ASC');
				break;

			case '4': //student
				$this->db->select(array('registration.id','registration.surname', 'registration.name'));
				$this->db->from('registration');
				if ($min_reg_id != false){
				$this->db->where('id >=', $min_reg_id);}
			
				if (empty($surname)==false){
				$this->db->where('registration.surname', $surname);}
			
				if (empty($name)==false){
				$this->db->where('registration.name', $name);}
		
				$this->db->order_by('registration.surname');
				$this->db->order_by('registration.name');
				break;
			
			case '2': //parent
				$this->db->select(array('registration.id','registration.surname', 'registration.name'));
				$this->db->from('registration');
				if ($min_reg_id != false){
				$this->db->where('id >=', $min_reg_id);}
			
				$parent = mb_substr($surname, 0, -2);
				$this->db->like('registration.surname', $parent, 'after');
				
			
				if (empty($name)==false){
					$this->db->bracket('open');
					$this->db->where('registration.fathers_name', $name);
					$this->db->or_where('registration.mothers_name', $name);
					$this->db->bracket('close');
				}
				$this->db->order_by('registration.surname');
		}
		

		$q = $this->db->get();
		
		if ($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
					$members_data[$row->id] = $row->surname.' '.$row->name;
			}
			return $members_data; 
		}
		else
		{
			return false;
		}
	} 	


	public function add_user_members($data)
	{
		//previously sha1
		//$this->load->helper('security');
		//$user_password = do_hash($data['password'], true);
		
		//currently pbkdf2
		$this->load->helper('pbkdf2_helper');
		$user_password = create_hash($data['password']);

		$insert_user_data = array(
							'id' => NULL,
							'surname' => $data['surname'],
							'name' => $data['name'],
							'username' => $data['username'],
							'password' => $user_password,
							'group_id' => $data['group_id'],
							'created' => NULL,
							'expires' => $data['expires']
							);
		
		$this->db->insert('user', $insert_user_data);
		$user_id = $this->db->insert_id();
		$members = $data['members'];
		
		if(is_array($members))
		{
			foreach($members as $member)
			{
				$insert_member_data_arrays = array(
								'id' => NULL,
								'user_id' => $user_id,
								'property_id' => $member
								);
				$insert_member_data[] = $insert_member_data_arrays;
			}
			if($this->db->insert_batch('member', $insert_member_data))
			{
				return true;
			}
			else 
			{
				return false;
			}
		}
		
		else
		
		{
			$insert_member_data = array(
								'id' => NULL,
								'user_id' => $user_id,
								'property_id' => $members
								);
			if($this->db->insert('member', $insert_member_data))
			{
				return true;
			}
			
			else 
			
			{
				return false;
			}
		}
					
	} 	

	public function del_webuser($user_id)
	{
		$this->db->delete('user', array('id' => $user_id)); 
	}
	
	
	public function update_webuser($data)
	{
		$update_user_data = array();
		
		if(!empty($data['username']))
		{
			$update_user_data['username'] = $data['username'];
		}
		
		if(!empty($data['password']))
		{
			//previousle for sha1
			//$this->load->helper('security');
			//$user_password = do_hash($data['password'], true);
			
			//currently for pbkdf2
			$this->load->helper('pbkdf2_helper');
			$user_password = create_hash($data['password']);
			
			$update_user_data['password'] = $user_password;
		}
		
		if(!empty($data['expires']))
		{
			$update_user_data['expires'] = $data['expires'];
		}
		
		$this->db->where('id', $data['id']);
		
		if(!empty($update_user_data))
		{
			$this->db->update('user', $update_user_data);
			return true;
		}
		else
		{
			return false;
		}
	}
	
}
