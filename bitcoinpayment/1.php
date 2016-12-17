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
echo 'Please send payment to'. $blockChainAPI['input_address']; //to start the process and send callback variables

echo '<br/><br/><a href="bitcoin:'. $address .'?amount='. $amount .'&message='. $note .'">Bitcoin URI link</a>'; //for a bitcoin wallet
?>