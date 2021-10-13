<?php
	class connections 
	{
		static function connect()  
		{
		$server = 'localhost';
		$username = 'root';
		$password = 'root';
		$database = 'onlineshop';
			try 
			{
			  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
			} 
			catch (PDOException $e) 
			{
			  die('Connection Failed: ' . $e->getMessage());
			}
			return $conn;
		}
		static function login($email,$password,$option) 
		{
			$conn=connections::connect();
			$query = $conn->query("SELECT COUNT(*) FROM users WHERE email ='".$email."'");
			$records = $conn->prepare("SELECT * FROM users WHERE email ='".$email."'");
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			$message = '';
			if ($query->fetchColumn() > 0 && password_verify($password, $results['password']))
			{
				$_SESSION['user_id'] = $results['id'];
				$_SESSION['email'] = $results['email'];
				$_SESSION['name'] = $results['name'];
				$_SESSION['role'] = $results['role'];
				switch ($option) 
				{
				case 1:
				$conn3=connections::connect();
				$records = $conn3->prepare("INSERT INTO balance (iduser, amount, transact) VALUES ('".$_SESSION['user_id']."', '100', 'income');");
				$records->execute();
				case 2:
				header('Refresh: 3; URL=../');
				$message = '<progress class="progress is-small is-primary" max="100">15%</progress> Please wait (3 seconds) until you get login';
				}
			} 
			else 
			{
			$message = 'Sorry, those credentials do not match';
			}
			return $message;
		}
		static function signup($email, $password, $name) 
		{
			$conn=connections::connect();
			$conn2=connections::connect();
			$conn3=connections::connect();
			$results = $conn->query("SELECT COUNT(*) FROM users WHERE email ='".$email."'");
			$message = '';
			if ($results->fetchColumn() > 0) 
			{
				$message = 'You are already registered';
			} else 
			{
				$stmt = $conn->prepare("INSERT INTO users (email, name, password, role) VALUES (:email, :name, :password, 'User')");
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':name', $name);
				$passwordcrypt = password_hash($password, PASSWORD_BCRYPT);
				$stmt->bindParam(':password', $passwordcrypt);
					if ($stmt->execute()) 
					{
						$message = '<progress class="progress is-small is-primary" max="100">15%</progress> Please wait (3 seconds) until you get login';
						connections::login($email,$password,1);
					} 
					else 
					{
						$message = 'Sorry there must have been an issue creating your account';
					}
			} 		
			return $message;
		}
		static function logout($Log) 
		{
			if ($Log==0) 
			{
				session_unset();
				session_destroy();
				header('Location:' . getenv('HTTP_REFERER'));
			}
		}
	}
	
	class purchase 
	{
		static function buildquery($reference, $totalamount) 
		{
			$results=shoppingcart::querycart (1,'');
			$records=shoppingcart::querycart (2,'');
			if($records -> rowCount() > 0)  
			{ 
			$query='';
				foreach($results as $result) 
				{
					$query=$query."INSERT INTO invoice(reference, iduser, date, codproduct, quality, unitprice, totalamount, currentbalance) VALUES (".$reference.",".$_SESSION['user_id'].",now(),".$result -> codproduct.",".$result -> countitem.",".$result -> price.",".$totalamount.",".fill::fillbalance ().");\n INSERT INTO inventory(codproduct, quality, transact) VALUES (".$result -> codproduct.",".$result -> countitem.",'expenses');\n";	
				}
				$query=$query."UPDATE shippingcart SET statuscart = 'Paid' WHERE movement = ".$reference.";\n INSERT INTO balance(iduser, amount, transact) VALUES (".$_SESSION['user_id'].",".$totalamount.",'expenses')"; 
				return $query;
			}
		}
		static function performanceoperations($query) 
		{
			$conn=connections::connect();
			$records = $conn->prepare($query);
			$records->execute();
		}
	}
	
	class shoppingcart 
	{
		static function querycart ($info, $code) 
		{
			$conn=connections::connect();	
			$records = $conn -> prepare("SELECT iduser, codproduct, image, name, um, price, SUM(quality) AS countitem FROM (SELECT * FROM cart INNER JOIN products ON cart.codproduct=products.cod) AS resumecart WHERE resumecart.iduser=".$_SESSION['user_id']." AND codproduct LIKE '%".$code."%' GROUP BY resumecart.codproduct"); 
			$records -> execute(); 
			$results = $records -> fetchAll(PDO::FETCH_OBJ); 
			switch ($info) 
			{
				case 1:
				return $results;
				break;
				case 2:
				return $records;
				break;
			}
		}	
		static function currentshipping ($info) 
		{
			$conn=connections::connect();
			$records = $conn->prepare("SELECT * FROM shippingcart WHERE statuscart='Unpaid' AND iduser=".$_SESSION['user_id'].";");
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			if ($records->rowCount() == 0) 
			{
				header('Location: ../');
			}
			$movement = $results['movement'];
			$shippingselected = $results['shippingselected'];
			$statuscart = $results['statuscart'];
			switch ($info) 
			{
				case 1:
				return $movement;
				break;
				case 2:
				return $shippingselected;
				break;
				case 3:
				return $statuscart;
				break;
			}
		}
		static function totalcart () 
		{
			$conn=connections::connect();
			$records = $conn->prepare("SELECT SUM(totalcart) AS totalcart FROM (SELECT iduser, codproduct, image, name, um, price*SUM(quality) AS totalcart FROM (SELECT * FROM cart INNER JOIN products ON cart.codproduct=products.cod) AS resumecart WHERE resumecart.iduser=".$_SESSION['user_id']." GROUP BY resumecart.codproduct) AS totalcart");
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			$totalcart = $results['totalcart'];
			return $totalcart;
		}
		static function deleteallitemshippingbycart () 
		{
			$conn=connections::connect();
			$records = $conn->prepare("DELETE FROM shippingcart WHERE iduser='".$_SESSION['user_id']."' AND statuscart='Unpaid'");
			$records->execute();
			return $conn;
		}
		static function addshippingbycart ($shippingselected, $statuscart) 
		{
			$conn=connections::connect();
			$records = $conn->prepare("INSERT INTO shippingcart (iduser, shippingselected, statuscart) VALUES ('".$_SESSION['user_id']." ', '".$shippingselected."', '".$statuscart."');");
			$records->execute();
		}
		static function countitemcart () 
		{
			$conn=connections::connect();
			$records = 'SELECT COUNT(*) total FROM cart WHERE iduser='.$_SESSION['user_id'];
				foreach ($conn->query($records) as $row) 
				{
					$cartnumberitem= $row['total'];
					return $cartnumberitem;
				}
		}
		static function addcart ($code, $amount, $page) 
		{
			$conn=connections::connect();
			$records = $conn->prepare("INSERT INTO cart(iduser, codproduct, quality) VALUES (".$_SESSION['user_id']." , ".$code.", ".$amount.")");
			$records->execute();
			switch ($page) 
			{
				case 1:
				header('Location: ../index.php');
				die();
				break;
				case 2:
				header('Location: ../product.php?Cod='.$code);
				die();
				break;
				case 3:
				header('Location: ../cart.php');
				die();
				break;
			}
		}	
		static function deleteitemcart ($code) 
		{
			$conn=connections::connect();
			$records = $conn->prepare("DELETE FROM cart WHERE codproduct='".$code."' AND iduser='".$_SESSION['user_id']."'");
			$records->execute();
			return $conn;
		}
		static function deleteallitemcart () 
		{
			$conn=connections::connect();
			$records = $conn->prepare("DELETE FROM cart WHERE iduser='".$_SESSION['user_id']."'");
			$records->execute();
			return $conn;
		}
		static function modifyitemcart ($code, $amount) 
		{
			$conn=shoppingcart::deleteitemcart ($code);
			shoppingcart::addcart ($code, $amount, 3);	
		}
	}
	
	class check 
	{
		static function checkbalance($shipping) 
		{
			$totalcart=shoppingcart::totalcart();
			$balance=fill::fillbalance();
			$remainingbalance=$balance-$totalcart-$shipping;
			if ($remainingbalance<0)
			{
				echo "<script> alert('Balance not enough. Current balance: ".$balance."$');</script>";
				header('Location: ../');
			} else 
			{
				return 'Ok';
			}			
		}
		static function checkstock() 
		{
			$results=shoppingcart::querycart (1,'');
			$records=shoppingcart::querycart (2,'');
			$remainingstock=0;
			if($records -> rowCount() > 0)  
			{ 
				foreach($results as $result) 
				{
				$name=$result -> name;
				$unit=$result -> um;
				$stock=fill::fillstock($result -> codproduct);
				$stockcart=round($result -> countitem);
				$remainingstock=$stock-$stockcart;
					if ($remainingstock<0)
					{
					echo "<script> alert('Selected qualities of ".$name." are sold out (just ".$stock." ".$unit." remaining)');</script>";
					return 'NotOk';
					die();
					} 
				}
			}
		}
		static function checkrole()
		{
			$conn=connections::connect();
			$records = $conn->prepare("SELECT * FROM users WHERE id ='".$_SESSION['user_id']."'");
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			$_SESSION['role'] = $results['role'];
		}
		static function checkinvoicenumber($reference)
		{
			$conn=connections::connect();
			$records = $conn->prepare("SELECT * FROM invoice WHERE reference ='".$reference."' LIMIT 1");
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			$iduser = $results['iduser'];
			return $iduser;
		}
	}
	
	class products 
	{
		static function queryproducts($querystring, $code) 
		{
			$conn=connections::connect();	
			$records = $conn -> prepare("SELECT * FROM products WHERE name LIKE '%".$querystring."%' AND cod LIKE '%".$code."%'");
			$records -> execute();
			return $records;
		}
		static function showproducts($querystring) 
		{
			$records=products::queryproducts($querystring,'');
			$results = $records -> fetchAll(PDO::FETCH_OBJ); 
			if($records -> rowCount() > 0)  
			{ 
				foreach($results as $result) 
				{ 
				echo "<div class='column is-half column-full'>
						<div class='card'>
							<span class='btn--mini-rounded' id='Table'>".$result -> price."$</span>
							<img src='img/".$result -> image.".png' alt=''>
							<div class='card-simple-options'>
							<p class='has-text-centered btn'>(Cod: ".$result -> cod.")<br>".$result -> name."<br>".$result -> um.".</p>
								<div class='card-buttons'>";
								if(isset($_SESSION['name']))  
								{
									echo "<a href='index.php?Cod=".$result -> cod."&Cart=1' class='btn--mini-rounded'><i class='zmdi zmdi-shopping-cart'></i></a>
									<a href='product.php?Cod=".$result -> cod."' class='btn--mini-rounded'><i class='zmdi zmdi-eye'></i></a>
									</div>
								</div>
							</div>
						</div>";
								} 
								else 
								{ 
								echo "<a href='product.php?Cod=".$result -> cod."' class='btn--mini-rounded'><i class='zmdi zmdi-eye'></i></a>
								</div>
							</div>
						</div>
					</div>";
								}
				}
			}                
		}
		static function showunitsset ()
		{
			$conn=connections::connect();
			$records = $conn->prepare("DESCRIBE products um;");
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			$umset = $results['Type'];
			$substring=substr(chunk_split($umset, 1, ''), 4, -1);
			$substring=str_replace("'", "", $substring);
			$array=explode(',', $substring);
			$i=0;
				foreach ($array as $word)
				{
				$i++;
				echo "<option value='".$word."'>".$word."</option>";
				}
		}
		static function retrieviewlastproduct ()
		{
			$conn=connections::connect();
			$records = $conn->prepare("SELECT MAX(cod) AS lastproduct FROM products;");
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			$lastproduct = $results['lastproduct'];
			return $lastproduct;
		}
		static function addproduct ($name, $price, $um)
		{
			$lastproduct=products::retrieviewlastproduct();
			$cod=$lastproduct+1;
			$image='item-'.$cod;
			$conn=connections::connect();
			$records = $conn->prepare("INSERT INTO products(cod, image, name, price, um) VALUES (".$cod." ,'".$image."' , '".$name."', ".$price.", '".$um."')");
			$records->execute();
			return $image;
		}
	}
	
	class fill 
	{
		static function fillcartinvoice () 
		{
			$results=shoppingcart::querycart (1, '');
			$records=shoppingcart::querycart (2, '');
			if($records -> rowCount() > 0)  
			{ 
				$table='';
				foreach($results as $result) 
				{
					if($result -> um=='Unit(s)'):
						$table = $table."<tr>
						<td>".$result -> codproduct."</td>
						<td>".$result -> name."</td>
						<td>" .round($result -> countitem). " ".$result -> um."</td>
						<td>".$result -> price."$</td>
						<td>".round($result -> price*$result -> countitem, 2)."$</td>
						</tr>";
					else:
						$table = $table."<tr>
						<td>".$result -> codproduct."</td>
						<td>".$result -> name."</td>
						<td>" .$result -> countitem. " ".$result -> um."</td>
						<td>".$result -> price."$</td>
						<td>".round($result -> price*$result -> countitem, 2)."$</td>
						</tr>";
					endif;		
				}
				return $table;
			}
		}
		static function fillinvoice ($reference, $info)
		{
			$conn=connections::connect();	
			$records = $conn -> prepare("SELECT reference, movement, date, codproduct, products.name, quality, unitprice, totalamount, um, shippingselected, statuscart, users.name AS username FROM invoice INNER JOIN products ON products.cod=invoice.codproduct INNER JOIN shippingcart ON shippingcart.movement=invoice.reference INNER JOIN users ON users.id=invoice.iduser WHERE movement= ".$reference." AND reference= ".$reference.""); 
			$records -> execute(); 
			$results = $records -> fetchAll(PDO::FETCH_OBJ); 
			$table='';
			foreach($results as $result) 
			{
				if($result -> um=='Unit(s)'):
				$table = $table."<tr>
					<td>".$result -> codproduct."</td>
					<td>".$result -> name."</td>
					<td>" .round($result -> quality). " ".$result -> um."</td>
					<td>".$result -> unitprice."$</td>
					<td>".round($result -> unitprice*$result -> quality, 2)."$</td>
				</tr>";
				else:
				$table=	$table."<tr>
					<td>".$result -> codproduct."</td>
					<td>".$result -> name."</td>	
					<td>" .$result -> quality. " ".$result -> um."</td>
					<td>".$result -> unitprice."$</td>
					<td>".round($result -> unitprice*$result -> quality, 2)."$</td>
				</tr>";
			   endif;
				$shipping = $result -> shippingselected;
				$statuscart = $result -> statuscart;
				$date=$result -> date;
				$totalamount=$result -> totalamount;
				$username= $result -> username;
			}
			switch ($info) 
			{
				case 1:
				return $table;
				break;
				case 2:
				return $shipping;
				break;
				case 3:
				return $statuscart;
				break;
				case 4:
				return $date;
				break;
				case 5:
				return $totalamount;
				break;
				case 6:
				return $username;
				break;
			}
		}
		static function filllistinvoice ()
		{
			$conn=connections::connect();	
			$records = $conn -> prepare("SELECT DISTINCT reference, movement, date, totalamount, shippingselected, statuscart, users.name AS username FROM invoice INNER JOIN products ON products.cod=invoice.codproduct INNER JOIN shippingcart ON shippingcart.movement=invoice.reference INNER JOIN users ON users.id=invoice.iduser"); 
			$records -> execute(); 
			$results = $records -> fetchAll(PDO::FETCH_OBJ); 
			$table='';
			foreach($results as $result) 
			{
				$table = $table."<tr>
					<td><a class='navbar-mobile-link' href='invoice.php?View=".$result -> reference."'>".$result -> reference."</a></td>
					<td>".$result -> date."</td>
					<td>".$result -> username."</td>
					<td>" .round($result -> totalamount, 2). " $</td>
					<td>".$result -> statuscart."</td>
				</tr>";	
			}
			return $table;	
		}
		static function fillcart () 
		{
			$results=shoppingcart::querycart (1,'');
			$records=shoppingcart::querycart (2,'');
			if($records -> rowCount() > 0)  
			{ 
				foreach($results as $result) 
				{
				$stars=fill::fillstars($result -> codproduct);
				$stock=fill::fillstock($result -> codproduct);
				echo "<div class='container'>
				<div class='columns'>
					<div class='column is-two-fifths-desktop'>
						<div class='slider' id='slider'>
							<div class='slider-img-container'>
								<img src='img/".$result -> image.".png' class='active slider-item'>
							</div>
						</div>
					</div>
					<div class='column'>
                <h3 class='is-size-4'>".ucwords($result -> name)."</h3>
				<p class='has-text-grey'><strong>Code: </strong>".$result -> codproduct."</p>
                <h2 class='price is-size-4'>Product price: <sup>$</sup>".$result -> price."</h2>
				<h2 class='price is-size-4'>Subtotal: <sup>$</sup>".round($result -> price*$result -> countitem, 2)."</h2>";
				if($result -> um=='Unit(s)'):
                echo "<p class='has-text-grey'> <strong>Qualities on Cart: </strong>" .round($result -> countitem). " ".$result -> um."</p>";
				else:
				echo "<p class='has-text-grey'> <strong>Qualities on Cart: </strong>".$result -> countitem. " ".$result -> um."</p>";
				endif;
                if(isset($_SESSION['name'])):
				echo "<form action='/cart.php' method='POST' class='form-control'>
                    <div class='columns is-multiline'> 
                        <div class='column is-one-third'>";
							if($result -> um=='Unit(s)'):
                            echo "<input class='form-control-field' placeholder =".round($result -> countitem)." name='quality".$result -> codproduct."' min=1 type='number' value=1>";
							else:
							echo "<input class='form-control-field' placeholder =".$result -> countitem." name='quality".$result -> codproduct."' step=0.01 min=0.01 type='number' value=1.00>";
							endif;
                        echo "</div>
                        <div class='column is-full is-marginless'>
                        <button class='btn btn-default btn-outline' name='modify' value='".$result -> codproduct."'><i class='zmdi zmdi-shopping-cart'></i>Modify quality</button>
						<button class='btn btn-default btn-outline' name='delete' value='".$result -> codproduct."'><i class='zmdi zmdi-shopping-cart'></i>Delete item</button>";
						else:
						echo "<form action='/login.php' class='form-control'>
                    <div class='columns is-multiline'> 
                        <div class='column is-full is-marginless'>
							<button class='btn btn-default btn-outline' ><i class='zmdi zmdi-shopping-cart'></i>Must Log In</button>";
						endif;
                        echo "
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> 
				<div class='container container-full'>
					<div class='columns is-centered is-multiline'>
						<div class='separator'></div>
					</div>
				</div>  ";
				}
			$totalcart=shoppingcart::totalcart ();
				echo "
				<nav class='column is-full'>
					<ul class='navbar-top-ul'>
						<li class='navbar-top-item'>
						<h2 class='price is-size-4'>Total: <sup>$</sup>".round($totalcart, 2)."</h2>
						<div class='select is-loading is-medium'>";
						if(round(fill::fillbalance ()-shoppingcart::totalcart (),2)>=0):
							echo" <form action='#'  method='POST'>
							  <select name='select' style='inline' onchange='hideshowselect(this);'>
								<option value='0'>Shipping:</option>
								<option value='UPS'>UPS: +5$</option>
								<option value='Pick Up'>Pick Up: 0$</option>
							  </select>
								<li class='footer-item' style= 'display: none' id='layer'><button class='footer-link button is-success button is-large is-rounded' name='invoice' href='#'>Get invoice</button></li>
							</form>";
							else:
							echo "<li class='footer-item'><button class='footer-link button is-warning button is-large is-rounded' href='#'>Not enough</button></li>";
						endif;
						echo "</div>
						</li>
					</ul>
				</nav>
				<script>
				function hideshowselect(e) 
				{
				var option = e.options[e.selectedIndex];
				
				if (option.value=='UPS') 
				{
					var afterpay =" .round(fill::fillbalance ()-shoppingcart::totalcart ()-5,2).";
					var purchasecost =" .round(shoppingcart::totalcart ()+5,2).";
					document.getElementById('balance').innerHTML='Balance after pay: <sup>$</sup>' + afterpay;
					document.getElementById('purchase').innerHTML='Purchase Cost: <sup>$</sup>' + purchasecost;
				} 
				else 
				{
					var purchasecost =" .round(shoppingcart::totalcart (),2).";
					var afterpay =" .round(fill::fillbalance ()-shoppingcart::totalcart (),2).";
					document.getElementById('balance').innerHTML='Balance after pay: <sup>$</sup>' + afterpay;
					document.getElementById('purchase').innerHTML='Purchase Cost: <sup>$</sup>' + purchasecost;
				}
				 if (option.value=='0' || afterpay<0) 
				{
					javascript:hide();
				} 
				else 
				{
					javascript:show();
				}
				}
				function hide()
				{
				   var elemento = document.getElementById('layer');
				   elemento.style.display = 'none';
				}
				function show()
				{
				   var elemento = document.getElementById('layer');
				   elemento.style.display = '';
				}
				</script>
				
				";			
			}                
		}
		static function fillproduct ($code, $info) 
		{
			$records=products::queryproducts('', $code);
			$results = $records->fetch(PDO::FETCH_ASSOC);
			$name = $results['name'];
			$price = $results['price'];
			$image = $results['image'];
			$unit = $results['um'];
			if (isset($_SESSION['name'])) 
			{
			$results2=shoppingcart::querycart (1,$code);
			$records2=shoppingcart::querycart (2,$code);
			if($records2 -> rowCount() > 0)  
			{ 
				foreach($results2 as $result) 
				{
					$qualityoncart=$result -> countitem;
				}
			} 
			else 
			{
				$qualityoncart=0;
			}	
			}
			
			switch ($info) 
			{
				case 1:
				return $name;
				break;
				case 2:
				return $price;
				break;
				case 3:
				return $image;
				break;
				case 4:
				return $unit;
				break;
				case 5:
				return $qualityoncart;
				break;
			}
		}		
		static function fillstars ($code) 
		{		
			$conn=connections::connect();
			$records = $conn->prepare("SELECT AVG(rate) AS rate FROM favorites WHERE codproduct=".$code.";");
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			$stars = $results['rate'];
			return $stars;	
		}		
		static function fillstock ($code) 
		{			
			$conn=connections::connect();
			$records = $conn->prepare("SELECT (IFNULL((SELECT SUM(quality) AS totalincomes FROM inventory WHERE codproduct=".$code." AND transact='income'),0)-IFNULL((SELECT SUM(quality) AS totalexpenses FROM inventory WHERE codproduct=".$code." AND transact='expenses'),0)) As Totalstock;");
			$records->execute();
			$stock = $records->fetchColumn();
			return $stock;
		}
		static function fillbalance () 
		{			
			$conn=connections::connect();
			$records = $conn->prepare("SELECT (IFNULL((SELECT SUM(amount) AS totalincomes FROM balance WHERE iduser= ".$_SESSION['user_id']." AND transact='income'),0)-IFNULL((SELECT SUM(amount) AS totalexpenses FROM balance WHERE iduser=".$_SESSION['user_id']." AND transact='expenses'),0)) As Currentbalance;");
			$records->execute();
			$balance = $records->fetchColumn();
			return $balance;
		}
	}
	
	class switchfavorite 
	{
		static function queryfavorites ($code) 
		{
			$conn=connections::connect();
			$records = $conn -> prepare( "SELECT AVG(rate) AS yourstars FROM favorites WHERE iduser=".$_SESSION['user_id']." AND codproduct=".$code.";");
			$records->execute();
			$results = $records->fetch(PDO::FETCH_ASSOC);
			$yourstars = $results['yourstars'];
			return $yourstars;	
		}
		static function setfavorite ($code, $rate) 
		{
		$conn=connections::connect();			
		$records = $conn->prepare("INSERT INTO favorites(iduser, codproduct, rate) VALUES (".$_SESSION['user_id']." , ".$code.", ".$rate.")");
		$records->execute();
		}
		static function unsetfavorite ($code) 
		{
		$conn=connections::connect();
		$records = $conn->prepare("DELETE FROM favorites WHERE iduser=".$_SESSION['user_id']." AND codproduct=".$code.";");
		$records->execute();
		}
	}
?>


