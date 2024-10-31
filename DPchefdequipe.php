<?php
if(!isset($_POST['action']) || $_POST['action'] != 'delete' && isset($_POST['id']))
{
	include('header.php');
}else
	session_start();
	if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']))
	{
		echo '<script>
		  document.location.href="./index.php";
		</script>';
	}
	$UserInfo = $db->query("Select * FROM accounts WHERE steamid = :user AND job = :job", Array('user' => $_SESSION['T2SteamID64'], 'job' => 'depanneur'));

	if(isset($UserInfo[0]) && (isset($UserInfo[0]['job']) && ($UserInfo[0]['job'] == 'depanneur' && $UserInfo[0]['admin'] == 1 || $UserInfo[0]['grade'] == 'chef-equipe')))
	{
		var_dump($_POST);
		if(isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id']))
		{
			/*$db->query('UPDATE accounts SET job = :job, grade = :grade, equipe = :equipe WHERE id = :id', Array('job' => 'civil', 'grade' => '', 'equipe' => 'NULL', 'id' => $_POST['id']));
			*/
			echo 'true';
		}
		?>
		<div class="content-wrapper">
			<div class="container">
				<div class="row pad-botm">
					<div class="col-md-12">
						<h4 class="header-line">MON EQUIPE</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="panel panel-info">
							<div class="panel-heading">
							   MES INFORMATIONS <i class="fa fa-info-circle"></i>
							</div>
							<div class="panel-body">
								<form role="form">
									<div class="form-group">
										<label>Nom / Prenom</label>
										<input class="form-control" type="text" name="name" value="<?php echo $UserInfo[0]['name']; ?>" disabled="">
									</div>
									<div class="form-group">
										<label>Metier</label>
										<input class="form-control" type="text" name="job" value="<?php echo $UserInfo[0]['job']; ?>" disabled="">
									</div>
								   <div class="form-group">
										<label>Grade</label>
										<input class="form-control" type="text" name="grade" value="<?php echo $UserInfo[0]['grade']; ?>" disabled="">
									</div>
									<div class="form-group">
										<label>Equipe</label>
										<input class="form-control" type="text" name="equipe" value="<?php echo $UserInfo[0]['equipe']; ?>" disabled="">
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="panel panel-danger">
							<div class="panel-heading">
							   INFORMATIONS EQUIPE <i class="fa fa-info-circle"></i>
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
										<label>Meilleur Employer</label>
										<input class="form-control" type="text" name="money" value="<?php echo $UserInfo[0]['money']; ?>$" disabled="">
									</div>
									<div class="form-group has-error">
										<label>Mauvais Employer</label>
										<input class="form-control" type="text" name="dirty_money" value="<?php echo $UserInfo[0]['dirtymoney']; ?>$" disabled="">
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="panel panel-out">
							<div class="panel-heading">
							   EMPLOYER DE L'EQUIPE <i class="fa fa-info-circle"></i>
							</div>
							<?php

							$equipe = $db->query("select * from accounts where equipe = :equipe", Array("equipe" => $UserInfo[0]['equipe']));
							?>
							<table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th id="delete" class="th-sm">Select</th>
										<th class="th-sm">Name</th>
										<th class="th-sm">Metier</th>
										<th class="th-sm">Grade</th>
										<th class="th-sm">Equipe</th>
									</tr>
								</thead>
								<tbody>
								<?php
								for($i = 0; $i < count($equipe); $i++)
									echo '
									<tr role="row">
										<td><input dataset="'.$equipe[$i]['name'].'" type="checkbox" value="'.$equipe[$i]['id'].'"/></td>
										<td>'.$equipe[$i]['name'].'</td>
										<td>'.$equipe[$i]['job'].'</td>
										<td>'.$equipe[$i]['grade'].'</td>
										<td>'.$equipe[$i]['equipe'].'</td>
									</tr>';
								?>
								</tbody>
							  
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	else
		echo '<script>
		  document.location.href="./index.php";
		</script>';
include('footer.php');
