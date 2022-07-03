<?php 
include_once "../include/function.php";
include_once "../include/connection.php";
session_start();
if(isset($_SESSION['author_role']))
{
   ?>
	<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin Panel</title>
		<link rel="stylesheet" href="../style/bootstrap.min.css">
		<link rel="stylesheet" href="../style.css>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<nav class="navbar navbar-dark sticky-top bg-dark shadow">
		  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
		  <ul class="navbar-nav px-3">
			<li class="nav-item text-nowrap">
			  <a class="nav-link" href="logout.php">Sign out</a>
			</li>
		  </ul>
		</nav>

		<div class="container-fluid">
		  <div class="row">
			<?php include_once "nav.inc.php"?>

			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
			  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2">Dashboard</h1>
				<h6>Howdy <?php echo $_SESSION['author_name']; ?> | Your role is <?php echo $_SESSION['author_role']; ?></h6>
			  </div>
			  <div id="admin-index-form">
			  <h1>Your Profile</h1>
			  <?php
				 if(isset($_GET['message']))
				 {
					 $msg=$_GET['message'];
					 echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
							 '.$msg.'
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							  </button>
							</div>';
				 }
				?>
				<form method="post">
					<div class="form-group">
					<label for="exampleInputEmail1">Name:</label>
					<input name="author_name"type="text" placeholder="Enter Name" value="<?php echo $_SESSION['author_name']; ?>"class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">Email address:</label>
					<input name="author_email" type="email" placeholder="Enter Email" value="<?php echo $_SESSION['author_email']; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1">Password:</label>
					<input name="author_password" type="password"placeholder="Password"
					class="form-control" id="exampleInputPassword1">
				  </div>
				  <div class="form-group">
					<label for="exampleFormControlTextarea1">Your Bio:</label>
					<textarea name="author_bio" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $_SESSION['author_bio']; ?></textarea>
				  </div>
				  <div class="form-group form-check">
				  </div>
				  <button type="submit" name="update" class="btn btn-primary">Update</button>
				</form>
				
				<?php
					if(isset($_POST['update']))
					{
						$author_name=mysqli_real_escape_string($conn,$_POST['author_name']);
						$author_email=mysqli_real_escape_string($conn,$_POST['author_email']);
						$author_password=mysqli_real_escape_string($conn,$_POST['author_password']);
						$author_bio=mysqli_real_escape_string($conn,$_POST['author_bio']);
						if(empty($author_name) OR empty($author_email) OR empty($author_bio))
						{
							echo "Empty Fields";
						}
						else
						{
							if(!filter_var($author_email,FILTER_VALIDATE_EMAIL))
							{
								echo "Enter a Valid Email";
							}
							else
							{
								if(empty( $author_password))
								{
									$author_id=$_SESSION['author_id'];
									$sql=  "UPDATE `author` SET author_name='$author_name',author_email='$author_email',author_bio='$author_bio' WHERE author_id='$author_id';";
									if(mysqli_query($conn,$sql))
									{
										$_SESSION['author_name']=$author_name;
										$_SESSION['author_email']=$author_email;
										$_SESSION['author_bio']=$author_bio;
										header("Location:index.php?message=Record+Updated");
									}
									else
									{
										echo "error";
									}
								}
								else
								{
									$hash=password_hash($author_password,PASSWORD_DEFAULT);
									$author_id=$_SESSION['author_id'];
									$sql=  "UPDATE `author` SET author_name='$author_name',author_email='$author_email',author_password='$hash',author_bio='$author_bio' WHERE author_id='$author_id';";
									if(mysqli_query($conn,$sql))
									{
										session_unset();
										session_destroy();
										header("Location:login.php?message=Record+Updated+.+You+May+Login+Again");
									}
									else
									{
										echo "error";
									}
								}
							}
						}
					}
				?>
			  </div>
			  </div>
			</main>
		  </div>
		</div>
		
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/scroll.js"></script>
	</body>
</html>
<?php
}
else
{
	header("Location:login.php?message=please+login");
}
?>

