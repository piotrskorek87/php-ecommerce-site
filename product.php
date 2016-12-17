<?php 
include 'storescripts/connect_to_mysql.php';
?>

<?php 
// This file is www.developphp.com curriculum material
// Written by Adam Khoury January 01, 2011
// http://www.youtube.com/view_play_list?p=442E340A42191003
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
// Check to see the URL variable is set and that it exists in the database
if (isset($_GET['id'])) {
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
	// Use this var to check to see if this ID exists, if yes then get the product 
	// details, if no then exit this script and give message why
	$sql = mysqli_query($db_conx, "SELECT * FROM products WHERE id='$id' LIMIT 1");
	$productCount = mysqli_num_rows($sql); // count the output amount
    if ($productCount > 0) {
		// get all the product details
		while($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)){ 
			 $product_name = $row["product_name"];
			 $price = $row["price"];
			 $details = $row["details"];
			 $category = $row["category"];
			 $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        }
		 
	} else {
		echo "That item does not exist.";
	    exit();
	}
		
} else {
	echo "Data to render this page is missing.";
	exit();
}
mysqli_close($db_conx);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $product_name; ?></title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>
  <div id="mainWrapper">
    <?php include_once("template/template_header.php"); ?>
    <div class="clearfix"></div>
    <div id="pageContent">
      <div class="product_page_contentWrapper">
        <div class="product_page_img">
          <a href="inventory_images/<?php echo $id; ?>.jpg"><img src="inventory_images/<?php echo $id; ?>.jpg" alt="<?php echo $id; ?>.jpg" width= "100%" height= "100%"></a>
        </div>
        <div class="product_page_description">
          <?php echo $product_name; ?>  <br>
          $ <?php echo $price; ?> <br>
          <?php echo $details; ?> <br><br>
          <form action="cart.php" method="post" id="form1" name="form1">
            <input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>">
            <input type="submit" name="button" id="button" class="button" value="Dodaj do koszyka">
          </form>
        </div>
        
      
    </div>    
    <div class="clearfix"></div>
    <?php include_once("template/template_footer.php"); ?>    
  </div>
</body>
</html>