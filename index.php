<?php
  require 'PHP/database.php';
  session_start();  
	if (isset($_SESSION['name'])) 
	{
		check::checkrole();
		$cartnumberitem=shoppingcart::countitemcart ();
		$balance=fill::fillbalance ();
		if (isset($_GET["Cod"]) && isset($_GET["Cart"])) 
		{
			shoppingcart::addcart ($_GET["Cod"], 1, 1);
		}	
	}
	if (isset($_GET["Log"])) 
	{
		connections::logout($_GET["Log"]);
	}
?>
<!DOCTYPE html>
<html lang="en">
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
						 <div class="navbar-top-links">Welcome to Online Shop</div>
					</li>
				</ul>
			</nav>
		<!--Nav bar-->	
			<nav class="navbar">
				<header class="nabvar-mobile is-size-5-mobile">
					<a class="navbar-mobile-link has-text-white" href="#" id="btn-mobile"><i class="zmdi zmdi-menu"></i></a>
					<a class="navbar-mobile-link has-text-white" href="index.php">Online Shop (Clear Search Term)</a>
					<?php if (isset($_SESSION['name'])): ?>	
					<a class='navbar-mobile-link has-text-white' href='cart.php'><i class='zmdi zmdi-paypal-alt'></i> Wallet: <?= $balance. "$" ; ?></a>
					<?php endif; ?>
				</header>
				<nav class="nav-menu --nav-dark-light" id="mySidenav">
					<form class="form-group" action="index.php" method=POST>
						<div class="form-group-container">
							<span class="form-group-icon"><i class="zmdi zmdi-search"></i></span>
							<input type="text" class="form-group-input" name="search" placeholder="Search...">
						</div>
					</form>
					
					<a class="is-hidden-mobile brand is-uppercase has-text-weight-bold has-text-dark" href="index.php">Online Shop <br> (Clear Search Term)</a>
                <ul class="nav-menu-ul">
                    <li class="nav-menu-item" id="men">
                        <a class="nav-menu-link link-submenu active" href="#">Operations<i class="zmdi zmdi-chevron-down"></i></a>
                        <div class="container-sub-menu">
                            <ul class="sub-menu-ul">
                                <li class="nav-menu-item ">
                                <a class="nav-menu-link" href="#"><strong>Users</strong><i class="zmdi zmdi-chevron-down"></i></a>
                                    <ul class="sub-menu-ul">
										<?php if(isset($_SESSION['name'])): ?>
										<li class="nav-menu-item"><a href="index.php?Log=0" class="nav-menu-link zmdi-power-off zmdi"><i> Log out</i></a></li>
										<li class="nav-menu-item"><a href="cart.php" class="nav-menu-link zmdi-shopping-cart zmdi"><i> Cart (<?= $cartnumberitem; ?>)</i></a></li>
										<?php else: ?>
										</i></a></li>
										<li class="nav-menu-item"><a href="login.php" class="nav-menu-link zmdi-sign-in zmdi"><i>Login</i></a></li>
										<li class="nav-menu-item"><a href="signup.php" class="nav-menu-link zmdi-account-add zmdi"><i>Sign Up</i></a></li>
										<?php endif; ?>
                                    </ul>
                                </li>
                            </ul>
							<?php if(isset($_SESSION['role'])): ?>
								<?php
								$generaltext='<ul class="sub-menu-ul">
								<li class="nav-menu-item">
								<a class="nav-menu-link" href="#"><strong>Administrators</strong><i class="zmdi zmdi-chevron-down"></i></a>';
								switch ($_SESSION['role']) 
								{
									case 'Administrator': echo $generaltext; ?>
									<ul class="sub-menu-ul">
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="productcontrol.php?Operation=Create">Create Product</a></li>
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="#">Modify Product</a></li>
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="#">Delete Product</a></li>
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="#">Assign Roles</a></li>
                                    </ul>
                                </li>
								<ul class="sub-menu-ul">
								<li class="nav-menu-item">
								<a class="nav-menu-link" href="#"><strong>Financial</strong><i class="zmdi zmdi-chevron-down"></i></a>
								<li class="nav-menu-item"><a class="nav-menu-link" href="invoice.php?List=View">Invoice list</a></li>
								</ul>
								</li>
                            </ul>
								<?php	
									break;
									case 'Publisher': echo $generaltext; ?>
									<ul class="sub-menu-ul">
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="productcontrol.php?Operation=Create">Create Product</a></li>
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="#">Modify Product</a></li>
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="#">Delete Product</a></li>
                                    </ul>
                                </li>
                            </ul>
								<?php
									break;
									case 'Accountant': echo $generaltext; ?>
										<ul class="sub-menu-ul">
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="#">Modify Product</a></li>
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="#">Assign Roles</a></li>
                                    </ul>
                                </li>
                            </ul>
								<?php
									break;	
									case 'Financial': echo $generaltext; ?>
									<ul class="sub-menu-ul">
                                        <li class="nav-menu-item"><a class="nav-menu-link" href="invoice.php?List=View">Invoice list</a></li>  
                                    </ul>
                                </li>
                            </ul>
								<?php
									break;
								}
								?>	
							<?php endif; ?>
                            <div class="ads is-hidden-touch">
							<?php if(isset($_SESSION['name'])): ?>
                                <h1 class="ads-h1">Welcome. <?= $_SESSION['name']; ?> (<?= $_SESSION['role']; ?>)</h1>
                                <h2 class="ads-h2">You have: <?= $balance. "$" ; ?></h2>
							<?php else: ?>
								<h1 class="ads-h1">Please Login or Sign Up.</h1>
                                <h2 class="ads-h2">Wallet</h2>
							<?php endif; ?>
                            </div>
                        </div>
                    </li>
                </ul>	
					
				</nav>
			</nav>
		</header>
		<!--Banner-->
		<div class="banner banner-cover">
			<div class="banner-container ">
				<h1 class="title-cover"></h1> 
			</div>
		</div>  
		<!--Image section-->
		<div class="container">
			<div class="columns is-multiline">
				<div class="column is-full-mobile">
					<div class="columns is-centered is-mobile is-multiline">
					<!--Every Item-->
					<?php 
					if (isset($_POST["search"])) {
					products::showproducts($_POST["search"]);
					} else {
					products::showproducts("");
					}
					?>		
					</div>
				</div>  
			</div>
		</div>
		<!--Separator--> 
		<div class="container container-full">
			<div class="columns is-centered is-multiline">
				<div class="separator"></div>
			</div>
		</div> 
		<!--Social network connectors-->
	<footer class="footer">
			<div class="container">
				<div class="columns is-multiline">
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