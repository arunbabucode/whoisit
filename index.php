<?php
/***
 * #@Modified by _MR.425
 * #@Copyright EthicalHavoc.net
 */
$mobile_number = $_GET['number'];
if(!is_dir("Cookies"))
{
	mkdir("Cookies");
}

$url1 = "http://site2sms.com/auth.asp";
$url2 = "http://www.site2sms.com/user/track_mobile.asp";
$mobnum = "9605575598"; // enter your number
$pass = "951693"; // enter your password
//$cookiefile = rand(1, 9999).'.txt';
$cookiefile = '387.txt';
$cookies = str_replace('\\', '/', dirname(__FILE__).'/Cookies/'.$cookiefile);
$useragent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.26 Safari/537.36";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$mobnum&Password=$pass&submit_btn=Log+In");
curl_exec($ch);
curl_setopt($ch, CURLOPT_URL, $url1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookies);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookies);
curl_setopt($ch, CURLOPT_COOKIE, "s2s%5Fcaptcha=67379");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "txtSource=captcha&txtCaptchaCode=949");
curl_exec($ch);
//$html = file_get_contents('./Cookies/'.$cookiefile);
//preg_match("/s2s%5Fsession(.*)/i", $html,$sessioncookies);
curl_setopt($ch, CURLOPT_URL, $url2);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "action=Track&txtMobile=".$mobile_number."&Submit=Track+Mobile+Location%21");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_REFERER, "http://site2sms.com/verification.asp?source=login");
//curl_setopt($ch, CURLOPT_COOKIE, "s2s%5Fsession=$sessioncookies[1]");
$result=curl_exec($ch);
//echo $result;
curl_close($ch); 
//$wanted = preg_replace('/<[^>]*>/', "\n",$result);
//echo $wanted;

if (strpos($result,'Please Enter Valid 10 Digit Mobile Number which you want to track') !== false) {
    echo 'Incorrect Mobile Number';
}
elseif(strpos($result,'unable') !== false){
echo 'unable';
}
else
{
$startStr = '<b>Mobile Number: </b>';
$endStr = '<b>Mobile Operator Name:</b>';

$startStrPos = strpos($result, $startStr)+strlen($startStr);
$endStrPos = strpos($result, $endStr);

$wanted = substr($result, $startStrPos, $endStrPos-$startStrPos );
//$wanted=str_replace("\n","\n\r",$wanted );
$wanted = preg_replace('/<[^>]*>/', "\n", $wanted);
$wanted = str_replace('91', "\n", $wanted);
$wanted = str_replace('Name:', "\n", $wanted);
$wanted = str_replace($mobile_number, "\n", $wanted);
//$wanted = explode("\r\n", $wanted);
$string = trim(preg_replace('/\s+/', ' ', $wanted));
echo $string;
}

// Now you can do what ever you want in site2sms with the $sessioncookies[1]
//for more help u can PM me!
//_MR.425
?>