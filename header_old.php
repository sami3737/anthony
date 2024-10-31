<?phpsession_start();
function bc_base_convert($value,$quellformat,$zielformat){
	$vorrat = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	if(max($quellformat,$zielformat) > strlen($vorrat))
		trigger_error('Bad Format max: '.strlen($vorrat),E_USER_ERROR);
	if(min($quellformat,$zielformat) < 2)
		trigger_error('Bad Format min: 2',E_USER_ERROR);
	$dezi   = '0';
	$level  = 0;
	$result = '';
	$value  = trim((string)$value,"\r\n\t +");
	$vorzeichen =  '-' === $value{0}?'-':'';
	$value  = ltrim($value,"-0");
	$len    = strlen($value);
	for($i=0;$i<$len;$i++)
	{
		$wert = strpos($vorrat,$value{$len-1-$i});
		if(FALSE === $wert) trigger_error('Bad Char in input 1',E_USER_ERROR);
		if($wert >= $quellformat) trigger_error('Bad Char in input 2',E_USER_ERROR);
		$dezi = bcadd($dezi,bcmul(bcpow($quellformat,$i),$wert));
	}
	if(10 == $zielformat) return $vorzeichen.$dezi; // abkürzung
	while(1 !== bccomp(bcpow($zielformat,$level++),$dezi));
	for($i=$level-2;$i>=0;$i--)	{
		$factor  = bcpow($zielformat,$i);
		$zahl    = bcdiv($dezi,$factor,0);
		$dezi    = bcmod($dezi,$factor);
		$result .= $vorrat{$zahl};
	}	$result = empty($result)?'0':$result;	
	return $vorzeichen.$result ;}	
function bc_convert($value){	$value = preg_split("/\//", $value);	$number = $value[count($value)-1];	
	return dechex ($number);
}
require(__DIR__ . '/api/mysql/Db.class.php');require(__DIR__ . '/api/rcon/q3query.class.php');

$db = new DB();
$serverinfo = array("0","Serveur FX","217.182.185.84","30120","phoenix@123!");

try
{
	$con = new q3query($serverinfo['2'], $serverinfo['3'], $success);
	$query = $con->setRconpassword($serverinfo['4']);
	$file = 'online.txt';
	$server_players = '';
	if(file_exists($file))
	{
		$lastmodified = stat($file)[9];
		if(($lastmodified + 30) <= time())
		{
			$server_players = $con->rcon("status");
			$files = fopen($file, 'w');
			fwrite($files, $server_players);
			fclose($files);
		}
		else
		{
			$server_players = file_get_contents($file);
		}
	}
	else
	{
		$server_players = $con->rcon("status");
		$files = fopen($file, 'w');
		fwrite($files, $server_players);
		fclose($files);
	}
}
catch(Exception $ex)
{}

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>OALM DP - Mon Espace</title>
		<link href="./css/bootstrap.css" rel="stylesheet">
		<link href="./css/font-awesome.css" rel="stylesheet">
		<link href="./css/style.css" rel="stylesheet">
		<link href="./css/css" rel="stylesheet" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/mustache.js"></script>
		<script type="text/javascript" src="js/jquery.notif.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				if(window.location.pathname.split("/").pop() == 'police.php'){
					var select0 = document.getElementById("s0");
					var select1 = document.getElementById("s1");
					var result = 0;
					var price = 0;
					var s0 = 0;
					var s1 = 0;
					select0.addEventListener('focus', function () {
						s0 = $(this)[0].value;
					});
					select1.addEventListener('focus', function () {
						s1 = $(this)[0].value;
					});
					$('#checkBtn').click(function() {
						checked = $("input[type=checkbox]:checked").length;

						if(!checked) {
							alert("You must check at least one checkbox.");
							return false;
						}
						$( "#target" ).submit();
					});
					$("input[type='checkbox']").change(function()
					{
						if((this).checked)
						{
							if($(this).attr('id') == 'c2')
							{
								result = 1*document.getElementById('c15').value;
								result += 1*$(this).attr("value");
								result += document.getElementById('s0').value * 25;
								document.getElementById('c15').value = result;
							}
							else if($(this).attr('id') == 'c5')
							{
								result = 1*document.getElementById('c15').value;
								result += 1*document.getElementById('s1').value;
								document.getElementById('c15').value = result;
							}
							else
							{
								console.log(document.getElementById('c15'));
								result = 1*document.getElementById('c15').value;
								result += 1*$(this).attr("value");
								document.getElementById('c15').value = result;
							}
						}
						else
						{
							if($(this).attr('id') == 'c2'){
								result = 1*document.getElementById('c15').value;
								result -= 1*$(this).attr("value");
								result -= document.getElementById('s0').value * 25;
								document.getElementById('c15').value = result;
							}
							else if($(this).attr('id') == 'c5')
							{
								result = 1*document.getElementById('c15').value;
								result -= 1*document.getElementById('s1').value;
								document.getElementById('c15').value = result;
							}
							else
							{
								result = 1*document.getElementById('c15').value;
								result -= $(this).attr("value");
								document.getElementById('c15').value = result;
							}
						}
					});
					$('select').on('change', function()
					{
						if($(this).attr('name') == 's0'){
							if(document.getElementById("c2").checked){
								result = 1*document.getElementById('c15').value;
								result -= s0 * 25;
								result += (this).value * 25;
								document.getElementById('c15').value = result;
							}
							s0 = (this).value;
							result = s0 * 25;
							$('.price').html(' + ' + result + '€');
						}
						else
						{
							if(document.getElementById("c5").checked){
								result = 1*document.getElementById('c15').value;
								result -= 1*s1;
								result += 1*(this).value;
								document.getElementById('c15').value = result;
							}
							s1 = (this).value;
						}
					});
				}
				else if(window.location.pathname.split("/").pop() == 'autoecole.php')
				{
					var select1 = document.getElementById("s1");
					var s1 = 0;
					select1.addEventListener('focus', function () {
						s1 = $(this)[0].value;
					});
					
					$('#SendPerm').click(function() {
						$( "#target" ).submit();
					});
				}
			});
		</script>
	</head>
	<body style="" cz-shortcut-listen="true">
		<div class="navbar navbar-inverse set-radius-zero">
			<div class="container">
				<div class="navbar-header">
