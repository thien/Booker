<?php
//This function returns True if visitor is either in the same IP as the Remote IP of where the server is held, (server is held at the nail bar)
//Or the client is in 

//Otherwise it returns False

function CheckAccess() {
	if ($_SERVER['SERVER_ADDR'] == ($_SERVER['REMOTE_ADDR']){
		return true;
	} 
	
//	else {
//		if (strpos($_SERVER['REMOTE_ADDR'],'192.168.0') !== false) {
//		    return true;
//		} else {
//		return false;
//		}
//	}
}

echo CheckAccess();

?>