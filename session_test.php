<?php

	// 设置 session_id 为 1 的对话
	session_id('1');
	session_start();
	$_SESSION['U'] = 'ONE';
	session_write_close();
	
	// 设置 session_id 为 2 的对话
	session_id( '2' );
	session_start();
	$_SESSION['U'] = 'TWO';
	session_write_close();
	
	session_id( '1' );
	session_start();
	echo $_SESSION['U'];

?>