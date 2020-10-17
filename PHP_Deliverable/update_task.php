<?php
	include('config/constants.php');

	if(isset($_GET['task_order']))
	{
		$task_order = $_GET['task_order'];
		$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
		$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
		$sql = "SELECT * FROM table_of_tasks WHERE task_order = $task_order";
		$res = mysqli_query($conn, $sql);

		if($res == true)
		{
			$row = mysqli_fetch_assoc($res);
			$task_name = $row['task_name'];
			$task_description = $row['task_description'];
			$list_order = $row['list_order'];
			$priority = $row['priority'];
			$deadline = $row['deadline'];
		}
	}
	else 
	{
		header('location:'.SITEURL);
	}
?>

<html>
	<head>
		<title>No Shilly-Shally</title>
	</head>

	<body>
		<h1>NO SHILLY-SHALLY</h1>

		<p>
			<a href="<?php echo SITEURL; ?>">HOME</a>
		</p>

		<h3>UPDATE TASK</h3>

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
					<td>Task Name: </td>
					<td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required="required"/></td>
				</tr>

				<tr>
					<td>Task Description: </td>
					<td>
						<textarea name="task_description">
							<?php echo $task_description; ?>
						</textarea>
					</td>
				</tr>

				<tr>
					<td>Select List: </td>
					<td>
						<select name="list_order">
							<?php
								$conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
								$db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());
								$sql2 = "SELECT * FROM table_of_lists";
								$res2 = mysqli_fetch_assoc($conn2, $sql2);

								if($res2 == true)
								{
									$count_rows2 = mysqli_num_rows($res2);

									if($count_rows2 > 0)
									{
										while($row2 = mysqli_fetch_assoc($res))
										{
											$list_order_db = $row2['list_order'];
											$list_name = $row2['list_name'];
											?>

											<option <?php if($list_order_db == $list_order) {echo "selected = 'selected'"; } ?> value = "<?php echo $list_order_db; ?>"><?php echo $list_name; ?></option>

											<?php
										}
									}
									else 
									{
										?>
											<option <?php if($list_order = 0) {echo "selected = 'selected'";} ?> value="0">None</option>
										<?php
									}
								}
							?>
							
							<option value="1">DOING</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>Priority: </td>
					<td>
						<select name="priority">
							<option <?php if($priority == "High") {echo "selected = 'selected'";} ?> value="High">High Priority</option>
							<option <?php if($priority == "Medium") {echo "selected = 'selected'";} ?> value="Medium">Medium Priority</option>
							<option <?php if($priority == "Low") {echo "selected = 'selected'";} ?> value="Low">Low Priority</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>Deadline: </td>
					<td>
						<input type="date" name="deadline" value-"<?php echo $deadline; ?>"/>
					</td>
				</tr>

				<tr>
					<td>
						<input type="submit" name="submit" value="UPDATE"/>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>

<?php
	if(isset($_POST['submit']))
	{
		#test echo "Clicked";

		$task_name = $_POST['task_name'];
		$task_description = $_POST['task_description'];
		$list_order = $_POST['list_order'];
		$priority = $_POST['priority'];
		$deadline = $_POST['deadline'];

		$conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
		$db_select3 = mysqli_select_db($conn3, DB_NAME) or die(mysqli_error());
		$sql3 = "UPDATE table_of_tasks SET
				task_name ='$task_name',
				task_description = '$task_description',
				list_order = '$list_order',
				priority = 'priority',
				deadline = '$deadline'
				WHERE 
				task_order = $task_order";

		$res3 = mysqli_query($conn3, $sql3);

		if($res3 == true)
		{
			$_SESSION['update'] = "Task update successfully.";
			header('location:'.SITEURL);
		}
		else 
		{
			$_SESSION['update_fail'] = "Failed to add task successfully.";
			header('location:'.SITEURL.'update_task.php?task_order ='.$task_order);
		}
	}
?>