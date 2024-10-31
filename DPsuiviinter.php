<?php
	include('header.php');
	
	if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']))
	{
		echo '<script>
		  document.location.href="./index.php";
		</script>';
	}
	$UserInfo = $db->query("Select * FROM accounts WHERE steamid = :user AND job = :job", Array('user' => $_SESSION['T2SteamID64'], 'job' => 'depanneur'));
	
	if(isset($UserInfo[0]) && (isset($UserInfo[0]['job']) && $UserInfo[0]['job'] == 'depanneur' || $UserInfo[0]['admin'] == 1))
	{
		if(isset($_POST) && !empty($_POST))
		{
			$db->query("UPDATE `facture` SET `paid` = :paid WHERE id = :id", Array('id' => $_POST['action'], 'paid' => $_POST['paid'] == 1 ? 0 : 1));
		}
		?>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<style>
			table, td, th{
				border: 1px solid black;
			}
			table{
				border-collapse:collapse;
				table-layout: fixed;
				width: 90%;
			}
			th{
				background: rgba(0,0,0,0.05);
				color: red;
			}
			#center{
				width: 40%;
				min-width: 30%;
				text-align: center;
				margin: auto;
				background: rgba(0,0,0,0.05);
			}
			form{
				text-align: left;
			}
			.red{
				color: red;
			}
			th, td{
				text-align:center;
			}
			#research{
				width:70%;
				margin:auto;
				text-align:center;
			}
		</style>
	</head>
	<body>
	<div id="research">
    <form style="display: grid;" action="" method="GET">
	Nom de famille: <input type="text" name="name"/><br/>
	<input type="submit" value="Recherché"/>

	

</form>
<br/><br/></div>
		<table>
			<thead>
				<tr>
					<th>
						Date   
					</th>
					<th>
						Dépanneur   
					</th>
					<th>
						Client   
					</th>
					<th>
						Plaque     
					</th>
					<th>
						Paiement   
					</th>
					<th>
						Total
					</th>
					<th>
						Action
					</th>
					<th>
					 	Modifier
					</th>
				</tr>
			</thead>
			<?php
			$users = array();
			if(isset($_GET['name']) && !empty($_GET['name']))
				$users = $db->query("select * FROM facture where `client` like CONCAT('%',:name,'%')", Array('name' => $_GET['name']));
			{
				?>
				
				<?php
				for ($i = 0; $i < count($users); $i++)
				{
					if(isset($_GET['name']))
						$action = "DPsuiviinter.php?name=".$_GET['name'];
					else
						$action = "DPsuiviinter.php";
					$details = '';
					echo '<tr>
						<td>' . $users[$i]['horodateur'] . '</td>
						<td>' . $users[$i]['agent'] . '</td>
						<td>' . $users[$i]['client'] . '</td>
						<td>' . $users[$i]['plaque'] . '</td>
						<td>' . ($users[$i]['paid'] == 0 ? 'Non payé' : 'Payé') . '</td>  
						<td>' . $users[$i]['prix'] . '</td>
						<td>' . ($users[$i]['paid'] == 0 ? '<form name="facture" method="POST" action="'.$action.'"><input name="action" value="'.$users[$i]['id'].'" hidden="hidden">
						<input name="paid" value="'.$users[$i]['paid'].'" hidden="hidden">
						<input type="submit" value="Somme Régler"/></form>' : '') . '</td>
					</tr>';
				}
				?>
				</tfoot>
				<?php
			}
		echo '</table>';
	?>


    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>


    <!-- Main JS-->
    <script src="js/global.js"></script>

	<?
	}
	else
		echo '<script>
		  document.location.href="./index.php";
		</script>';
include('footer.php');
