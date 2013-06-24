<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin_sections_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
 

	function get_sections() {

		$this->db->select(array('section.section', 'class.class_name', 'count(section.lesson_id) AS lessons_num'));
		$this->db->from('section');
		$this->db->join('class', 'section.class_id = class.id');
		$this->db->join('lookup', 'section.schoolyear = lookup.value_1');
		$this->db->where('lookup.id','2');
		$this->db->group_by('section.section');
		$this->db->group_by('class.class_name');
		$this->db->order_by('class.class_name','ASC');
		$this->db->order_by('section.section','ASC');
	
		
				
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$sections_data[] = $row;
			}
			return $sections_data;
		}
		else {
			return false;
		}
	} 


	function get_sections_details() {

		$this->db->select(array('section.id','section.section', 'catalog_lesson.title', 'section_program.day',
							    'section_program.start_tm', 'section_program.end_tm',
							    'classroom.classroom', 'employee.surname', 'employee.name'));
		$this->db->from('section' );
		$this->db->join('class', 'section.class_id = class.id');
		$this->db->join('section_program', 'section.id = section_program.section_id','left');
		$this->db->join('classroom', 'section_program.classroom_id = classroom.id', 'left');
		$this->db->join('weekday', 'section_program.day=weekday.name','left');
		$this->db->join('lesson_tutor', 'section.tutor_id = lesson_tutor.id');
		$this->db->join('catalog_lesson', 'lesson_tutor.cataloglesson_id = catalog_lesson.id'); 
		$this->db->join('employee', 'lesson_tutor.employee_id = employee.id');		
		$this->db->join('lookup', 'lookup.value_1 = section.schoolyear');
		$this->db->where('lookup.id','2');
		$this->db->order_by('class.class_name','ASC');
		$this->db->order_by('section.section','ASC');
		$this->db->order_by('weekday`.`priority','ASC');
		$this->db->order_by('section_program.start_tm','ASC');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$sections_details[] = $row;
			}
			return $sections_details;
		}
		else {
			return false;
		}
	} 





	function get_section_students($section_id) {

		$this->db->select(array('section.id', 'registration.surname', 'registration.name', 'contact.home_tel', 'contact.std_mobile'));
		$this->db->from('std_lesson' );
		$this->db->join('registration', 'std_lesson.reg_id = registration.id');
		$this->db->join('contact' , 'registration.id = contact.reg_id');
		$this->db->join('section', 'section.id = std_lesson.section_id');
		$this->db->join('lookup', 'lookup.value_1 = section.schoolyear');
		$this->db->where('lookup.id','2');
		$this->db->where('section_id', $section_id);
		$this->db->order_by('registration.surname','ASC');
		$this->db->order_by('registration.name','ASC');
		$this->db->order_by('registration.id','ASC');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$section_students[] = $row;
			}
			return $section_students;
		}
		else {
			return false;
		}
	} 
	
}
