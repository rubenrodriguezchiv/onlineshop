<?php
	require 'PHP/database.php';
	session_start();
	if (isset($_SESSION['name'])) 
	{
		check::checkrole();
		if ($_SESSION['role']=='Publisher'||$_SESSION['role']=='Administrator')
		{
			if (!empty($_POST)) 
			{
				if (!empty($_POST['name']))
				{
					if (empty($_POST['price']))
					{
						$price=1;
					}
					else
					{
						$price=$_POST['price'];
					}
					$photo = $_FILES['photo'];
					$photoname=$photo['name'];
					$photourl = $photo['tmp_name'];
					$image=products::addproduct($_POST['name'], $price, $_POST['um']);
					if ($photoname!='') 
					{
						// Read the image
						$img = imagecreatefromjpeg($photourl);
						// Now resize the image width = 450 and height = 450
						$imgresize = imagescale($img, 450, 450);
						//Save the image
						imagepng($imgresize, 'img/'.$image.'.png');
					}
					echo "<script> alert('Product registered');</script>";
				}
				else
				{
					echo "<script> alert('Product Name can\'t be empty');</script>";
				}
			}
		}	
		else
		{
			header('Location: ../');
		}
	} 
	else
	{
		header('Location: ../');
	}
?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="shortcut icon" href="img/logo.png">
		<link rel="stylesheet" href="css/styles.css">
		<script src="js/jquery-3.6.0.js"></script> 

		<title>Online Shop</title>
	</head>
	<body>
		<!--Upper section-->
		 <header>
			<nav class="navbar-top">
				<ul class="navbar-top-ul">
					<li class="navbar-top-item">
						 <div class="navbar-top-links">Product Control</div>
					</li>
				</ul>
			</nav>
		<!--Nav bar-->	
			<nav class="navbar">
				<header class="nabvar-mobile is-size-5-mobile">
					<a class="navbar-mobile-link has-text-white" href="#" id="btn-mobile"><i class="zmdi zmdi-menu"></i></a>
					<a class="navbar-mobile-link has-text-white" href="index.php">Online Shop</a>
				</header>
				<nav class="nav-menu --nav-dark-light" id="mySidenav">
					<form class="form-group" action="productcontrol.php" method=POST>
						<div class="form-group-container">
							<span class="form-group-icon"><i class="zmdi zmdi-search"></i></span>
							<input type="text" class="form-group-input" name="search" placeholder="Search...">
						</div>
					</form>
					<a class="is-hidden-mobile brand is-uppercase has-text-weight-bold has-text-dark" href="index.php">Online Shop</a>
					<ul class="nav-menu-ul">
					<li class="nav-menu-item"><a class="nav-menu-link"><i>
					<?php if(!empty($message)): ?>
					<p> <?= $message ?></p>
					<?php else: echo $message='Please Log In'; ?>
					<?php endif; ?>
					</i></a></li>
						<li class="nav-menu-item"><a href="signup.php" class="nav-menu-link zmdi-account-add zmdi"><i>Sign Up</i></a></li>
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
		<!--Create Product form-->
		<div class="container">
			<div class="columns">
				<div class="column">
					<form action="productcontrol.php" method="post" enctype="multipart/form-data" class="form-control">
					<h2 class="footer-socials is-size-4">Create Product</h2>
					<input type="text" name = "name" placeholder="Product Name" class="form-control-field">
					<input type="number" name = "price" placeholder="Price" min=0.01 step=0.01 value= 1.00 class="form-control-field">
					<select class= "btn" name="um" id="um"><?php products::showunitsset ();?></select>	
					<div class="photo">
					<label for="photo"><br></label>
					<div class="prevPhoto">
					<span class="delPhoto notBlock">X</span>
					<label for="photo"></label>
					</div>
					<div class="upimg"><input type="file" name="photo" id="photo"></div>
					<div id="form_alert"></div>
					</div>
					<br>
					<button name= "create" type = "submit" class="btn btn-default btn-primary">Create</button>
					</form>
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