<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PAY WITH BITCOIN</title>
</head>
<body>
	<form action="payment_parser.php" method="POST">
		Invoice: <input type="text" name="invoice"><br>
		Amount:  <input type="text" name="amount"><br>
		User:    <input type="text" name="user"><br>
		<input type="submit" value="SEND">
	</form>
</body>
</html>