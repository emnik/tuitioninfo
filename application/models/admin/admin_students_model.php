<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_students_model extends CI_Model
{

     function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


	function get_students() {

		$min_reg_id = $this->get_min_schoolyear_reg_id();
		if ($min_reg_id==false)
		{
			return false;
		}
		
		$this->db->select('registration.id, registration.surname, registration.name, 
				registration.fathers_name, registration.mothers_name, registration.std_book_no, 
				registration.start_lessons_dt, registration.del_lessons_dt, registration.address, 
				registration.month_price,
				class.class_name AS class, course.course AS course,
				contact.home_tel AS home_tel, contact.std_mobile AS std_mobile,
				contact.mothers_mobile AS mothers_mobile,
				contact.fathers_mobile AS fathers_mobile,
				contact.work_tel AS work_tel');
		$this->db->from('registration' );
		$this->db->join('contact','registration.id=contact.reg_id','left');
		$this->db->join('class','registration.class_id=class.id','left');
		$this->db->join('course','registration.course_id=course.id','left');
		$this->db->where('registration.id >=',$min_reg_id);
		$this->db->order_by('surname','ASC');
		$this->db->order_by('name','ASC');
		$this->db->order_by('registration.id','ASC');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$students_data[] = $row;
			}
			return $students_data;
		}
		else {
			return false;
		}
	} 

	
	function get_min_schoolyear_reg_id()
	{
		$this->db->select_min('id');
		$min_reg_id = $this->db->get('vw_schoolyear_reg_ids')->row_array();
		if (empty($min_reg_id)==false)
		{
			return $min_reg_id['id'];
		}
		else
		{
			return false;
		}
	}


	function get_students_pay_summary() 
	{
		$min_reg_id = $this->get_min_schoolyear_reg_id();
		if ($min_reg_id==false)
		{
			return false;
		}
		

		$this->db->select(array('registration.name', 'registration.surname', 'registration.id', 'COALESCE(COUNT(post_payment.month_num),0) pay_summary'));
		$this->db->from('registration');
		$this->db->join('post_payment','registration.id=post_payment.reg_id','left');
		$this->db->where('registration.id >=',$min_reg_id);
		$this->db->bracket('open');
		$this->db->where('post_payment.is_credit','0');	
		$this->db->bracket('close');
		$this->db->group_by('registration.id');
		$this->db->order_by('surname','ASC');
		$this->db->order_by('name','ASC');
		$this->db->order_by('registration.id','ASC');

		$query = $this->db->get();

		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$students_pay_summary[] = $row;
			}
			return $students_pay_summary;
		}
		else 
		{
			return false;
		}
	} 



	function get_students_debt_summary() 
	{
		$min_reg_id = $this->get_min_schoolyear_reg_id();
		if ($min_reg_id==false)
		{
			return false;
		}
	
		$this->db->select(array('registration.surname', 'registration.name',
								'registration.id', 'COUNT(debt.month_num) AS `debt_summary`'));
		$this->db->from('registration');
		$this->db->join('debt','registration.id=debt.reg_id','left');
		$this->db->where('registration.id >=',$min_reg_id);
		$this->db->group_by('registration.id');
		$this->db->order_by('surname','ASC');
		$this->db->order_by('name','ASC');
		$this->db->order_by('registration.id','ASC');

		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$students_debt_summary[] = $row;
			}
			return $students_debt_summary;
		}
		else 
		{
			return false;
		}
	} 




	function get_students_program() 
	{
		$min_reg_id = $this->get_min_schoolyear_reg_id();
		if ($min_reg_id==false)
		{
			return false;
		}


		$this->db->select(array('registration.id', 'registration.surname',
								'registration.name', 'section_program.day',
								'weekday.priority', 'classroom.classroom',
								'section_program.start_tm', 'section_program.end_tm',
								'employee.nickname', 'catalog_lesson.title', 
								'std_lesson.section_id', 'section.section'));
		$this->db->from('registration, section_program');
		$this->db->join('classroom','section_program.classroom_id = classroom.id','left');
		$this->db->join('weekday','section_program.day = weekday.name','left');
		$this->db->join('std_lesson', 'std_lesson.reg_id = registration.id AND section_program.section_id = std_lesson.section_id'); 
		$this->db->join('section','std_lesson.section_id = section.id');
		$this->db->join('lesson_tutor','section.tutor_id = lesson_tutor.id');
		$this->db->join('employee','lesson_tutor.employee_id = employee.id');
		$this->db->join('catalog_lesson','lesson_tutor.cataloglesson_id = catalog_lesson.id');
		$this->db->where('registration.id >=',$min_reg_id);
		$this->db->order_by('surname');
		$this->db->order_by('name');
		$this->db->order_by('registration.id');
		$this->db->order_by('weekday.priority');
		$this->db->order_by('start_tm', 'ASC');

		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$students_program[] = $row;
			}
			return $students_program;
		}
		else 
		{
			return false;
		}
	} 




	function get_students_payments() 
	{
		$min_reg_id = $this->get_min_schoolyear_reg_id();
		if ($min_reg_id==false)
		{
			return false;
		}
	
		$this->db->select(array('registration.id', 'registration.surname', 'registration.name', 
								'payment.apy_no', 'payment.apy_dt', 'payment.amount', 'payment.is_credit', 'payment.month_range'));
		$this->db->from('registration');
		$this->db->join('payment','registration.id=payment.reg_id','left');
		$this->db->where('registration.id >=',$min_reg_id);
		$this->db->order_by('surname');
		$this->db->order_by('name');
		$this->db->order_by('registration.id');
		$this->db->order_by('payment.apy_no');
		$this->db->order_by('payment.apy_dt','ASC');

		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$students_payments[] = $row;
			}
			return $students_payments;
		}
		else 
		{
			return false;
		}
	} 





	function get_schoolyear() 
	{
		
		$this->db->select('lookup.value_1 AS start_schoolyear');
		$this->db->from('lookup');
		$this->db->where('id','2');
		
		$query = $this->db->get()->row_array();
		if (empty($query)==false) 
		{
			$startschoolyear = $query['start_schoolyear'];
			$endschoolyear = $startschoolyear+1;
			$schoolyear=$startschoolyear.'-'.$endschoolyear;
			
			return $schoolyear;
		}
		else 
		{
			return false;
		}
	} 


}

