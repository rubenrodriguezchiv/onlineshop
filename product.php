<?php
	require 'PHP/database.php';
	session_start();
	if (isset($_SESSION['name'])) 
	{
		$cartnumberitem=shoppingcart::countitemcart ();
		$balance=fill::fillbalance ();
		
		
		if (isset($_GET["Cod"])) 
		{
			$code=$_GET["Cod"];
			$name = fill::fillproduct ($_GET["Cod"], 1);
			$price = fill::fillproduct ($_GET["Cod"], 2);
			$image = fill::fillproduct ($_GET["Cod"], 3);
			$unit = fill::fillproduct ($_GET["Cod"], 4);
			$qualityoncart = fill::fillproduct ($_GET["Cod"], 5);
			$stars= fill::fillstars ($_GET["Cod"]);
			$yourstars=switchfavorite::queryfavorites($code);
				if (isset($_POST["rate"])) 
				{
					switchfavorite::unsetfavorite ($code);
					switchfavorite::setfavorite ($code, $_POST['rate']);
					$stars= fill::fillstars ($_GET["Cod"]);
					$yourstars=switchfavorite::queryfavorites($_GET["Cod"]);
					echo "<script> alert('You rate ".$_POST["rate"]." on ".$name."');</script>";
				}
				if (isset($_GET["Cart"])) 
				{
					shoppingcart::addcart ($_GET["Cod"], $_POST["quality"], 2);
				}
		} 
		else 
		{
		$code=0;
		$name = '';
		$price = 0;
		$image = '';
		$unit = '';
		$stars=0;
		$qualityoncart=0;
		}
	} 
	else 
	{
		if (isset($_GET["Cod"])) 
		{
			$code=$_GET["Cod"];
			$name = fill::fillproduct ($_GET["Cod"], 1);
			$price = fill::fillproduct ($_GET["Cod"], 2);
			$image = fill::fillproduct ($_GET["Cod"], 3);
			$unit = fill::fillproduct ($_GET["Cod"], 4);
			$stars= fill::fillstars ($_GET["Cod"]);
		} 
		else 
		{
		$code=0;
		$name = '';
		$price = 0;
		$image = '';
		$unit = '';
		$stars=0;
		}		
		$qualityoncart=0;
		$yourstars=0;
	}
	if (isset($_GET["Log"])) 
	{
		connections::logout($_GET["Log"]);
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
                     <div class="navbar-top-links">Product details</div>
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
                <form class="form-group" action="index.php" method=POST>
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
				<li class="nav-menu-item"><a href="cart.php" class="nav-menu-link zmdi-shopping-cart zmdi"><i> Cart (<?= $cartnumberitem; ?>)</i></a></li>
				<?php else: ?>
				</i></a></li>
				<li class="nav-menu-item"><a href="login.php" class="nav-menu-link zmdi-sign-in zmdi"><i>Login</i></a></li>
				<li class="nav-menu-item"><a href="signup.php" class="nav-menu-link zmdi-account-add zmdi"><i>Sign Up</i></a></li>
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
	<!--Details-->
    <div class="container">
        <div class="columns">
            <div class="column is-two-fifths-desktop">
                <div class="slider" id="slider">
                    <div class="slider-img-container">
                        <img src="img/<?php echo $image?>.png" class="active slider-item">
                    </div>
                </div>
            </div>
            <div class="column">
                <h3 class="is-size-4"><?php echo ucwords($name)?></h3>
                <div class="course-rating-container">
                    <div class="rating-stars" style="--rating: <?php echo (($stars/5)*100)?>%">______________(Average)</div>
					
					
					<?php if(isset($_SESSION['name'])): ?>
					
					
					<form action="product.php?Cod=<?php echo $_GET["Cod"]?>" method="POST" class="form-control">
					<div class="rate">
						<input type="radio" id="star5" name="rate" value="5" />
						<label for="star5" title="text">5 stars</label>
						<input type="radio" id="star4" name="rate" value="4" />
						<label for="star4" title="text">4 stars</label>
						<input type="radio" id="star3" name="rate" value="3" />
						<label for="star3" title="text">3 stars</label>
						<input type="radio" id="star2" name="rate" value="2" />
						<label for="star2" title="text">2 stars</label>
						<input type="radio" id="star1" name="rate" value="1" />
						<label for="star1" title="text">1 star</label>
				  </div>
					 <button class="btn btn-default btn-outline" ><i class="zmdi zmdi-star-border"></i>Post Rate</button>
					</form>
					<h2 class="price is-size-4">Your rate: <?php echo round($yourstars)?></h2>
					<?php else: ?>
					<br>
					<?php endif; ?>
                </div>
                <p class="">Share: 
					<a class="icon-socials" href="#"><i class="zmdi zmdi-facebook"></i></a>
                    <a class="icon-socials" href="#"><i class="zmdi zmdi-twitter"></i></a>
                    <a class="icon-socials" href="#"><i class="zmdi zmdi-instagram"></i></a>
                    <a class="icon-socials" href="#"><i class="zmdi zmdi-pinterest"></i></a>
                    <a class="icon-socials" href="#"><i class="zmdi zmdi-email"></i></a>
                </p>
                <h2 class="price is-size-4"><sup>$</sup><?php echo $price?></h2>
				<p class='has-text-grey'> <strong>Unit measure: <?php echo $unit?></strong>
				<?php if($unit=='Unit(s)'): ?>
					<?php if(isset($_SESSION['name'])): echo "<p class='has-text-grey'> <strong>On Cart: </strong>" .round($qualityoncart). " ".$unit; ?>
					<?php endif; ?>
				</p>
				<?php else: ?>
					<?php if(isset($_SESSION['name'])): echo "<p class='has-text-grey'> <strong>On Cart: </strong>" .$qualityoncart. " ".$unit; ?>
					<?php endif; ?>
				<?php endif; ?>
                <p class="has-text-grey"><strong>Code: </strong><?php echo $code; ?></p>
					<?php if(isset($_SESSION['name'])): ?>
						<?php if($code!=0): ?>
				<form action="product.php?Cod=<?php echo $_GET["Cod"]?>&Cart=1" method="POST" class="form-control">
                    <div class="columns is-multiline"> 
                        <div class="column is-one-third">
                            <label for="quality">Quality</label>
							<?php if($unit=='Unit(s)'): ?>
                            <input class="form-control-field" placeholder =1 name="quality" min=1 type="number"  value=1>
							<?php else: ?>
							<input class="form-control-field" placeholder =1.00 name="quality" step=0.01 min=1.00 type="number"  value=1.00>
							<?php endif; ?>
                        </div>
                        <div class="column is-full is-marginless">
                        <button class="btn btn-default btn-outline"><i class="zmdi zmdi-shopping-cart"></i>Add to cart</button>
						<?php else: ?>
						<form action="#" class="form-control">
                    <div class="columns is-multiline"> 
                        <div class="column is-full is-marginless">
                        <button class="btn btn-default btn-outline"><i class="zmdi zmdi-shopping-cart"></i>Nothing</button>
						<?php endif; ?>
					<?php else: ?>
						<form action="/login.php" class="form-control">
                    <div class="columns is-multiline"> 
                        <div class="column is-full is-marginless">
							<button class="btn btn-default btn-outline" ><i class="zmdi zmdi-shopping-cart"></i>Must Log In</button>
					<?php endif; ?>
                        </div>
                    </div>
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