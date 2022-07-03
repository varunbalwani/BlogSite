 <?php 
include_once "../include/function.php";
include_once "../include/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Signup</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../style/bootstrap.min.css">
		<link rel="stylesheet" href="../style.css>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
	
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
	
		<div style="width:500px;margin:auto;margin-top:150px">
		 <form method="post" class="form-signin">
			  <h1 class="h3 mb-3 font-weight-normal">Please Sign Up</h1>
			  
			  <input type="text" name="author_name" id="input" class="form-control" placeholder="Enter Name" required autofocus>
			  
			  <input type="email" name="author_email" id="inputEmail" class="form-control" placeholder="Enter Email" required autofocus>
			  
			  <input type="password" name="author_password" id="inputPassword" class="form-control" placeholder="Enter Password" required>
			  
			  <div class="checkbox mb-3">
				</div>
			<button class="btn btn-lg btn-primary btn-block" name="signup" type="submit">Sign Up</button>
		 </form>
		</div>
		<?php
		if(isset($_POST['signup']))
		{
			$author_name=mysqli_real_escape_string($conn,$_POST['author_name']);
			$author_email=mysqli_real_escape_string($conn,$_POST['author_email']);
			$author_password=mysqli_real_escape_string($conn,$_POST['author_password']);
			
			if(empty($author_name) OR empty($author_email) OR empty( $author_password))
			{
				header("Location:signup.php?message=empty+fields");
				exit();
			}
			if(!filter_var($author_email,FILTER_VALIDATE_EMAIL))
			{	
				header("Location:signup.php?message=please+enter+a+valid+email");
				exit();
			}
			else
			{
				$sql="SELECT * FROM `author` WHERE author_email='$author_email'";
				$result=mysqli_query($conn,$sql);
				if(mysqli_num_rows($result)>0)
				{
					header("Location:signup.php?message=email+already+exists");
					exit();
				}
				else
				{
					$hash=password_hash($author_password,PASSWORD_DEFAULT);
					$sql="INSERT INTO `author`(`author_name`,`author_email`,`author_password`,`author_bio`,`author_role`) VALUES ('$author_name','$author_email','$hash','enter bio','author')";
					if(mysqli_query($conn,$sql)){
						header("Location:signup.php?message=sucessfully+registered");
						exit();
					}
					else{
						header("Location:signup.php?message=registration+failed");
						exit();
					}
				}
			}
				
		}
		?>
		
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/scroll.js"></script>
	</body>
</html>