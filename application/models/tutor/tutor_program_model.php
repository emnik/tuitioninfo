<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Tutor_program_model extends CI_Model
{
 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
		function get_tutor_program($member_id) {

		$this->db->select(array('employee.id', 'employee.nickname', 'section_program.day', 'weekday.priority',
							    'section_program.start_tm', 'section_program.end_tm',
							    'section.section', 'catalog_lesson.title', 'classroom.classroom',
							    'section_program.section_id', 'section_program.duration'));
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
				$tutor_program_data[] = $row;
			}
			return $tutor_program_data;
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
				
				
				$query = $this->db->get();
		
				if ($query->num_rows() > 0) 
				{
					foreach($query->result_array() as $row) 
					{
						$tutor_program_data_basics[] = $row;
					}
				return $tutor_program_data_basics;
				}
				else {
					return false;
				}
	} 
	
	
	
}
