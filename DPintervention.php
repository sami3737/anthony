<?php
	include('header.php');

	if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']))
	{
		echo '<script>
		  document.location.href="./index.php";
		</script>';
	}
	$UserInfo = $db->query("Select * FROM accounts WHERE steamid = :user AND job = :job", Array('user' => $_SESSION['T2SteamID64'], 'job' => 'depanneur'));

	if(isset($UserInfo[0]) && (isset($UserInfo[0]['job']) && $UserInfo[0]['job'] == 'depanneur' || $UserInfo[0]['admin'] == 1))
	{
		if(isset($_POST) && !empty($_POST))
		{
			$lastinsert = $db->query("SELECT (intervention + 1) as indexed FROM `facture` ORDER BY intervention DESC LIMIT 0,1", Array());
			
			$db->query("INSERT INTO `facture`(`agent`, `client`, `paid`, `plaque`, `horodateur`, `prix`, `intervention`) VALUES (:agent, :client, :paid, :plaque, :horo, :prix, :inter)", Array('agent' => $UserInfo[0]['name'], 'client' => $_POST['cname'], 'paid' => $_POST['pay'] == 'oui' ? 1 : 0, 'plaque' => $_POST['imma'], 'horo' => $_POST['horo'], 'prix' => $_POST['price'], 'inter' => $lastinsert[0]['indexed']));
			
			$inter = explode(',', $_POST['dataInsert']);
			
			for($i = 0; $i < count($inter); $i++)
			{
				$db->query("INSERT INTO `interventiondata` (`dataindex`, `intervention`) VALUES (:data, :inter)", Array('data' => $lastinsert[0]['indexed'], 'inter' => $inter[$i]));
			}
			echo 'Facture enregistrée.';
		}
		else
		{
			?>
    <div class="page-wrapper p-t-20 p-b-20 font-robo">
        <div class="wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-body">
                    <h2 class="title">SAISI INTER   ||MAXI 3000$ ||  </h2>
                    <form method="POST" action="">
                        <div class="row row-space">
							<div class="col-2">
								<div class="input-group">
									<input class="input--style-2" type="text" placeholder="<?php echo $UserInfo[0]['name']; ?>" name="name" disabled="disabled" required>
								</div>
							</div>
							<div class="col-2">
								<div class="input-group">
									<input class="input--style-2" type="text" placeholder="Nom du client" name="cname" required>
								</div>
							</div>
                        </div>
						<div class="row row-space">
							<div class="col-2">
								<div class="input-group">
									<input class="input--style-2" type="text" placeholder="Plaque d'immatriculation" name="imma" required>
								</div>
							</div>
							<div class="col-2">
								<div class="form-row">
									<div class="input-group">
										<span class="input-group-addon">$</span>
										<input placeholder="Price" readonly id="price" name="price" type="number" min="0" step="1" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" required>
									</div>
								</div>
							</div>
						</div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-2 js-datepicker" type="text" placeholder="Horodateur" name="horo" required>
                                    <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="pay" required>
                                            <option value="" disabled="disabled" selected="selected">Paiement</option>
                                            <option value="oui">Oui</option>
                                            <option value="non">Non</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="check full">
								<input hidden="hidden" class="input--style-2" id="dataInsert" type="input" name="dataInsert" value="">
								<table class="full">
									<?php
									$options = $db->query("Select * FROM intervention WHERE id!= '3' AND id!= '4' AND id!= '5' AND id!= '6' AND id!= '7' AND id!= '8' AND id!= '9' AND id!= '10'", Array());
									for($i = 0; $i < count($options); $i++)
									{
										echo $i % 2 == 0 ? '<tr>' : '';
										echo '<td><input data-index="'.$options[$i]['id'].'" type="checkbox" name="inter" value="'.$options[$i]['price'].'">'.$options[$i]['name'].'</td>';
										echo $i % 2 != 0 ? '</tr>' : '';
									}
									?>
								</table>
								<script type="text/javascript">
									$('input[type=checkbox]').change(function () {
										var favorite = 0;
										var data = [];
										$.each($("input[name='inter']:checked"), function(){
											favorite += parseInt($(this).val());
											data.push($(this).attr("data-index"));
										});
										document.getElementById("price").value = favorite;
										document.getElementById("dataInsert").value = data.join(',');
										console.log(data.join(','));
									});
								</script>
							</div>
                        </div>
                        <div class="p-t-30">
                            <button class="btn btn--radius btn--green" type="submit">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

	<?
		}
	}
	else
		echo '<script>
		  document.location.href="./index.php";
		</script>';
include('footer.php');
