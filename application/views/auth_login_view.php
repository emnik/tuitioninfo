<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Πληροφοριακό σύστημα φροντιστηρίου</title>
	<?php $theme = $this->config->item(theme);?>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500&subset=latin,greek' rel='stylesheet' type='text/css'> 
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/main.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/global.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/notify.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/slides.min.jquery.js"></script>	

	<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: '<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/img/loading.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true,
				generatePagination: true,
				effect: 'slide',
				bigTarget: true,
				animationStart: function(current){
					$('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationStart on slide: ', current);
					};
				},
				animationComplete: function(current){
					$('.caption').animate({
						bottom:0
					},200);
					if (window.console && console.log) {
						// example return of current slide number
						console.log('animationComplete on slide: ', current);
					};
				},
				slidesLoaded: function() {
					$('.caption').animate({
						bottom:0
					},200);
				}
			});
		});
	</script>

	<script>
		var myMessages = ['info','warning','error','success'];
		
		function hideAllMessages()
		{
			var messagesHeights = new Array(); // this array will store height for each
	 
			
			for (i=0; i<myMessages.length; i++)
		 	{
				messagesHeights[i] = $('.' + myMessages[i]).outerHeight(); // fill array
				$('.' + myMessages[i]).css('top', -messagesHeights[i]); //move element outside viewport	  
		 	}
		}

		function showMessage(type)
		{
			$('.'+ type +'-trigger').click(function(){
		  			hideAllMessages();				  
		  			$('.'+type).animate({top:"0"}, 500);
			});
		}


		$(document).ready(function(){
		 
			// Initially, hide them all
		 	hideAllMessages();
		 
			// Show message
		 	for(var i=0;i<myMessages.length;i++)
		 	{
				showMessage(myMessages[i]);
		 	}

		 	//Show error message if there are validation errors
		 	<?php if(validation_errors()):?>
		  		$('.info').animate({top:"0"}, 500);
		  	<?php elseif ($login_failed):?>
		  		$('.error').animate({top:"0"}, 500);
		  	<?php endif?>
		 
		 	// When message is clicked, hide it
		 	$('.message').click(function(){			  
				  $(this).animate({top: -$(this).outerHeight()}, 500);
		  	})		 
		 
		});  

	</script>




</head>
	
<body>

 <div id="main">
    
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          
          <h1><a href="<?php echo base_url() ?>index.php">Φροντιστήριο <span class="logo_colour">'σπουδή'</span></a></h1>
          <h2>Πληροφοριακό Σύστημα Φροντιστηρίου (έκδ. 1.0 beta1)</h2>

    
        </div>
