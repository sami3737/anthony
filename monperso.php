<?php
include('header.php');
if(isset($_POST['action']))
{
	$client = 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16);
	if($_POST['action'] == 'Accepter')
	{
		$db->query('UPDATE users SET job = :job WHERE identifier = :client', Array('job' => $_POST['job'], 'client' => $_POST['embaucher']));
		$db->query('DELETE FROM proposition_job WHERE uniqueID = :id', Array('id' => $_POST['id']));

		$server_players_array = explode("\n", $server_players);
		if(preg_match('/'.$client.'/', $server_players))
		{
			for($i = 0; $i < count($server_players_array); $i++)
			{
				$players_array = explode(" ", $server_players_array[$i]);
				if($players_array[1] == $client)
				{
					$con->rcon("message ".$players_array[0]);
					break;
				}
			}
		}
	}
	elseif($_POST['action'] == 'Refuser')
	{
		$db->query('DELETE FROM proposition_job WHERE uniqueID = :id', Array('id' => $_POST['id']));

		$server_players_array = explode("\n", $server_players);
		if(preg_match('/'.$client.'/', $server_players))
		{
			for($i = 0; $i < count($server_players_array); $i++)
			{
				$players_array = explode(" ", $server_players_array[$i]);
				if($players_array[1] == $client)
				{
					$con->rcon("message ".$players_array[0]);
					break;
				}
			}
		}
	}
}
?>
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">MON PERSONNAGE</h4>
			</div>
        </div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-info">
                        <div class="panel-heading">
                           INFORMATIONS <i class="fa fa-info-circle"></i>
                        </div>
                        <div class="panel-body">
                            <form role="form">

                                        <div class="form-group">
                                            <label>Nom / Prenom</label>
                                            <input class="form-control" type="text" name="prenom" value="<?php echo $UserInfo[0]['prenom']; ?>" disabled="">
                                        </div>
										<div class="form-group">
                                            <label>Metier</label>
                                            <input class="form-control" type="text" name="nom" value="<?php echo $UserInfo[0]['nom']; ?>" disabled="">
                                        </div>
                                       <div class="form-group">
                                            <label>Equipe</label>
                                            <input class="form-control" type="text" name="date" value="<?php echo $UserInfo[0]['dateNaissance']; ?>" disabled="">
                                        </div>


                                    </form>
                            </div>
                        </div>
                            </div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-danger">
					<div class="panel-heading">
					   INFORMATIONS SOCIETE <i class="fa fa-info-circle"></i>
					</div>
					<div class="panel-body">
						<form role="form">
							<div class="form-group">
								<label>Total Facture</label>
								<input class="form-control" type="text" name="adresse" value="" disabled="">
							</div>
							<div class="form-group">
								<label>Total Fourierre</label>
								<input class="form-control" type="text" name="job" value="<?php echo $UserInfo[0]['job_name']; ?>" disabled="">
							</div>
							<div class="form-group has-success">
								<label>Total Equipe</label>
								<input class="form-control" type="text" name="money" value="<?php echo $UserInfo[0]['money']; ?>$" disabled="">
							</div>
							<div class="form-group has-error">
								<label>Total Société</label>
								<input class="form-control" type="text" name="dirty_money" value="<?php echo $UserInfo[0]['dirtymoney']; ?>$" disabled="">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="panel panel-out">
					<div class="panel-heading">
					   PROPOSITION DE JOB <i class="fa fa-info-circle"></i>
					</div>
					<div class="panel-body">
						<?php
						$prop = $db->query("SELECT * FROM proposition_job, jobs where embaucher = :jobber and job = job_id", Array('jobber' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));
						if(count($prop) == 0)
							echo 'Vous n\'avez aucune proposition de job';
						for($i = 0; $i < count($prop); $i++)
						{
							echo '<form action="monperso.php" method="post"><div class="form-group">';
							echo '<label>Une proposition vous à été faite pour le job de '.$prop[0]['job_name'].' de la part de '.$patron[0]['nom'].' '.$patron[0]['prenom'].'</label>';
							echo '<input class="form-control" type="hidden" name="id" value="'.$prop[0]['uniqueID'].'">';
							echo '<input class="form-control" type="hidden" name="job" value="'.$prop[0]['job'].'">';
							echo '<input class="form-control" type="hidden" name="embaucher" value="'.$prop[0]['embaucher'].'">';
							echo '<input class="form-control" type="submit" name="action" value="Accepter">';
							echo '<input class="form-control" type="submit" name="action" value="Refuser">';
							echo '</div></form>';

						}
						?>
					</div>
				</div>
			</div>
        </div>
    </div>
    </div>

<?php
include('footer.php');
