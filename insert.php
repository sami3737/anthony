<?php
include('header.php');
ini_set("display_errors", 1);
if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']))
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
	if(isset($_POST) && !empty($_POST)){
		$infract = ""; 
		for($i = 1; $i < 15; $i++)
		{
			$name = 'c'.$i;
			if(isset($_POST[$name]))
			{
				$infract .= ",".$name;
			}
		}
		$InsertPunish = $db->query("INSERT INTO `punish`(`Horodateur`, `Nom du suspect`, `Infraction`, `Montant a payer`, `Lieux`, `Signature`, `Détails`, `Autres agent`)
		 VALUES (:Horodateur, :suspect, :Infraction, :montant, :lieux, :signature, :details, :autre)", Array('Horodateur' => $_POST['c16'], 'suspect' => $_POST['c0'], 
		 'Infraction' => $infract, 'montant' => $_POST['c15'], 'lieux' => $_POST['c17'], 'signature' => $_POST['c18'], 'details' => $_POST['c19'], 'autre' => $_POST['c20']));
	}
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
			td{
				text-align:center;
			}
			#research{
				width:280px;
				margin:auto;
				text-align:center;
			}
		</style>
	</head>
	<body>
	<br />
	<br />
	<br />
	<br />
	<div id="research">Recherché
<form action="" method="GET">
	Nom Prenom: <input type="text" name="name"/><br/>
	<input type="submit" value="Recherché"/>
</form><br/><br/></div>
		<table>
			<thead>
				<tr>
					<th>
						Horodateur
					</th>
					<th>
						Nom du suspect
					</th>
					<th>
						Infraction
					</th>
					<th>
						Montant à payer
					</th>
					<th>
						Lieux
					</th>
					<th>
						Signature
					</th>
					<th>
						Détails supplémentaire
					</th>
					<th>
						Autres agent
					</th>
				</tr>
			</thead>
			<?php
			if(isset($_GET['name']) && !empty($_GET['name']))
				$punish = $db->query("select * FROM punish where `Nom du suspect` like CONCAT('%',:name,'%')", Array('name' => $_GET['name']));
			else
				$punish = $db->query("select * FROM punish", Array());
			if (count($punish) > 0)
			{
				?>
				<tfoot>
				<?php
				for ($i = 0; $i < count($punish); $i++)
				{
					$details = '';
					if(preg_match('#,#', $punish[$i]['Infraction']))
					{
						$pre = explode(",", $punish[$i]['Infraction']);
						for($t = 0; $t < count($pre); $t++)
						{
							$punishs = $db->query("select * FROM infraction where `InfractionCode` = :name", Array('name' => $pre[$t]));
							$details .= $punishs[0]['InfractionDetails'].'<br />';
						}
					}
					else
					{
						$details = $punish[$i]['Infraction'];
					}
					echo '<tr><td>' . $punish[$i]['Horodateur'] . '</td><td>' . $punish[$i]['Nom du suspect'] . '</td><td>' . $details . '</td><td>' . $punish[$i]['Montant a payer'] . '€</td><td>' . $punish[$i]['Lieux'] . '</td><td>' . $punish[$i]['Signature'] . '</td><td>' . $punish[$i]['Détails'] . '</td><td>' . $punish[$i]['Autres agent'] . '</td></tr>';
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

