<?php
	include('header.php');
	$UserInfo = $db->query("Select t.*, s.job_name FROM users t, jobs s WHERE identifier = :user && t.job = s.job_id", Array('user' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));

	if(isset($UserInfo[0]) && (isset($UserInfo[0]['job']) && $UserInfo[0]['job'] == 2 || $UserInfo[0]['group'] == 'superadmin'))
	{
?>
    <div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">Recherché</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel">
					<?php
if(isset($_SESSION['T2SteamID64']))
{
	?>
<html>
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
	<div id="research">
<form style="display: grid;" action="" method="GET">
	Plaque d'immatriculation: <input type="text" name="name"/><br/>
	<input type="submit" value="Recherché"/>
<br/><br/></div>
		<table>
			<thead>
				<tr>
					<th>
						Nom
					</th>
					<th>
						Prenom
					</th>
					<th>
						Modèle du véhicule
					</th>
					<th>
						Prix
					</th>
					<th>
						Numéro de plaque
					</th>
					<th>
						Status
					</th>
					<th>
						Permis
					</th>
				</tr>
			</thead>
			<?php
			$users = array();
			if(isset($_GET['name']) && !empty($_GET['name']))
				$users = $db->query("select v.*, u.prenom, u.nom FROM user_vehicle v, users u where v.`vehicle_plate` like CONCAT('%',:name,'%') and v.identifier = u.identifier", Array('name' => $_GET['name']));
			{
				?>
				<tfoot>
				<?php
				for ($i = 0; $i < count($users); $i++)
				{
					$details = '';
					echo '<tr>
						<td>' . $users[$i]['nom'] . '</td>
						<td>' . $users[$i]['prenom'] . '</td>
						<td>' . $users[$i]['vehicle_model'] . '</td>
						<td>' . $users[$i]['vehicle_price'] . '</td>
						<td>' . $users[$i]['vehicle_plate'] . '</td>
						<td>' . $users[$i]['vehicle_state'] . '</td>
						<td><a href="permis.php?name=' . $users[$i]['identifier'] . '">Voir permis</a>
						</td>
					</tr>';
				}
				?>
				</tfoot>
				<?php
			}
		echo '</table>';
	}
}
else
	header('Location: index.php');
		?>					
				</div>
			</div>
		</div>

	</div>
</div>
<?php
	include('footer.php');

