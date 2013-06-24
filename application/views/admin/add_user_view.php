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

		//the following is ajax post to populate the members dropdown 
		$('#groupmembers, #groupmembers_label').hide();
		
		$('#groupname').change(function(){
			var group_id = $('#groupname').val();
			var surname = $('#surname').val();
			var name = $('#name').val();
			var label = $('#groupmembers_label');
			//the first line of postdata is needed to conform with csrf protection
			//the others are the data I want to post to the controler
			var postdata = {'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>', 
							'jsgroupid': group_id,
							'jssurname': surname,
							'jsname':name}
			if (surname==""){alert('Προτού επιλέξετε ομάδα πρέπει να συμπληρώσετε τουλάχιστον το επίθετο!');}
			if (group_id != "" && group_id != '1' && surname!=""){
				switch (group_id){
					case '3': //tutor
						label.html('Πρόσβαση σε δεδομένα του καθηγητή:');
						break;
					case '4': //student
						label.html('Πρόσβαση σε δεδομένα του μαθητή:');
						break;
					case '2': //parent
						if (surname.length<3){
							alert('Το επίθετο είναι πολύ μικρό!');
							return false;}
						label.html('Πρόσβαση σε δεδομένα των μαθητών:');
					}
				//post_url is the controller function where I want to post the data
				var post_url = "<?php echo base_url()?>admin/getmembers/";
				$.ajax({
					type: "POST",
					url: post_url,
					data : postdata,
					dataType:'json',
					//members is just a name that gets the result of the controller's function I posted the data
					success: function(members) //we're calling the response json array 'members data'
						{
							$('#groupmembers').empty();
							$('#groupmembers, #groupmembers_label').show();
							$.each(members,function(id,member) 
								{
									var opt = $('<option />'); // here we're creating a new select option for each group
									opt.val(id);
									opt.text(member);
									$('#groupmembers').append(opt); 
								});
						} //end success
					}); //end AJAX
			} else {
				$('#groupmembers').empty();
				$('#groupmembers, #groupmembers_label').hide();
			}//end if
		}); //end change 
			
			
		//use jquery's ui datepicker for id=#end_date in the form
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

		<h2> Προσθήκη χρήστη. </h2>

		<?php if($this->session->flashdata('adduser_message') != ''): 
			echo $this->session->flashdata('adduser_message'); 
		endif;?>
	
				
		<div class = "form_settings">

		<?php echo form_open('admin/adduser');?>

			<p>
				<?php echo form_label('Εισάγετε επίθετο:', 'surname');?>
				<br />
				<?php $surname_input = array("name" => "surname", "value" => set_value('surname'), "class" => "input", "id" => "surname");?>
				<?php echo form_input($surname_input)?>				
			</p>

			<p>
				<?php echo form_label('Εισάγετε όνομα:', 'name');?>
				<br />
				<?php $name_input = array("name" => "name", "value" => set_value('name'), "class" => "input", "id" => "name");?>
				<?php echo form_input($name_input)?>
				
			</p>

			<p>
				<?php echo form_label('Επιλέξτε ομάδα χρήστη:', 'groupname');?>
				<br />
				<?php echo form_dropdown('groupname', $groups, '1' ,"class='select'  id='groupname'")?>
				
			</p>

			<p>
				<?php echo form_label('Επιλέξτε:', 'groupmembers', array("id"=>"groupmembers_label"));?>
				<br />
				<?php $members=array('NA'=>'No options');?>
				<?php echo form_multiselect('groupmembers[]', $members, array('') ,"class='multiselect' id='groupmembers'")?>
				
			</p>
				
			<p>
				<?php echo form_label('Εισάγετε όνομα χρήστη:', 'username');?>
				<br />
				<?php $username_input = array("name" => "username", "value" => set_value('username'), "class" => "input", "id" => "username");?>
				<?php echo form_input($username_input)?>	
			</p>
			
			<p>
				<?php echo form_label('Εισάγετε κωδικό χρήστη:', 'password');?>
				<br />
				<?php $password_input = array("name" => "password", "value" => "", "class" => "input", "id" => "password");?>
				<?php echo form_password($password_input);?>
			</p>
			
			<p>
				<?php echo form_label('Επαληθεύστε τον κωδικό χρήστη:', 'repeatpassword');?>
				<br />
				<?php $repeatpassword_input = array("name" => "repeatpassword", "value" => "", "class" => "input", "id" => "repeatpassword");?>
				<?php echo form_password($repeatpassword_input);?>
			</p>
			
			<p>
				<?php echo form_label('Εισάγετε την ημερομηνία λήξης του λογαριασμού:', 'end_date');?>
				
				<br />
				<?php $end_date_input = array("name" => "end_date", "value" => '00/00/0000', "class" => "input", "id" => "end_date");?>
				<?php echo form_input($end_date_input)?>				
			</p>
			<h5>*Αφήστε 00/00/0000 αν δεν θέλετε να λήγει ο λογαριασμός! </h5>
		
			<div class="errors">
				<p><?php echo validation_errors(); ?></p>
			</div>			

			<p>
				<?php $submit = array("name" => "submit", "value" => "Προσθήκη", "class" => "submit", "id"=>"submit");?>
				<?php echo form_submit($submit);?>
			</p>
		
		<?php echo form_close();?>
		
		</div>


<!-- end of page content here -->
	</div>
</div>


