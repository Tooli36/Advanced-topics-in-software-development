<?php 
	require "sys.php";
	$page_title="Cart";	
	
	if (!$_SESSION["loggedIn"])
	{
		$_SESSION["login_error"]="you must be logged in to access this page!";
		header("location: login.php");
	}
	
	function drawCartItem($itemid)
	{
		$item = getItem($itemid);
		$_SESSION["total_price"]+=$item["price"];
		echo "
		<li class=\"list-group-item d-flex justify-content-between align-items-center\">
		<b>".$item["name"]." (".$item["price"].getCurrency().")</b>
		<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method=\"post\">
		<input type=\"hidden\" name=\"item_id\" value=\"".$itemid."\">
		<button type=\"submit\" class=\"btn btn-danger\">Remove</button>
		</form>
		</li>";
	}
	
	if ($_SESSION["loggedIn"])
	{
		$cart_size = updateCartList($_SESSION["user_id"]);
	}
	
	
	if (isset($_POST["item_id"]))
	{
		if ($_SESSION["loggedIn"])
		{
			$itemid = htmlspecialchars($_POST["item_id"]);
			removeFromCart($_SESSION["user_id"], $itemid);
			header("refresh:0");
		}
	}
	
	if (isset($_POST["order"]))
	{
		if ($_SESSION["loggedIn"])
		{
			$description="";
			if ($cart_size>=1)
			{
				for ($i=0; $i<$cart_size; $i++)
				{
					$item = getItem($_SESSION["cartList"][$i]);
					$description=$description.$item["name"]." (".$item["price"].getCurrency().")";
					if ($i<$cart_size-1)
					{
						$description=$description.",";
					}
					removeFromCart($_SESSION["user_id"], $item["id"]);
				}
				addToOrders($_SESSION["user_id"], $description, $_SESSION["total_price"]);
				header("refresh:0");
			}
		}
	}
	
?>
<!doctype html>
<html lang="en">
	<?php printHead(); ?>
	<body style="background-image: url('imgs/back.png'); background-repeat: repeat;">
		<div class="container">
<!-- NAVIGATION -->
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			  <div class="container-fluid">
				<a class="navbar-brand" href="#"><?php echo $store_name;?></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
				  <ul class="navbar-nav">
					<li class="nav-item">
					  <a class="nav-link" href="index.php">Store Front</a>
					</li>
					<?php 
						if ($_SESSION["loggedIn"]) 
						{
						echo "<li class=\"nav-item\">
							<a class=\"nav-link\" href=\"order.php\">Orders</a>
							</li>
							<li class=\"nav-item\">
							<a class=\"nav-link active\" aria-current=\"page\" href=\"cart.php\">Cart(".$cart_size.")</a>
							</li>";
						}
					 
						if ($_SESSION["loggedIn"]) 
						{
							echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\">Logout</a></li>";
						}
					?>
				  </ul>
				</div>
			  </div>
			</nav>
<!-- CART -->
			
			<?php
				if ($cart_size<1)
				{
					echo "<div class=\"alert alert-danger my-2\" role=\"alert\">Cart is empty!</div>";
				}
			?>
			
			<div class="container-fluid px-2 py-2">
				<?php 
					if ($cart_size>=1)
					{
						$_SESSION["total_price"]=0;
						for ($i=0; $i<$cart_size; $i++)
						{
							drawCartItem($_SESSION["cartList"][$i]);
						}
					}
				?>
			</div>
			
			<div class="container-fluid px-5 py-5">
				<div class="row justify-content-md-center">
				<?php 
					if ($cart_size>=1)
					{
						echo "
						<h2 class=\"col-md-auto\"><B>Total: ".$_SESSION["total_price"].getCurrency()."</B></h2>
						";
						
						echo "<form class=\"col-md-auto\" action=\"".SelfPOST()."\" method=\"post\">
						<input type=\"hidden\" name=\"order\">
						<button type=\"submit\" class=\"col-md-auto btn btn-success px-4\">Place Order</button>
						</form>";
					
					
					}
				?>
				</div>
			</div>
		</div>
	

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
