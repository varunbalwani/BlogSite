<?php
include_once "/include/connection.php";
session_start();
if(!isset($_POST['submit']))
{
	header("Location:category.php?message=Please+Submit+Correct+Information");
	exit();
}	
else
{
	if(!isset($_SESSION['email']))
	{
		header("Location:login.php?");
		exit();
	}
	else
	{
			$form_first_name=$_POST['first_name'];
			$form_last_name=$_POST['last_name'];
			$form_email=$_POST['email'];
			$form_phone_number=$_POST['phone number'];
			$form_country=$_POST['country'];
			
			$sql="INSERT INTO formanswers (`first_name`,`last_name`,`email`,`phone_number`,`country`) VALUES ('$form_first_name','$form_last_name','$form_email','$form_phone_number','$form_country')";
			if(mysqli_query($con,$sql))
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