<?php
//--------第三种AES-ECB加密方案--------
echo '第三种AES加密方案:<br>';
$key = '1234567890123456';
$key = pad2Length($key,16);
$iv = 'asdff';
$content = 'hello';
$content = pad2Length($content,16);
$AESed =  bin2hex( mcrypt_encrypt(MCRYPT_RIJNDAEL_128,$key,$content,MCRYPT_MODE_ECB,$iv) ); #加密
echo "128-bit encrypted result:".$AESed.'<br>';
$jiemi = mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$key,hexToStr($AESed),MCRYPT_MODE_ECB,$iv); #解密
echo '解密:';
echo trimEnd($jiemi);
//--------第三种AES加密方案--------
?>