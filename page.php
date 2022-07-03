<?php
include_once "include/connection.php";
include_once "include/function.php";
if(!isset($_GET['id']))
{
	header("Location: index.php");
}
else
{
	$id=mysqli_real_escape_string($conn,$_GET['id']);
	if(!is_numeric($id))
	{
		header("Location:index.php");
		exit();
	}
	else if(is_numeric($id))
	{
		$sql="SELECT * FROM page WHERE page_id='$id'";
		$result=mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)<=0)
		{
			header("Location:index.php?nopagefound");
			exit();
		}
		else if(mysqli_num_rows($result)>0)
		{
			while($row=mysqli_fetch_assoc($result))
			{
				$page_title=$row['page_title'];
				$page_content=$row['page_content'];
				?>				
				
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $page_title ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="style/bootstrap.min.css">
		<link rel="stylesheet" href="style.css>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<!--NAVIGATION BAR HERE-->
		<?php include_once "include/nav.php";?>
		<!--NAVIGATION ENDS BAR HERE-->
		
		<div class="container">
			<h1 style="width:100%;background-color:grey;padding-top:25px;padding-bottom:25px;text-align:center;color:white;"><?php echo $page_title; ?></h1>
			<hr>
			<p><?php echo $page_content; ?></p>
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scroll.js"></script>
	</body>
</html>
				
				<?php
			}
		}

	}
}
?>