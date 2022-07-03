<?php
include_once "../include/connection.php";
session_start();
if(!isset($_POST['submit']))
{
	header("Location:category.php?message=Please+Add+a+Category");
	exit();
}	
else
{
	if(!isset($_SESSION['author_role']))
	{
		header("Location:login.php?");
		exit();
	}
	else
	{
		if($_SESSION['author_role']!="admin")
		{
			echo "YOU CAN,T ACCESS THIS PAGE";
			exit();
		}
		else if($_SESSION['author_role']=="admin")
		{
			$category_name=$_POST['category_name'];
			$sql="INSERT INTO category (`category_name`) VALUES ('$category_name')";
			if(mysqli_query($conn,$sql))
			{
				header("Location:category.php?message=Added");
				exit();
			}
			else
			{
				header("Location:category.php?message=Error");
				exit();
			}
			
		}
	}
}
?>