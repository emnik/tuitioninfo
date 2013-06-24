<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tutor_sections_model extends CI_Model
{
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }    
    
	function get_tutor_sections_summary($member_id) {

		$this->db
				->select(array('section.section', 'class.class_name', 'count(section.lesson_id) AS lessons_num'))
				->from('section')
				->join('class', 'section.class_id = class.id')
				->join('lesson_tutor', 'lesson_tutor.id = section.tutor_id')
				->join('employee','lesson_tutor.employee_id = employee.id')
				->join('lookup', 'section.schoolyear = lookup.value_1')
				->where('lookup.id','2')
				->where('employee_id', $member_id)
				->group_by('section.section')
				->group_by('class.class_name')
				->order_by('class.class_name','ASC')
				->order_by('section.section','ASC');
	
		
				
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$tutor_sections_summary_data[] = $row;
			}
			return $tutor_sections_summary_data;
		}
		else {
			return false;
		}
	} 


	function get_tutor_sections($member_id) {

		$this->db
				->select('section.id')
				->from('section')
				->join('class', 'section.class_id = class.id')
				->join('lesson_tutor', 'lesson_tutor.id = section.tutor_id')
				->join('employee','lesson_tutor.employee_id = employee.id')
				->join('lookup', 'section.schoolyear = lookup.value_1')
				->where('lookup.id','2')
				->where('employee_id', $member_id)
				->order_by('class.class_name','ASC')
				->order_by('section.section','ASC');
	
		
				
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$tutor_sections_data[] = $row;
			}
			return $tutor_sections_data;
		}
		else {
			return false;
		}
	} 



	function get_tutor_sections_program($member_id, $section_id) {

		$this->db
				->select(array('section.id','section.section', 'catalog_lesson.title', 'section_program.day',
							    'section_program.start_tm', 'section_program.end_tm',
							    'classroom.classroom'))
				->from('section' )
				->join('class', 'section.class_id = class.id')
				->join('section_program', 'section.id = section_program.section_id','left')
				->join('classroom', 'section_program.classroom_id = classroom.id', 'left')
				->join('weekday', 'section_program.day=weekday.name','left')
				->join('lesson_tutor', 'section.tutor_id = lesson_tutor.id')
				->join('catalog_lesson', 'lesson_tutor.cataloglesson_id = catalog_lesson.id') 
				->join('employee', 'lesson_tutor.employee_id = employee.id')		
				->join('lookup', 'lookup.value_1 = section.schoolyear')
				->where('lookup.id','2')
				->where('employee.id', $member_id)
				->where('section.id', $section_id)
				->order_by('class.class_name','ASC')
				->order_by('section.section','ASC')
				->order_by('weekday`.`priority','ASC')
				->order_by('section_program.start_tm','ASC');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$tutor_sections_program[] = $row;
			}
			return $tutor_sections_program;
		}
		else {
			return false;
		}
	} 





	function get_tutor_section_students($section_id) {

		$this->db
				->select(array('section.id', 'registration.surname', 'registration.name'))
				->from('std_lesson' )
				->join('registration', 'std_lesson.reg_id = registration.id')
				->join('section', 'section.id = std_lesson.section_id')
				->join('lookup', 'lookup.value_1 = section.schoolyear')
				->where('lookup.id','2')
				->where('registration.del_lessons_dt is null', `null`)
				->where('section.id', $section_id)

				->order_by('registration.surname','ASC')
				->order_by('registration.name','ASC')
				->order_by('registration.id','ASC');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$tutor_section_students[] = $row;
			}
			return $tutor_section_students;
		}
		else {
			return false;
		}
	} 
	
}
