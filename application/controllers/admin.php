<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Αυτός είναι ο βασικός controller για το χρήστη admin

class Admin extends CI_Controller {
	
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

				//ανακατεύθυνση στο σωστο controller αν το group δεν είναι admin 
				switch ($grp->name)
				{
					case 'tutor':
						redirect('tutor');
						break;
					case 'parent':
						redirect('parent');
						break;
				}
		}
	}
	
	
	public function index()
	{
		//debugging:	$this->output->enable_profiler(TRUE);
		$this->load->model('auth_model');
		$admin_user = $this->auth_model->get_user_name($this->session->userdata('user_id'));
		$data['admin_user']  = $admin_user->surname.' '.$admin_user->name;
		$this->load->view('admin/home_view', $data);
		$this->load->view('footer');
	}


	public function users()
	{
		//debugging:	$this->output->enable_profiler(TRUE);
				
		$data['users'] = null;
		
		$this->load->model('admin/admin_home_model');
		if ($users = $this->admin_home_model->get_users())
		{
			foreach($users as $user)
			{
				$user_id = $user['id'];
				$group_id = $user['group_id'];
				
				$members = null; // for admins
				
				if ($group_id != '1') //not admin
				{
					//gettting the members for the user
					$members_data = $this->admin_home_model->get_members($user_id, $group_id);	
					//get each member as one string in an array
					foreach($members_data as $member)
					{
						$members[] = $member['surname'].' '.$member['name'];
					}
				}
				//adding the members array in the user data
				$user['members'] = $members; 
				//merging old user data with new (members)
				$users_data[] = $user;
			}
			
			$data['users'] = $users_data;
			//$data['groups'] = $this->admin_home_model->get_groups();
		}
				
		$this->load->view('admin/users_view', $data);
		$this->load->view('footer');
	}


	public function students()
	{
		//Μαθητές
		$this->load->model('admin/admin_students_model');
		$data['students'] = null;
		$data['schoolyear']=null;
		$data['students_pay_summary']=null;
		$data['students_debt_summary']=null;
		$data['students_program']=null;
		$data['students_payments']=null;
		

		if($students_data = $this->admin_students_model->get_students())
		{
			//get the data or the value false as a return error from the functions called
			$data['students'] = $students_data;
			$data['schoolyear'] = $this->admin_students_model->get_schoolyear();
			$data['students_pay_summary'] = $this->admin_students_model->get_students_pay_summary();
			$data['students_debt_summary'] = $this->admin_students_model->get_students_debt_summary();
			$data['students_program'] = $this->admin_students_model->get_students_program();
			$data['students_payments'] = $this->admin_students_model->get_students_payments();
		}
		

		$this->load->view('admin/students_view', $data);
		$this->load->view('footer');
	}	


	public function tutors()
	{
		//Καθηγητές
		$this->load->model('admin/admin_tutors_model');
		$data['tutors'] = null;
		$data['tutors_program'] = null;
		$data['tutors_weekly_hours'] = null;


		if($tutors_data = $this->admin_tutors_model->get_tutors())
		{
			$data['tutors'] = $tutors_data;
			$data['tutors_program'] = $this->admin_tutors_model->get_tutors_program();
			$data['tutors_weekly_hours'] = $this->admin_tutors_model->get_tutors_weekly_hours();
		}
		$this->load->view('admin/tutors_view', $data);
		$this->load->view('footer');
	}

	
	public function sections()
	{
		//Τμήματα
		$this->load->model('admin/admin_sections_model');
		$data['sections'] = null;
		$data['sections_details'] = null;
		$data['sections_students'] = null;


		if($sections = $this->admin_sections_model->get_sections())
		{
			$section_details = $this->admin_sections_model->get_sections_details();
						
			foreach ($section_details as $row)
			{
				$section_id = $row['id'];
				$sections_students[] = $this->admin_sections_model->get_section_students($section_id);
			}
			$data['sections_students'] = $sections_students;			
			$data['sections'] = $sections;
			$data['sections_details'] = $section_details;
			
		}

		$this->load->view('admin/sections_view', $data);
		$this->load->view('footer');
	}
	
	

	public function program()
	{
		//Πρόγραμμα
		$this->load->model('admin/admin_program_model');
		$data['program'] = null;
		$data['program_details'] = null;


		if($program_data = $this->admin_program_model->get_program_basics())
		{
			$data['program'] = $program_data;
			$data['program_details'] = $this->admin_program_model->get_program_details();
			
		}
		$this->load->view('admin/program_view', $data);	
		$this->load->view('footer');
	
	}
	
	
	public function adduser()
	{
		$this->load->model('admin/admin_home_model');
		$data['groups'] = $this->admin_home_model->get_groups();
		
	
		$this->load->library('form_validation');
		$this->lang->load('form_validation','greek');
		$this->form_validation->set_rules('surname','Επίθετο','required|min_length[3]|max_length[15]|alpha_greek');
		$this->form_validation->set_rules('name','Όνομα','required|min_length[3]|max_length[25]|alpha_greek');
		$this->form_validation->set_rules('username','Όνομα χρήστη','required|min_length[4]|max_length[12]|alpha_numeric|is_unique[user.username]');
		$this->form_validation->set_rules('password','Κωδικός χρήστη','required|min_length[4]|max_length[12]');
		$this->form_validation->set_rules('repeatpassword','Επιβεβαίωση κωδικού χρήστη','required|matches[password]');
		$this->form_validation->set_rules('groupname','Ομάδα χρήστη','required|is_natural_no_zero');
		
		if($this->input->post('groupname')!='1')
		{
			$groupmembers = $this->input->post('groupmembers[]', TRUE);
			foreach ($groupmembers as $groupmember) {
				$this->form_validation->set_rules($groupmember,'Μέλη ομάδας','required|integer');
			}
		}
		
		$data['validation'] = null;
		
		if($this->form_validation->run()==false)
		{
			$data['validation'] = validation_errors();
			$this->load->view('admin/add_user_view', $data);
			$this->load->view('footer');
		}
		 else
        {
            #Add User to Database
            $data['surname'] = $this->input->post('surname');
            $data['name'] = $this->input->post('name');
            $data['group_id'] = $this->input->post('groupname');
			$data['members'] = $this->input->post('groupmembers');
            $data['username'] = $this->input->post('username');
            $data['password'] = $this->input->post('password');
            
            //convert the date to the mysql required format
            $date=explode("/",$this->input->post('end_date'));
			// where the $_POST['date'] is a value posted by form in dd/mm/yyyy format
			$mysqldate=$date[2]."-".$date[1]."-".$date[0];
			// The string mysqldate is now in yyyy-mm-dd format
			$data['expires'] = $mysqldate;
            
            
            $this->load->model('admin/admin_home_model');

            if($this->admin_home_model->add_user_members($data)){

				$success_message="Η προσθήκη χρήστη ήταν επιτυχής.<br/>Μπορείτε να προσθέσετε νέο χρήστη ή να επιστρέψετε στον πίνακα διαχείρισης πατώντας 'Επιστροφή'.";
				$this->session->set_flashdata('adduser_message', $success_message);
				redirect(current_url());

			}
        }
	}
	
	
	public function deluser($user_id)
	{
		if(!empty($user_id))
		{
			$this->load->model('admin/admin_home_model');
			$this->admin_home_model->del_webuser($user_id);
			$this->users();
		}
	}
	
	
	
	public function delete_checkbox()
	{
        $dat=$this->input->post('forms');
        $this->load->model('admin/admin_home_model');
        for($i=0; $i<sizeof($dat);$i++)
        {
            // print_r($dat[$i]);
            $this->admin_home_model->del_webuser($dat[$i]);
        }
        $this->users();
    }
	
	
	public function edit_selected($user_id, $message=null)
	{
		if(!empty($user_id))
		{
			
			$this->load->model('admin/admin_home_model');
			$name = $this->admin_home_model->get_user($user_id);
			if($name){
				$data['name'] = $name;
			}
			$data['message'] = $message;
			$data['id'] = $user_id;
			$this->load->view('admin/edit_user_view',$data);
			$this->load->view('footer');
		}
		else
		{
			$this->users();
		}
	}
	
	
	public function edituser($user_id)
	{
		$this->load->library('form_validation');
		$this->lang->load('form_validation','greek');
		$this->form_validation->set_rules('username','Όνομα χρήστη','min_length[4]|max_length[12]|alpha_numeric|is_unique[user.username]');
		$this->form_validation->set_rules('password','Κωδικός χρήστη','min_length[4]|max_length[12]');
		$this->form_validation->set_rules('repeatpassword','Επιβεβαίωση κωδικού χρήστη','matches[password]');
		
		$data['validation'] = null;

		
		if($this->form_validation->run()==false)
		{
			$data['validation'] = validation_errors();
			$this->load->view('admin/edit_user_view', $data);
			$this->load->view('footer');
		}
		 else
        {
            #Update User 
            $data['id'] = $user_id;
            
            $username = $this->input->post('username');
            if(!empty($username))
            {
				$data['username'] = $this->input->post('username');
			}
			
			$password = $this->input->post('password');
			if(!empty($password))
			{
				$data['password'] = $this->input->post('password');
			}
            
            $end_date = $this->input->post('end_date');
            if(!empty($end_date))
            {
				//convert the date to the mysql required format
				$date=explode("/",$this->input->post('end_date'));
				// where the $_POST['date'] is a value posted by form in dd/mm/yyyy format
				$mysqldate=$date[2]."-".$date[1]."-".$date[0];
				// The string mysqldate is now in yyyy-mm-dd format
				$data['expires'] = $mysqldate;
			}
            
            
            $this->load->model('admin/admin_home_model');

            if($this->admin_home_model->update_webuser($data)){

				$this->users();

			}
			else
			{
				$error_message="Πατήσατε αποθήκευση χωρίς να συμπληρώσετε κάποιο πεδίο! Δεν έγιναν αλλαγές.";
				$this->edit_selected($user_id, $error_message);
			}
        }
		
	}
	
	
	public function getmembers()
	{
		$this->load->model('admin/admin_home_model','', TRUE);    
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this
						->admin_home_model
						->get_members_dropdown_data($this->input->post('jsgroupid'),
													$this->input->post('jssurname'),
													$this->input->post('jsname')
													)
						)
			);
	}
	


	public function logout()
	{
		
		//$this->session->unset_userdata('is_logged_in');
		//$this->session->unset_userdata('user_id');
		$this->session->sess_destroy();
		
		$this->load->view('auth_login_view');
		$this->load->view('footer');
	}


}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
