<?php 
	require "sys.php";
	$page_title = "Register";
	
	if ($_SESSION["loggedIn"])
	{
		header("location: index.php");
	}
	
	if (isset($_POST["email"]) && isset($_POST["password"]))
	{
		$email = htmlspecialchars($_POST["email"]);
		$password = htmlspecialchars($_POST["password"]);
		$address = htmlspecialchars($_POST["address"]);
		$lastname = htmlspecialchars($_POST["ln"]);
		$firstname = htmlspecialchars($_POST["fn"]);
		$city = htmlspecialchars($_POST["city"]);
		$phone = htmlspecialchars($_POST["phone"]);
		
		userRegister($email, md5($password), $address, $lastname, $firstname, $city, $phone);
		header("location: index.php");
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
					<li class="nav-item">
					  <a class="nav-link" href="login.php">Login</a>
					</li>
				  </ul>
				</div>
			  </div>
			</nav>
			<!-- register -->
			<div class="container"> 
				<form class="row g-3" action="<?php echo SelfPOST();?>" method="post">
					<div class="col-md-6">
						<label for="name_f" class="form-label"><h5><B>First Name</B></h5></label>
						<input type="text" name="fn" class="form-control" id="name_f">
					</div>
					<div class="col-md-6">
						<label for="name_l" class="form-label"><h5><B>Last Name</B></h5></label>
						<input type="text" name="ln" class="form-control" id="name_l">
					</div>
					<div class="col-md-6">
						<label for="inputEmail4" class="form-label"><h5><B>Email</B></h5></label>
						<input type="email" name="email" class="form-control" id="inputEmail4">
					</div>
					<div class="col-md-6">
						<label for="inputPassword4" class="form-label"><h5><B>Password</B></h5></label>
						<input type="password" name="password" class="form-control" id="inputPassword4">
					</div>
					<div class="col-6">
						<label for="phone" class="form-label"><h5><B>Phone Number</B></h5></label>
						<input type="text" name="phone" class="form-control" id="phone" name="phone">
					</div>
					<div class="col-6">
						<label for="inputAddress" class="form-label"><h5><B>Address</B></h5></label>
						<input type="text" name="address" class="form-control" id="inputAddress">
					</div>
					<div class="col-md-6">
						<label for="inputCity" class="form-label"><h5><B>City</B></h5></label>
						<input type="text" name="city" class="form-control" id="inputCity">
					</div>
					<div class="col-12">
						<button type="submit" class="btn btn-primary">Register</button>
					</div>
				</form>
			</div>
		</div>
	

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
