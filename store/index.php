<?php 
	require "sys.php";
	$page_title = "Home";
	$catalog_array = getCatalog();
	$catalog_size = count($catalog_array);
	
	if (isset($_POST["item_id"]))
	{
		if ($_SESSION["loggedIn"])
		{
			addToCart(htmlspecialchars($_POST["item_id"]), $_SESSION["user_id"]);
		}
		else
		{
			$_SESSION["login_error"]="you must login before you can add to cart!";
			header("location: login.php");
		}
	}
	
	if ($_SESSION["loggedIn"])
	{
		$cart_size = updateCartList($_SESSION["user_id"]);
	}
	
?>
<!doctype html>
<html lang="en">
	<?php printHead(); ?>
  <body style="background-image: url('imgs/back.png'); background-repeat: repeat;">  
		<div class="container" >		
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
					  <a class="nav-link active" aria-current="page" href="index.php">Store Front</a>
					</li>
					<?php 
						if ($_SESSION["loggedIn"]) 
						{
						echo "<li class=\"nav-item\">
							<a class=\"nav-link\" href=\"order.php\">Orders</a>
							</li>
							<li class=\"nav-item\">
							<a class=\"nav-link\" href=\"cart.php\">Cart(".$cart_size.")</a>
							</li>";
						}
					?>
					<li class="nav-item">
					  <?php
						if ($_SESSION["loggedIn"]) 
						{
							echo "<a class=\"nav-link\" href=\"logout.php\">";
							echo "Logout";
						}
						else
						{
							echo "<a class=\"nav-link\" href=\"login.php\">";
							echo "Login";
						}
						?>
					  </a>
					</li>
				  </ul>
				</div>
			  </div>
			</nav>
			<!-- BIG AD -->
			<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
			  <div class="carousel-indicators">
				<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
				<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
				<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
			  </div>
			  <div class="carousel-inner">
				<div class="carousel-item active">
				  <img src="imgs/ad_1.png" class="d-block w-100" alt="ad01">
				</div>
				<div class="carousel-item">
				  <img src="imgs/ad_2.png" class="d-block w-100" alt="ad02">
				</div>
				<div class="carousel-item">
				  <img src="imgs/ad_3.png" class="d-block w-100" alt="ad03">
				</div>
			  </div>
			  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			  </button>
			  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			  </button>
			</div>
			
			<!-- LIST -->
			<?php 			
				$full_rows = floor($catalog_size/4); // how much full rows
				$last_row = $catalog_size-($full_rows*4);
				$item_count = 0;
				for ($i=0; $i<$full_rows; $i++)
				{
					echo "<div class=\"row py-4\">";
						for ($j=0; $j<4; $j++)
						{
							$id = $catalog_array[$item_count][0];
							$name = $catalog_array[$item_count][1];
							$des = $catalog_array[$item_count][2];
							$img = $catalog_array[$item_count][3];
							$price = $catalog_array[$item_count][4];
							$stock = $catalog_array[$item_count][5];
							echo "
							<div class=\"col py-1\">
							<div class=\"card\" style=\"width: 18rem;\">
							<img src=\"".$img."\" class=\"card-img-top\" alt=\"item\">
							<div class=\"card-body\">
							<h5 class=\"card-title\">".$name."</h5>
							<h4 class=\"card-subtitle text-muted py-1\">".$price."₪</h4>
							<p class=\"card-text\">".$des."</p>
							";
							if ($stock>0)
							{
								echo "
								<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method=\"post\">
								<input type=\"hidden\" name=\"item_id\" value=\"".$id."\">
								<button type=\"submit\" class=\"btn btn-primary\">Add to cart</button>
								</form>
								";
							}
							else
							{
								echo "<a href=\"#\" class=\"btn btn-secondary disabled\">Out off Stock</a>";
							}
							echo "</div></div></div>";
							$item_count++;
						}
					echo "</div>";
				}
				if ($last_row>0)
				{
					echo "<div class=\"row py-4\">";
					for ($i=0; $i<$last_row; $i++)
					{
						$id = $catalog_array[$item_count][0];
						$name = $catalog_array[$item_count][1];
						$des = $catalog_array[$item_count][2];
						$img = $catalog_array[$item_count][3];
						$price = $catalog_array[$item_count][4];
						$stock = $catalog_array[$item_count][5];
						echo "
						<div class=\"col py-1\">
						<div class=\"card\" style=\"width: 18rem;\">
						<img src=\"".$img."\" class=\"card-img-top\" alt=\"item\">
						<div class=\"card-body\">
						<h5 class=\"card-title\">".$name."</h5>
						<h4 class=\"card-subtitle text-muted py-1\">".$price."₪</h4>
						<p class=\"card-text\">".$des."</p>
						";
						if ($stock>0)
						{
							echo "
							<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method=\"post\">
							<input type=\"hidden\" name=\"item_id\" value=\"".$id."\">
							<button type=\"submit\" class=\"btn btn-primary\">Add to cart</button>
							</form>
							";
						}
						else
						{
							echo "<a href=\"#\" class=\"btn btn-secondary disabled\">Out off Stock</a>";
						}
						echo "</div></div></div>";
						$item_count++;
					}
					echo "</div>";
				}
			?>
		</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
