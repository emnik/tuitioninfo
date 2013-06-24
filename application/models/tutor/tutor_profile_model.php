<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tutor_profile_model extends CI_Model
{
	
   function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function get_tutor_member_id($user_id)
	{
		$q= $this
			->db
			->select('member.property_id')
			->from('member')
			->join('user', 'user.id = member.user_id')
			->where('user.id', $user_id)
			->limit(1)
			->get();
			
		if ($q->num_rows > 0)
		{
			return $q->row();
		}
		return false;
	}
	

	function get_tutor_profile($member_id) 
	{
		$this->db->select(array('employee.surname' , 'employee.name', 'speciality', 'employee.mobile', 'employee.home_tel'));
		$this->db->from('employee');
		$this->db->where('employee.id',$member_id);
				
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$tutor_profile[] = $row;
			}
			return $tutor_profile;
		}
		else 
		{
			return false;
		}
	} 
	
	
		function get_tutor_weekly_hours($member_id) {

		$this->db->select(array('employee.id', 'SUM(`section_program`.`duration`) AS `weekly hours`'));
		$this->db->from('section_program' );
		$this->db->join('classroom', 'section_program.classroom_id = classroom.id', 'left');
		$this->db->join('weekday', 'section_program.day=weekday.name','left');
		$this->db->join('section', 'section_program.section_id = section.id');
		$this->db->join('lesson_tutor', 'section.tutor_id = lesson_tutor.id');
		$this->db->join('employee', 'lesson_tutor.employee_id = employee.id');
		$this->db->join('catalog_lesson', 'lesson_tutor.cataloglesson_id = catalog_lesson.id'); 
		$this->db->join('lookup', 'lookup.value_1 = section.schoolyear');
		$this->db->where('lookup.id','2');
		$this->db->where('employee.active','1');
		$this->db->where('employee.id', $member_id);
		$this->db->group_by('employee.id');
		$this->db->order_by('employee.surname','ASC');
		$this->db->order_by('employee.name','ASC');
		$this->db->order_by('employee.id','ASC');
		
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$tutors_weekly_hours[] = $row;
			}
			return $tutors_weekly_hours;
		}
		else {
			return false;
		}
	} 
	
	
		function get_tutor_program($member_id) {

		$this->db->select(array('employee.id', 'employee.nickname', 'section_program.day', 'weekday.priority',
							    'section_program.start_tm', 'section_program.end_tm',
							    'section.section', 'catalog_lesson.title', 'classroom.classroom',
							    'section_program.section_id'));
		$this->db->from('section_program' );
		$this->db->join('classroom', 'section_program.classroom_id = classroom.id', 'left');
		$this->db->join('weekday', 'section_program.day=weekday.name','left');
		$this->db->join('section', 'section_program.section_id = section.id');
		$this->db->join('lesson_tutor', 'section.tutor_id = lesson_tutor.id');
		$this->db->join('employee', 'lesson_tutor.employee_id = employee.id');
		$this->db->join('catalog_lesson', 'lesson_tutor.cataloglesson_id = catalog_lesson.id'); 
		$this->db->join('lookup', 'lookup.value_1 = section.schoolyear');
		$this->db->where('lookup.id','2');
		$this->db->where('employee.active','1');
		$this->db->where('employee.id', $member_id);
		$this->db->order_by('weekday.priority','ASC');
		$this->db->order_by('section_program.start_tm','ASC');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$tutors_data[] = $row;
			}
			return $tutors_data;
		}
		else {
			return false;
		}
	} 
	
	
	function get_tutor_program_basics($member_id)
	{
		$this->db
				->select(array('employee.id', 'section_program.day', 'weekday.priority', 
								'MIN(section_program.start_tm) AS start_day_tm', 
								'MAX(section_program.end_tm) AS end_day_tm', 
								'SUM(section_program.duration) AS day_hours'))
				->from('section_program')
				->join('weekday', 'section_program.day = weekday.name', 'left')
				->join('classroom', 'section_program.classroom_id = classroom.id', 'left')
				->join('section', 'section_program.section_id = section.id')
				->join('lesson_tutor', 'section.tutor_id = lesson_tutor.id')
				->join('employee', 'lesson_tutor.employee_id = employee.id')
				->join('catalog_lesson', 'lesson_tutor.cataloglesson_id = catalog_lesson.id')
				->join('lookup', 'lookup.value_1 = section.schoolyear')
				->where('lookup.id', '2')
				->where('employee.id', $member_id)
				->group_by('employee.id')
				->group_by('section_program.day')
				->order_by('weekday.priority', 'ASC')
				->order_by('start_day_tm', 'ASC');
	}
	
	
}
