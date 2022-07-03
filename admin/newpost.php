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
				<h1 class="h2">Add New Post:</h1>
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
				<form method ="post" enctype="multipart/form-data">
					Post Title
					<input type="text" name="post_title" class="form-control" placeholder="Post Title"><br>
					Post Category
					<select class="form-control" name="post_category" id="exampleFormControlSelect1">
					<?php
						$sql="SELECT * FROM `category`";
						$result=mysqli_query($conn,$sql);
						while($row=mysqli_fetch_assoc($result))
						{
							$category_id=$row['category_id'];
							$category_name=$row['category_name'];
							?>
							<option value="<?php echo $category_id;?>"><?php echo $category_name; ?>
							</option>
							<?php
						}
					?>
					</select><br>
					Post Content
					<textarea class="form-control" name="post_content" id="exampleFormControlTextarea1" rows="3"></textarea><br>
					Post Image
					<input type="file" name="file" class="form-control-file" id="exampleFormControlFile1"><br>
					Post Keywords
					<input type="text" name="post_keywords" class="form-control" placeholder="Post Keywords"><br>
					<button name="submit" type="submit" class="btn btn-primary">Submit</button>
				</form>
				<?php
					if(isset($_POST['submit']))
					{
						$post_title=mysqli_real_escape_string($conn,$_POST['post_title']);
						$post_category=mysqli_real_escape_string($conn,$_POST['post_category']);
						$post_content=mysqli_real_escape_string($conn,$_POST['post_content']);
						$post_keywords=mysqli_real_escape_string($conn,$_POST['post_keywords']);
						$post_author=$_SESSION['author_id'];
						$post_date=date("d/m/y");
						if(empty($post_title) OR empty($post_category) OR empty($post_content))
						{
							header("Location:newpost.php?message=Empty+Fields");
							exit();
						}
						$file=$_FILES['file'];
						
						$fileName=$file['name'];
						$fileType=$file['type'];
						$fileTmp=$file['tmp_name'];
						$fileErr=$file['error'];
						$fileSize=$file['size'];
						
						$fileEXT=explode('.',$fileName);
						$fileExtension=strtolower(end($fileEXT));
						
						$allowedExt=array("jpg","jpeg","png","gif");
						
						if(in_array($fileExtension,$allowedExt))
						{
							if($fileErr===0)
							{
								if($fileSize<4000000)
								{
									$newFileName=uniqid('',true).'.'.$fileExtension;
									$destination="../uploads/$newFileName";
									$dbdestination="uploads/$newFileName";
									move_uploaded_file($fileTmp,$destination);
									$sql="INSERT INTO `post` (`post_title`,`post_content`,`post_category`,`post_author`,`post_date`,`post_keywords`,`post_image`) VALUES ('$post_title','$post_content','$post_category','$post_author','$post_date','$post_keywords','$dbdestination');";
									if(mysqli_query($conn,$sql))
									{
										header("Location:posts.php?message=Post+Published");
										exit();
									}
									else
									{
										header("Location:newpost.php?message=Oops+Error+Uploading+Your+file");
										exit();
									}
								}
								else
								{
									header("Location:newpost.php?message=YOUR FILE IS TOO BIG TO UPLOAD!");
									exit();
								}
							}
							else
							{
								header("Location:newpost.php?message=ERROR UPLOADING FILE!");
									exit();
							}
						}
						else
						{
							header("Location:newpost.php?message=YOU ARE UPLOADING WRONG FILE!");
									exit();
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
else
{
	header("Location:login.php?message=please+login");
}
?>

