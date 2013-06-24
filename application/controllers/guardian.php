<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Αυτός είναι ο βασικός controller για το group parent
// Αντί για τη λέξη parent χρησιμοποιώ τη guardian(κηδεμόνας) γιατί η parent είναι reserved word στον codeigniter
// Παρόλα αυτά, βάζοντας στο application->config->routes τις γραμμές
// $route['parent'] = 'guardian';
// $route['parent/(:any)'] = "guardian/$1"; 
// στον τελικό χρήστη φαίνεται το URL ως ../parent/...

class Guardian extends CI_Controller {
	
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

			//ανακατεύθυνση στο σωστο controller αν το group δεν είναι parent 
			switch ($grp->name)	
			{
				case 'admin':
					redirect('admin');
					break;
				case 'tutor':
					redirect('tutor');
					break;
				case 'student':
					redirect('student');
					break;
			}
		}
	}
	
	
	public function index()
	{	
		$this->load->model('guardian/guardian_profile_model');		
		$data['guardian_profile'] = null;
		$data['guardian_details'] = null;
		$data['guardian_members'] = null;
		
		
		//get guardian details (surname, name)
		$user_data = $this
					->guardian_profile_model
					->get_guardian_user_details($this->session->userdata('user_id'));
		
		if ($user_data)
		{
			$data['guardian_details'] = $user_data;
		}
		
		//get guardian members ids
		//when signed in as parent the property id is the registration id of each kid
		$reg_ids = $this
				->guardian_profile_model
				->get_reg_ids($this->session->userdata('user_id'));
		

		if ($reg_ids)
		{
			$this->session->set_userdata('members_ids', $reg_ids); //store reg_ids array as session data
			
			foreach ($reg_ids as $id)
			{
				$members[] =  $this->guardian_profile_model->get_guardian_member_profile($id);
			}
			$data['guardian_members'] = $members;
		
			//use the first guardian member to get guardian profile
			if($profile = $this
						->guardian_profile_model
						->get_guardian_profile($reg_ids[0])
												
				)
			{
				$data['guardian_profile'] = $profile;
			}
		}
		
		$this->load->view('guardian/home_view', $data);
		$this->load->view('footer');
	}





	public function program()
	{
		$this->load->model('guardian/guardian_program_model');
		$reg_ids = $this->session->userdata('members_ids');
		
		foreach ($reg_ids as $id)
		{
			$students[] = $this->guardian_program_model->get_guardian_member_profile($id);
			$students_program[] = $this->guardian_program_model->get_guardian_member_program($id);
		}
		
		$data['guardian_members'] = $students;
		$data['guardian_member_program'] = $students_program;
		
		$this->load->view('guardian/program_view', $data);
		$this->load->view('footer');
	}



	public function fees()
	{
		$this->load->model('guardian/guardian_fees_model');
		$reg_ids = $this->session->userdata('members_ids');
		
		foreach ($reg_ids as $id)
		{
			$fees_basics[] = $this->guardian_fees_model->get_guardian_member_fee_basics($id);
			$pay_summary[] = $this->guardian_fees_model->get_guardian_member_pay_summary($id);
			$debt_summary[] = $this->guardian_fees_model->get_guardian_member_debt_summary($id);
			$pay_analysis[] = $this->guardian_fees_model->get_guardian_member_payments($id);
			$debt_analysis[] = $this->guardian_fees_model->get_guardian_member_debts($id);
		}
		
		$data['member_fees_basics'] = $fees_basics;
		$data['member_pay_summary'] = $pay_summary;
		$data['member_debt_summary'] = $debt_summary;
		$data['member_pay_analysis'] = $pay_analysis;
		$data['member_debt_analysis'] = $debt_analysis;

		$this->load->view('guardian/fees_view', $data);
		$this->load->view('footer');
		
		
	}



	public function logout()
	{
		//$this->session->unset_userdata('is_logged_in');
		//$this->session->unset_userdata('user_id');
		//$this->session->unset_userdata('members_ids');
		    
		/*
		$user_data = $this->session->all_userdata();

		foreach ($user_data as $key => $value) 
		{
			$this->session->unset_userdata($key);
        }
        */
		$this->session->sess_destroy();
		
		$this->load->view('auth_login_view');
		$this->load->view('footer');
	}


}

/* End of file guardian.php */
/* Location: ./application/controllers/guardian.php */
