<?php
	include('config/constants.php');

	if(isset($_GET['list_order']))	#Check if list_order is assigned or otherwise
	{
		$list_order = $_GET['list_order'];	#Get the list order from the URL or GET Method

		#Delete the list from the database
		$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());	#Connect the database
		$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());	#Select database
		$sql = "DELETE FROM table_of_lists WHERE list_order=$list_order";
		$res = mysqli_query($conn, $sql);	#Executes the query
		
		if($res == true)	#Checks if the query is Successfully executed
		{
			$_SESSION['delete'] = "List Deleted Successfully";	#List is deleted
			header('location:'.SITEURL.'manage_list.php');	#Redirect to manage_list
		}
		else 
		{
			$_SESSION['delete_fail'] = "Failed to Delete List";	#Failed to delete
			header('location:'.SITEURL.'manage_list.php');
		}
	}
	else 
	{
		header('location:'.SITEURL.'manage_list.php');	#Redirect to manage_list.php
	}

	#test echo "Delete List";
?>