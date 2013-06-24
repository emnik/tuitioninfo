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

	<script type="text/javascript">
		function closeWP() {
			var Browser = navigator.appName;
			var indexB = Browser.indexOf('Explorer');

			if (indexB > 0) {
				var indexV = navigator.userAgent.indexOf('MSIE') + 5;
				var Version = navigator.userAgent.substring(indexV, indexV + 1);

				if (Version >= 7) {
					window.open('', '_self', '');
					window.close();
				}
				else if (Version == 6) {
					window.opener = null;
					window.close();
				}
				else {
					window.opener = '';
					window.close();
				}
		
			}
			else {
				window.close();
			}
		}
	</script>

	<script type="text/javascript">
		function confirm_del($url) {
			if(confirm("Να γίνει διαγραφή χρήστη;")) {
				window.location.href = '<?php echo base_url()?>/admin/deluser/'+$url
				}
		}
	</script>

</head>
	
<body>
	
<div id="main">
	<div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1>Πίνακας Διαχείρισης</h1>
          <h2>Πληροφοριακό Σύστημα Φροντιστηρίου.</h2>
        </div>
      </div>


      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <li class="selected"><a href="<?php echo base_url() ?>admin/users">Χρηστες</a></li>
          <li><a href="#" onclick="closeWP();">Κλεισιμο</a></li>

        </ul>
      </div>
    </div>
    <div id="site_content">


      <div id="content">
        <!-- insert the page content here -->
		<h2>Διαχείριση χρηστών.</h2>
	
		<div class="square_button_users">
			<a href="<?php echo base_url()?>admin/adduser" rel=<?php echo "#mies-adduser"?> >
				<img src="<?php echo base_url()?>css/24_users.png" style="margin:7px 0px 0px 7px;"/>
			</a>	
		</div>			
		<p style="font-weight:bold; margin:17px 0 0 50px;">Προσθήκη νέου χρήστη<br></br></p>
		
		<?php $attributes = array('class' => 'form_settings');?>
		<?php echo form_open('admin/delete_checkbox', $attributes);?>
			
		<table class="db-table">
		<thead>
			<tr>
				<th>Επιλογή</th>
				<th>Όνομα χρήστη</th>
				<th>Oνοματεπώνυμο</th>
				<th>Ομάδα</th>
				<th>Πρόσβαση σε δεδομένα των:</th>
				<th>Ημερ. λήξης λογαριασμού</th>
				<th>Ενέργειες</th>
			</tr>
		</thead>
		<tbody>
			<?php if($users):?>
				<?php foreach($users as $user):?>
				<tr>
					<td>
						<?php $chkboxdata = array(
							 "type"=>"checkbox",
							 "name"=>"forms[]",
							 "id"=>"air",
							 "value"=> $user['id']);?> 
						<?php echo form_input($chkboxdata);?>
					</td>
					<td><?php echo $user['username']?></td>
					<td><?php echo $user['surname']?> <?php echo $user['name']?></td>
					<td><?php echo $user['groupname']?></td>
					<?php if(empty($user['members'])):?>
						<td>ΟΛΩΝ! </td>
					<?else: //the user has members ?> 
						<td>
							<?php foreach($user['members'] as $member):?>
								<?php echo $member?>
								<br/>
							<? endforeach;?>
						</td>
					<?php endif;?>
					<?php if($user['expires']=='0000-00-00'):?>
						<td>ΔΕΝ ΛΗΓΕΙ</td>
					<?php else:?> 
						<td><?php echo implode('-', array_reverse(explode('-', $user['expires'])));?></td>
					<?php endif;?>
					<td>
						<a href="<?php echo base_url()?>admin/edit_selected/<?php echo $user['id']?>">
							<img src="<?php echo base_url()?>css/16_edit.png"/>
						</a>
						<a href="#" onclick="confirm_del('<?php echo addslashes($user['id'])?>')">
							<img src="<?php echo base_url()?>css/16_trash_2.png"/>
						</a>
					</td>
				</tr>
				<?php endforeach?>
			<?php else:?>
				Σφάλμα ανάκτησης δεδομένων χρηστών!
			<?php endif;?>
		</tbody>
	</table>

	<p>
		<?php $submit = array("name" => "submit", "value" => "Διαγραφή επιλεγμένων", "class" => "submitdeluser", "id"=>"submit");?>
		<?php echo form_submit($submit);?>
	</p>
	
	<?php echo form_close();?>

		
<!-- end of page content here -->
	</div>
</div>


