<?php
include_once "../include/connection.php";
include_once "../include/function.php";
session_start();
if(!isset($_GET['id']))
{
	header("Location:page.php?message=Please+Click+The+Edit+Button");
	exit();
}
else
{
	if(!isset($_SESSION['author_role']) OR ($_SESSION['author_role']!="admin") )
	{
		header("Location:login.php?message=Please+Login");
		exit();
	}
	else
	{
		$page_id=$_GET['id'];
		$sql="SELECT * FROM page WHERE page_id='$page_id'";
		$result=mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)<=0)
		{
			header("Location:page.php?message=No+page+found");
			exit();
		}
		else
		{
			?>
			
			<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin Panel</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
				<h1 class="h2">Edit Page:</h1>
				<h6>Howdy <?php echo $_SESSION['author_name']; ?> | Your role is <?php echo $_SESSION['author_role']; ?></h6>
			  </div>
			  <div id="admin-index-form">

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
				<?php
$post_id=$_GET['id'];
$formsql="SELECT* FROM `page` WHERE `page_id`='$page_id'";
$formresult=mysqli_query($conn,$formsql);
while($formrow=mysqli_fetch_assoc($formresult))
{	
$pagetitle=$formrow['page_title'];
$pagecontent=$formrow['page_content'];
				?>
				<form method ="post" enctype="multipart/form-data">
					Page Title
					<input type="text" name="page_title" class="form-control" placeholder="Page Title" value="<?php echo $pagetitle; ?>"><br>
					
					Page Content
					<textarea class="form-control" name="page_content" id="exampleFormControlTextarea1" rows="6"><?php echo $pagecontent; ?></textarea><br>
					<br>
					<button name="submit" type="submit" class="btn btn-primary">Update</button>
				</form>
<?php } ?>
				<?php
					if(isset($_POST['submit']))
					{
						$page_title=mysqli_real_escape_string($conn,$_POST['page_title']);
						$page_content=mysqli_real_escape_string($conn,$_POST['page_content']);
						
						if(empty($page_title) OR empty($page_content))
						{
							echo '<script>window.location="page.php?message=Empty+Fields";</script>';
							exit();
						}
					
						else
						{
							$sql="UPDATE page SET page_title='$page_title',page_content='$page_content' WHERE page_id='$page_id'";
							if(mysqli_query($conn,$sql))
										{
											echo '<script>window.location="page.php?message=Page+Updated";</script>';
											exit();
										}
										else
										{
											echo '<script>window.location="page.php?message=Oops+Error+Updating+Your+Page";</script>';
											exit();
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
		<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({selector:'textarea'});</script>
	</body>
</html>
			
			
			
			<?php
		}
	}
}