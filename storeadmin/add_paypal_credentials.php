<?php 
// This file is www.developphp.com curriculum material
// Written by Adam Khoury January 01, 2011
// http://www.youtube.com/view_play_list?p=442E340A42191003
session_start();
if (!isset($_SESSION["manager"])) {
    header("location: admin_login.php"); 
    exit();
}
// Be sure to check that this manager SESSION value is in fact in the database
$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
// Connect to the MySQL database  
include "../storescripts/connect_to_mysql.php"; 
$sql = mysqli_query($db_conx, "SELECT * FROM admin WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1"); // query the person
// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysqli_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
   echo "Your login session data is not on record in the database.";
     exit();
}
?>
<?php 

if (isset($_POST['email'])) {
  
  $email = mysqli_real_escape_string($db_conx, $_POST['email']);

$sql = mysqli_query($db_conx, "SELECT * FROM paypal_credentials LIMIT 1");
$existCount = mysqli_num_rows($sql);
if ($existCount == 0) { 
  $sql = mysqli_query($db_conx, "INSERT INTO paypal_credentials (email) 
        VALUES('$email')");
} elseif($existCount == 1){
  while($row = mysqli_fetch_array($sql)){ 
    $id = $row["id"];
  }
  $sql = mysqli_query($db_conx, "UPDATE paypal_credentials SET email = '$email' WHERE id = '$id'");  
}



}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dodaj dane Paypal</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div  id="mainWrapper">
  <?php include_once("../template/template_header.php");?>
  <div id="pageContent" align="center"><br />
  <form action="add_paypal_credentials.php" method="post">
    <label>Podaj email</label>
    <input type="text" name="email">   
    <input type="submit" value="Wyślij"> 
  </form>
  </div>
  <?php include_once("../template/template_footer.php");?>
</div>
</body>
</html>