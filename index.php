<?php
ini_set('session.gc_maxlifetime', 3600);
include('header.php');
if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']))
{
?>
		<div class="content-wrapper">
			<div class="container">
				<div class="row pad-botm">
					<div class="col-md-12">
						<h4 class="header-line">CONNEXION SRIS</h4>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
					<?php
					include('./api/login.php');
					?>
					</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-danger">
						<div class="panel-heading">
						   Conditions d'utilisation <i class="fa fa-support"></i>
						</div>
						<div class="panel-body">
							<form role="form">
								© 2020 Tous droits réservés - Onset,  sont la propriété de 'BLUE MOUNTAINS GMBH'.
	 'SRIS OALM' n'est en aucun cas lié avec ces derniers, et tous les droits relatifs à l'utilisation des ressources originales reviennent a 'BLUE MOUNTAINS GMBH'.
	 L'ensemble du contenu et de la structure de 'OALM' est protégé par le Code de la propriété intellectuelle, en particulier par ses articles L.111-1 et L.123-1.
							</form>
						</div>
					</div>
				</div>

				</div>
			</div>
		</div>
<?php
}
else
{
	$UserInfo = $db->query("Select * FROM accounts WHERE steamid = :user", Array('user' => $_SESSION['T2SteamID64']));
	$registered = $db->query("select steamid from accounts", Array());
	$topMoney = $db->query("SELECT `bank_balance` as money, name as who FROM `accounts` order by money desc", Array());
?>

    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">SRIS OALM</h4>
			</div>
        </div>
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-6">
				<div class="alert alert-info back-widget-set text-center">
					<i class="fa fa-group fa-5x"></i>
					<h3><?php echo count($registered); ?></h3>
				   Membres
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<div class="alert alert-success back-widget-set text-center">
					<i class="fa fa-dollar fa-5x"></i>
					<h3><?php echo $topMoney[0]['who'];?></h3>
					Premiere Recrue
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-6">
				<div class="alert alert-warning back-widget-set text-center">
					<i class="fa fa-minus fa-5x"></i>
					<h3><?php echo $topMoney[count($topMoney)-1]['who'];?></h3>
					Derniere Recrue
				</div>
			</div>
        </div>
		<div class="row">
			<div class="col-md-8 col-sm-8 col-xs-12">
				<div id="carousel-example" class="carousel slide slide-bdr" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="./img/1.jpg" alt="">
                        </div>
                        <div class="item">
                            <img src="./img/2.jpg" alt="">
                        </div>
                        <div class="item">
                            <img src="./img/3.jpg" alt="">
                        </div>
                    </div>
					<ol class="carousel-indicators">
                        <li data-target="#carousel-example" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example" data-slide-to="1" class=""></li>
                        <li data-target="#carousel-example" data-slide-to="2" class=""></li>
                    </ol>
					<a class="left carousel-control" href="index.php#carousel-example" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="right carousel-control" href="index.php#carousel-example" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
                </div>
		</div>
		
	</div>
<?php
}
include('footer.php');
