<?php
	$key_str = '';
	for( $i=0; $i<16; $i++ )
		$key_str .= dechex( rand(0,255) );
	echo strlen($key_str)."    $key_str\r\n";
?>