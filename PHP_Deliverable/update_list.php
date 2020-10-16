<?php 
	include('config/constants.php'); 
	
	if(isset($_GET['list_order']))	#Get the current values of the selected list
	{
		$list_order = $_GET['list_order'];	#Get the list order value
		$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());	#Connect to database
		$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());	#Select database
		$sql = "SELECT * FROM table_of_lists WHERE list_order=$list_order";	#Query to get the values from database
		$res = mysqli_query($conn, $sql);	#Executes query

		if($res == true)	#Check if query is successfully executed or otherwise
		{
			$row = mysqli_fetch_assoc($res);	#Value is in array
			#test print_r($row);

			#Create individual variable to save the data 
			$list_name = $row['list_name'];
			$list_description = $row['list_description'];

		}
		else 
		{
			header('location:'.SITEURL.'manage_list.php');	#Redirect to manage_list
		}
	}
?>

<html>
	<head>
		<title>No Shilly-Shally</title>
	</head>

	<body>
		<h1>NO SHILLY-SHALLY</h1>

		<div class="menu">
			<a href="<?php echo SITEURL; ?>">HOME</a>
			<a href="<?php echo SITEURL; ?>manage_list.php">MANAGE LISTS</a>
		</div>

		<h3>UPDATE LIST</h3>

		<p>
			<?php
				if(isset($_SESSION['update_fail']))
				{
					echo $_SESSION['update_fail'];
					unset($_SESSION['update_fail']);
				}
			?>
		</p>

		<form method="POST" action="">
			<table>
				<tr>
					<td>List Name: </td>
					<td><input type="text" name="list_name" value="<?php echo $list_name; ?>" required="required"/></td>
				</tr>

				<tr>
					<td>List Description: </td>
					<td>
						<textarea name="list_description">
							<?php echo $list_description; ?>
						</textarea>
					</td>
				</tr>

				<tr>
					<td><input type="submit" name="submit" value="UPDATE"/></td>
				</tr>
			</table>
		</form>
	</body>
</html>

<?php
	if(isset($_POST['submit']))	#Check if update is clicked or not
	{
		#test echo "Button Clicked";

		#Get the update values from the form>
		$list_name = $_POST['list_name'];
		$list_description = $_POST['list_description'];

		$conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_error());	#Connect to database
		$db_select2 = mysqli_select_db($conn2, DB_NAME);	#Select database

		#Query to update list
		$sql2 = "UPDATE table_of_lists SET	
				list_name = '$list_name',
				list_description = '$list_description'
				WHERE list_order=$list_order";

		$res2 = mysqli_query($conn2, $sql2);

		#Check if query is successfully successfully
		if($res == true)
		{
			$_SESSION['update'] = "List Updated Succesfully";
			header('location:'.SITEURL.'manage_list.php');
		}
		else
		{
			$_SESSION['update_fail'] = "Failed to Update List";
			header('location:'.SITEURL.'update_list.php?list_order=$list_order'.$list_order);
		}
	}
?>