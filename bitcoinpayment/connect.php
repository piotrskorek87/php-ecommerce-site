<?php 
$db_conx = mysqli_connect('sql.petersinclai.nazwa.pl', 'petersinclai_7', 'Pmc1Pmc1', 'petersinclai_7', '3307');

if (mysqli_connect_errno()) {
	echo mysqli_connect_error();
	exit();
} 
?>