<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Guardian_fees_model extends CI_Model
{
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    
	function get_guardian_member_fee_basics($reg_id) 
	{
		$this->db->select(array('registration.id', 'registration.surname' , 'registration.name',
								'registration.start_lessons_dt', 'month_price'));
		$this->db->from('registration');
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
	
	
	
		function get_guardian_member_pay_summary($reg_id) 
	{

		$this->db->select(array('registration.id', 'COALESCE(COUNT(post_payment.month_num),0) AS `pay_summary`'));
		$this->db->from('registration');
		$this->db->join('post_payment','registration.id=post_payment.reg_id','left');
		$this->db->where('registration.id',$reg_id);
		$this->db->where('post_payment.is_credit','0');	
		$this->db->group_by('registration.id');
		$query = $this->db->get();

		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$student_pay_summary[] = $row;
			}
			return $student_pay_summary;
		}
		else 
		{
			return false;
		}
	} 



	function get_guardian_member_debt_summary($reg_id) 
	{
	
		$this->db->select(array('registration.id', 'COALESCE(COUNT(debt.month_num),0) AS `debt_summary`',
								'COALESCE(SUM(debt.amount),0) AS `fee`'));
		$this->db->from('registration');
		$this->db->join('debt','registration.id=debt.reg_id','left');
		$this->db->where('registration.id',$reg_id);
		$this->db->group_by('registration.id');
		$query = $this->db->get();

		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$student_debt_summary[] = $row;
			}
			return $student_debt_summary;
		}
		else 
		{
			return false;
		}
	} 

	
	
	function get_guardian_member_payments($reg_id) 
	{
			
		$this->db->select(array('registration.id', 'payment.apy_no', 'payment.apy_dt', 'payment.amount',
								'payment.is_credit', 'payment.month_range'));
		$this->db->from('registration');
		$this->db->join('payment','registration.id=payment.reg_id','left');
		$this->db->where('registration.id',$reg_id);
		$this->db->where('is_credit', '0');
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
	


	function get_guardian_member_debts($reg_id) 
	{
			
		$this->db->select(array('registration.id', 'debt.month_num', 'debt.amount'));
		$this->db->from('registration');
		$this->db->join('debt','registration.id = debt.reg_id','left');
		$this->db->join('month', 'debt.month_num = month.num');
		$this->db->where('registration.id',$reg_id);
		$this->db->order_by('month.priority');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) 
		{
			foreach($query->result_array() as $row) 
			{
				$student_debts[] = $row;
			}
			return $student_debts;
		}
		else 
		{
			return false;
		}
	} 	
	
	
	
}
