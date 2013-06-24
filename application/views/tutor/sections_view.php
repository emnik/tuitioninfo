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
				top: 'center',
				closeOnClick: true
				});			

		});
			
	</script>

</head>
	
<body>

<!-- overlay content here -->

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
          <li><a href="<?php echo base_url() ?>tutor">Αρχικη</a></li>
          <li><a href="<?php echo base_url() ?>tutor/students">Μαθητες</a></li>
          <li class="selected"><a href="<?php echo base_url() ?>tutor/sections">Τμηματα</a></li>
          <li><a href="<?php echo base_url() ?>tutor/program">Προγραμμα</a></li>
          <li><a href="<?php echo base_url() ?>tutor/logout">Εξοδος</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">

        <div id="content">
        <!-- insert the page content here -->
        
	<h2> Τμήματα που αφορούν στον καθηγητή. </h2>
	
	<?php if($sections) : ?>

		<?php $i=0; //counter for sections
			  $j=0; //counter for program 
			  $k=0; //counter for students
			  $plast=count($section_program); //last key for program?>
		<table id="sections-table" class="db-table">
			<thead>
			<tr>
				<th style='width: 25px;'>Α/Α </th>
				<th>Τμήμα</th>
				<th>Τάξη</th>
				<th>Μαθήματα</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach($sections as $data) : ?>
				<?php // alternate rows ?>
					<?php if($i%2==1): ?>
						<tr class="color">
					<?php else : ?>
						<tr>
					<?php endif; ?>
					
					<td class="clickable">
						<?php echo $i+1 ?>. 
					</td>
					<td><?php echo $data['section'];?></td>
					<td><?php echo $data['class_name']; ?></td>
					<td><?php echo $data['lessons_num']; ?></td>
				</tr>
					<?php if($i%2==1):?><tr class="color invisible">
					<?php else :?><tr class="invisible">
					<?php endif; ?>

					<td>&nbsp;</td>
					<td colspan="3" style="padding:10px 16px 10px 0; border-left:0;">
						<table class="sectioninline">
							<tbody>
							<?php while($section_program[$j][0]['section'] == $data['section']):?>
								<tr>
									<td colspan="3" style="text-align:left; font-weight:bold;" >Μάθημα: <?php echo $section_program[$j][0]['title']?></td>
								</tr>
								<tr>
									<td class="sectionlefthead">Μαθητές</td>
									<td class="sectionrighthead">Πρόγραμμα</td>
									<td></td>
								</tr>
								<tr>
									<td class="sectionleft">
										<?php foreach($section_students[$j] as $student):?>
											<?php echo $student['surname']?> <?php echo $student['name']?><br>
										<? endforeach; ?>
									</td>
									<td class="sectionright">
										<table class="centeredtable">
											<tbody>
												<tr>
													<th>Ημέρα</th>
													<th>Έναρξη</th>
													<th>Λήξη</th>
													<th>Αίθουσα</th>
												</tr>
												<?php foreach($section_program[$j] as $program):?>
													<tr>
														<td><?php echo $program['day']?></td>
														<td><?php echo date('H:i',strtotime($program['start_tm']))?></td>
														<td><?php echo date('H:i',strtotime($program['end_tm']))?></td>
														<td><?php echo $program['classroom']?></td>
													</tr>
												<?php endforeach;?>


											</tbody>
										</table>
									</td>
								</tr>
								<!--just a blank row-->
								<tr><td style="height:10px;"></td></tr>										
								<?php $j++;?>
								<?php if($j == $plast){break;}?>	
								<?php endwhile;?>			
										
							</tbody>
						</table>
					</td>
				
				</tr>

				<?php $i++; ?>		
			<?php endforeach; ?>
		</tbody>
		</table>
	<?php else:?>
		<span class="error">Σφάλμα ανάκτησης δεδομένων τμημάτων!</span>
	<?php endif; ?>

<!-- end of page content here -->
	</div>
</div>

