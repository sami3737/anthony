<?php
if(isset($_POST['string']))
{
	require(__DIR__ . './api/mysql/Db.class.php');
	$db = new DB();
	if(isset($_POST['data']))
		$select = $db->query("SELECT * FROM users WHERE (nom like CONCAT('%',:id,'%') or prenom like CONCAT('%',:idd,'%')) and job = 1 and patron = 0", Array('id' => $_POST['string'], 'idd' => $_POST['string']));
	else
		$select = $db->query("SELECT * FROM users WHERE nom like CONCAT('%',:id,'%') or prenom like CONCAT('%',:idd,'%')", Array('id' => $_POST['string'], 'idd' => $_POST['string']));
	
	if(!isset($select['ERROR']))
	{
		for ($i = 0; $i < count($select); $i++)
		{
			echo '<li data='.$select[$i]['identifier'].'>'.$select[$i]['nom'].' '.$select[$i]['prenom'].'</li>';
		}
		echo '<script type="text/javascript">
			$("#list li").click(function() {
				document.getElementById("c0").value = $(this).text();
				document.getElementById("c00").value = $(this).attr("data");
			});
		</script>';
	}
}
?>