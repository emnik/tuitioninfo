<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<title>Πληροφοριακό σύστημα φροντιστηρίου</title>
	<?php $theme = $this->config->item(theme);?>
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/main.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/style.css" rel="stylesheet" type="text/css">


	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.7.2.min.js"></script>
	<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>

	
	<script language="javascript">
		var popupWindow = null;
		function centeredPopup(url,winName,w,h,scroll){
			LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
			TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
			settings =
			'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
			popupWindow = window.open(url,winName,settings)
		}
	</script>

</head>
	
<body>

	
<div id="main">
	<div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="<?php echo base_url() ?>index.php">Φροντιστήριο <span class="logo_colour">'σπουδή'</span></a></h1>
          <h2>Πληροφοριακό Σύστημα Φροντιστηρίου.</h2>
        </div>
        <div id="contact_details">
          <p>τηλ: 25520 24200</p>
          <p>email: info@spoudh.gr</p>
        </div>
      </div>


      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <li class="selected"><a href="<?php echo base_url() ?>admin">Αρχικη</a></li>
          <li><a href="<?php echo base_url() ?>admin/students">Μαθητες</a></li>
          <li><a href="<?php echo base_url() ?>admin/tutors">Καθηγητες</a></li>
          <li><a href="<?php echo base_url() ?>admin/sections">Τμηματα</a></li>
          <li><a href="<?php echo base_url() ?>admin/program">Προγραμμα</a></li>
          <li><a href="<?php echo base_url() ?>admin/logout">Εξοδος</a></li>

        </ul>
      </div>
    </div>
    <div id="site_content">

      <div class="sidebar">
        <!-- insert your sidebar items here -->
        
      </div>
        <!-- end of sidebar items here -->


      <div id="content">
        <!-- insert the page content here -->

		<h2>Σύνδεση ως <?php echo $admin_user?> (διαχειριστής).</h2>

		<p>Έχετε πλήρη πρόσβαση στα δεδομένα του φροντιστηρίου!
			<br></br>
		</p>

		
		<div class="square_button_users">
			<a href="<?php echo base_url()?>admin/users" onclick="centeredPopup(this.href,'Manage Users','1024','800','yes');return false">
				<img src="<?php echo base_url()?>css/24_account.png" style="margin:7px 0px 0px 7px;"/>
			</a>	
		</div>			
		<p style="font-weight:bold; margin:12px 0 0 50px;">Διαχείριση χρηστών</p>
		
				
		<?php if(!empty($adduser_result)):?>
			<?php if($adduser_result=='success'):?>
				<p>Η προσθήκη χρήστη ήταν επιτυχής!</p>
			<?php else:?>
				<p>Η προσθήκη χρήστη απέτυχε!</p>
			<?php endif;?>
		<?php endif;?>


<!-- end of page content here -->
	</div>
</div>


