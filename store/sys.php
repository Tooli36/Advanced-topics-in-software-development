<?php 
	session_start();
	$store_name = "Digital Store";
	$page_title = "";
	$db_host="localhost";
	$db_user="root";
	$db_pass="";
	$db_name="storeDB";
	if (!isset($_SESSION["total_price"]))
	{
		$_SESSION["total_price"]=0;
	}
	
	function getCurrency()
	{
		return "₪";
	}
	
	function SelfPOST()
	{
		return htmlspecialchars($_SERVER["PHP_SELF"]);
	}
	
	function printHead()
	{
		global $store_name, $page_title;
		echo "<head>
				<meta charset=\"utf-8\">
				<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
				<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC\" crossorigin=\"anonymous\">
				<title>".$store_name." - ".$page_title."</title>
		</head>";
	}
	
	if (!isset($_SESSION["loggedIn"]))
	{
		$_SESSION["loggedIn"]=false;
		$_SESSION["user_id"]=-1;
	}	
	
	function sendQuery($q)
	{	$result = null;
		global $dbc;
		if (($result=$dbc->query($q)) === FALSE) 
		{
		  echo "Query Error: ".$dbc->error;
		}
		return $result;
	}
	
	function connectDB()
	{
		global $db_host,$db_user,$db_pass, $db_name;
		$conn = new mysqli($db_host,$db_user,$db_pass, $db_name);
		if ($conn->connect_error)
		{
			die("Database Error: ".$conn->connect_error);
		}
		return $conn;
	}
	
	function getOrders($userId)
	{
		$q = "SELECT * FROM orders WHERE user_id = '".$userId."'";
		$r = sendQuery($q);
		$c = 0;
		$orders = null;
		while($row = $r->fetch_assoc()) 
		{
			$orders[$c]["id"]=$row["id"];
			$orders[$c]["user_id"]=$row["user_id"];
			$orders[$c]["description"]=$row["description"];
			$orders[$c]["sum"]=$row["sum"];
			$orders[$c]["city"]=$row["city"];
			$orders[$c]["address"]=$row["address"];
			$orders[$c]["firstname"]=$row["firstname"];
			$orders[$c]["lastname"]=$row["lastname"];
			$orders[$c]["phone"]=$row["phone"];
			$orders[$c]["status"]=$row["status"];
			$c++;
		}
		return $orders;
	}
	
	function getAllOrders()
	{
		$q = "SELECT * FROM orders";
		$r = sendQuery($q);
		$c = 0;
		$orders = null;
		while($row = $r->fetch_assoc()) 
		{
			$orders[$c]["id"]=$row["id"];
			$orders[$c]["user_id"]=$row["user_id"];
			$orders[$c]["description"]=$row["description"];
			$orders[$c]["sum"]=$row["sum"];
			$orders[$c]["city"]=$row["city"];
			$orders[$c]["address"]=$row["address"];
			$orders[$c]["firstname"]=$row["firstname"];
			$orders[$c]["lastname"]=$row["lastname"];
			$orders[$c]["phone"]=$row["phone"];
			$orders[$c]["status"]=$row["status"];
			$c++;
		}
		return $orders;
	}
	
	function updateCartList($userId)
	{
		$q = "SELECT * FROM cart_list WHERE user_id = '".$userId."'";
		$r = sendQuery($q);
		$c = 0;
		unset($_SESSION["cartList"]);
		while($row = $r->fetch_assoc()) 
		{
			$_SESSION["cartList"][$c]=$row["item_id"];
			$c++;
		}
		if (isset($_SESSION["cartList"]))
		{
			return count($_SESSION["cartList"]);
		}
		return 0;
	}
	
	function getItem($item_id)
	{
		$q = "SELECT * FROM catalog WHERE id = '".$item_id."'";
		$r = sendQuery($q);
		while($row = $r->fetch_assoc()) 
		{
			$item["id"]=$row["id"];
			$item["name"]=$row["name"];
			$item["description"]=$row["description"];
			$item["img"]=$row["img"];
			$item["price"]=$row["price"];
			$item["availability"]=$row["availability"];
			return $item;
		}
	}
	
	function getUser($userId)
	{
		$q = "SELECT * FROM `users` WHERE id = '".$userId."';";
		$r = sendQuery($q);
		while($row = $r->fetch_assoc()) 
		{
			$user["id"]=$row["id"];
			$user["email"]=$row["email"];
			$user["password"]=$row["password"];
			$user["phone"]=$row["phone"];
			$user["city"]=$row["city"];
			$user["address"]=$row["address"];
			$user["firstname"]=$row["firstname"];
			$user["lastname"]=$row["lastname"];
			$user["admin"]=$row["admin"];
			return $user;
		}
	}
	
	function removeFromCart($userId, $item_id)
	{
		$q = "SELECT * FROM cart_list WHERE user_id = '".$userId."' AND item_id = '".$item_id."'";
		$r = sendQuery($q);
		while($row = $r->fetch_assoc()) 
		{
			$id=$row["id"];
			break;
		}
		$q = "DELETE FROM `cart_list` WHERE id = '".$id."' AND user_id = '".$userId."' AND item_id = '".$item_id."'";
		$r = sendQuery($q);
	}
	
	function ApproveOrder($order_id)
	{
		$q = "UPDATE `orders` SET `status` = '1' WHERE `orders`.`id` = '".$order_id."'";
		$r = sendQuery($q);
	}
	
	function removeOrder($order_id)
	{
		$q = "DELETE FROM `orders` WHERE id = '".$order_id."'";
		$r = sendQuery($q);
	}
	
	function userLogin($email, $password)
	{
		$q = "SELECT * FROM users WHERE email = '".$email."' AND password = '".$password."'";
		$r = sendQuery($q);
		if (!empty(mysqli_num_rows($r)))
		{
			$_SESSION["user_id"]=$r->fetch_assoc()["id"];
			$_SESSION["loggedIn"]=true;
			return true;
		}
		return false;
	}
	
	function addToOrders($userid, $description, $totalprice)
	{
		$user = getUser($userid);
		
		$q = "INSERT INTO `orders` (`id`, `user_id`, `description`, `sum`, `city`, `address`, `firstname`, `lastname`, `phone`, `status`) VALUES (NULL, '".$userid."', '".$description."', '".$totalprice."', '".$user["city"]."', '".$user["address"]."', '".$user["firstname"]."', '".$user["lastname"]."', '".$user["phone"]."', '0');";
		$r = sendQuery($q);
	}
	
	function addToCart($item_id, $user_id)
	{
		$q = "INSERT INTO `cart_list` (`id`, `item_id`, `user_id`) VALUES (NULL, '".$item_id."', '".$user_id."');";
		$r = sendQuery($q);
	}
	
	function userRegister($email, $password, $address, $lname, $fname, $city, $phone)
	{
		$q = "INSERT INTO `users` (`id`, `email`, `password`, `phone`, `city`, `address`, `firstname`, `lastname`, `admin`) VALUES (NULL, '".$email."', '".$password."', '".$phone."', '".$city."', '".$address."', '".$fname."', '".$lname."', '0'); ";
		$r = sendQuery($q);
	}
	
	function getCatalog()
	{
		$q = "SELECT * FROM catalog";
		$r = sendQuery($q);
		$catalog_array = array();
		$c = 0;
		while($row = $r->fetch_assoc()) 
		{
			$catalog_array[$c][0]=$row["id"];
			$catalog_array[$c][1]=$row["name"];
			$catalog_array[$c][2]=$row["description"];
			$catalog_array[$c][3]=$row["img"];
			$catalog_array[$c][4]=$row["price"];
			$catalog_array[$c][5]=$row["availability"];
			$c++;
		}
		return $catalog_array;
	}
	
	$dbc = connectDB();
	
?>
