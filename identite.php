<?php
	include('header.php');
	$UserInfo = $db->query("Select t.*, s.job_name FROM users t, jobs s WHERE identifier = :user && t.job = s.job_id", Array('user' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));

	if(isset($UserInfo[0]) && (isset($UserInfo[0]['job']) && $UserInfo[0]['job'] == 2 || $UserInfo[0]['group'] == 'superadmin'))
	{
?>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./index.php">

                    <img src="./img/logo.png">
                </a>

            </div>

            <div class="right-div">
				<a href="./logout.php" class="btn btn-danger pull-right"><i class="fa fa-power-off"></i> Déconnexion</a>
            </div>
        </div>
    </div>
		
	
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
	Nom de famille: <input type="text" name="name"/><br/>
	<input type="submit" value="Recherché"/>
</form>
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
						Date de Naissance
					</th>
					<th>
						Sexe
					</th>
					<th>
						Taille
					</th>
					<th>
						Numero de Télephone
					</th>
					<th>
						Compte en Banque
					</th>
					<th>
						Permis
					</th>
				</tr>
			</thead>
			<?php
			$users = array();
			if(isset($_GET['name']) && !empty($_GET['name']))
				$users = $db->query("select * FROM users where `nom` like CONCAT('%',:name,'%')", Array('name' => $_GET['name']));
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
						<td>' . $users[$i]['dateNaissance'] . '</td>
						<td>' . $users[$i]['sexe'] . '</td>
						<td>' . $users[$i]['taille'] . 'cm</td>
						<td>' . $users[$i]['phone_number'] . '</td>
						<td></td>
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

