<?php
	require 'PHP/database.php';
	session_start();
	if (isset($_SESSION['name'])) 
	{
		$cartnumberitem=shoppingcart::countitemcart ();
		$balance=fill::fillbalance ();
	} 
	else 
	{
		header('Location: ../');
	}
	if (isset($_GET["Log"])) 
	{
		connections::logout($_GET["Log"]);
	}
	if (isset($_POST["delete"])) 
	{
		shoppingcart::deleteitemcart ($_POST["delete"]);
		header('Location: ../cart.php');
	}
	if (isset($_POST["modify"]) && isset($_POST["quality".$_POST["modify"]])) 
	{
		shoppingcart::modifyitemcart ($_POST["modify"], $_POST["quality".$_POST["modify"]]);
	}
	if (isset($_POST["deleteall"])) 
	{
		shoppingcart::deleteallitemcart ();
		header('Location: ../cart.php');
	}
	if (isset($_POST['invoice'])) 
	{
		if ($_POST['select']!=0) {
		shoppingcart::deleteallitemshippingbycart ();
		shoppingcart::addshippingbycart ((string)$_POST['select'], "Unpaid");
		header('Location: ../invoice.php');
		} 
		else 
		{
		echo "<script> alert ('You must select a shipping method');</script>";
		}
	}
	
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="img/logo.png">
    <link rel="stylesheet" href="css/styles.css">
    <title>Online Shop</title>
</head>
<body>
    <!--Upper section-->
	 <header>
        <nav class="navbar-top">
            <ul class="navbar-top-ul">
                <li class="navbar-top-item">
                     <div class="navbar-top-links">Shopping Cart</div>
                </li>
            </ul>
        </nav>
	<!--Nav bar-->	
        <nav class="navbar">
            <header class="nabvar-mobile is-size-5-mobile">
                <a class="navbar-mobile-link has-text-white" href="#" id="btn-mobile"><i class="zmdi zmdi-menu"></i></a>
                <a class="navbar-mobile-link has-text-white" href="index.php">Online Shop</a>
				<?php if(isset($_SESSION['name'])): ?>
                <a class="navbar-mobile-link has-text-white" href="cart.php"><i class="zmdi zmdi-shopping-cart"></i> Cart (<?= $cartnumberitem; ?>)</a>
				<?php endif; ?>
            </header>
            <nav class="nav-menu --nav-dark-light" id="mySidenav">
               <form class="form-group" action="index.php" method="POST">
                    <div class="form-group-container">
                        <span class="form-group-icon"><i class="zmdi zmdi-search"></i></span>
                        <input type="text" class="form-group-input" name="search" placeholder="Search...">
                    </div>
                </form>
                <a class="is-hidden-mobile brand is-uppercase has-text-weight-bold has-text-dark" href="index.php">Online Shop</a>
                <ul class="nav-menu-ul">
				<li class="nav-menu-item"><a class="nav-menu-link"><i>
				<?php if(isset($_SESSION['name'])): ?>
				<li class="nav-menu-item"><a href="login.php" class="nav-menu-link zmdi-ticket-star zmdi"><i>Welcome. <?= $_SESSION['name']; ?>. You have: <?= $balance. "$" ; ?></i></a></li>
				<li class="nav-menu-item"><a href="index.php?Log=0" class="nav-menu-link zmdi-power-off zmdi"><i> Log out</i></a></li>
				<li class="nav-menu-item"><a href="#" class="nav-menu-link zmdi-shopping-cart zmdi"><i> Cart (<?= $cartnumberitem; ?>)</i></a></li>
				<?php else: ?>
				</i></a></li>
				<li class="nav-menu-item"><a href="login.php" class="nav-menu-link"><i>Login</i></a></li>
				<li class="nav-menu-item"><a href="signup.php" class="nav-menu-link"><i>Sign Up</i></a></li>
				<?php endif; ?>
                </ul>
            </nav>
        </nav>
    </header>
    <!--Banner-->
    <div class="banner banner-second">
        <div class="banner-container ">
            <h1>Online Shop</h1>
            <h2>Buy in the comfort of your home</h2>
        </div>
    </div>
	<!--Cart screen-->
	<?php if(isset($_SESSION['name'])): fill::fillcart(); ?>
	<?php endif; ?>
<br> 
<br> 
<br>  
	<!--Separator--> 
    <div class="container container-full">
		<div class="columns is-centered is-multiline">
            <div class="separator"></div>
			
			<nav class='column is-full'>
					<ul class='navbar-top-ul'>
						<li class='navbar-top-item'>
						<?php if(isset($_SESSION['name'])): ?>
						<h2 class='price is-size-4' id='purchase'>Purchase Cost: <sup>$</sup>
						<?= round(shoppingcart::totalcart (),2);?></h2>
						<h2 class='price is-size-4' id='balance'>Balance after pay: <sup>$</sup>
						<?= round(fill::fillbalance ()-shoppingcart::totalcart (),2);?></h2>
						<?php endif; ?>
						</li>
					</ul>
				</nav>
			
	<div class="container container-full">
		<div class="columns is-centered is-multiline">
            <div class="separator"></div>
		</div>
	</div> 
	
		</div>
	</div> 
		
	<!--Start footer-->
	<footer class="footer">
        <div class="container">
            <div class="columns is-multiline">
	<!--Shopping cart options-->		
			<div class="column">
				<li class="footer-item">
					<h3 class="has-text-weight-bold title is-2">Shopping Cart</h3>
				</li>
				<form action='#'  method='POST'><li class="footer-item"><button class='footer-link button is-large is-rounded button is-danger' name='deleteall'>(x) Empty all your shopping cart (!)</button></li></form>
			</div>
	<!--Social network connectors-->		
                <div class="column is-full">
                    <div class="footer-socials">
                        <a class="footer-solcials-link" href="#"><i class="zmdi zmdi-facebook"></i></a>
                        <a class="footer-solcials-link" href="#"><i class="zmdi zmdi-twitter"></i></a>
                        <a class="footer-solcials-link" href="#"><i class="zmdi zmdi-instagram"></i></a>
                        <a class="footer-solcials-link" href="#"><i class="zmdi zmdi-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
	<!--Authorship info--> 
        <div class="footer-bar-top">
            <div class="container">
                <a class="footer-bar-top-links" href="#">2021 Online Shop</a>
            </div>
        </div>
    </footer>
	<!--Dinamic bar -->
<script src="js/main.js"></script> 
</body>
</html>
	
  
                
         
            
        
        <
   
