<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require(__DIR__ . '/api/mysql/Db.class.php');
require(__DIR__ . '/api/rcon/q3query.class.php');

$db = new DB();
//$serverinfo = array("0","Serveur FX","217.182.185.84","30120","phoenix@123!");

/*try
{
	$con = new q3query($serverinfo['2'], $serverinfo['3'], $success);
	$query = $con->setRconpassword($serverinfo['4']);
	$file = 'online.txt';
	$server_players = '';
	if(file_exists($file))
	{
		$lastmodified = stat($file)[9];
		if(($lastmodified + 30) <= time())
		{
			$server_players = $con->rcon("status");
			$files = fopen($file, 'w');
			fwrite($files, $server_players);
			fclose($files);
		}
		else
		{
			$server_players = file_get_contents($file);
		}
	}
	else
	{
		$server_players = $con->rcon("status");
		$files = fopen($file, 'w');
		fwrite($files, $server_players);
		fclose($files);
	}
}
catch(Exception $ex)
{}*/

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>SRIS OALM - Mon Espace</title>
		<link href="./css/bootstrap.css" rel="stylesheet">
		<link href="./css/font-awesome.css" rel="stylesheet">
		<link href="./css/style.css" rel="stylesheet">
		<link href="./css/css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="./css/view.css" media="all">
		<!-- Icons font CSS-->
		<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
		<link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
		<!-- Vendor CSS-->
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
		<link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

		<!-- Main CSS-->
		<script src="./js/jquery-3.3.1.js"></script>
		<link href="css/main.css" rel="stylesheet" media="all">
		<link href="css/jquery.dataTables.min.css" rel="stylesheet" media="all">
		<script type="text/javascript" src="js/mustache.js"></script>
		<!-- Latest compiled and minified CSS -->
		<script type="text/javascript" src="js/jquery.notif.min.js"></script>
		<script type="text/javascript" src="./js/view.js"></script>
		<script type="text/javascript" src="./js/calendar.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#dtBasicExample").click(function() {
				console.log($(this));
			});
			$("#delete").click(function(){
				console.log();
				$('input:checked').each(function(){
					
					$.ajax({
						method: "POST",
						url: "DPchefdequipe.php",
						data:{action: "delete", id: $(this).value, name: $(this).attr('dataset').value}
					})
					.done(function(msg){
						alert(msg);
					});
				});
			});
		});
		</script>
		<style type="text/css">
		@mixin clearfix() {
		  &::after {
			display: block;
			content: "";
			clear: both;
		  }
		}

		.element {
		  @include clearfix;
		}
		</style>
	</head>
	<body style="" cz-shortcut-listen="true">
		<div class="navbar navbar-inverse set-radius-zero">
			<div class="container">
				<div class="navbar-header">
					<?php
						$currentFile = $_SERVER["PHP_SELF"];
						$parts = Explode('/', $currentFile);
						if((empty($_SESSION) || !isset($_SESSION['T2SteamID64'])))
						{
							if( $parts[count($parts) - 1] != 'index.php'){
							header('Location: index.php');
							}
						}
						$UserInfo = Array();
						if(isset($_SESSION['T2SteamID64']))
							$UserInfo = $db->query("Select * FROM accounts WHERE steamid = :user", Array('user' => $_SESSION['T2SteamID64']));

						if(isset($UserInfo[0]))
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

		<section class="menu-section">
			<div class="container">
				<div class="row ">
					<div class="col-md-12">
						<div class="navbar-collapse collapse ">
							<ul id="menu-top" class="nav navbar-nav navbar-right">
								<li><a href="./index.php"><i class="fa fa-home"></i> ACCUEIL</a></li>
								<?php
								if(isset($UserInfo[0]) && ($UserInfo[0]['admin'] == '1' || strtolower($UserInfo[0]['job']) == 'POLICE'))
								{
									echo '<li><a href="./POLICEaccueil.php"><i class="fa fa-home"></i> POLICE</a></li>';
								}
								if(isset($UserInfo[0]) && ($UserInfo[0]['admin'] == '1' || strtolower($UserInfo[0]['job']) == 'EMS'))
								{
									echo '<li><a href="./EMSaccueil.php"><i class="fa fa-home"></i> EMS</a></li>';
								}
								if(isset($UserInfo[0]) && ($UserInfo[0]['admin'] == '1' || strtolower($UserInfo[0]['job']) == 'depanneur'))
								{
									echo '<li><a href="./DPaccueil.php"><i class="fa fa-home"></i> DEPANNEUR</a></li>';
								}
								?>
								<li><a href="./"><i class="fa fa-address-card"></i> Mon Profil(SOON)</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
		}
		elseif(isset($_SESSION['T2SteamID64']) && (basename($_SERVER['PHP_SELF']) != 'inscription.php'))
		{
			echo '<script>
			  document.location.href="./inscription.php";
			</script>';
		}
		else
		{
			?>
							<a class="navbar-brand" href="./index.php">
								<img src="./img/logo.png">
							</a>
						</div>
					</div>
				</div>

		<?php
		}
