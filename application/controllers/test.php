<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	

	public function index()
	{
		$this->load->helper('pbkdf2_helper');
		$pass= create_hash('usr#6379');
		echo $pass;
		echo "<p>".strlen($pass)."</p>";
		echo "<p>result:</p>";
		if (validate_password('usr#6379', $pass) == true) {
			echo "validation passed";
		} 
		else
		{
			echo "didn't pass!";
		};
	}


	public function index2()
	{
		$this->load->helper('bcrypt_helper');
		$pass= bcrypt_hash('mypassword');
		echo $pass;
		echo "<p>result:</p>";
		if (bcrypt_check('mypassword', $pass) == true) {
			echo "validation passed";
		} 
		else
		{
			echo "didn't pass!";
		};
	}



}