<?php
	
	session_id();
	session_start();
	
	if( !isset($_SESSION['user']) )
		echo '';
	else
		echo $_SESSION['user'];
	
	echo session_id();
?>