<!--
        <div id="contact_details">
          <p>τηλ: 25520 24200</p>
          <p>email: info@spoudh.gr</p>
        </div>
            -->
      </div>

      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <li class="selected"><a>Καλως ηρθατε !</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">
	   
	<div class="slide_container">
	
        <!-- insert your sidebar items here -->
	<!-- 
	    <h3>Οδηγίες</h3>
        <h4>Κωδικός Πρόσβασης</h4>
        <h5>22 Ιουνίου 2012</h5>
        <p>
			Μπορείτε να προμηθευτείτε τον προσωπικό σας κωδικό πρόσβασης
			από τη γραμματεία του φροντιστηρίου. 
			<br />
			<a href="#">Περισσότερα</a>
        </p>
        <p></p>

        <h3>Χρήσιμοι σύνδεσμοι</h3>
        <ul>
          <li><a href="http://www.spoudh.gr">Φροντιστήριο 'σπουδή'</a></li>
        </ul>
    -->
    	<div id="container">
    		<div id="example">
					<!--<img src="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/img/ribbon.png" width="112" height="112" alt="New Ribbon" id="ribbon">-->
				<div id="slides">
					<div class="slides_container">
						<div class="slide">
						<img src="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/img/slide1.png" width="380" height="210" alt="Slide 1">
							<!--
							<div class="caption" style="bottom:0">
								<p>Ξεχάστε τις ατζέντες & τα σημειωματάρια!</p>
							</div>
							-->
						</div>
						<div class="slide">
						<img src="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/img/slide2.png" width="380" height="210" alt="Slide 2">
							<!--
							<div class="caption" style="bottom:0">
								<p>Ζητείστε τον κωδικό σας από τη Γραμματεία!</p>
							</div>
							-->
						</div>
						<div class="slide">
						<img src="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/img/slide3.png" width="380" height="210" alt="Slide 3">
						<!-- 
						<div class="caption" style="bottom:0">
								<p>ΥΠΟ ΚΑΤΑΣΚΕΥΗ!</p>
							</div>
						-->
						</div>
						<div class="slide">
						<img src="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/img/slide4.png" width="380" height="210" alt="Slide 3">
							<!--
							<div class="caption" style="bottom:0">
								<p>Ζητείστε τον κωδικό σας από τη Γραμματεία!</p>
							</div>		
							-->
						</div>
					</div>
					<a href="#" class="prev"><img src="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/img/arrow-prev.png" width="10" height="20" alt="Arrow Prev"></a>
					<a href="#" class="next"><img src="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/img/arrow-next.png" width="10" height="20" alt="Arrow Next"></a>
				</div>
			</div>
				<!--<img src="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/slides/img/example-frame.png" width="380" height="250" alt="Example Frame" id="frame">-->
		</div>


      </div>
    
        <!-- end of sidebar items here -->

      <div id="content">
        <!-- insert the page content here -->

		<h2> Εισαγωγή μέλους. </h2>

		<div class = "form_settings">
		<?php echo form_open('auth');?>
			<p>
				<?php echo form_label('Εισάγετε το όνομα χρήστη * :', 'username');?>
				<br />
				<div class="errors"> 
					<?php echo form_error('username');?>
				</div>
				<?php $username_input = array("name" => "username", "value" => set_value('username'), "class" => "input", "id" => "username");?>
				<?php echo form_input($username_input)?>
				
			</p>

			<p>
				<?php echo form_label('Εισάγετε τον κωδικό * :', 'password');?>
				<br />
				<div class="errors"> 
					<?php echo form_error('password');?>
				</div>
				<?php $password_input = array("name" => "password", "value" => "", "class" => "input", "id" => "password");?>
				<?php echo form_password($password_input);?>
			</p>

			<p></p>
			<p style="font-weight: bold">* Το όνομα χρήστη και ο κωδικός πρόσβασης είναι αυστηρά προσωπικά 
			και μπορείτε να τα αποκτήσετε ή/και να τα τροποποιήσετε ΜΟΝΟ 
			από τη γραμματεία του φροντιστηρίου.<a href="#"> [Περισσότερα] </a></p>

			<p style="padding-top: 15px">
			<?php $submit = array("name" => "submit", "value" => "Είσοδος", "class" => "submit");?>
			<?php echo form_submit($submit);?>
			</p>

		<?php echo form_close();?>
		</div>
		</div>

<!-- end of page content here -->

</div>

<!--if I want to trigger notifications by buttons
	   <ul id="trigger-list">
		 <li><a href="#" class="trigger info-trigger">Info</a></li>
		 <li><a href="#" class="trigger error-trigger">Error</a></li>
		 <li><a href="#" class="trigger warning-trigger">Warning</a></li>
		 <li><a href="#" class="trigger success-trigger">Success</a></li>
		</ul>
-->

<!--notification messages here-->
<div class="error message">
	<p>Τα στοιχειά σύνδεσης που εισάγατε είναι εσφαλμένα. 
		<br/>
		Σε περίπτωση που εισάγετε σωστά στοιχεία και δε μπορείτε να συνδεθείτε επικοινωνήστε με τη γραμματεία του φροντιστηρίου!</p>
</div>  

<div class="info message">
	<p>Παρακαλώ διορθώστε τα σφάλματα που επισημαίνονται πάνω από τα αντίστοιχα πεδία!</p>
</div>  
