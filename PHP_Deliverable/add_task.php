<?php
	include('config/constants.php');
?>

<html>
	<head>
		<title>No Shilly-Shally</title>
	</head>

	<body>
		<h1>NO SHILLY-SHALLY</h1>

		<a href="<?php echo SITEURL; ?>">HOME</a>

		<h3>Add Task</h3>

		<p>
			<?php	
				if(isset($_SESSION['add_fail']))
				{
					echo $_SESSION['add_fail'];
					unset($_SESSION['add_fail']);
				}
			?>
		</p>

		<form method="POST" action="">
			<table>
				<tr>
					<td>Task Name: </td>
					<td><input type="type" name="task_name" placeholder="Add task name" required="required"/></td>
				</tr>

				<tr>
					<td>Task Description: </td>
					<td><textarea name="task_description" placeholder="Add task description"></textarea></td>
				</tr>

				<tr>
					<td>Select List: </td>
					<td>
						<select name="list_order">
							<?php
								$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
								$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
								$sql = "SELECT * FROM table_of_lists";
								$res = mysqli_query($conn, $sql);

								if($res == true)
								{
									$count_rows = mysqli_num_rows($res);
									
									if($count_rows > 0)
									{
										while($row = mysqli_fetch_assoc($res)) #Display all data from database
										{
											$list_order = $row['list_order'];
											$list_name = $row['list_name'];
											?>

												<option value="<?php echo $list_order ?>"><?php echo $list_name; ?></option>
											<?php
										}
									}
									else 
									{
										?>
											<option value="0">None</option>
										<?php
									}
								}
							?>
						</select>
					</td>
				</tr>

				<tr>
					<td>Priority: </td>
					<td>
						<select name="priority">
							<option value="High">High Priority</option>
							<option value="Medium">Medium Priority</option>
							<option value="Low">Low Priority</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>Deadline: </td>
					<td>
						<input type="date" name="deadline"/>
					</td>
				</tr>

				<tr>
					<td>
						<input type="submit" name="submit" value="SAVE"/>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>

<?php
	if(isset($_POST['submit']))	#Check if save button is clicked or otherwise
	{
		#test echo "Button Clicked";
		$task_name = $_POST['task_name'];
		$task_description = $_POST['task_description'];
		$list_order = $_POST['list_order'];
		$priority = $_POST['priority'];
		$deadline = $_POST['deadline'];

		$conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
		$db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());
		$sql2 = "INSERT INTO table_of_tasks SET
				task_name = '$task_name',
				task_description = '$task_description',
				list_order = $list_order,
				priority = '$priority',
				deadline = '$deadline'";

		$res2 = mysqli_query($conn2, $sql2);
		
		if($res2 == true)
		{
			$_SESSION['add'] = "Task Added Successfully";
			header('location:'.SITEURL);
		}
		else 
		{
			$_SESSION['add_fail'] = "Failed to add task";
			header('location:'.SITEURL.'add_task.php');
		}
	}
?>