<?php
include('header.php');
$vehicle = $db->query("Select * from user_vehicle where identifier = :id", Array('id' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));
$UserInfo = $db->query("Select * FROM users WHERE identifier = :user", Array('user' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));
$boat = array();

?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">MES VEHICULES</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							 MES VEHICULES <i class="fa fa-car"></i>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
							<h4>Mes Voitures</h4>
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th>Modele</th>
											<th>Prix</th>
											<th>Plaque</th>
											<th>Etat</th>
											<th>Type</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$client = 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16);
									for($i =0; $i < count($vehicle); $i++){
										if(isset($_GET['car']))
											if($vehicle[$i]['id'] == $_GET['car'])
											{
												if(preg_match('/'.$client.'/', $server_players))
												{
													echo 'Vous devez être déconnecter pour effectuer cette action';
												}
												else
												{
													$db->query('UPDATE user_vehicle set vehicle_state = \'In\' where id = :id', Array('id' => $_GET['car']));
													echo 'Votre véhicule à été renvoyer au garage';
												}
											}
										echo '<tr>
											<td>'.$vehicle[$i]['vehicle_name'].'</td>
											<td><button class="btn btn-success btn-xs">'.$vehicle[$i]['vehicle_price'].'</button></td>
											<td><button class="btn btn-primary btn-xs">'.$vehicle[$i]['vehicle_plate'].'</button></td>
											<td>'.($vehicle[$i]['vehicle_state'] != 'In' ? '<a href="mesveh.php?car='.$vehicle[$i]['id'].'">Rentré au garage</a>' : $vehicle[$i]['vehicle_state']).'</td><td>Voiture</td>
										</tr>';
									}
									?>
									</tbody>
								</table>
								<br>
								<h4>Mes Bateaux</h4>
								<table class="table table-striped table-bordered table-hover" id="dataTables-example">
									<thead>
										<tr>
											<th>Modele</th>
											<th>Prix</th>
											<th>Plaque</th>
											<th>Etat</th>
											<th>Type</th>
										</tr>
									</thead>
									<tbody>
									<?php
									for($i =0; $i < count($boat); $i++){
										echo '<tr>
											<td>'.$boat[$i]['vehicle_name'].'</td>
											<td><button class="btn btn-success btn-xs">'.$boat[$i]['vehicle_price'].'</button></td>
											<td><button class="btn btn-primary btn-xs">'.$boat[$i]['vehicle_plate'].'</button></td>
											<td>'.$boat[$i]['vehicle_state'].'</td><td>Voiture</td>
										</tr>';
									}
									?>
									</tbody>
								</table>
							</div>
							
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
<?php

include('footer.php');