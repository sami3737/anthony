<?php
include('header.php');
$UserInfo = $db->query("Select t.*, s.job_name FROM users t, jobs s WHERE identifier = :user && t.job = s.job_id", Array('user' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));
?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">MES PERMIS</h4>
				</div>
			</div>
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             MES PERMIS <i class="fa fa-check"></i>
                        </div>
                        <div class="panel-body">
							<div class="col-md-4 col-sm-4">
								<div class="panel panel-success">
									<?php 
									if($UserInfo[0]['permisauto'] == 0)
									{
										?>
										<div class="panel-heading">Permis à obtenir</div>
										<div class="panel-footer"><i class="fa fa-times"></i> Voiture</div>
										<?php
									}
									else
									{
										?>
										<div class="panel-heading">Permis Obtenu <?php echo $UserInfo[0]['permisauto'].' point(s) restant';?></div>
										<div class="panel-footer"><i class="fa fa-check"></i> Voiture</div>
										<?php
									}
									?>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="panel panel-primary">
									<?php 
									if($UserInfo[0]['permiscamion'] == 0)
									{
										?>
										<div class="panel-heading">Permis à obtenir</div>
										<div class="panel-footer"><i class="fa fa-times"></i> Camion</div>
										<?php
									}
									else
									{
										?>
										<div class="panel-heading">Permis Obtenu <?php echo $UserInfo[0]['permiscamion'].' point(s) restant';?></div>
										<div class="panel-footer"><i class="fa fa-check"></i> Camion</div>
										<?php
									}
									?>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="panel panel-warning">
									<?php 
									if($UserInfo[0]['gunlicense'] == 0)
									{
										?>
										<div class="panel-heading">Permis à obtenir</div>
										<div class="panel-footer"><i class="fa fa-times"></i> Port d'Armes</div>
										<?php
									}
									else
									{
										?>
										<div class="panel-heading">Permis Obtenu <?php echo $UserInfo[0]['gunlicense'].' point(s) restant';?></div>
										<div class="panel-footer"><i class="fa fa-check"></i> Port d'Armes</div>
										<?php
									}
									?>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="panel panel-info">
									<?php 
									if($UserInfo[0]['permisbateau'] == 0)
									{
										?>
										<div class="panel-heading">Permis à obtenir</div>
										<div class="panel-footer"><i class="fa fa-times"></i> Bateau</div>
										<?php
									}
									else
									{
										?>
										<div class="panel-heading">Permis Obtenu <?php echo $UserInfo[0]['permisbateau'].' point(s) restant';?></div>
										<div class="panel-footer"><i class="fa fa-check"></i> Bateau</div>
										<?php
									}
									?>
								</div>
							</div>                            
							<div class="col-md-4 col-sm-4">
								<div class="panel panel-danger">
									<?php 
									if($UserInfo[0]['permisavion'] == 0)
									{
										?>
										<div class="panel-heading">Permis à obtenir</div>
										<div class="panel-footer"><i class="fa fa-times"></i> Avion</div>
										<?php
									}
									else
									{
										?>
										<div class="panel-heading">Permis Obtenu <?php echo $UserInfo[0]['permisavion'].' point(s) restant';?></div>
										<div class="panel-footer"><i class="fa fa-check"></i> Avion</div>
										<?php
									}
									?>
								</div>
							</div>                            
							<div class="col-md-4 col-sm-4">
								<div class="panel panel-out">
									<?php 
									if($UserInfo[0]['permismoto'] == 0)
									{
										?>
										<div class="panel-heading">Permis à obtenir</div>
										<div class="panel-footer"><i class="fa fa-times"></i> Moto</div>
										<?php
									}
									else
									{
										?>
										<div class="panel-heading">Permis Obtenu <?php echo $UserInfo[0]['permismoto'].' point(s) restant';?></div>
										<div class="panel-footer"><i class="fa fa-check"></i> Moto</div>
										<?php
									}
									?>
								</div>
							</div>                           
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
    
<?php
include('footer.php');