<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<title>Πληροφοριακό σύστημα φροντιστηρίου.</title>
	<?php $theme = $this->config->item(theme);?>
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/main.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url() ?>css/themes/<?php echo $theme ?>/style.css" rel="stylesheet" type="text/css">

	<link href="<?php echo base_url() ?>css/tipTip.css" rel="stylesheet" type="text/css">


	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.7.2.min.js"></script>
	<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script> 
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.tipTip.minified.js"></script>



	<script type="text/javascript">

		$(document).ready(function(){

			
			$("tr.invisible").hide(); 
			$('#expand a').removeAttr('href');

	  		$("td.clickable").click(function(){
				var t=$(this).parent().next("tr");
				t.toggle();
			});							

			$('div.triggers  a[rel]').removeAttr('href');
			$('div.triggers  a[rel]').overlay({
				effect: 'default',
				top: 'center'
				});
			
			$(function(){
				$(".zoom").tipTip({maxWidth: "auto", edgeOffset: 10});
				$(".clickable").tipTip({maxWidth: "auto", edgeOffset: 10});
			});

		});
			
	</script>

	<script type="text/javascript">
		
		function not_done_yet()
		{
			alert("Η λειτουργία δεν έχει υλοποιηθεί ακόμα!");
		};

		/*
		function expand_collapse()
		{
			$('body').css('cursor', 'wait');
			setTimeout(function(){
				if ($("tr.invisible").is(':visible'))
				{
					$("tr.invisible").hide();
					document.getElementById('expand').innerHTML ="<span style='cursor:pointer;text-decoration:underline;'>[Εμφάνιση λεπτομερειών]</span>";	
				}
				else
				{
					$("tr.invisible").show();
					document.getElementById('expand').innerHTML ="<span style='cursor:pointer;text-decoration:underline;'>[Απόκρυψη λεπτομερειών]</span>";	
				};
			$('body').css('cursor', 'auto');
			},1000);
		};
		*/

		function expand_all()
		{
			$('tr.invisible').show();
		};

		function collapse_all()
		{
			$('tr.invisible').hide();
		};


		
	</script>

</head>
	
<body>

<!-- overlay content here -->
<?php $pc=0; //program counter 
	  $payc=0; //payments counter
	  $stdnum=count($students); //students number
	  $plast=count($students_program); //program's last key value
	  $paylast=count($students_payments); //payments last key value?>

