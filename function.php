<?php

	function password(){
		$password="";
		$letters = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
		$word_lenght = 5;
		$size_letters = strlen($letters)-1;
		for($i=0;$i<5;$i++){
			while($word_lenght--){
				$password.=$letters[rand(0,$size_letters)];
			}
			$word_lenght = 10;
			$password_value=$password;
			$password = '';
		}
		salt($password_value)
	}

	function salt($password_value){

		$salt = substr(md5(uniqid()), -8);
		$salt = md5(md5($password_value).$salt);
		return $salt;
	}

?>