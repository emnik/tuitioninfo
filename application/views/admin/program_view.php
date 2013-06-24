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

	<script type="text/javascript">
		
		$(document).ready(function(){
			
			$("tr.invisible").hide(); 
	  		$("td.clickable").click(function(){
				$(this).parent().next("tr").toggle();
			});							

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
          <li><a href="<?php echo base_url() ?>admin">Αρχικη</a></li>
          <li><a href="<?php echo base_url() ?>admin/students">Μαθητες</a></li>
          <li><a href="<?php echo base_url() ?>admin/tutors">Καθηγητες</a></li>
          <li><a href="<?php echo base_url() ?>admin/sections">Τμηματα</a></li>
          <li class="selected"><a href="<?php echo base_url() ?>admin/program">Προγραμμα</a></li>
          <li><a href="<?php echo base_url() ?>admin/logout">Εξοδος</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">

        <div id="content">
        <!-- insert the page content here -->
        
	<h2> Πρόγραμμα Φροντιστηρίου. </h2>
	
	<?php if($program) : ?>

		<?php $i=0; //counter for program
			  $j=0; //counter for details 
			  $plast=count($program_details); //last key for details?>
		<table id="program-table" class="db-table">
			<thead>
			<tr>
				<th style='width: 25px;'>Α/Α </th>
				<th>Ημέρα</th>
				<th>Έναρξη</th>
				<th>Λήξη</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach($program as $data) : ?>
				<?php // alternate rows ?>
					<?php if($i%2==1): ?>
						<tr class="color">
					<?php else : ?>
						<tr>
					<?php endif; ?>
					
					<td class="clickable">
						<?php echo $i+1 ?>. 
					</td>
					<td><?php echo $data['day'];?></td>
					<td><?php echo date('H:i',strtotime($data['start'])); ?></td>
					<td><?php echo date('H:i',strtotime($data['end'])); ?></td>
				</tr>
					<?php if($i%2==1):?><tr class="color invisible">
					<?php else :?><tr class="invisible">
					<?php endif; ?>

					<td>&nbsp;</td>
					<td colspan="3" style="padding:10px 16px 10px 0; border-left:0;">
						<table class="sectionsdetail">
							<thead>
								<tr>
									<th>Έναρξη</th>
									<th>Λήξη</th>
									<th>Διδ. ώρες</th>
									<th>Μάθημα</th>
									<th>Τμήμα</th>
									<th>Καθηγητής</th>
									<th>Αίθουσα</th>
								</tr>
							</thead>
							<tbody>
								<?php if($program_details[$j]): ?>
									<?php while($data['day']==$program_details[$j]['day']):?>
										<tr>
											<td><?php echo date('H:i',strtotime($program_details[$j]['start_tm']))?></td>
											<td><?php echo date('H:i',strtotime($program_details[$j]['end_tm']))?></td>
											<td><?php echo $program_details[$j]['duration']?></td>
											<td><?php echo $program_details[$j]['title']?></td>
											<td><?php echo $program_details[$j]['section']?></td>
											<td><?php echo $program_details[$j]['surname']?> <?php echo $program_details[$j]['name']?></td>
											<td><?php echo $program_details[$j]['classroom']?></td>
										<?php $j++; ?>	
										<?php if($j==$plast){break;}?>								
									<?php endwhile;?>
								<?php else:?>
									<tr>
										<td colspan='7'>Σφάλμα στην ανάκτηση δεδομένων προγράμματος!</td>
									</tr>
								<?php endif;?>	
							</tbody>
						</table>
					</td>
				</tr>
				<?php $i++; ?>		
			<?php endforeach; ?>
		</tbody>
		</table>
	<?php else:?>
		<span class="error">Σφάλμα ανάκτησης συγκεντρωτικών δεδομένων προγράμματος!</span>
	<?php endif; ?>

<!-- end of page content here -->
	</div>
</div>