<?php for($overlayitem=0; $overlayitem < $stdnum; $overlayitem++):?>  
	<!-- program content here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-1";?> >
		<?php if($students_program):?>
			<table class="overlay-table">
				<thead>
					<tr>
					<th>Ημέρα</th>
					<th>Μάθημα</th>
					<th>Έναρξη</th>
					<th>Λήξη</th>
					<th>Αίθουσα</th>
					<th>Διδάσκων</th>
					<th>Τμήμα</th>
					</tr>
					</thead>
					<tbody>
				<!--checking correct pairing via id key -->
				<?php while ($students_program[$pc]['id']==$students[$overlayitem]['id']):?>
					<tr>
						<td><?php echo $students_program[$pc]['day'];?></td>
						<td><?php echo $students_program[$pc]['title'];?></td>
						<td><?php echo date('H:i',strtotime($students_program[$pc]['start_tm']));?></td>
						<td><?php echo date('H:i',strtotime($students_program[$pc]['end_tm']));?></td>
						<td><?php echo $students_program[$pc]['classroom'];?></td>
						<td><?php echo $students_program[$pc]['nickname'];?></td>
						<td><?php echo $students_program[$pc]['section'];?></td>
					</tr>
					</tbody>
				<?php $pc++ ;?>
				<!-- if in the last entry checks again the while contition
				it'll give us an error as there  won't be such position
				in the students_program array. So we break the loop!--> 
				<?php if ($pc == $plast){ break;}?>			
			<?php endwhile;?>
			</table>
		<?php else:?>
			Σφάλμα ανάκτησης προγράμματος μαθητή!
		<?php endif;?>
	</div>
	<!-- payments content here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-2"?> >
		<?php if($students_program):?>
			<table class="overlay-table">
				<thead>
					<tr>
					<th>Αρ. ΑΠΥ</th>
					<th>Ημερομηνία</th>
					<th>Ποσό</th>
					<th>Μήνας</th>
					</tr>
				</thead>
				<tbody>
					<!--checking correct pairing via id key -->
					<?php while ($students_payments[$payc]['id']==$students[$overlayitem]['id']):?>
						<tr>
							<td><?php echo $students_payments[$payc]['apy_no'];?></td>
							<td><?php echo implode('-', array_reverse(explode('-', $students_payments[$payc]['apy_dt'])));?></td>
							<td>
								<?php if(!empty($students_payments[$payc]['amount'])):?>
									<?php echo $students_payments[$payc]['amount'];?>
									<?php echo '€';?>
								<?php endif;?>
								<?php if($students_payments[$payc]['is_credit']=='1'):?>
									<?php echo '(ΕΠΙ ΠΙΣΤΩΣΕΙ)';?>
								<?php endif;?>
								<?php if($students_payments[$payc]['amount']=='0'):?>
									<?php echo '(ΔΩΡΕΑΝ)';?>
								<?php endif;?>
							</td>
							<td><?php echo $students_payments[$payc]['month_range'];?></td>
						</tr>
						<?php $payc++ ;?>
						<?php /* if in the last entry checks again the while contition
						it'll give us an error as there  won't be such position
						in the students_program array. So we break the loop! */ ?>
						<?php if ($payc == $paylast){ break;}?>			
					<?php endwhile;?>
				</tbody>
			</table>
		<?php else:?>
			Σφάλμα ανάκτησης δεδομένων αποδείξεων μαθητή!
		<?php endif;?>
	</div>
	<!-- progress content here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-3"?> >
		<div class="details">
			<h3>Η λειτουργία της ενημέρωσης προόδου δεν έχει υλοποιηθεί ακόμη.</h3>
		</div>
	</div>
	<!-- absences content here -->
	<div class="simple_overlay" id=<?php echo "mies-".$overlayitem."-4"?> >
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
          <li><a href="<?php echo base_url() ?>admin">Αρχικη</a></li>
          <li class="selected"><a href="<?php echo base_url() ?>admin/students">Μαθητες</a></li>
          <li><a href="<?php echo base_url() ?>admin/tutors">Καθηγητες</a></li>
          <li><a href="<?php echo base_url() ?>admin/sections">Τμηματα</a></li>
          <li><a href="<?php echo base_url() ?>admin/program">Προγραμμα</a></li>
          <li><a href="<?php echo base_url() ?>admin/logout">Εξοδος</a></li>
        </ul>
      </div>
    </div>
    <div id="site_content">

        <div id="content">
        <!-- insert the page content here -->
        
	<h2> Μαθητές Φροντιστηρίου </h2>
	
	<?php if($students) : ?>
		<h1> Σχολικό έτος: <?php echo $schoolyear ?></h1>
		<!--<div id="expand" onclick="expand_collapse();"> <span style="cursor:pointer;text-decoration:underline;">[Eμφάνιση λεπτομερειών]</span></div>-->
		<div id="expand"> 
			<span style="cursor:pointer;">
				[<a href="#" onclick="expand_all();">Ανάπτυξη</a> | <a href="#" onclick="collapse_all();">Σύμπτυξη</a>]
			</span>
		</div>
		<?php $i=0; //counter for students, details
			  $j=0; //counter for payments
			  $k=0; //counter for debt ?>
		<table id="students-table" class="db-table">
			<thead>
			<tr>
				<th width=25px>Α/Α</th>
				<th width=150px>Ονοματεπώνυμο</th>
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
					
					<td class="clickable" title="click για εμφάνιση/απόκρυψη λεπτομερειών.">
						<?php echo $i+1 ?>. 
					</td>
					<td><?php echo $data['surname']; ?> <?php echo $data['name']; ?></td>
					<td><?php echo $data['class']; ?></td>
					<td><?php echo $data['course']; ?></td>
					<td style="cursor:default;" class="zoom" title="<span style='font-size:20px;'><?php echo $data['home_tel'];?></span>"><?php echo $data['home_tel']; ?></td>
					<td style="cursor:default;"  class="zoom" title="<span style='font-size:20px;'><?php echo $data['std_mobile'];?></span>"><?php echo $data['std_mobile']; ?></td>
					<td><?php echo $data['fathers_name']; ?></td>
					<td style="cursor:default;"  class="zoom" title="<span style='font-size:20px;'><?php echo $data['fathers_mobile'];?></span>"><?php echo $data['fathers_mobile']; ?></td>
					<td><?php echo $data['mothers_name']; ?></td>
					<td style="cursor:default;"  class="zoom" title="<span style='font-size:20px;'><?php echo $data['mothers_mobile'];?></span>"><?php echo $data['mothers_mobile']; ?></td>
				</tr>
					<?php if($i%2==1):?><tr class="color invisible">
					<?php else :?><tr class="invisible">
					<?php endif; ?>

					<td>&nbsp;</td>
					<td colspan="7" style="padding:10px 16px 10px 0; border-left:0;">
						<table class="studentsdetail">
							<tr>
								<td><span style="font-weight:bold;">Λεπτομέρειες</span></td>
								<td></td>
							</tr>
							
								<tr>
									<td class="ralign">Διεύθυνση κατοικίας: </td>
									<td><?php echo $data['address']?></td>
								</tr>	
								<tr>
									<td class="ralign">Τηλέφωνο εργασίας:</td>
									<td><?php echo $data['work_tel']?></td>
								</tr>
								<tr>
									<td class="ralign">Αρ. μαθητολογίου:</td>
									<td><?php echo $data['std_book_no']?></td>
								</tr>
								<?php // convert date formating: yyyy-mm-dd -> dd-mm-yyyy: implode('-', array_reverse(explode('-', $date))) ?>
								<tr>
									<td class="ralign">Ημερομηνία έναρξης:</td>
									<td><?php echo implode('-', array_reverse(explode('-', $data['start_lessons_dt'])))?></td>
								</tr>
								<tr>
									<td class="ralign">Ημερομηνία διαγραφής:</td>
									<td><?php echo implode('-', array_reverse(explode('-', $data['del_lessons_dt'])))?></td>
								</tr>
								<tr>
									<td class="ralign">Μηνιαία δίδακτρα:</td>
									<td>
										<?php echo $data['month_price']?> €
										<?php if($data['month_price']=='0'):?>
											<?php echo '(ΔΩΡΕΑΝ)';?>
										<?php endif;?>						
									</td>
									
								</tr>
								<?php if($students_pay_summary): ?>
									<?php if($data['id']==$students_pay_summary[$j]['id']): ?>
										<tr>
											<td class="ralign">Εξοφλημένοι μήνες: </td>	
											<td><?php echo $students_pay_summary[$j]['pay_summary']?> </td>
										</tr>
										<?php $j++; ?>									
									<?php else: ?>
										<tr>
											<!--if month_price=0 then we intentionally have no payment data
											and if start_lesson_dt = del_lesson_dt we logically have no payments data!
											In both occassions we show no error message but a '-' -->
											<td class="ralign">Εξοφλημένοι μήνες: </td>	
											<!--
											<?php if($data['month_price'] == '0'  or  $data['start_lessons_dt'] == $data['del_lessons_dt']):?>
												<td> - </td>
											<?php else:?>											
												<td>Σφάλμα στην αντιστοίχιση οικονομικών δεδομένων!</td>
											<?php endif;?>
											-->
											<td>0</td>
										</tr>
									<?php endif;?>
								<?php else:?>
									<tr>
										<td class="ralign">Εξοφλημένοι μήνες: </td>	
										<!--Σφάλμα στην ανάκτηση οικονομικών δεδομένων!-->
										<td>0</td>
									</tr>
								<?php endif;?>	
								
								<?php if($students_debt_summary): ?>
									<?php if($data['id']==$students_debt_summary[$k]['id']):?>
										<tr>
											<td class="ralign">Οφειλόμενοι μήνες: </td>
											<td><?php echo $students_debt_summary[$i]['debt_summary']?> </td>
										</tr>
										<?php $k++;?>
									<?php else: ?>
										<tr>
											<td class="ralign">Οφειλόμενοι μήνες: </td>
											<td>Σφάλμα στην αντιστοίχιση οικονομικών δεδομένων!</td>
										</tr>
									<?php endif;?>
								<?php else:?>
									<tr>
										<td class="ralign">Οφειλόμενοι μήνες: </td>	
										<td>Σφάλμα στην ανάκτηση οικονομικών δεδομένων!</td>
									</tr>
								<?php endif;?>
							</table>
						<td colspan="2">
							<div class="triggers">
								<dl>
									<li><a href="#" rel=<?php echo "#mies-".$i."-1"?> >Πρόγραμμα</a></li>
									<li><a href="#" rel=<?php echo "#mies-".$i."-2"?> >Πληρωμές</a></li>

									<li><a href="#" onclick="not_done_yet(); return false">Πρόοδος</a></li>
									<li><a href="#" onclick="not_done_yet(); return false">Απουσίες</a></li>
									<!--
									<li><a href="#" rel=<?php echo "#mies-".$i."-3"?> >Πρόοδος</a></li>
									<li><a href="#" rel=<?php echo "#mies-".$i."-4"?> >Απουσίες</a></li>
									-->
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

