<?php
	include('header.php');
	if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']))
	{
		header('Location: index.php');
		exit();
	}
	$UserInfo = $db->query("Select * FROM users WHERE identifier = :user ", Array('user' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));
	$voteur = $db->query("Select * FROM voteelection WHERE electeur = :user ", Array('user' => $UserInfo[0]['nom'].' '.$UserInfo[0]['prenom']));
	if(isset($_POST) && !empty($_POST))
	{
		$insert = $db->query("INSERT INTO `voteelection`(`electeur`, `vote`, `date-heure`, `candidat`) VALUES (:electeur, :vote, :date, :candidat)", Array('electeur' => $_POST['c0'], 'vote' => 1, 'date' => date("Y-m-d H:i:s"), 'candidat' => $_POST['candidat']));
		if(isset($voteur[0]))
		{
			echo 'Vous ne pouvez voter qu\'une seule fois';
			echo '<script language="Javascript">
			   <!--
				setTimeout(function()
				{
					document.location.replace("index.php");
				}, 2000);
			   // -->
			</script>';
			exit();
		}
		else
		{
			echo 'Merci pour votre vote.';
			echo '<script language="Javascript">
			   <!--
				setTimeout(function()
				{
					document.location.replace("index.php");
				}, 2000);
			   // -->
			</script>';
			exit();
		}
	}
	if(isset($voteur[0]))
	{
		echo '<script language="Javascript">
           <!--
                 document.location.replace("index.php");
           // -->
		</script>';
		exit();
	}
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
					<h4 class="header-line">VOTE</h4>
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
			?>
			<form id="target" action="vote.php" method="POST">
				<input type="hidden" name="c0" id="c0" value="<?php echo $UserInfo[0]['nom'].' '.$UserInfo[0]['prenom']; ?>" readonly/>
				<input type="radio" name="candidat" value="GLAZKOV Igor"/>GLAZKOV Igor<br/>
				<input type="radio" name="candidat" value="WILLIAMS Derek"/>WILLIAMS Derek<br/>
				<input type="radio" name="candidat" value="DJUDI Reswan"/>DJUDI Reswan<br/>
				<input type="radio" name="candidat" value="STARK Tony"/>STARK Tony<br/>
				<input type="radio" name="candidat" value="BLANC"/>BLANC<br/>
				<input type="submit" value="Voter" id="checkBtn">
			</form>
			</div>
			<div>
			</div>
		<?php
		}
			?>					
					</div>
				</div>
			</div>

		</div>
    </div>
    
	<?php
		include('footer.php');

