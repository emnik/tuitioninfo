<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin_program_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
 

	function get_program_basics() {

		$this->db->select(array('section_program.day' , 'MIN(section_program.start_tm) AS start', 'MAX(section_program.end_tm) AS end'));
		$this->db->from('section');
		$this->db->join('section_program', 'section.id =  section_program.section_id');
		$this->db->join('weekday', 'section_program.day = weekday.name', 'left'); 
		$this->db->join('lookup', 'section.schoolyear = lookup.value_1');
		$this->db->where('lookup.id','2');
		$this->db->group_by('section_program.day');
		$this->db->order_by('weekday.priority','ASC');
	
				
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$program_basics[] = $row;
			}
			return $program_basics;
		}
		else {
			return false;
		}
	} 


	function get_program_details() {

		$this->db->select(array('section.id', 'section_program.day', 'section_program.start_tm', 'section_program.end_tm', 'section_program.duration', 'catalog_lesson.title', 'section.section', 'employee.surname', 'employee.name', 'classroom.classroom'));
		$this->db->from('section' );
		$this->db->join('section_program', 'section.id = section_program.section_id');
		$this->db->join('lesson_tutor', 'section.tutor_id = lesson_tutor.id');
		$this->db->join('catalog_lesson', 'lesson_tutor.cataloglesson_id = catalog_lesson.id'); 
		$this->db->join('employee', 'lesson_tutor.employee_id = employee.id');		
		$this->db->join('classroom', 'section_program.classroom_id = classroom.id', 'left');
		$this->db->join('weekday', 'section_program.day=weekday.name','left');
		$this->db->join('lookup', 'lookup.value_1 = section.schoolyear');
		$this->db->where('lookup.id','2');
		$this->db->order_by('weekday`.`priority','ASC');
		$this->db->order_by('section_program.start_tm','ASC');
		$this->db->order_by('section_program.duration','ASC');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$program_details[] = $row;
			}
			return $program_details;
		}
		else {
			return false;
		}
	} 
	
}
