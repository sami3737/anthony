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
		$Jobs = $db->query("Select * FROM jobs where job_id != 1 and job_id != 0 and job_id < 100 ", Array());
		$patron = $UserInfo[0]['job_name'];
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
								 <?php echo ($patron != "AUCUN" ? $patron : "SuperAdmin"); ?>
							</div>
							<?php
								switch($UserInfo[0]['patron'])
								{
									case 0:
										$result = $db->query("select * from users", Array());
										break;
									default:
										$result = $db->query("select * from users where job = :patron", Array('patron' => $UserInfo[0]['patron']));
										break;
								}
							if($patron != "AUCUN"){
								?>
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th>Nom</th>
											<th>Prenom</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									for($i =0; $i < count($result); $i++){
										echo '<tr>
											<td>'.$result[$i]['nom'].'</td>
											<td>'.$result[$i]['prenom'].'</td>
											<td>
												<form action="metier.php" method="POST">
												<input name="action" type="hidden" value="renvoyer"/>
												<input name="patron" type="hidden" value="'.'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16).'"/>
												<input name="client" type="hidden" value="'.$result[$i]['identifier'].'"/>
												<input type="submit" value="Renvoyer">
												</form>
											</td>
										</tr>';
									}
									?>
									</tbody>
								</table>
								<div id="players" style="position:absolute; left:70%"><ul id="list"></ul></div>
								<script type="text/javascript">
									$( document ).ready(function() {
										$( "#c0" ).keyup(function(data) {
											if($(this).val().length > 1)
											{
												$("#list").load('players.php', {string:$(this).val(), data:true});
											}
										});
									});
								</script>
								<form id="target" action="metier.php" method="POST">
									<legend>Nom de la personne à embaucher</legend>
									<input type="text" name="c0" id="c0" required/><br/><br/>
									<input name="action" type="hidden" value="embaucher"/>
									<input type="hidden" name="c00" id="c00"/>
									<input type="submit" value="Embaucher" id="checkBtn">
									<input type="hidden" name="job" value="<?php echo $UserInfo[0]['job']; ?>">
								</form>
								<?php
							}
							else
							{
								?>
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Nom</th>
											<th>Prenom</th>
											<th>Métier</th>
										</tr>
									</thead>
									<tbody>
									<?php
									for($i =0; $i < count($result); $i++){
										echo '<tr>
											<td>'.$result[$i]['nom'].'</td>
											<td>'.$result[$i]['prenom'].'</td>
											<td>
											<form action="metier.php" method="POST">
											<input name="action" type="hidden" value="embaucher"/>
											<input name="patron" type="hidden" value="'.'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16).'"/>
											<input name="client" type="hidden" value="'.$result[$i]['identifier'].'"/>
											<select name="job">
											';
											foreach($Jobs as $job)
												echo '<option value="'.$job['job_id'].'">'.$job['job_name'].'</option>';
										echo '</select>
											<input type="submit" value="Embaucher">
											</form>
											</td>
										</tr>';
									}
									?>
									</tbody>
								</table>
								<?php
							}
							?>
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

