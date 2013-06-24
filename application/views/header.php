<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Πληροφοριακό σύστημα φροντιστηρίου</title>
<?php $theme = $this->config->item(theme);?>
<!--	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500&subset=latin,greek' rel='stylesheet' type='text/css'> -->
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme;?>/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme;?>/main.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.7.2.min.js"></script>	


</head>
	
<body>
	
<div id="main">
	<div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="<?php echo base_url() ?>index.php">ΦΡΟΝΤΙΣΤΗΡΙΟ <span class="logo_colour">ΣΠΟΥΔΗ'</span></a></h1>
          <h2>Πληροφοριακό Σύστημα Φροντιστηρίου.</h2>
        </div>
        <div id="contact_details">
          <p>τηλ: 25520 24200</p>
          <p>email: info@spoudh.gr</p>
        </div>
      </div>
