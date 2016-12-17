<div id="pageHeader">
		<img src="http://localhost/buytims/style/logo.jpg" alt="">
		<div class="nav">
			<ul>
				<li><a href="index.php">Dom</a></li>
				<li><a href="storeadmin/index.php">Administrator</a></li>
				<li><a href="cart.php">Twój koszyk</a></li>
				<?php 
					if (isset($_SESSION["manager"])) {
						echo '<li><a href="../logout.php">Wyloguj</a></li>';
					} 
				?>				
			</ul>
		</div>
	</div>	