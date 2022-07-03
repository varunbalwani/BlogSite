<?php
session_start();
include_once "../include/connection.php";
if(!isset($_GET['id']))
{
	header("Location: index.php");
	exit();
}	
else
{
	if(!isset($_SESSION['author_role']))
	{
		header("Location: login.php?message=Please+Login");
		exit();
	}
	else
	{		
		if($_SESSION['author_role']=="admin")
		{
			$id=$_GET['id'];
			$sqlcheck="SELECT * FROM post WHERE post_id='$id'";
			$result=mysqli_query($conn,$sqlcheck);
			if(mysqli_num_rows($result)<=0){
				header("Location:posts.php?message=NoFile");
				exit();
			}
			$sql="DELETE FROM post WHERE post_id='$id'";
			if(mysqli_query($conn,$sql))
			{
				header("Location: posts.php?message=Successfully+Deleted");
				exit();
			}
			else{
				header("Location:posts.php?message=Could+Not+Delete+Posts");
				exit();
			}
		}
		else{
			echo "ERROR: You can not access this page!";
		exit();
		}
	}
}
?>