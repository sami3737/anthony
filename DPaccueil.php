<?php	include('header.php');	if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']))	{		echo '<script>		  document.location.href="./index.php"; 		</script>';	}
	$UserInfo = $db->query("Select * FROM accounts WHERE steamid = :user AND job = :job", Array('user' => $_SESSION['T2SteamID64'], 'job' => 'depanneur'));		if(isset($UserInfo[0]) && (isset($UserInfo[0]['job']) && $UserInfo[0]['job'] == 'depanneur' || $UserInfo[0]['admin'] == 1))	{
?><div class="content-wrapper">	<div class="container">		<div class="row pad-botm">			<div class="col-md-12">				<h4 class="header-line">Bienvenue</h4>			</div>		</div>
		<div class="row">			<div class="col-md-12">				<div class="panel panel-default">					<div class="panel-heading">						<section class="menu-section-police">							<div class="container">								<div class="row ">									<div class="col-md-12">										<div class="navbar-collapse collapse ">											<ul id="menu-top" class="nav navbar-nav">
			<li><a href="./DPintervention.php"><i class="fa fa-pencil-square-o"></i> Saisi inter</a></li>
			<li><a href="./DPsuiviinter.php"><i class="fa fa-search"></i>Recherche Inter</a></li>
			<?php if(isset($UserInfo[0]) && ($UserInfo[0]['admin'] == '1' || strtolower($UserInfo[0]['grade']) == "chef-equipe"))
			{
				echo '<li><a href=""><i class="fa fa-handshake-o"></i> Chef d\'equipe(SOON)</a></li>';
			}
			 ?> 
		  <?php if(isset($UserInfo[0]) && ($UserInfo[0]['admin'] == '1' || strtolower($UserInfo[0]['grade']) == "pdg"))
			{
				echo '<li><a href="DPpdg.php"><i class="fa fa-handshake-o"></i> PDG DEPANNEUR</a></li>';
			}
			 ?> 		 								</ul>										</div>									</div>								</div>							</div>						</section>					</div>				</div>			</div>		</div>	</div></div>		<?php	}	else		echo '<script>		  document.location.href="./index.php"; 		</script>';include('footer.php');
