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

<?php $snum = count($sections_details);?>

<?php for($overlayitem=0; $overlayitem < $snum; $overlayitem++):?>  
	<!-- section students content here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-1";?> >
	<?php if($sections_students):?>
		<table class="overlay-table">
			<thead>
				<tr>
				<th>Ονοματεπώνυμο</th>
				<th>Σταθερό τηλ.</th>
				<th>Κινητό τηλ.</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($sections_students[$overlayitem] as $section_students_data):?>
					<tr>
						<td><?php echo $section_students_data['surname'];?> <?php echo $section_students_data['name'];?></td>
						<td><?php echo $section_students_data['home_tel'];?></td>
						<td><?php echo $section_students_data['std_mobile'];?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php else:?>
		Σφάλμα ανάκτησης δεδομένων μαθητών τμήματος!
	<?php endif;?>
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
          <li><a href="<?php echo base_url() ?>admin">Αρχικη</a></li>
          <li><a href="<?php echo base_url() ?>admin/students">Μαθητες</a></li>
          <li><a href="<?php echo base_url() ?>admin/tutors">Καθηγητες</a></li>
          <li class="selected"><a href="<?php echo base_url() ?>admin/sections">Τμηματα</a></li>
          <li><a href="<?php echo base_url() ?>admin/program">Προγραμμα</a></li>
          <li><a href="<?php echo base_url() ?>admin/logout">Εξοδος</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">

        <div id="content">
        <!-- insert the page content here -->
        
	<h2> Τμήματα Φροντιστηρίου. </h2>
	
	<?php if($sections) : ?>

		<?php $i=0; //counter for sections
			  $j=0; //counter for details 
			  $dlast=count($sections_details); //last key for details?>
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
						<table class="sectionsdetail">
							<thead>
								<tr>
									<th>Μάθημα</th>
									<th>Ημέρα</th>
									<th>Έναρξη</th>
									<th>Λήξη</th>
									<th>Αίθουσα</th>
									<th>Καθηγητής</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php if($sections_details[$j]): ?>
									<?php while($data['section']==$sections_details[$j]['section']):?>
										<tr>
											<td><?php echo $sections_details[$j]['title']?></td>
											<td><?php echo $sections_details[$j]['day']?></td>
											<td><?php echo date('H:i',strtotime($sections_details[$j]['start_tm']))?></td>
											<td><?php echo date('H:i',strtotime($sections_details[$j]['end_tm']))?></td>
											<td><?php echo $sections_details[$j]['classroom']?></td>
											<td><?php echo $sections_details[$j]['surname']?> <?php echo $sections_details[$j]['name']?></td>
											<td>
												<div class="triggers">
													<dl>
														<li><a href="#" rel=<?php echo "#mies-".$j."-1"?> >Μαθητές</a></li>
													</dl>
												</div>
											</td>
										<?php $j++; ?>	
										<?php if($j==$dlast){break;}?>								
									<?php endwhile;?>
								<?php else:?>
									<tr>
										<td colspan='7'>Σφάλμα στην ανάκτηση δεδομένων μαθήματος!</td>
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
		<span class="error">Σφάλμα ανάκτησης δεδομένων τμημάτων!</span>
	<?php endif; ?>

<!-- end of page content here -->
	</div>
</div>

