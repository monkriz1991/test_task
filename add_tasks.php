<?php

include 'assets/config.php';
include 'assets/db.php';
// include 'function.php';

	$name = $_POST['name'];
	$email = $_POST['email'];
	$text = $_POST['text'];
	$status = 'new';

	//Дата создания задания
	$date = date("Y-m-d H:i:s");
	
	if(empty($email)){

		$answer = 'Поле Email <br>не может быть пустым!';

	}else{

		if(!preg_match('/[\.a-z0-9_\-]+[@][a-z0-9_\-]+([.][a-z0-9_\-]+)+[a-z]{1,4}/i', $email)){

		   $answer =  'Неправильно введен E-mail'.'<br>';

			}else{
			
				//Получаем ХЕШ соли
				$password = $salt;
				
				/*Если все хорошо, пишем данные в базу, table users*/
				$sql_insert_users = 'INSERT INTO `users`
					VALUES(
							NULL,
							"'. $name .'",
							"'. $email .'",
							"'. md5($password) .'",
							"'. $status .'"
							)';
								
				$res = mysqli_query($db_connect,$sql_insert_users);

				$sql_last_users = 'SELECT max(id_user) as last_id from users';
				$row_last_users = mysqli_fetch_assoc(mysqli_query($db_connect,$sql_last_users));
				$last_insert_id_user = $row_last_users['last_id'];

				/*Если все хорошо, пишем данные в базу, table tasks*/
				$sql_insert_tasks = 'INSERT INTO `tasks`
					VALUES(
							NULL,
							"'. $last_insert_id_user .'",
							"'. $status .'",
							"'. $text .'",
							"'. $date .'"
							)';
								
				$res = mysqli_query($db_connect,$sql_insert_tasks);

			}
	}	


	if ($error == ""){
		$result = array('status' => 'ok','text' => $answer);
	} else {
		$result = array('status' => 'error','text' => $error);
	}
	
	$json = json_encode($result);
	echo $json;		
?>