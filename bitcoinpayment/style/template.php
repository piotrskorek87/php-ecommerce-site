<?php 

$secret = "Pmc1Pmc1!@#";
$address = "1J7LbX9FVow46tKCWSQ6aQRU6qwtcsraPg";
$invoice = 101;
$amount = 0.00;
$user = 'bill';

$note = "Donation";

$callback = 'http://bitcoinpayment.cba.pl/callback.php?user='. $user .'address='. $address .'amount='. $amount .'invoice='. $invoice .'&secret='. $secret;
$blockChainAPI = json_decode(file_get_contents('https://blockchain.info/api/receive?method=create&address='. $address .'&callback='. urlencode($callback)), true);

$btcAddress = $blockChainAPI['input_address'];
//echo 'Please send payment to'. $blockChainAPI['input_address']; //to start the process and send callback variables

//echo '<br/><br/><a href="bitcoin:'. $address .'?amount='. $amount .'&message='. $note .'">Bitcoin URI link</a>'; //for a bitcoin wallet
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<div id="mainContent">
		<span id="btcAmount"><?php echo $amount; ?> BTC</span> 
		<a id="payButton" href="bitcoin:'. $address .'?amount='. $amount .'&message='. $note .'"><img src="images/pay_with_bitcoin.png" alt="pay with bitcoin"></a>
		<img id="qrCode" src="qrcode.php?text=http://www.google.com.pl&size=250&padding=10" alt="QR Code">
		<span id="btcAdress"><?php echo $btcAddress; ?></span> 
	</div>
</body>
</html>