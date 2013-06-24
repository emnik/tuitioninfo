<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tutor_students_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

		function get_tutor_students($member_id) {
		
		//get min_red_id from the function in admin_students_model
		$this->load->model('admin/admin_students_model');
		$min_reg_id = $this->admin_students_model->get_min_schoolyear_reg_id();
		if ($min_reg_id==false)
		{
			return false;
		}
		
		$this->db
			 ->select(array('registration.id', 'registration.surname',  'registration.name', 'class.class_name',  'course.course',
			 			   'contact.std_mobile', 'contact.home_tel', 'registration.fathers_name', 
						   'contact.fathers_mobile', 'registration.mothers_name', 'contact.mothers_mobile'))
		 	 ->from('registration')
			 ->join('std_lesson', 'registration.id=std_lesson.reg_id')
			 ->join('section', 'std_lesson.section_id = section.id')
			 ->join('class', 'registration.class_id = class.id')
			 ->join('course', 'registration.course_id = course.id')
			 ->join('contact', 'registration.id = contact.reg_id')
			 ->join('lesson_tutor', 'lesson_tutor.id= std_lesson.tutor_id ')
			 ->join('employee', 'lesson_tutor.employee_id = employee.id')
			 ->where('employee.id', $member_id)
			 ->where('registration.id >=', $min_reg_id)
			 ->where('registration.del_lessons_dt is null', `null`)
			 ->group_by('registration.id')
			 ->order_by('registration.surname')
			 ->order_by('registration.name');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$tutor_students[] = $row;
			}
			return $tutor_students;
		}
		else {
			return false;
		}
	} 



		function get_tutor_students_details($member_id, $reg_id) 
		{
		
		$this->db
			 ->select(array('registration.id', 'registration.surname',  'registration.name',
			 'catalog_lesson.title', 'section.section'))
		 	 ->from('registration')
			 ->join('std_lesson', 'registration.id=std_lesson.reg_id')
			 ->join('section', 'std_lesson.section_id = section.id')
			 ->join('lesson_tutor', 'lesson_tutor.id= std_lesson.tutor_id')
			 ->join('catalog_lesson', 'lesson_tutor.cataloglesson_id = catalog_lesson.id')			 
			 ->join('employee', 'lesson_tutor.employee_id = employee.id')
			 ->where('employee.id', $member_id)
			 ->where('registration.id', $reg_id)
			 ->order_by('registration.surname')
			 ->order_by('registration.name')
			 ->order_by('section');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$tutor_students_details[] = $row;
			}
			return $tutor_students_details;
		}
		else {
			return false;
		}
	} 


	
}
