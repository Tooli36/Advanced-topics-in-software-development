<?php 
	require "sys.php";
	$page_title = "Orders";
	
	if (!$_SESSION["loggedIn"])
	{
		$_SESSION["login_error"]="you must be logged in to access this page!";
		header("location: login.php");
	}
		
	if ($_SESSION["loggedIn"])
	{
		$cart_size = updateCartList($_SESSION["user_id"]);
	}
	
	if (getUser($_SESSION["user_id"])["admin"]==1 and $_SESSION["loggedIn"]) // work only if admin
	{
		if (isset($_POST["delete_order"]))
		{
			$orderId = htmlspecialchars($_POST["delete_order"]);
			removeOrder($orderId);
			header("refresh:0");
		}
		
		if (isset($_POST["approve_order"]))
		{
			$orderId = htmlspecialchars($_POST["approve_order"]);
			ApproveOrder($orderId);
			header("refresh:0");
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
							<a class=\"nav-link active\" aria-current=\"page\" href=\"order.php\">Orders</a>
							</li>
							<li class=\"nav-item\">
							<a class=\"nav-link\" href=\"cart.php\">Cart(".$cart_size.")</a>
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
			<!-- orders -->
			<div class="container-fluid px-2 py-2">
			<?php 
			$orders = getOrders($_SESSION["user_id"]);
			if (empty($orders))
			{
				echo "<div class=\"alert alert-danger my-2\" role=\"alert\">No Orders!</div>";
			}
			else
			{
				if (getUser($_SESSION["user_id"])["admin"]==1) // if you're admin
				{
					echo '<h3 style="color: #ffa500;"><B>you are admin</B></h3>';
					$orders = getAllOrders();
					for ($i=0; $i<count($orders); $i++)
					{
						$item_list = explode(",",$orders[$i]["description"]);
						$order_userID = $orders[$i]["user_id"];
						$state = "unknown";
						$state_color = "text-primary";
						switch ($orders[$i]["status"])
						{
							case 0:
								$state="Awaiting approval";
								$state_color = "text-danger";
								break;
							case 1:
								$state="Order Approved";
								$state_color = "text-success";
								break;
						}
								
						
						echo "	<div class=\"shadow p-3 mb-5 bg-body rounded\">
								<div class=\"row\">
								<div class=\"col border-bottom border-2\">
								<b>Order Number: ".$orders[$i]["id"]."</b>
								/ <i>User-ID: ".$order_userID."</i>
								</div>
								<div class=\"col border-bottom border-2\">
								<b class=\"".$state_color."\">Status: ".$state."</b>
								</div>
								</div>
								<div class=\"row\">
								<div class=\"col\">
								<b>description:</b>
								<ul>
								";
								for ($j=0; $j<count($item_list); $j++)
								{
									echo "<li>".$item_list[$j]."</li>";
								}							
							echo "</ul>
							<p class=\"my-1\"><b>Sum: </b>".$orders[$i]["sum"].getCurrency()."</p>
							<p class=\"my-1\"><b>Sent To: </b>".$orders[$i]["city"].", ".$orders[$i]["address"].".</p>
							<p class=\"my-1\"><b>Contact Info: </b> ".$orders[$i]["firstname"].", ".$orders[$i]["lastname"].".</p>
							<p class=\"my-1\"><b>Phone: </b>".$orders[$i]["phone"]."</p>
							</div>
							</div>
							<div class=\"row\">
								<div class=\"col border-top py-1 border-2\">
								<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method=\"post\">";
								if ($state=="Awaiting approval")
								{
									echo "<button type=\"submit\" name=\"approve_order\" class=\"btn btn-primary\" value=\"".$orders[$i]["id"]."\">Approve Order</button>";
								}
								else
								{
									echo "<button type=\"button\" class=\"btn btn-secondary\" >Approved</button>";
								}
								echo "<button type=\"submit\" name=\"delete_order\" class=\"btn btn-danger\" value=\"".$orders[$i]["id"]."\">Delete Order</button>
								</form>
								</div>
							</div>
							</div>
						";
					}
				}
				else // if you're NOT admin
				{
					for ($i=0; $i<count($orders); $i++)
					{
						$item_list = explode(",",$orders[$i]["description"]);
						$state = "unknown";
						$state_color = "text-primary";
						switch ($orders[$i]["status"])
						{
							case 0:
								$state="Awaiting approval";
								$state_color = "text-danger";
								break;
							case 1:
								$state="Order Approved";
								$state_color = "text-success";
								break;
						}
								
						
						echo "	<div class=\"shadow p-3 mb-5 bg-body rounded\">
								<div class=\"row\">
								<div class=\"col border-bottom border-2\">
								<b>Order Number: ".$orders[$i]["id"]."</b>
								</div>
								<div class=\"col border-bottom border-2\">
								<b class=\"".$state_color."\">Status: ".$state."</b>
								</div>
								</div>
								<div class=\"row\">
								<div class=\"col\">
								<b>description:</b>
								<ul>
								";
								for ($j=0; $j<count($item_list); $j++)
								{
									echo "<li>".$item_list[$j]."</li>";
								}							
							echo "</ul>
							<p class=\"my-1\"><b>Sum: </b>".$orders[$i]["sum"].getCurrency()."</p>
							<p class=\"my-1\"><b>Sent To: </b>".$orders[$i]["city"].", ".$orders[$i]["address"].".</p>
							<p class=\"my-1\"><b>Contact Info: </b> ".$orders[$i]["firstname"].", ".$orders[$i]["lastname"].".</p>
							<p class=\"my-1\"><b>Phone: </b>".$orders[$i]["phone"]."</p>
							</div>
							</div>
							</div>
						";
					}	
				}
			}
			?>
		</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
