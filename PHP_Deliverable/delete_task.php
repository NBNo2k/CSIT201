<?php
	include('config/constants.php');

	if(isset($_GET['task_order']))
	{
		$task_order = $_GET['task_order'];
		$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_errror());
		$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_errror());
		$sql = "DELETE FROM table_of_tasks WHERE task_order = $task_order";
		$res = mysqli_query($conn, $sql);

		if($res == true)
		{
			$_SESSION['delete'] = "Task deleted successfully.";
			header('location:'.SITEURL);
		}
		else 
		{
			$_SESSION['delete_fail'] = "Failed to delete task";

		}header('location:'.SITEURL);
	}
	else 
	{
		header('location:'.SITEURL);
	}
?>