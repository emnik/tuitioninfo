<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<title>Πληροφοριακό σύστημα φροντιστηρίου.</title>
	<?php $theme = $this->config->item(theme);?>
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/main.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/style.css" rel="stylesheet" type="text/css">


	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.7.2.min.js"></script>
	<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script> 


	<script type="text/javascript">

		$(document).ready(function(){

			
			$("tr.invisible").hide(); 
	  		$("td.clickable").click(function(){
				$(this).parent().next("tr").toggle();
			});							

			$('div.triggers  a[rel]').removeAttr('href');
			$('div.triggers  a[rel]').overlay({
				effect: 'default',
				top: 'center'
				});
			
		});
			
	</script>

</head>
	
<body>

<!-- overlay content here -->
<?php $stdnum=count($students); //students number ?>

<?php for($overlayitem=0; $overlayitem < $stdnum; $overlayitem++):?>  
	<!-- progress content here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-1"?> >
		<div class="details">
			<h3>Η λειτουργία της ενημέρωσης προόδου δεν έχει υλοποιηθεί ακόμη.</h3>
		</div>
	</div>
	<!-- absences content here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-2"?> >
		<div class="details">
			<h3>Η λειτουργία της ενημέρωσης απουσιών δεν έχει υλοποιηθεί ακόμη.</h3>
		</div>
	</div>
<?php endfor;?>

<!-- end of overlay content here -->




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
          <li><a href="<?php echo base_url() ?>tutor">Προφιλ</a></li>
          <li class="selected"><a href="<?php echo base_url() ?>tutor/students">Μαθητες</a></li>
          <li><a href="<?php echo base_url() ?>tutor/sections">Τμηματα</a></li>
          <li><a href="<?php echo base_url() ?>tutor/program">Προγραμμα</a></li>
          <li><a href="<?php echo base_url() ?>tutor/logout">Εξοδος</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">

        <div id="content">
        <!-- insert the page content here -->
        
	<h2> Μαθητές που αφορούν στον καθηγητή. </h2>
		
	<?php if($students) : ?>
		<?php $i=0; //counter for students, details
			  $j=0; //counter for payments
			  $k=0; //counter for debt ?>
		<table id="students-table" class="db-table">
			<thead>
			<tr>
				<th style="width:25px;">Α/Α</th>
				<th>Ονοματεπώνυμο</th>
				<th>Τάξη</th>
				<th>Κατεύθυνση</th>
				<th>Σταθερό τηλ.</th>
				<th>Κινητό τηλ.</th>
				<th>Πατρώνυμο</th>
				<th>Τηλ. πατέρα</th>
				<th>Μητρώνυμο</th>
				<th>Τηλ. μητέρας</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach($students as $data) : ?>
				<?php // alternate rows ?>
					<?php if($i%2==1): ?>
						<tr class="color">
					<?php else : ?>
						<tr>
					<?php endif; ?>
					
					<td class="clickable">
						<?php echo $i+1 ?>. 
					</td>
					<td style="width:120px;"><?php echo $data['surname']; ?> <?php echo $data['name']; ?></td>
					<td><?php echo $data['class_name']; ?></td>
					<td><?php echo $data['course']; ?></td>
					<td><?php echo $data['home_tel']; ?></td>
					<td><?php echo $data['std_mobile']; ?></td>
					<td><?php echo $data['fathers_name']; ?></td>
					<td><?php echo $data['fathers_mobile']; ?></td>
					<td><?php echo $data['mothers_name']; ?></td>
					<td><?php echo $data['mothers_mobile']; ?></td>
				</tr>
					<?php if($i%2==1):?><tr class="color invisible">
					<?php else :?><tr class="invisible">
					<?php endif; ?>

					<td>&nbsp;</td>
					<!-- if I'll enable the overlay buttons (πρόοδος, απουσίες), colspan will be: 7 -->
					<td colspan="9" style="padding:10px 16px 10px 0; border-left:0;">
						<table class="studentsdetail">
							<tr>
								<td><span style="font-weight:bold;">Μάθημα</span></td>
								<td style="width:15px;"></td>
								<td><span style="font-weight:bold;">Τμήμα</span></td>
							</tr>
							<?php if($students_details):?>
								<?php foreach($students_details[$i] as $details):?>
									<tr>
										<td><?php echo $details['title']?></td>
										<td></td>
										<td><?php echo $details['section']?></td>
									</tr>
								<?php endforeach;?>
							<? else:?>
								<tr>
									<td class="ralign">Μαθήματα / Τμήματα:</td>
									<td>Σφάλμα ανάκτησης δεδομένων!</td>
								</tr>
							<? endif;?>
						</table>
						<!--
						<td colspan="2">
							<div class="triggers">
								<dl>
									<li><a href="#" rel=<?php echo "#mies-".$i."-1"?> >Πρόοδος</a></li>
									<li><a href="#" rel=<?php echo "#mies-".$i."-2"?> >Απουσίες</a></li>
								</dl>
							</div>	
						</td>
						-->
					</tr>
				<?php $i++; ?>		
			<?php endforeach; ?>
		</tbody>
		</table>
	<?php else:?>
		<span class="error">Σφάλμα ανάκτησης δεδομένων !</span>
	<?php endif; ?>

<!-- end of page content here -->
	</div>
</div>

