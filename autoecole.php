<?php
	include('header.php');
	$UserInfo = $db->query("Select t.*, s.job_name FROM users t, jobs s WHERE identifier = :user && t.job = s.job_id", Array('user' => 'steam:'.bc_base_convert($_SESSION['T2SteamID64'], 10, 16)));

	if(isset($UserInfo[0]) && (isset($UserInfo[0]['job']) && $UserInfo[0]['job'] == 5 || $UserInfo[0]['group'] == 'superadmin'))
	{
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
					<h4 class="header-line">AUTO ECOLE</h4>
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

			if(isset($_POST) && isset($_POST['c00']) && $_POST['c00'] != '')
			{
				$query = $db->query('UPDATE users SET '.$_POST['s1'].' = 12 where identifier = :user', Array('user' => $_POST['c00']));
				$permis = '';
				switch($_POST['s1'])
				{
					case 'permisauto':
					$permis = 'Voiture';
					break;
					case 'permisavion';
					$permis = 'Avion';
					break;
					case 'permiscamion';
					$permis = 'Camion';
					break;
					case 'permismoto';
					$permis = 'Moto';
					break;
					case 'permisbateau';
					$permis = 'Bateau';
					break;
				}
				echo 'Permis '.$permis.' donner à '.$_POST['c0'].'.';
			}
			echo '<div id="players" style="position:absolute; left:70%"><ul id="list"></ul></div>';
			echo '<div id="center">';
			?>
			<script type="text/javascript">
				$( document ).ready(function() {
					$( "#c0" ).keyup(function(data) {
						if($(this).val().length > 1)
						{
							$("#list").load('players.php', {string:$(this).val()});
						}
					});
				});
			</script>
			<form id="target" action="autoecole.php" method="POST">
				<legend>Nom du civil</legend>
				<input type="text" name="c0" id="c0" required/><br/><br/>
				<input type="hidden" name="c00" id="c00"/>
				<select id="s1"  name="s1">
					<option value="permisauto" selected="selected">Permis voiture</option>
					<option value="permisbateau">Permis bateau</option>
					<option value="permiscamion">Permis camion</option>
					<option value="permismoto">Permis moto</option>
					<option value="permisavion">Permis avion</option>
				</select><br/>
				<input type="button" value="Donner permis" id="SendPerm">
			</form>
			</div>
		<?php
	}
	else
		header('Location: index.php');
	?>
					</div>
				</div>
			</div>
		</div>
    </div>
    
	<?php
		include('footer.php');