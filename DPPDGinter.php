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
			$db->query("UPDATE `accounts` SET `grade` = :grade WHERE id = :id", Array('id' => $_POST['action'], 'grade' => $_POST['grade'] == 'employer' ? null : 'employer'));
		}
		?>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
		<style>
			table, td, th{
				border: 1px solid black;
			}
			table{
				border-collapse:collapse;
				table-layout: fixed;
				width: 100%;
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
				width:100%;
				margin:auto;
				text-align:center;
			}
		</style>
	</head>
	<body>



	<br/><br/></div>
		<table>
			<thead>
				<tr>
					<th>
						Date
					</th>
					<th>
						Agent
					</th>
					<th>
						Client
					</th>
					<th>
						Plaque
					</th>
					<th>
						Prix
					</th>
					<th>
						Intervention
					</th>
				</tr>
			</thead>
			<?php
			$users = array();
			if(isset($_GET['paid']) && !empty($_GET['paid']))
				$users = $db->query("SELECT s.*, GROUP_CONCAT(`name`) AS concat_titre
FROM interventiondata, intervention, facture s
WHERE intervention.id = interventiondata.intervention and s.intervention = interventiondata.dataindex
AND paid = :paid GROUP BY dataindex", Array('paid' => $_GET['paid']));
			{
				?>

				<?php
				for ($i = 0; $i < count($users); $i++)
				{
					if(isset($_GET['paid']))
						$action = "DPPDGliste.php?paid=".$_GET['paid'];
					else
						$action = "DPPDGliste.php?paid=0";
					$details = '';
					echo '<tr>
						<td>' . $users[$i]['horodateur'] . '</td>
						<td>' . $users[$i]['agent'] . '</td>
						<td>' . $users[$i]['client'] . '</td>
						<td>' . $users[$i]['plaque'] . '</td>
						<td>' . $users[$i]['prix'] . '</td>
						<td>' . $users[$i]['concat_titre'] . '</td>
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
