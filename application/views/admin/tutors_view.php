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
			
			
			$(function() {
				$('div.triggers  a[rel]').overlay({
					effect: 'default',
					top: 'center',
					closeOnClick: true,
				});			
			});
		});
			
	</script>

</head>
	
<body>
<!-- overlay content here -->
<?php $tnum=count($tutors); //tutors number
	  $tpc=0; //tutors program counter
	  $tplast=count($tutors_program); //tutors program last key value ?>

<?php for($overlayitem=0; $overlayitem < $tnum; $overlayitem++):?>  
	<!-- program content here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-1";?> >
	<div class="details">
		<table class="overlay-table">
			<thead>
				<tr>
				<th>Ημέρα</th>
				<th>Έναρξη</th>
				<th>Λήξη</th>
				<th>Μάθημα</th>
				<th>Τμήμα</th>
				<th>Αίθουσα</th>
				</tr>
			</thead>
			<tbody>
			<?php while ($tutors_program[$tpc]['id']==$tutors[$overlayitem]['id']):?>
				<tr>
					<td><?php echo $tutors_program[$tpc]['day'];?></td>
					<td><?php echo date('H:i',strtotime($tutors_program[$tpc]['start_tm']));?></td>
					<td><?php echo date('H:i',strtotime($tutors_program[$tpc]['end_tm']));?></td>
					<td><?php echo $tutors_program[$tpc]['title'];?></td>
					<td><?php echo $tutors_program[$tpc]['section'];?></td>
					<td><?php echo $tutors_program[$tpc]['classroom'];?></td>
				</tr>
				<?php $tpc++ ;?>
				<?php if ($tpc == $tplast){ break;}?>			
			<?php endwhile;?>
			</tbody>
		</table>
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
          <li><a href="<?php echo base_url() ?>admin">Αρχικη</a></li>
          <li><a href="<?php echo base_url() ?>admin/students">Μαθητες</a></li>
          <li class="selected"><a href="<?php echo base_url() ?>admin/tutors">Καθηγητες</a></li>
          <li><a href="<?php echo base_url() ?>admin/sections">Τμηματα</a></li>
          <li><a href="<?php echo base_url() ?>admin/program">Προγραμμα</a></li>
          <li><a href="<?php echo base_url() ?>admin/logout">Εξοδος</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">

        <div id="content">
        <!-- insert the page content here -->
        
	<h2> Καθηγητές Φροντιστηρίου. </h2>
	
	<?php $lasttp = count($tutors_weekly_hours);?>
	<?php if($tutors) : ?>
		<?php $i=0; //counter for tutors
			  $j=0; //counter for tutors_program?>
		<table id="tutors-table" class="db-table">
			<thead>
			<tr>
				<th style='width: 25px;'>Α/Α </th>
				<th>Ονοματεπώνυμο</th>
				<th>Ειδικότητα</th>
				<th>Σταθερό τηλ.</th>
				<th style='width: 125px;'>Κινητό τηλ.</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach($tutors as $data) : ?>
				<?php // alternate rows ?>
					<?php if($i%2==1): ?>
						<tr class="color">
					<?php else : ?>
						<tr>
					<?php endif; ?>
					
					<td class="clickable">
						<?php echo $i+1 ?>. 
					</td>
					<td><?php echo $data['surname']; ?> <?php echo $data['name']; ?></td>
					<td><?php echo $data['speciality']; ?></td>
					<td><?php echo $data['home_tel']; ?></td>
					<td><?php echo $data['mobile']; ?></td>
				</tr>
					<?php if($i%2==1):?><tr class="color invisible">
					<?php else :?><tr class="invisible">
					<?php endif; ?>

					<td>&nbsp;</td>
					<td colspan="3" style="padding:10px 16px 10px 0; border-left:0;">
						<table class="studentsdetail">
							<tr>
								<td><span style="font-weight:bold;">Λεπτομέρειες</span></td>
								<td></td>
							</tr>
<!--							<tr>
								<td class="ralign">Σύντομο όνομα: </td>
								<td><?php echo $data['nickname']?> </td>
-->							</tr>
							<tr>
								<td class="ralign">Eβδομαδιαίες ώρες: </td>
								<?php if($data['id'] != $tutors_weekly_hours[$j]['id']):?>
									<td>Σφάλμα ανάκτησης δεδομένων ωρών!</td>
								<?php endif;?>		

								<?php while($data['id'] == $tutors_weekly_hours[$j]['id']):?>
									<td><?php echo $tutors_weekly_hours[$j]['weekly hours'];?></td>
									<?php $j++;?>
									<?php if($j==$lasttp):?>
										<?php break;?>
									<?php endif;?>
								<?php endwhile;?>

							</tr>
						</table>
					<td>
						<div class="triggers">
							<dl>
								<li><a href="#" rel=<?php echo "#mies-".$i."-1"?> >Πρόγραμμα</a></li>
							</dl>
						</div>	
					</td>
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

