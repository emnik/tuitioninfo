<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_tutors_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
 

	function get_tutors() {

		$this->db->from('employee' );
		$this->db->where('is_tutor','1');
		$this->db->where('active','1');
		$this->db->order_by('surname','ASC');
		$this->db->order_by('name','ASC');
		$this->db->order_by('id','ASC');
				
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


	function get_tutors_program() {

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
		$this->db->where('is_tutor','1');
		$this->db->order_by('employee.surname','ASC');
		$this->db->order_by('employee.name','ASC');
		$this->db->order_by('employee.id','ASC');
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


	function get_tutors_weekly_hours() {

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
		$this->db->where('is_tutor','1');
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
	
}
