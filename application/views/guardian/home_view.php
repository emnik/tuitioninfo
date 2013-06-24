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
	<script type="text/javascript">
		function not_done_yet()
		{
			alert("Η λειτουργία δεν έχει υλοποιηθεί ακόμα!");
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
          <li class="selected"><a href="<?php echo base_url() ?>parent">Προφιλ</a></li>
          <li><a href="<?php echo base_url() ?>parent/program">Προγραμμα</a></li>
          <li><a href="#" onclick="not_done_yet()">Προοδος</a></li>
          <li><a href="#" onclick="not_done_yet()">Απουσιες</a></li>
          <li><a href="<?php echo base_url() ?>parent/fees">Διδακτρα</a></li>
          <li><a href="<?php echo base_url() ?>parent/logout">Εξοδος</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">

      <div class="sidebar">
        <!-- insert your sidebar items here -->
        
        <h4>Σύνδεση ως: </h4>
		<h5><?php echo $guardian_details['surname'].' '.$guardian_details['name'];?></h5>
              
      </div>
        <!-- end of sidebar items here -->

      <div id="content">
        <!-- insert the page content here -->


		<?php if($guardian_details):?>
			<h4>
				Στοιχεία κηδεμόνων :
			</h4>
		<?php endif;?>
		
		<?php if($guardian_profile):?>
			<table class="studentsdetail">
				<?php foreach($guardian_profile as $data):?>
					<tr>
						<td class="ralign">Πατρώνυμο:</td>
						<td><?php echo $data['fathers_name'];?></td>
					</tr>
					<tr>
						<td class="ralign">Κινητό τηλέφωνο πατέρα:</td>
						<td><?php echo $data['fathers_mobile'] ?></td>
					</tr>
					<tr>
						<td class="ralign">Μητρώνυμο:</td>
						<td><?php echo $data['mothers_name'];?></td>
					</tr>
					<tr>
						<td class="ralign">Κινητό τηλέφωνο μητέρας:</td>
						<td><?php echo $data['mothers_mobile'] ?></td>
					</tr>
					<tr>
						<td class="ralign">Διέυθυνση:</td>
						<td><?php echo $data['address'] ?></td>
					</tr>
					<tr>
						<td class="ralign">Τηλέφωνο σπιτιού:</td>
						<td><?php echo $data['home_tel'] ?></td>
					</tr>
					<tr>
						<td class="ralign">Τηλέφωνο εργασίας:</td>
						<td><?php echo $data['work_tel'] ?></td>
					</tr>
				<?php endforeach ?>
				
			</table>
		<?php else:?>
				<p>Σφάλμα ανάκτησης δεδομένων κηδεμόνα!</p>
		<?php endif;?>

		<div style="margin-top:20px;float:left;">			
			<h4>Έχετε πρόσβαση στα δεδομένα που αφορούν τους:</h4>

				<ul>				
				<?php foreach ($guardian_members as $member):?>
							<li><?php echo $member['surname'].' '.$member['name'];?></li>
				<?php endforeach;?>
				</ul>
		</div>

<!-- end of page content here -->
	</div>
</div>


