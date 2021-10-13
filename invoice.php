<?php
	require 'PHP/database.php';
	require 'PHP/file.php';
	session_start(); 
	$balance=0;  
	if (isset($_SESSION['name'])) 
	{
		check::checkrole();
		if (isset($_GET['View'])) 
		{
			$iduser=check::checkinvoicenumber($_GET['View']);
			if ($_SESSION['user_id']==$iduser || $_SESSION['role']=='Administrator'||$_SESSION['role']=='Financial')
			{
				if(fill::fillinvoice ($_GET['View'], 2)=='UPS'): $shipping=5;
				elseif(fill::fillinvoice ($_GET['View'], 2)=='Pick Up'): $shipping=0;
				endif;
			}
			else
			{
				echo "<script> alert('Invoice number is not refered to your user account');</script>";
				header('Location: ../');	
			}
		}
		elseif (isset($_GET['List']))
		{
			if ($_SESSION['role']=='User')
			{
				header('Location: ../');
			}
			$shipping=0;
		}	
		else
		{
			$balance=fill::fillbalance ();
			if(shoppingcart::currentshipping(2)=='UPS'): $shipping=5;
			elseif(shoppingcart::currentshipping(2)=='Pick Up'): $shipping=0;
			endif;
			if (fill::fillbalance ()-shoppingcart::totalcart ()-$shipping<0) 
			{
			echo "<script> alert('Balance not enough. Current balance: ".fill::fillbalance ()."$');</script>";
			header('Location: ../');
			}	
			if (isset($_POST['Pay'])) 
			{
			$currentinvoice=shoppingcart::currentshipping(1);
			$purchasecost= shoppingcart::totalcart ()+$shipping;
			$checkbalance=check::checkbalance($shipping);
				if ($checkbalance=='Ok')
				{
					$query=purchase::buildquery(shoppingcart::currentshipping(1), $purchasecost);
					purchase::performanceoperations($query);
					shoppingcart::deleteallitemcart ();
					echo "<script> alert('Congrats, you have made the purchase of Invoice # : ".$currentinvoice.". Previous balance: ".$balance."$. Purchase cost: ". $purchasecost."$. New balance: ".fill::fillbalance ()."$');</script>";
					die("<script> window.location.href = 'index.php';</script>");
				}
			}
		}	
	} 
	else 
	{
	header('Location: ../');
	die;
	}
	if (isset($_GET["Log"])) 
	{
		connections::logout($_GET["Log"]);
	}
?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="shortcut icon" href="img/logo.png">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/invoice styles.css">
		<title>Online Shop</title>
	</head>
	<body>
		<?php if (isset($_GET['View'])): echo pages::invoice ($_GET['View'], 1, $shipping);?>	
		<?php elseif (isset($_GET['List'])&& $_GET['List']=='View'): echo pages::invoice (0, 3, $shipping);?>
		<?php else: echo pages::invoice (0, 2, $shipping);?>
		<?php endif ?>
	</body>
</html>