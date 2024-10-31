<?php
include('header.php');

$UserInfo = $db->query("Select * FROM accounts WHERE steamid = :user", Array('user' => $_SESSION['T2SteamID64']));
if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']) || !isset($UserInfo[0]))
{
?>
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
	
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">Inscription</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel">
					<?php
						if(isset($_SESSION['T2SteamID64']))
						{
							$registered = $db->query("SELECT count(*) as count FROM accounts WHERE steamid = :steam", Array('steam' => $_SESSION['T2SteamID64']));
							if($registered != null && $registered[0]['count'] > 0)
							{
								echo 'Vous avez déjà fais une demande, merci de patienter ou de contacter un responsable';
							}
							else
							{
								$users = array();
								if(isset($_GET['firstname']) && !empty($_GET['firstname']) && isset($_GET['lastname']) && !empty($_GET['lastname']))
								{
									$users = $db->query("SELECT * FROM accounts WHERE name = :name OR name = :name1", Array('name' => $_GET['firstname']." ".$_GET['lastname'], 'name1' => $_GET['lastname']." ".$_GET['firstname']));
									if(isset($users[0]))
										echo 'Ce nom existe déjà, merci d\'en utiliser un autre';
									else
									{
										$db->query("INSERT INTO `accounts`(`steamid`, `name`, `job`) VALUES (:steamid, :name, :job)", Array('steamid' => $_SESSION['T2SteamID64'], 'name' => $_GET['firstname']." ".$_GET['lastname'], 'job' => $_GET['job']));
										echo 'Votre demande à bien été prise en compte, un gérant vous contactera très bientôt';
									}
								}
								else
								{
									?>
									<div id="research">
										<form style="display: grid;" action="" method="GET">
											Nom: <input type="text" name="firstname" required/><br/>
											Prenom: <input type="text" name="lastname" required/><br/>
											Métier: <select name="job">
											<option value="depanneur" selected="selected">Depanneur</option>
											<option value="ems">EMS</option>
											<option value="police">Police</option>
											</select>
											<input type="submit" value="S'inscrire"/>
											<br/><br/>
										</form>
									</div>
									<?php
								}
							}
						}
								?>
					</div>
				</div>
			</div>

		</div>
	</div>
<?php
}
include('footer.php');