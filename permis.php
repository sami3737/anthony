<?php
	include('header.php');
	$UserInfo = $db->query("Select t.*, s.job_name FROM users t, jobs s WHERE identifier = :user && t.job = s.job_id", Array('user' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));

	if(isset($UserInfo[0]) && (isset($UserInfo[0]['job']) && $UserInfo[0]['job'] == 2 || $UserInfo[0]['group'] == 'superadmin'))
	{
?>
		<style>
			table, td, th{
				border: 1px solid black
			}
			table{
				border-collapse:collapse;
				table-layout: fixed;
				width: 100%;
			}
			th{
				background: rgba(0,0,0,0.05);
			}
			#center{
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
		</style>
    <div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">POLICE</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel">
						<?php
		if(isset($_SESSION['message']))
		{
			echo $_SESSION['message'];
		}

		if(isset($_SESSION['T2SteamID64']))
		{
			if(isset($_POST) && !empty($_POST))
			{
				$points = $db->query('SELECT * from users where identifier = :user', Array('user' => $_POST['c00']));
				$permis = '';
				switch($_POST['s1'])
				{
					case 'permisauto':
					$permis = 'Voiture';
					break;
					case 'permisavion';
					$permis = 'Avion';
					break;
					case 'permiscamion';
					$permis = 'Camion';
					break;
					case 'permismoto';
					$permis = 'Moto';
					break;
					case 'permisbateau';
					$permis = 'Bateau';
					break;
				}
				if($permis == 'Voiture' || $permis == 'Camion' || $permis == 'Moto')
				{
					if($permis == 'Voiture')
					{
						if($points[0]['permisauto'] - $_POST['point'] <= 0)
						{
							$query = $db->query('UPDATE users SET permisauto = 0 where identifier = :user', Array('user' => $_POST['c00']));
							echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis '.$permis.' de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						}
						else
						{
							$query = $db->query('UPDATE users SET permisauto = permisauto - :points where identifier = :user', Array('points' => $_POST['point'], 'user' => $_POST['c00']));
							echo ''.$_POST['point'].' points retiré, il reste '.($points[0][$_POST['s1']] - $_POST['point']).' sur le permis '.$permis.' de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						}
						$query = $db->query('UPDATE users SET permiscamion = permiscamion - :points where identifier = :user', Array('points' => $_POST['point'], 'user' => $_POST['c00']));
						$query = $db->query('UPDATE users SET permismoto = permismoto - :points where identifier = :user', Array('points' => $_POST['point'], 'user' => $_POST['c00']));
						$points = $db->query('SELECT * from users where identifier = :user', Array('user' => $_POST['c00']));
						if($points[0]['permiscamion'] <= 0)
						{
							$query = $db->query('UPDATE users SET permiscamion = 0 where identifier = :user', Array('user' => $_POST['c00']));
							echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis Camion de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						}
						else
							echo ''.$_POST['point'].' points retiré, il reste '.($points[0]['permiscamion']).' sur le permis Camion de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						if($points[0]['permismoto'] <= 0)
						{
							$query = $db->query('UPDATE users SET permismoto = 0 where identifier = :user', Array('user' => $_POST['c00']));
							echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis Moto de '.$points[0]['nom'].' '.$points[0]['prenom'];
						}
						else
							echo ''.$_POST['point'].' points retiré, il reste '.($points[0]['permismoto']).' sur le permis Moto de '.$points[0]['nom'].' '.$points[0]['prenom'];
					}
					elseif($permis == 'Camion')
					{
						if($points[0]['permiscamion'] - $_POST['point'] <= 0)
						{
							$query = $db->query('UPDATE users SET permiscamion = 0 where identifier = :user', Array('user' => $_POST['c00']));
							echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis '.$permis.' de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						}
						else
						{
							$query = $db->query('UPDATE users SET permiscamion = permiscamion - :points where identifier = :user', Array('points' => $_POST['point'], 'user' => $_POST['c00']));
							echo ''.$_POST['point'].' points retiré, il reste '.($points[0][$_POST['s1']] - $_POST['point']).' sur le permis '.$permis.' de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						}
						$query = $db->query('UPDATE users SET permisauto = permisauto - :points where identifier = :user', Array('points' => $_POST['point'], 'user' => $_POST['c00']));
						$query = $db->query('UPDATE users SET permismoto = permismoto - :points where identifier = :user', Array('points' => $_POST['point'], 'user' => $_POST['c00']));
						$points = $db->query('SELECT * from users where identifier = :user', Array('user' => $_POST['c00']));
						if($points[0]['permisauto'] <= 0)
						{
							$query = $db->query('UPDATE users SET permisauto = 0 where identifier = :user', Array('user' => $_POST['c00']));
							echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis Voiture de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						}
						else
							echo ''.$_POST['point'].' points retiré, il reste '.($points[0]['permisauto']).' sur le permis Voiture de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						if($points[0]['permismoto'] <= 0)
						{
							$query = $db->query('UPDATE users SET permismoto = 0 where identifier = :user', Array('user' => $_POST['c00']));
							echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis Moto de '.$points[0]['nom'].' '.$points[0]['prenom'];
						}
						else
							echo ''.$_POST['point'].' points retiré, il reste '.($points[0]['permismoto']).' sur le permis Moto de '.$points[0]['nom'].' '.$points[0]['prenom'];
					}
					else
					{
						if($points[0]['permismoto'] - $_POST['point'] <= 0)
						{
							$query = $db->query('UPDATE users SET permismoto = 0 where identifier = :user', Array('user' => $_POST['c00']));
							echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis '.$permis.' de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						}
						else
						{
							$query = $db->query('UPDATE users SET permismoto = permismoto - :points where identifier = :user', Array('points' => $_POST['point'], 'user' => $_POST['c00']));
							echo ''.$_POST['point'].' points retiré, il reste '.($points[0][$_POST['s1']] - $_POST['point']).' sur le permis '.$permis.' de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						}
						$query = $db->query('UPDATE users SET permisauto = permisauto - :points where identifier = :user', Array('points' => $_POST['point'], 'user' => $_POST['c00']));
						$query = $db->query('UPDATE users SET permiscamion = permiscamion - :points where identifier = :user', Array('points' => $_POST['point'], 'user' => $_POST['c00']));
						$points = $db->query('SELECT * from users where identifier = :user', Array('user' => $_POST['c00']));
						if($points[0]['permisauto'] <= 0)
						{
							$query = $db->query('UPDATE users SET permisauto = 0 where identifier = :user', Array('user' => $_POST['c00']));
							echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis Voiture de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						}
						else
							echo ''.$_POST['point'].' points retiré, il reste '.($points[0]['permisauto']).' sur le permis Voiture de '.$points[0]['nom'].' '.$points[0]['prenom'].'<br />';
						if($points[0]['permiscamion'] <= 0)
						{
							$query = $db->query('UPDATE users SET permiscamion = 0 where identifier = :user', Array('user' => $_POST['c00']));
							echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis Moto de '.$points[0]['nom'].' '.$points[0]['prenom'];
						}
						else
							echo ''.$_POST['point'].' points retiré, il reste '.($points[0]['permiscamion']).' sur le permis Camion de '.$points[0]['nom'].' '.$points[0]['prenom'];
					}
				}
				else
				{
					if($points[0][$_POST['s1']] - $_POST['point'] <= 0)
					{
						$query = $db->query('UPDATE users SET '.$_POST['s1'].' = 0 where identifier = :user', Array('user' => $_POST['c00']));
						echo $_POST['point'].' points retiré, il ne reste plus de point sur le permis '.$permis.' de '.$points[0]['nom'].' '.$points[0]['prenom'];
					}
					else
					{
						$query = $db->query('UPDATE users SET '.$_POST['s1'].' = :point where identifier = :user', Array('point' => $points[0][$_POST['s1']] - $_POST['point'], 'user' => $_POST['c00']));
						echo ''.$_POST['point'].' points retiré, il reste '.($points[0][$_POST['s1']] - $_POST['point']).' sur le permis '.$permis.' de '.$points[0]['nom'].' '.$points[0]['prenom'];
					}
				}
			}
			?>
			<form id="target" action="permis.php" method="POST">
				Selectionnez le permis 
				<input type="hidden" name="c00" value="<?php echo isset($_GET['name']) ? $_GET['name'] : $_POST['c00']; ?>"/>
				<select id="s1"  name="s1">
					<option value="permisauto" selected="selected">Permis voiture</option>
					<option value="permisbateau">Permis bateau</option>
					<option value="permiscamion">Permis camion</option>
					<option value="permismoto">Permis moto</option>
					<option value="permisavion">Permis avion</option>
				</select><br />
				Nombre de points à retiré
				<input type="text" name="point"/><br/>
				<input type="submit" value="Retiré points" id="SendPerm">
			</form>
			<div class="panel-body">
				<div class="col-md-4 col-sm-4">
					<div class="panel panel-success">
						<?php 
						$criminfo = $db->query('SELECT * from users where identifier = :user', Array('user' => isset($_POST['c00']) ? $_POST['c00'] : $_GET['name']));
						if($criminfo[0]['permisauto'] == 0)
						{
							?>
							<div class="panel-heading">Permis à obtenir</div>
							<div class="panel-footer"><i class="fa fa-times"></i> Voiture</div>
							<?php
						}
						else
						{
							?>
							<div class="panel-heading">Permis Obtenu <?php echo $criminfo[0]['permisauto'].' point(s) restant';?></div>
							<div class="panel-footer"><i class="fa fa-check"></i> Voiture</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="panel panel-primary">
						<?php 
						if($criminfo[0]['permiscamion'] == 0)
						{
							?>
							<div class="panel-heading">Permis à obtenir</div>
							<div class="panel-footer"><i class="fa fa-times"></i> Camion</div>
							<?php
						}
						else
						{
							?>
							<div class="panel-heading">Permis Obtenu <?php echo $criminfo[0]['permiscamion'].' point(s) restant';?></div>
							<div class="panel-footer"><i class="fa fa-check"></i> Camion</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="panel panel-warning">
						<?php 
						if($criminfo[0]['gunlicense'] == 0)
						{
							?>
							<div class="panel-heading">Permis à obtenir</div>
							<div class="panel-footer"><i class="fa fa-times"></i> Port d'Armes</div>
							<?php
						}
						else
						{
							?>
							<div class="panel-heading">Permis Obtenu <?php echo $criminfo[0]['gunlicense'].' point(s) restant';?></div>
							<div class="panel-footer"><i class="fa fa-check"></i> Port d'Armes</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="col-md-4 col-sm-4">
					<div class="panel panel-info">
						<?php 
						if($criminfo[0]['permisbateau'] == 0)
						{
							?>
							<div class="panel-heading">Permis à obtenir</div>
							<div class="panel-footer"><i class="fa fa-times"></i> Bateau</div>
							<?php
						}
						else
						{
							?>
							<div class="panel-heading">Permis Obtenu <?php echo $criminfo[0]['permisbateau'].' point(s) restant';?></div>
							<div class="panel-footer"><i class="fa fa-check"></i> Bateau</div>
							<?php
						}
						?>
					</div>
				</div>                            
				<div class="col-md-4 col-sm-4">
					<div class="panel panel-danger">
						<?php 
						if($criminfo[0]['permisavion'] == 0)
						{
							?>
							<div class="panel-heading">Permis à obtenir</div>
							<div class="panel-footer"><i class="fa fa-times"></i> Avion</div>
							<?php
						}
						else
						{
							?>
							<div class="panel-heading">Permis Obtenu <?php echo $criminfo[0]['permisavion'].' point(s) restant';?></div>
							<div class="panel-footer"><i class="fa fa-check"></i> Avion</div>
							<?php
						}
						?>
					</div>
				</div>                            
				<div class="col-md-4 col-sm-4">
					<div class="panel panel-out">
						<?php 
						if($criminfo[0]['permismoto'] == 0)
						{
							?>
							<div class="panel-heading">Permis à obtenir</div>
							<div class="panel-footer"><i class="fa fa-times"></i> Moto</div>
							<?php
						}
						else
						{
							?>
							<div class="panel-heading">Permis Obtenu <?php echo $criminfo[0]['permismoto'].' point(s) restant';?></div>
							<div class="panel-footer"><i class="fa fa-check"></i> Moto</div>
							<?php
						}
						?>
					</div>
				</div>                           
			</div>
		<?php
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

