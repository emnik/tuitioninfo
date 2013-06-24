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
          <li class="selected"><a href="<?php echo base_url() ?>tutor">Προφίλ</a></li>
          <li><a href="<?php echo base_url() ?>tutor/students">Μαθητες</a></li>
          <li><a href="<?php echo base_url() ?>tutor/sections">Τμηματα</a></li>
          <li><a href="<?php echo base_url() ?>tutor/program">Προγραμμα</a></li>
          <li><a href="<?php echo base_url() ?>tutor/logout">Εξοδος</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">

      <div id="content">
        <!-- insert the page content here -->

		<?php if($tutor_profile):?>
			<table class="studentsdetail">
				<?php foreach($tutor_profile as $data):?>
					<tr>
						<td class="ralign">Ονοματεπώνυμο:</td>
						<td style="font-weight:bold;"><?php echo $data['surname']?> <?php echo $data['name'] ?></td>
					</tr>
					<tr>
						<td class="ralign">Ειδικότητα:</td>
						<td><?php echo $data['speciality'] ?></td>
					</tr>
					<tr>
						<td class="ralign">Τηλέφωνο σπιτιού:</td>
						<td><?php echo $data['home_tel'] ?></td>
					</tr>
					<tr>
						<td class="ralign">Κινητό τηλέφωνο:</td>
						<td><?php echo $data['mobile'] ?></td>
					</tr>
				<?php endforeach ?>
				<?php if($tutor_hours):?>
					<tr>
						<td class="ralign">Εβδομαδιαίες ώρες:</td>
						<td><?php echo $tutor_hours[0]['weekly hours']?></td>
					</tr>
				<?php else:?>
					<tr>
						<td class="ralign">Εβδομαδιαίες ώρες:</td>
						<td>Σφάλμα ανάκτησης ωρών καθηγητή!</td>
					</tr>
				<?php endif;?>
			</table>
		<?php else:?>
				<p>Σφάλμα ανάκτησης δεδομένων προφίλ καθηγητή!</p>
		<?php endif;?>

<!-- end of page content here -->
	</div>
</div>


