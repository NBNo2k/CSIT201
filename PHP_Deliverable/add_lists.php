<?php 
	include('config/constants.php');
?>

<html>
	<head>
		<title>No Shilly-Shally</title>
		<link rel="stylesheet" href="<?php echo SITEURL; ?>CSS/style.css"/>
	</head>

	<body>
	<div class="wrapper">
		<h1>NO SHILLY-SHALLY</h1>

		<a class="btn-secondary" href="<?php echo SITEURL; ?>index.php">HOME</a>
		<a class="btn-secondary" href="<?php echo SITEURL; ?>manage_list.php">MANAGE LISTS</a>

		<h3>Add Lists</h3>

		<p>
			<?php #Checks if sessions is set or otherwise
				if (isset($_SESSION['add_fail']))
				{
					echo $_SESSION['add_fail'];	#Display message
					unset($_SESSION['add_fail']);	#Remove after the display (once)
				}
			?>
		</p>

		<!-- Form to Add Lists Starts Here -->
		<form method="POST" action="">
			<table class="table_half">
				<tr>
					<td>Lists Name: </td>
					<td><input type="text" name="list_name" placeholder="Add Name" required="required"/></td>
				</tr>

				<tr>
					<td>List Description: </td>
					<td>
						<textarea name="list_description" placeholder="Add Description"></textarea>
					</td>
				</tr>

				<tr>
					<td>
						<input class="btn-secondary btn-lg" type="submit" name="submit" value="SAVE"/>
					</td>
				</tr>
			</table>
		</form>
		<!-- Form to Add Lists Ends Here -->
	</div>
	</body>
</html>

<?php
	if(isset($_POST['submit']))	#Check the if forms submission is successful or otherwise
	{	
		$list_name = $_POST['list_name'];	#Get the values from form and save it in a variable
		#test echo $list_name;

		$list_description = $_POST['list_description'];
		#test echo $list_description;
	
		#Connect Database
		$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD)	#Connect successful
		or 
		die(mysqli_erro());	#Connect unsuccessful

		/*if($conn == true)	Check if connection is successful or otherwise
		{
			echo "Database Connect";
		}*/

		$db_select = mysqli_select_db($conn, DB_NAME);	#Select Database

		/*if($db_select == true)	#Check if database successfully connected or otherwise
		{
			echo "Database Selected";
		}*/

		#SQL Query to insert data into the database
		/*echo for testing purposes*/ $sql = "INSERT INTO table_of_lists SET
											  list_name = '$list_name',
										   	  list_description = '$list_description'
											  ";

		$res = mysqli_query($conn, $sql);	#Execute Query and Insert into the Database

		if($res == true)	#Chech if query is successful or otherwise
		{
			#test echo "Data inserted successfully";

			$_SESSION['add'] = "List Added Successfully";	#Session variable that display message
			header('location:'.SITEURL.'manage_list.php');	#Redirect to Manage List
		}
		else 
		{
			#test echo "Invalid";

						$_SESSION['add'] = "Failed to Add List";	
			header('location:'.SITEURL.'add_list.php');	#Redirect in the same page
		}

	}
?>