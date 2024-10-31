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
			$db->query("UPDATE `accounts` SET `job` = :job WHERE id = :id", Array('id' => $_POST['action'], 'job' => $_POST['job'] == 'civil' ? depanneur : 'civil'));
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
						Nom Prenom
					</th>
					<th>
						Metier
					</th>
					<th>
						Grade
					</th>
					<th>
						Equipe
					</th>
					<th>
						Definir Employer
					</th>
					<th>
						Renvoyer Employer
					</th>
				</tr>
			</thead>
			<?php
			$users = array();
			if(isset($_GET['job']) && !empty($_GET['job']))
				$users = $db->query("select * FROM accounts where `job` like CONCAT('%',:job,'%')", Array('job' => $_GET['job']));
			{
				?>

				<?php
				for ($i = 0; $i < count($users); $i++)
				{
					if(isset($_GET['job']))
						$action = "DPPDGliste.php?job=".$_GET['job'];
					else
						$action = "DPPDGliste.php?job=depanneur";
					$details = '';
					echo '<tr>
						<td>' . $users[$i]['name'] . '</td>
						<td>' . $users[$i]['job'] . '</td>
						<td>' . $users[$i]['grade'] . '</td>
						<td>' . $users[$i]['equipe'] . '</td>
						<td>' . ($users[$i]['grade'] == null ? '<form name="DPPDGliste" method="POST" action="'.$action.'"><input name="action" value="'.$users[$i]['id'].'" hidden="hidden">
						<input name="grade" value="'.$users[$i]['grade'].'" hidden="hidden">
						<input type="submit" value="Promouvoir DP"/></form>' : '') . '</td>
						<td>' . ($users[$i]['job'] != null ? '<form name="DPPDGliste" method="POST" action="'.$action.'"><input name="action" value="'.$users[$i]['id'].'" hidden="hidden">
						<input name="job" value="'.$users[$i]['job'].'" hidden="hidden">
						<input type="submit" value="Renvoyer DP"/></form>' : '') . '</td>
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
