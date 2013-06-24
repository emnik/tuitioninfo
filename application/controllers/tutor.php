<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Αυτός είναι ο βασικός controller για το group tutor

class Tutor extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();

		
		//as not to be able to access the pages with browser's back button after logout. 
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0"); 
		$this->output->set_header("Pragma: no-cache");


		$this->load->library('session');
		$session_user = $this->session->userdata('is_logged_in');
		if(empty($session_user))
		{
			redirect('auth');
		}
		else
		{
			$this->load->model('auth_model');
			$grp = $this
					->auth_model
					->get_user_group($this->session->userdata('user_id'));

			//ανακατεύθυνση στο σωστο controller αν το group δεν είναι tutor 
			switch ($grp->name)	
			{
				case 'admin':
					redirect('admin');
					break;
				case 'parent':
					redirect('parent');
					break;
			}
		}
	}
	
	
	public function index()
	{	
		$this->load->model('tutor/tutor_profile_model');		
		$data['tutor_profile'] = null;
		$data['tutor_hours'] = null;

		
		//when signed in as tutor then member id is employee id
		$tutor_id = $this
						->tutor_profile_model
						->get_tutor_member_id($this	->session->userdata('user_id'))
						->property_id;
		
		$this->session->set_userdata('member_id', $tutor_id);
		
		if($tutor_id)
		{
			$tutor_data = $this
							->tutor_profile_model
							->get_tutor_profile($tutor_id);
			
			$tutor_hours =  $this
							->tutor_profile_model
							->get_tutor_weekly_hours($tutor_id);
			
			$data['tutor_profile'] = $tutor_data;
			$data['tutor_hours'] = $tutor_hours;
			
		}
		$this->load->view('tutor/home_view', $data);
		$this->load->view('footer');
	}



	public function students()
	{
		//debugging:	$this->output->enable_profiler(TRUE);

		//Μαθητές
		$this->load->model('tutor/tutor_students_model');
		$data['students'] = null;
		$data['students_details'] = null;
		if($students = $this->tutor_students_model->get_tutor_students($this->session->userdata('member_id'))  )
		{
			$data['students'] = $students;
			
			//for each student I get in students_details array the lessons and sections he attents
			//by doing this, array $students_details will have the same ordering as array $students! 
			//and each position will correspont to a subarray with details of that particular student
			foreach ($students as $row)
			{
				$reg_id = $row['id'];
				$students_details[] = $this->tutor_students_model->get_tutor_students_details($this->session->userdata('member_id'), $reg_id);
			}
			
		}
			$data['students_details'] = $students_details;
			
		$this->load->view('tutor/students_view', $data);	
		$this->load->view('footer');
	
	}



	public function program()
	{
		//debugging:	$this->output->enable_profiler(TRUE);


		//Πρόγραμμα
		$this->load->model('tutor/tutor_program_model');
		$data['program'] = null;
		$data['program_basics'] = null;
		if($program_basics = $this->tutor_program_model->get_tutor_program_basics($this->session->userdata('member_id')) )
		{
			$data['program_basics'] = $program_basics;
			$data['program'] = $this->tutor_program_model->get_tutor_program($this->session->userdata('member_id'));
			
		}
		$this->load->view('tutor/program_view', $data);	
		$this->load->view('footer');
	
	}



	public function sections()
	{
		//debugging:	$this->output->enable_profiler(TRUE);


		//Τμήματα
		$this->load->model('tutor/tutor_sections_model');
		$data['sections'] = null;
		$data['section_students'] = null;
		$data['section_program'] = null;
		if($tutor_sections_summary = $this->tutor_sections_model->get_tutor_sections_summary($this->session->userdata('member_id')) )
		{
			$data['sections'] = $tutor_sections_summary;
			
			$tutor_sections = $this->tutor_sections_model->get_tutor_sections($this->session->userdata('member_id'));
			foreach($tutor_sections as $row)
			{
				$section_id = $row['id'];
				$tutor_section_students[] = $this->tutor_sections_model->get_tutor_section_students($section_id);
				$tutor_section_program[] = $this->tutor_sections_model->get_tutor_sections_program($this->session->userdata('member_id'), $section_id);
			}
			
			$data['section_students'] = $tutor_section_students;
			$data['section_program'] = $tutor_section_program;
			
		}
		$this->load->view('tutor/sections_view', $data);	
		$this->load->view('footer');
	
	}



	public function logout()
	{
		$this->session->unset_userdata('is_logged_in');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('member_id');
		$this->session->sess_destroy();


		$this->load->view('auth_login_view');
		$this->load->view('footer');
	}


}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
