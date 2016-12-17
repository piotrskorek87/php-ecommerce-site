<?php 
echo 'hey';

$to = 'petersinclair87@gmail.com';
$subject = 'Payment received';
$body = 'Payment received on invoice'. $_GET['invoice'];
$headers = 'From: sales@yoursite.com'.'\r\n';
$headers .= 'Content-type: text/html\r\n';

$mail = mail($to, $subject, $body, $headers);

if($mail){
	echo 'done';
}



?>