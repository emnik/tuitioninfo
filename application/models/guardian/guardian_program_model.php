<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Guardian_program_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


	function get_guardian_member_profile($reg_id) 
	{
		$this->db->select(array('registration.id', 'registration.surname' , 'registration.name',
								'class.class_name', 'course.course'));
		$this->db->from('registration');
		$this->db->join('class','registration.class_id=class.id');
		$this->db->join('course','registration.course_id=course.id');
		$this->db->where('registration.id',$reg_id);
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
	
	
	
	
	function get_guardian_member_program($reg_id) 
	{

		$this->db->select(array('registration.id', 'registration.surname',
								'registration.name', 'section_program.day',
								'weekday.priority', 'classroom.classroom',
								'section_program.start_tm', 'section_program.end_tm',
								'employee.nickname', 'catalog_lesson.title', 
								'std_lesson.section_id', 'section.section'));
		$this->db->from('registration, section_program');
		$this->db->join('class', 'registration.class_id = class.id');
		$this->db->join('classroom','section_program.classroom_id = classroom.id','left');
		$this->db->join('weekday','section_program.day = weekday.name','left');
		$this->db->join('std_lesson', 'std_lesson.reg_id = registration.id AND section_program.section_id = std_lesson.section_id'); 
		$this->db->join('section','std_lesson.section_id = section.id');
		$this->db->join('lesson_tutor','section.tutor_id = lesson_tutor.id');
		$this->db->join('employee','lesson_tutor.employee_id = employee.id');
		$this->db->join('catalog_lesson','lesson_tutor.cataloglesson_id = catalog_lesson.id');
		$this->db->where('registration.id',$reg_id);
		$this->db->order_by('weekday.priority');
		$this->db->order_by('start_tm', 'ASC');

		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$student_program[] = $row;
			}
			return $student_program;
		}
		else 
		{
			return false;
		}
	} 
	
	
}
