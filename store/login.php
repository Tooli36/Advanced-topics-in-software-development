<?php 
	require "sys.php";
	$page_title = "Login";
	
	if ($_SESSION["loggedIn"])
	{
		header("location: index.php");
	}
	
	function displayLoginMsg($msg)
	{
		$_SESSION["login_error"]=$msg;
	}
	
	if (isset($_POST["email"]) && isset($_POST["password"]))
	{
		$email = htmlspecialchars($_POST["email"]);
		$password = htmlspecialchars($_POST["password"]);
		
		if (strlen($email)<=3)
		{
			displayLoginMsg("email too short");
		}
		
		if (userLogin($email, md5($password)))
		{
			header("location: index.php");
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
					<li class="nav-item">
					  <a class="nav-link active" aria-current="page" href="login.php">
					  <?php
						if ($_SESSION["loggedIn"]) 
						{
							echo "Logout";
						}
						else
						{
							echo "Login";
						}
						?>
					  </a>
					</li>
				  </ul>
				</div>
			  </div>
			</nav>
			<!-- login -->
			<?php 
				if (isset($_SESSION["login_error"]))
				{
					echo "<div class=\"alert alert-danger my-2\" role=\"alert\">".$_SESSION["login_error"]."</div>";
					unset($_SESSION["login_error"]);
				}
			?>
			<div class="container"> 
				<form action="<?php echo SelfPOST();?>" method="post">
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label"><h5><B>Email address</B></h5></label>
						<input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label"><h5><B>Password</B></h5></label>
						<input type="password" name="password" class="form-control" id="exampleInputPassword1">
					</div>
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="register.php" role="button" class="btn btn-success">Register</a>
				</form>
			</div>
		</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
