<?php 
include 'connect.php';

function getPrice($url){
	$decode = file_get_contents($url);
	return json_decode($decode, true);
}


$secret = "abc123";

$user = $_GET['user'];
$address = $_GET['address'];
$amount = $_GET['amount'];
// $amount_in_dollars = $_GET['amountInDollars'];
$invoice = $_GET['invoice'];
$callbackSecret = $_GET['callbackSecret'];
// $value = $_GET['value'];
// $value_in_btc = $value / 100000000;

// $btcUSD = getPrice('https://btc-e.com/api/2/btc_usd/ticker');
// $btcPrice = $btcUSD["ticker"]["last"];
// $value_in_dollars = $value_in_btc * $btcPrice;
// $value_in_dollars = round($value_in_dollars, 2);


if($secret != $callbackSecret){
	echo 'wrong password';
} else{
	$sql = "INSERT INTO transactions(transaction, amount_in_usd, amount_in_btc, amount_received_usd, amount_received_btc) VALUES ('$invoice', '10', '10', '10', '10') ";
	if($query = mysqli_query($db_conx, $sql)){
		echo '*ok*';
	}
}
?>