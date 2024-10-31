<?php
	include('header.php');
	if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']))
	{
		header('Location: index.php');
		exit();
	}
	$UserInfo = $db->query("Select t.*, s.job_name FROM users t, jobs s WHERE identifier = :user && t.patron = s.job_id", Array('user' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));
	if(isset($UserInfo[0]) && ($UserInfo[0]['group'] == 'superadmin' || $UserInfo[0]['job_name'] != "AUCUN"))
	{
?>
<div class="content-wrapper">
	<div class="container">
		<div class="row pad-botm">
			<div class="col-md-12">
				<h4 class="header-line">Gérer employé</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					<?php
						if(isset($_POST) && !empty($_POST))
						{
							$action = isset($_POST['action']) ? $_POST['action'] : '';
							$patron = isset($_POST['patron']) ? $_POST['patron'] : isset($UserInfo[0]) ? $UserInfo[0]['identifier'] : '';
							$client = '';
							if(isset($_POST['client']))
								$client = $_POST['client'];
							if(isset($_POST['c00']))
								$client = $_POST['c00'];
							$job = isset($_POST['job']) ? $_POST['job'] : '';
							
							if($action == "embaucher")
							{
								//$select = $db->query("update users set job = :job where identifier = :id", Array('job' => $job, 'id' => $client));
								$insert = $db->query("INSERT into proposition_job (`embaucher`, `job`, `patron`) values (:embaucher, :job, :patron)", Array('embaucher' => $client, 'job' => $job, 'patron' => $patron));
								echo 'Votre demande d\'embauche à bien été éffectuer';
								//echo 'Votre embauche à bien été éffectuer';
								$server_players_array = explode("\n", $server_players);
								if(preg_match('/'.$client.'/', $server_players))
								{
									for($i = 0; $i < count($server_players_array); $i++)
									{
										$players_array = explode(" ", $server_players_array[$i]);
										
										if(isset($players_array[1]) && $players_array[1] == $client)
										{
											$con->rcon("message ".$players_array[0]);
											break;
										}
									}
								}
							}
							if($action == "renvoyer")
							{
								$user = $db->query("select * from users where identifier = :id", Array('id' => $client));
								if(!empty($user)){
									$job = $db->query("select * from jobs where job_id = :job", Array('job' => $user[0]['job']));
									echo 'Vous avez renvoyé '.$user[0]['nom'].' '.$user[0]['prenom'].' du métier '.$job[0]['job_name'];
								}
								else{
									echo 'Vous avez renvoyé un civil.';
								}
								$db->query("UPDATE users set job = 1, patron = 0 where identifier = :client", Array('client' => $client));
								$server_players_array = explode("\n", $server_players);
								if(preg_match('/'.$user[0]['identifier'].'/', $server_players))
								{
									for($i = 0; $i < count($server_players_array); $i++)
									{
										$players_array = explode(" ", $server_players_array[$i]);
										if($players_array[1] == $client)
										{
											$con->rcon("message ".$players_array[0]." Vous avez été renvoyé de votre emploi.");
											break;
										}
									}
								}
							}
							if($action == "payer")
							{
								
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>

			</div>
		</div>
		<?php
	}
	else
		header('Location: index.php');
include('footer.php');

