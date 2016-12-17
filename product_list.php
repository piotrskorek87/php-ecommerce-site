<?php 
include 'storescripts/connect_to_mysql.php';
?><?php 
// This file is www.developphp.com curriculum material
// Written by Adam Khoury January 01, 2011
// http://www.youtube.com/view_play_list?p=442E340A42191003
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
?><?php //Query six latests items
  if(isset($_GET['category'])){
  	  $category = mysqli_real_escape_string($db_conx, $_GET['category']);
  	  $product_list="";
	  $sql = "SELECT * FROM products WHERE id > 1 AND category = '$category' ORDER BY RAND() LIMIT 5";
	  $query = mysqli_query($db_conx, $sql);
	  $num_rows = mysqli_num_rows($query);
	  if($num_rows > 0) {
	  while($rows = mysqli_fetch_array($query, MYSQLI_ASSOC)){
	    $id = $rows['id'];
	    $product_name = $rows['product_name'];
	    $details =  $rows['details'];
	    $price = $rows['price'];
	    $date_added = strftime("%b %d, %Y", strtotime($rows['date_added']));
	    $product_list .='<div class="img">
	            <a href="product.php?id=' . $id . '"><img src="inventory_images/' . $id . '.jpg" alt="' . $id . '.jpg" width= "100%" height= "100%"></a>
	            </div>
	            <div class="description">
	            ' . $product_name . '  <br>
	            $ ' . $price . ' <br>
	            ' . $details . ' <br><br>
	            <a class="button" href="product.php?id=' . $id . '">Zobacz opis produktu</a>
	            </div>';
		  }
	  } else {
		  $product_list='"You have no products listed in your store yet"';
	  }
  } else{
  	header("location: index.php"); 
    exit();
  }
?>

<?php 
$categories = "";   
$sql2 = "SELECT DISTINCT category FROM categories WHERE id > 0";
$query2 = mysqli_query($db_conx, $sql2);
$num_rows2 = mysqli_num_rows($query2);
if($num_rows2 > 0) {
  while($rows2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)){
    $category = $rows2['category'];
    $categories .= '<a href="product_list.php?compound=' . $category . '">' . $category . '</a></br>';
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kategoria</title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>
  <div id="mainWrapper">
    <?php include_once("template/template_header.php"); ?>
    <div class="clearfix"></div>
    <div id="pageContent">
      
      <div class="contentWrapper">
        <div class="col1">
          <p>Categories</p>
            <?php echo $categories. '<br/><br/>'; ?>
        </div>
        <div class="col2">
          <?php echo $product_list; ?>
        </div>
      </div>
    </div>    
    <div class="clearfix"></div>
    <?php include_once("template/template_footer.php"); ?>    
  </div>
</body>
</html>