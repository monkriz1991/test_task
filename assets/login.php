<?php

include 'config.php';
include 'db.php';

	$login = $_POST['login'];
	$password = $_POST['password'];

	$answer = '';

	if(empty(str_replace(" ","",$_POST['login']))){
		$answer = 'Не введен Логин';
	}
	else{
		if(empty(str_replace(" ","",$_POST['password']))){
			$answer = 'Не введен Пароль';
		}
		else{

			$sql = 'SELECT * 
					FROM `users`
					WHERE `name` = "'. str_replace(" ","",$login) .'"
					AND `status` = "admin"';
			$res = mysqli_query($db_connect,$sql);
			
			if(mysqli_num_rows($res) > 0){

				$row = mysqli_fetch_assoc($res);
				if(md5(md5(str_replace(" ","",$_POST['password'])).$row['salt']) == $row['password'])
				{
					
					session_start();
					$_SESSION['auth'] = true; 
					$_SESSION['id'] = $row['id_user']; 
					$_SESSION['login'] = $row['name']; 

					//Пишем в сессию статус пользователя (приоритет):
					$_SESSION['staus'] = 'admin'; 
					$answer = 'ok';
				}
				else{
					$answer = 'Неверный пароль!';
				}

			}
			else{
				$answer = 'Логин: '. str_replace(" ","",$login) .' не найден!';
			}
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