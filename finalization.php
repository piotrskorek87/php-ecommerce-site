<?php 

if(isset($_GET['success'])){
	$success = $_GET['success'];
	if($success === 'true'){
		echo 'payment made :)';
	} elseif($success === 'true'){
		echo 'something went wrong :(';		
	}
}

?>