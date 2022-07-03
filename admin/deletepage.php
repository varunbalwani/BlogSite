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
			$page_id=$_GET['id'];
			$sql="DELETE FROM page WHERE page_id='$page_id'";
			if(mysqli_query($conn,$sql))
			{
				header("Location:page.php?message=Page+Deleted");
				exit();
			}
			else{
				header("Location:page.php?message=Could+not+delete+page");
				exit();
			}
		}
	}
}