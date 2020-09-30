<?php

	$db_connect = mysqli_connect( DBSERVER, DBUSER, DBPASSWORD, DATABASE ) or die('Error. Can`t connect to MySQL server.');
	mysqli_set_charset($db_connect, "utf8");

?>