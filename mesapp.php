<?php
include('header.php');
$app = $db->query("Select * from user_appartement where identifier = :id", Array('id' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));
$UserInfo = $db->query("Select * FROM users WHERE identifier = :user", Array('user' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));
?>
     <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">MES APPARTEMENTS</h4>
                
                            </div>

        </div>
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             MES APPARTEMENTS <i class="fa fa-home"></i>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Adresse</th>
                                            <th>Prix</th>
                                            <th>Argent</th>
								            <th>Argent Sale</th>	
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									for($i =0; $i < count($app); $i++){
										echo '<tr>
											<td><button class="btn btn-success btn-xs">'.$app[$i]['name'].'</button></td>
											<td><button class="btn btn-default btn-xs">'.$app[$i]['price'].'</button></td>
											<td><button class="btn btn-primary btn-xs">'.$app[$i]['money'].'</button></td>
											<td><button class="btn btn-warning btn-xs">'.$app[$i]['dirtymoney'].'</button></td>
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