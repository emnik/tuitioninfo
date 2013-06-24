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

			
			//$("tr.invisible").hide(); 
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
	<script type="text/javascript">
		function not_done_yet()
		{
			alert("Η λειτουργία δεν έχει υλοποιηθεί ακόμα!");
		}
	</script>
</head>
	
<body>

<!-- overlay content here -->
<?php $stdnum=count($member_fees_basics); //members number ?>

<?php for($overlayitem=0; $overlayitem < $stdnum; $overlayitem++):?>  
	<!-- payments analysis here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-1"?> >
		<div class="details">
		<?php if($member_pay_analysis):?>
			<table class="overlay-table">
				<thead>
					<tr>
						<th>Ημερομηνία πληρωμής</th>
						<th>ΑΠΥ Νο</th>
						<th>Ποσό πληρωμής</th>
						<th>Μήνας πληρωμής</th>
					</tr>
				</thead>
				<tbody>
				<?php if($member_pay_analysis[$overlayitem]):?>
				<?php foreach($member_pay_analysis[$overlayitem] as $pay_data):?>
					<tr>
						<td><?php echo implode('-', array_reverse(explode('-', $pay_data['apy_dt'])))?></td>
						<td><?php echo $pay_data['apy_no'];?></td>
						<td><?php echo $pay_data['amount'];?> €</td>
						<td><?php echo $pay_data['month_range'];?></td>
					</tr>
			<?php endforeach;?>					
					</tbody>
				<?php endif;?>
			</table>
		<?php else:?>
			Σφάλμα ανάκτησης δεδομένων πληρωμών!
		<?php endif;?>
		</div>
	</div>
	<!-- debt analysis here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-2"?> >
		<div class="details">
		<?php if($member_debt_analysis):?>
			<table class="overlay-table">
				<thead>
					<tr>
						<th>A/A</th>
						<th>Μήνας οφειλής</th>
						<th>Ποσό οφειλής</th>
					</tr>
				</thead>
				<tbody>
				<?php if($member_debt_analysis[$overlayitem]):?>
				<?php $debtc=1;?>
				<?php foreach($member_debt_analysis[$overlayitem] as $debt_data):?>
					<tr>
						<td><?php echo $debtc;?></td>
						<td><?php echo $debt_data['month_num'];?></td>
						<td><?php echo $debt_data['amount'];?> €</td>
					</tr>
					<?php $debtc++;?>
			<?php endforeach;?>					
					</tbody>
				<?php endif;?>
			</table>
		<?php else:?>
			Σφάλμα ανάκτησης δεδομένων οφειλών!
		<?php endif;?>
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
          <li><a href="<?php echo base_url() ?>parent">Προφιλ</a></li>
          <li><a href="<?php echo base_url() ?>parent/program">Προγραμμα</a></li>
          <li><a href="#" onclick="not_done_yet()">Προοδος</a></li>
          <li><a href="#" onclick="not_done_yet()">Απουσιες</a></li>
          <li class="selected"><a href="<?php echo base_url() ?>parent/fees">Διδακτρα</a></li>
          <li><a href="<?php echo base_url() ?>parent/logout">Εξοδος</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">

        <div id="content">
        <!--insert the page content here-->
        
	<h2>Οικονομικά.</h2>
	<?php $debtsum=0;?>
	<?php if($member_fees_basics):?>
		<?php $i=0; //counter for students, details ?>
		<table id="students-table" class="db-table">
			<thead>
			<tr>
				<th style="width:25px;">Α/Α</th>
				<th style="width:275px;">Ονοματεπώνυμο</th>
				<th>Έναρξη μαθημάτων</th>
				<th>Τιμή μήνα</th>
			</tr>
			</thead>
			<tbody>
				<?php foreach($member_fees_basics as $data) : ?>
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
					<td><?php echo implode('-', array_reverse(explode('-', $data['start_lessons_dt'])))?></td>
					<td><?php echo $data['month_price'];?> €</td>
				</tr>
					<?php if($i%2==1):?><tr class="color invisible">
					<?php else :?><tr class="invisible">
					<?php endif; ?>

					<td>&nbsp;</td>
					<td colspan="2" style="padding:10px 16px 10px 0; border-left:0;">
						<table class="studentsdetail">
							<?php if($member_pay_summary):?>
								<tr>
									<td class="ralign">Εξοφλημένοι μήνες:</td>
									<td><?php echo $member_pay_summary[$i][0]['pay_summary']?></td>
								</tr>
							<?php else:?>
								<tr>
									<td class="ralign">Εξοφλημένοι μήνες:</td>
									<td>Σφάλμα ανάκτησης οικονομικών συγκεντρωτικών δεδομένων εξόφλησης!</td>
								</tr>
							<?php endif;?>
							<?php if($member_debt_summary):?>
								<tr>
									<td class="ralign">Οφειλόμενοι μήνες:</td>
									<td><?php echo $member_debt_summary[$i][0]['debt_summary'];?></td>
								</tr>
								<tr>
									<td class="ralign">Οφειλή:</td>
									<td><?php echo $member_debt_summary[$i][0]['fee'];?> €</td>
									<?php $debtsum = $debtsum + $member_debt_summary[$i][0]['fee'];?>
								</tr>
							<? else:?>
								<tr>
									<td class="ralign">Οφειλές:</td>
									<td>Σφάλμα ανάκτησης οικονομικών συγκεντρωτικών δεδομένων οφειλών!</td>
								</tr>
							<? endif;?>
						</table>
						<td>
							
							<div class="triggers">
								<dl>
									<li><span style="font-weight:bold;">Ανάλυση</span></li>
									<li><a href="#" rel=<?php echo "#mies-".$i."-1";?> >Πληρωμών</a></li>
									<li><a href="#" rel=<?php echo "#mies-".$i."-2";?> >Οφειλών</a></li>
								</dl>
							</div>	
						</td>
					</tr>
				<?php $i++; ?>		
			<?php endforeach; ?>
			<tr>
				<td colspan=4>
					<span style="text-align:left; display:block; font-weight:bold;">Συνολική Οφειλή: <?php echo $debtsum ?> € </span>
				</td>
			</tr>
		</tbody>
		</table>
	<?php else:?>
		<span class="error">Σφάλμα ανάκτησης δεδομένων !</span>
	<?php endif; ?>

<!-- end of page content here -->
	</div>
</div>

