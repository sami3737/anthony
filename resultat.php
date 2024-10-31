<?php
	include('header.php');
	if(empty($_SESSION) || !isset($_SESSION['T2SteamID64']))
	{
		header('Location: index.php');
		exit();
	}
?>
    <div class="content-wrapper">
		<div class="container">
			<div class="row pad-botm">
				<div class="col-md-12">
					<h4 class="header-line">RESULTAT</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel">
					<?php
						$result = $db->query("select candidat, count(*) as nbpre from voteelection group by candidat", Array());
					?>
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
					<script type="text/javascript">
					  google.load("visualization", "1", {packages:["corechart"]});
					  google.setOnLoadCallback(drawChart);
					  function drawChart() {
						// Chart 1
						var data = google.visualization.arrayToDataTable([["Name", "Amount"], ["<?php echo $result[0]['candidat']; ?>",<?php echo $result[0]['nbpre']; ?>],
						["<?php echo $result[1]['candidat']; ?>",<?php echo $result[1]['nbpre']; ?>],
						["<?php echo $result[2]['candidat']; ?>",<?php echo $result[2]['nbpre']; ?>],
						["<?php echo $result[3]['candidat']; ?>",<?php echo $result[3]['nbpre']; ?>]]);
						var options = {
						  title: 'Résultats des votes'
						};
						var chart = new google.visualization.PieChart(document.getElementById('piechart'));
						chart.draw(data, options);
					  }
					</script>

					<div id="piechart" style="width: 100%; height: 500px;">&nbsp;</div>
					</div>
				</div>
			</div>

		</div>
    </div>
    
	<?php
		include('footer.php');

