<?php
	$string = <<<XML
<?xml version='1.0'?>
<document>
<cmd t='10' >login</cmd>
<login>imdonkey</login>
<c t='20' s='34' />
</document>
XML;

	$xml = simplexml_load_string( $string );
	print_r($xml);
	echo $xml->cmd->attributes()."\r\n";
	
	return;
	
	$login = $xml->login;					//这里返回的依然是个SimpleXMLElement对象
	print_r($login);
	$login = (string) $xml->login;			//在做数据比较时，注意要先强制转换
	print_r($login);
?>