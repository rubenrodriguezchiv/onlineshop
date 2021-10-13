<?php
	require 'PHP/database.php';
	session_start();
	$message='';
	if (isset($_SESSION['name'])) 
	{
		header('Location: ../');
	}
	if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm'])) 
	{
		if ($_POST['password'] == $_POST['confirm'])
		{
		$message = connections::signup($_POST["email"], $_POST["password"], $_POST["name"]);
		} 
		else 
		{
		$message = 'Please verify your password';
		}
	} 
	else 
	{
	$message='You must fill all inputs';
	}
?>
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
						 <div class="navbar-top-links">
						Sign Up
						</div>
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
					<form class="form-group" action="index.php" method=POST>
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
					<?php else: echo $message='Please Sign Up'; ?>
					<?php endif; ?>
					</i></a></li>
						<li class="nav-menu-item"><a href="login.php" class="nav-menu-link zmdi-sign-in zmdi"><i>Login</i></a></li>
					</ul>
				</nav>
			</nav>
		</header>
		<!--Banner-->
		<div class="banner banner-second">
			<div class="banner-container ">
				<h1>Online Shop</h1>
				<h2>Buy in the comfort of your home </h2>
			</div>
		</div>
		<!--Signup form-->
		<div class="container">
			<div class="columns">
				<div class="column">
					<form action="signup.php" method="post" class="form-control">
						<h2 class="footer-socials is-size-4">Signup</h2>
						<input type="email" name = "email" placeholder="Email" class="form-control-field">
						<input type="text" name = "name" placeholder="Name" class="form-control-field">
						<input type="password" name = "password" placeholder="Password" class="form-control-field">
						<input type="password" name = "confirm" placeholder="Confirm your password" class="form-control-field">   
						<button name= "signup" class="btn btn-default btn-primary">Sign Up</button>
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