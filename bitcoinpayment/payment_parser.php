<?php 
$invoice = $_POST['invoice'];
$amount = $_POST['amount'];
$user = $_POST['user'];

$secret = "abc123";
$address = "1Hdst3TTHcvpB6qtVPxgctHRjGbYwD6Jfo";
$label = 'Money from '. $user;
$note = "EMPTY FOR NOW";

$callback = 'http://bitcoin.bugs3.com/callback.php?user='. $user .'address='. $address .'amount='. $amount .'invoice='. $invoice .'&callbackSecret='. $secret;
$blockChainAPI = json_decode(file_get_contents('https://blockchain.info/api/receive?method=create&address='. $address .'&callback='. urlencode($callback)), true);

$btcAddress = $blockChainAPI['input_address'];

$href = 'bitcoin:'. $address .'?amount='. $amount .'&message='. $note .'&label='. $label;




?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PAY WITH BITCOIN</title>
	<link rel="stylesheet" href="style/style.css">
<script>
function countDown(secs){
	if(secs < 1){
		clearTimeout(timer);
		window.location = "index.php";
	}
secs--;
var timer = setTimeout('countDown('+ secs +')', 1000);
}
</script>
</head>
<body>
	<div id="mainContent">
		<span id="btcAmount"><?php echo $amount; ?> BTC</span> 
		<a id="payButton" href="<?php echo $href; ?>"><img src="images/pay_with_bitcoin.png" alt="pay with bitcoin"></a>
		<img id="qrCode" src="qrcode.php?text=http://<?php echo $href; ?>&size=250&padding=10" alt="QR Code">
		<span id="btcAdress"><?php echo $btcAddress; ?></span> 
	</div>
</body>
<script>
	countDown(60);
</script>
</html>
