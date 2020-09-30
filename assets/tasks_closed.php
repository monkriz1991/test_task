<?php
	include 'config.php';
	include 'db.php';

	if (!isset($_SESSION)){session_start();$id_user=$_SESSION['id'];}else{}

	$id_tasks = $_POST['id_tasks'];
	$status = 'closed';

		if (isset($_SESSION['id'])){ 


		$sql = "UPDATE tasks SET status = '$status' WHERE id_tasks ='$id_tasks'";
				$res = mysqli_query($db_connect,$sql);      


		if ($error == ""){
			$result = array('status' => 'ok','text' => $sql);
		} else {
			$result = array('status' => 'error','text' => $error);
		}
		
		$json = json_encode($result);
		echo $json;
	}

?>


