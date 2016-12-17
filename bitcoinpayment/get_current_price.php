<?php 
function getPrice($url){
	$decode = file_get_contents($url);
	return json_decode($decode, true);
}

$btcUSD = getPrice('https://btc-e.com/api/2/btc_usd/ticker');
$btcPrice = $btcUSD["ticker"]["last"];

$btcDisplay = round($btcPrice, 2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		h1{
			font-family: "Calibri", Arial, sans-serif;
			font-size: 60px;
		}
		#container{
			font-family: "Calibri", Arial, sans-serif;
			font-size: 42px;
			border:4px solid #999999;
			border-radius: 6px;
			height: 60px;
			width: 500px;
		}
	</style>
	<script>
	function btcConvert(input){
		if(isNaN(input.value)){
			input.value = 0;
		}
		var price = "<?php echo $btcDisplay; ?>";
		var output = input.value * price;
		var co = document.getElementById('ci');
		co.value = output.toFixed(2);
	}
	function usdConvert(input){
		if(isNaN(input.value)){
			input.value = 0;
		}
		var price2 = "<?php echo $btcDisplay; ?>";
		var output2 = input.value / price;
		var co = document.getElementById('bi');
		co.value = output.toFixed(8);
	</script>
</head>
<body>
<h1>Awsome Bitcoin!</h1>
<div id="container">
	<input type="text" name="bi" id="bi" onchange="btcConvert(this);" onkeyup="btcConvert(this);"> BTC = <input type="text" name="ci" id="ci" onchange="usdConvert(this);" onkeyup="usdConvert(this);"> USD

	<?php $btcDisplay; ?>
</div>	
	
</body>
</html>