<?php 
include 'storescripts/connect_to_mysql.php';
?><?php 
// This file is www.developphp.com curriculum material
// Written by Adam Khoury January 01, 2011
// http://www.youtube.com/view_play_list?p=442E340A42191003
session_start(); // Start session first thing in script
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 1 (if user attempts to add something to the cart from the product page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
	$wasFound = false;
	$i = 0;
	// If the cart session variable is not set or cart array is empty
	if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
	    // RUN IF THE CART IS EMPTY OR NOT SET
		$_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
	} else {
		// RUN IF THE CART HAS AT LEAST ONE ITEM IN IT
		foreach ($_SESSION["cart_array"] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $pid) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
					  $wasFound = true;
				  } // close if condition
		      } // close while loop
	       } // close foreach loop
		   if ($wasFound == false) {
			   array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
		   }
	}
	header("location: cart.php"); 
    exit();
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 2 (if user chooses to empty their shopping cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 3 (if user chooses to adjust item quantity)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
    // execute some code
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
	if ($quantity >= 100) { $quantity = 99; }
	if ($quantity < 1) { $quantity = 1; }
	if ($quantity == "") { $quantity = 1; }
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $item_to_adjust) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
				  } // close if condition
		      } // close while loop
	} // close foreach loop
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 4 (if user wants to remove an item from cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
    // Access the array and run code to remove that array index
 	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 5  (render the cart for the user to view on the page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cartOutput = "";
$cartTotal = "";
$pp_checkout_btn = '';
$bitcoin_checkout_btn ='';
$invoice = '';
$product_id_array = '';
$product_id_array = '';
$paypal_email = '';

$sql = mysqli_query($db_conx, "SELECT email FROM paypal_credentials LIMIT 1");
while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
	$paypal_email = $row["email"];
}

if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Twój koszyk jest pusty</h2>";
} else {
	$pp_checkout_btn .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="'. $paypal_email .'">';
	// Start the For Each loop
	$i = 0; 
    foreach ($_SESSION["cart_array"] as $each_item) { 
		$item_id = $each_item['item_id'];
		$sql = mysqli_query($db_conx, "SELECT * FROM products WHERE id='$item_id' LIMIT 1");
		while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
			$product_name = $row["product_name"];
			$price = $row["price"];
			$details = $row["details"];
		}
		$totalPrice = $price * $each_item['quantity'];
		$cartTotal = $cartTotal + $totalPrice;
		$totalPrice = number_format($totalPrice, 2);
		$cartTotal = number_format($cartTotal, 2);

		$invoice .= $product_name .'|'. $price .'|'. $each_item['quantity'] .'|'. $totalPrice .'|||';

		$x = $i + 1;
		$pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">
       						<input type="hidden" name="amount_' . $x . '" value="' . $price . '">
       						<input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';

       	$product_id_array .= "$item_id-".$each_item['quantity'].","; 

		$cartOutput .= '<div class="cartOutput">
							<div class="cartCol1"><div><a href ="product.php?id=' . $item_id . '">' . $product_name . '</a></div><div><img src="inventory_images/' . $item_id . '.jpg" alt="' . $item_id . '.jpg" width="40px" height="52px" border="1px"></div></div>
							<div class="cartCol2">' . $details . '</div>
							<div class="cartCol3">$ ' . $price . '</div>
							<div class="cartCol4">
								<form action="cart.php" method="post">
								<input type="text" name="quantity" value="' . $each_item['quantity'] . '" size="1" maxlenght="2">
								<input type="submit" class="button" name="adjustBtn' . $item_id . '" value="Zmień">
								<input type="hidden" name="item_to_adjust" value="' . $item_id . '">
								</form>
							</div>
							<div class="cartCol5">$ ' . $totalPrice . '</div>
							<div class="cartCol6">
								<form action="cart.php"	method="post">
								<input type="submit" class="button" name="deleteBtn' . $item_id . '" value="X">
								<input type="hidden" name="index_to_remove" value="' . $i . '">
								</form>
							</div>
						</div>';
		$i++;					
	}
}
	$cartTotal = "Łączna cena produktów: $" . $cartTotal . " USD";

	$pp_checkout_btn .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
	<input type="hidden" name="notify_url" value="http://www.petersinclai.nazwa.pl/ecommerce/storescripts/my_ipn_script.php">
	<input type="hidden" name="return" value="http://www.petersinclai.nazwa.pl/ecommerce/finalization.php?success=true">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="cbt" value="Return to The Store">
	<input type="hidden" name="cancel_return" value="http://www.petersinclai.nazwa.pl/ecommerce/finalization.php?success=false">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="currency_code" value="USD">
	<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit"  alt="Pay with PayPal. It\'s easy and safe">
	</form>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Twój Koszyk</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<div id="mainWrapper">
		<?php include_once("template/template_header.php"); ?>
		<div class="clearfix"></div>
		<div id="pageContent">
		<div>
			
		<br><br>
		<?php 
			if (isset($_SESSION["cart_array"])) {
   			echo '<div class="cartOutputHeader">
					  <div class="cartCol1a">Produkt</div>
					  <div class="cartCol2">Opis</div>
			    	  <div class="cartCol3">Cena</div>
					  <div class="cartCol4">Ilość</div>
					  <div class="cartCol5">Suma</div>
					  <div class="cartCol6">Usuń</div>
				  </div>';	
			}
		?>

		<?php echo $cartOutput; ?>
		
		<div class="clearfix"></div>

		<?php 
			if (isset($_SESSION["cart_array"])){
				echo $cartTotal;
				echo '<br/><br/><br/>';
				echo $pp_checkout_btn; 
				echo '<a href="cart.php?cmd=emptycart">Kliknij tutaj by opróżnić koszyk</a>';
			}
		?>
		</div>	
		<br>		
		</div>		
		<div class="clearfix"></div>
		<?php include_once("template/template_footer.php"); ?>		
	</div>
</body>
</html>


	
	