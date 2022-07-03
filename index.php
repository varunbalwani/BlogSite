<?php 
include_once "include/function.php";
include_once "include/connection.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Dynamic Site</title>
		
		<link rel="stylesheet" href="style/bootstrap.min.css">
		<link rel="stylesheet" href="style.css>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
	</head>
	<body>
		<!--NAVIGATION BAR HERE-->
		<?php include_once "include/nav.php";?>
		<!--NAVIGATION ENDS BAR HERE-->
		<div class="jumbotron jumbotron-fluid">
		  <div class="container">
			<h1 class="display-4"><?php getsettingvalue("home_jumbo_title"); ?></h1>
			<p class="lead"><?php getsettingvalue("home_jumbo_desc"); ?></p>
		  </div>
		</div>

		<div class="container">
		<?php
		//pagination
		$sqlpg="SELECT * FROM `post` ORDER BY post_id DESC";
		$resultpg=mysqli_query($conn,$sqlpg);
		$totalposts=mysqli_num_rows($resultpg);
		$totalpages=ceil($totalposts/6);
		?>
		<?php
			if(isset($_GET['p']))
			{
				$pageid=$_GET['p'];
				$start=($pageid*6)-6;
				$sql="SELECT * FROM `post` ORDER BY `post_id` DESC LIMIT $start,6";
			}
			else
			{
				$sql="SELECT * FROM `post` ORDER BY `post_id` DESC LIMIT 0,6";
			}
		?>
		<div class="card-columns">
		<?php
			
			$result=mysqli_query($conn,$sql);
			while($row=mysqli_fetch_assoc($result))
			{
				$post_title=$row['post_title'];
				$post_image=$row['post_image'];
				$post_author=$row['post_author'];
				$post_content=$row['post_content'];
				$post_id=$row['post_id'];
				$sqlauth="SELECT * FROM `author` WHERE `author_id`='$post_author';";
				$resultauth=mysqli_query($conn,$sqlauth);
				while($authrow=mysqli_fetch_assoc($resultauth))
				{
					$post_author_name=$authrow['author_name'];
				
		?>
		
			<div class="card" style="width: 17rem;">
			  <img src="<?php echo $post_image ?>" class="card-img-top" alt="..." width="50px" height="180px">
			  <div class="card-body">
				<h5 class="card-title"><?php echo $post_title ?></h5>
				<h6 class="card-subtitle mb-2 text-muted"><?php echo $post_author_name ?></h6>
				<p class="card-text"><?php echo substr(strip_tags($post_content),0,90).'....' ?></p>
				<a href="post.php?id=<?php echo $post_id ?>" class="btn btn-primary">Read More</a>
				</div>
			</div>
			<?php }} ?>
			</div>
			<?php
			echo "<center>";
				for($i=1;$i<=$totalpages;$i++)
				{
					?>
					<a href="?p=<?php echo $i; ?>"><button class="btn btn-info"><?php echo $i ?></button></a>&nbsp;
					<?php
				}
				echo "</center>";
			?>
			<br><br>
		</div>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scroll.js"></script>
	</body>
</html>