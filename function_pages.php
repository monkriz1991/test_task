<?php

function myForeach($data_filter){
		
    if(is_array($data_filter)){
        foreach($data_filter as $key => $value){
        	 if ($key == 'name') {
        	 	foreach ($value as $valueName) {
					$nameString .= ' or users.name = "'.$valueName.'"';
				}
        	 }
        	 if ($key == 'email') {
        	 	foreach ($value as $valueName) {
					$emailString .= ' or users.email = "'.$valueName.'"';
				}
        	 }
        	 if ($key == 'status') {
        	 	foreach ($value as $valueName) {
					$statusString .= ' or tasks.status = "'.$valueName.'"';
				}
        	 }
				
        }
    }else{echo 'error'; }

	    if (!empty($nameString)) {
	    	$nameString = substr($nameString, 3);
	    	$nameString = ' or ( '.$nameString.' ) ';
	    }
	    if (!empty($emailString)) {
	    	$emailString = substr($emailString, 3);
	    	$emailString = ' or ( '.$emailString.' ) ';
	    }
	   	if (!empty($statusString)) {
	   		$statusString = substr($statusString, 3);
	    	$statusString = ' and ('.$statusString.' ) ';
	    }	    

	    	$whereString = $nameString.$emailString.$statusString;
	    	if (!empty($whereString)) {
	    		$resultString = 'where '.substr($whereString, 4);
			}
	return $resultString;
}


?>
