<?php
//--------第二种AES-ECB加密方案--------
//加密
echo '第二种AES加密方案:<br>';
$key = '1234567890123456';
$content = 'hello';
$padkey = pad2Length($key,16);
$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
$iv_size = mcrypt_enc_get_iv_size($cipher);
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); #IV自动生成？
echo '自动生成iv的长度:'.strlen($iv).'位:'.bin2hex($iv).'<br>';
if (mcrypt_generic_init($cipher, pad2Length($key,16), $iv) != -1)
{
    // PHP pads with NULL bytes if $content is not a multiple of the block size..
    $cipherText = mcrypt_generic($cipher,pad2Length($content,16) );
    mcrypt_generic_deinit($cipher);
    mcrypt_module_close($cipher);
   
    // Display the result in hex.
    printf("128-bit encrypted result:/n%s/n/n",bin2hex($cipherText));
    print("<br />");
   
}
//解密
$mw = bin2hex($cipherText);
$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
if (mcrypt_generic_init($td, $padkey, $iv) != -1)
{
    $p_t = mdecrypt_generic($td, hexToStr($mw));
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
   
    $p_t = trimEnd($p_t);
    echo '解密:';
    print($p_t);
    print("<br />");
    print(bin2hex($p_t));
    echo '<br><br>';
}
//将$text补足$padlen倍数的长度
function pad2Length($text, $padlen){
    $len = strlen($text)%$padlen;
    $res = $text;
    $span = $padlen-$len;
    for($i=0; $i<$span; $i++){
        $res .= chr($span);
    }
    return $res;
}
//将解密后多余的长度去掉(因为在加密的时候 补充长度满足block_size的长度)
function trimEnd($text){
    $len = strlen($text);
    $c = $text[$len-1];
    if(ord($c) <$len){
        for($i=$len-ord($c); $i<$len; $i++){
            if($text[$i] != $c){
                return $text;
            }
        }
        return substr($text, 0, $len-ord($c));
    }
    return $text;
}
//16进制的转为2进制字符串
function hexToStr($hex) 
{ 
    $bin=""; 
    for($i=0; $i<strlen($hex)-1; $i+=2) 
    {
        $bin.=chr(hexdec($hex[$i].$hex[$i+1])); 
    }
    return $bin; 
}
//--------第二种AES加密方案--------