<?php
	$currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
	if((empty($_SESSION) || !isset($_SESSION['T2SteamID64'])))
	{
		if( $parts[count($parts) - 1] != 'index.php'){
		header('Location: index.php');
		}
	}
	$UserInfo = Array();
	if(isset($_SESSION['T2SteamID64']))
		$UserInfo = $db->query("Select t.* FROM accounts t WHERE t.steamid = :user", Array('user' => 'steam:'.bc_convert($_SESSION['T2SteamID64'], 10, 16)));
	if(isset($UserInfo[0]))	{
?>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./index.php">

                    <img src="./img/logo.png">
                </a>

            </div>

            <div class="right-div">
				<a href="./logout.php" class="btn btn-danger pull-right"><i class="fa fa-power-off"></i> Déconnexion</a>
            </div>
        </div>
    </div>
		
	<section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="./index.php"><i class="fa fa-home"></i> ACCUEIL</a></li>
                           
                            <li><a href="./monperso.php"><i class="fa fa-user"></i> POLICE</a></li>
                            <li><a href="./mesveh.php"><i class="fa fa-car"></i> EMS</a></li>
							 <li><a href="./mesapp.php"><i class="fa fa-home"></i> DP</a></li>
                             <li><a href="./mesper.php"><i class="fa fa-credit-card"></i> MES PERMIS</a></li>
							<?php
							if(isset($UserInfo[0]) && ($UserInfo[0]['admin'] == '1' || $UserInfo[0]['job'] == 5))
							{
								echo '<li><a href="autoecole.php"><i class="fa fa-taxi"></i> AUTO ECOLE</a></li>';
							}
							if(isset($UserInfo[0]) && ($UserInfo[0]['admin'] == '1' || $UserInfo[0]['job'] == 2))
							{
								echo '<li><a href="police.php"><i class="fa fa-empire"></i> POLICE</a></li>';
							}
							if(isset($UserInfo[0]) && ($UserInfo[0]['admin'] == '1' || $UserInfo[0]['patron'] != 0))
							{
								echo '<li><a href="patron.php"><i class="fa fa-handshake-o"></i> Patron</a></li>';
							}
							?>
						</ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php
	}
else
{
	?>
					<a class="navbar-brand" href="./index.php">
						<img src="./img/logo.png">
					</a>
				</div>
			</div>
		</div>
<?php
}