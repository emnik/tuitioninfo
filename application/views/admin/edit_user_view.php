<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<title>Πληροφοριακό σύστημα φροντιστηρίου</title>
	<?php $theme = $this->config->item(theme);?>
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/main.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/style.css" rel="stylesheet" type="text/css">

	<link href="<?php echo base_url() ?>css/smoothness/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.23.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/i18n/jquery.ui.datepicker-el.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#end_date').datepicker();
		});
	</script>
</head>
	
<body>

	
<div id="main">
	<div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1>Πίνακας Διαχείρισης</h1>
          <h2>Πληροφοριακό Σύστημα Φροντιστηρίου.</h2>
        </div>
      </div>


      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <li class="selected"><a href="<?php echo base_url() ?>admin/users">Επιστροφη</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">


      <div id="content">
        <!-- insert the page content here -->

		<h2> Επεξεργασία χρήστη:</h2>
		
		<h4>
		<?php if(!empty($name)):
				echo $name['surname'].' '.$name['name'];
				endif;
				?>
		</h4>
		
		<?php if(!empty($message)): 
			echo "<span style='font-weight:bold; color:red;'>".$message."</span>"; 
		endif;?>
		
		<div class = "form_settings">
		
		<?php $user_id=$this->uri->segment(3);?>

		<?php echo form_open('admin/edituser/'.$user_id);?>

			<p>
				<?php echo form_label('Εισάγετε νέο όνομα χρήστη:', 'username');?>
				<br />
				<?php $username_input = array("name" => "username", "value" => set_value('username'), "class" => "input", "id" => "username");?>
				<?php echo form_input($username_input)?>	
			</p>
			
			<p>
				<?php echo form_label('Εισάγετε νέο κωδικό χρήστη:', 'password');?>
				<br />
				<?php $password_input = array("name" => "password", "value" => "", "class" => "input", "id" => "password");?>
				<?php echo form_password($password_input);?>
			</p>
			
			<p>
				<?php echo form_label('Επαληθεύστε τον νέο κωδικό χρήστη:', 'repeatpassword');?>
				<br />
				<?php $repeatpassword_input = array("name" => "repeatpassword", "value" => "", "class" => "input", "id" => "repeatpassword");?>
				<?php echo form_password($repeatpassword_input);?>
			</p>
			
			<p>
				<?php echo form_label('Εισάγετε τη νέα ημερομηνία λήξης του λογαριασμού:', 'end_date');?>
				<br />
				<?php $end_date_input = array("name" => "end_date", "value" => "", "class" => "input", "id" => "end_date");?>
				<?php echo form_input($end_date_input)?>				
			</p>
			<h5>*Εισάγετε 00/00/0000 αν δεν θέλετε να λήγει ο λογαριασμός! </h5>
		
			<div class="errors">
				<p><?php echo validation_errors(); ?></p>
			</div>			

			<p>
				<?php $submit = array("name" => "submit", "value" => "Αποθήκευση", "class" => "submit", "id"=>"submit");?>
				<?php echo form_submit($submit);?>
			</p>
		
		<?php echo form_close();?>
		
		</div>


<!-- end of page content here -->
	</div>
</div>


