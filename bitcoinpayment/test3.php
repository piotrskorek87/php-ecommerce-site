if($amount != $parseBalance){
	echo 'Error';
	exit();
} else{
	$sql = "UPDATE users SET active='1' WHERE user='$user'";
	$query = mysqli_query($db_conx, $sql);
	echo '*ok*';
}


$balance = json_decode(file_get_contents('https://blockchain.info/merchant/$ID/address_balance?password=$password&address=$address&confirmations=0'), true);
$parseBalance = $balance[balance];

echo $value_in_btc;
echo $user;
echo $amount;

if($secret != $callbackSecret){
	echo 'Error';
	return;
} else{
	echo 'secret correct';
}