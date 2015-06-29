<?php
//--------第一种AES-CBC加密方案--------
//仅为理解之用
$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, ''); #128位 = 16字节 iv必须16字节
$key128 = '1234567890123456';
$iv =  '1234567890123456';
$cleartext = 'hello'; #待加密的字符串
if (mcrypt_generic_init($cipher, $key128, $iv) != -1)
{
	// PHP pads with NULL bytes if $cleartext is not a multiple of the block size..
	//如果$cleartext不是128位也就是16字节的倍数，补充NULL字符满足这个条件，返回的结果的长度一样
	$cipherText = mcrypt_generic($cipher,$cleartext );
	mcrypt_generic_deinit($cipher);
	
	// Display the result in hex.
	//很明显，结果也是16字节的倍数.1个字节用两位16进制表示，所以下面输出的是32的倍数位16进制的字符串 
	echo '第一种AES加密方案:<br>';
	printf("128-bit encrypted result:/n%s/n/n",bin2hex($cipherText));
	echo '<br>';echo '<br>';
}
//--------第一种AES加密方案--------
?>