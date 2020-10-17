<?php 
	include('config/constants.php');
?>

<html>
	<head>
		<title>No Shilly-Shally</title>
	</head>
	
	<body>
		<h1>NO SHILLY-SHALLY</h1>
	
		<!-- Menu Starts Here-->
		<div class="menu">
			<a href="<?php echo SITEURL; ?>index.php">HOME</a>	<!-- Static Link -->
		
			<!-- Dynamic Links -->
			<a href="#">To Do</a>
			<a href="#">In Progress</a>
			<a href="#">Done</a>

			<a href="<?php echo SITEURL; ?>manage_list.php">MANAGE LISTS</a>	<!-- Static Link -->
		</div>
		<!-- Menu Ends Here-->

		<!-- Tasks Starts Here -->
		<p>
			<?php
				if(isset($_SESSION['add']))
				{
					echo $_SESSION['add'];
					unset($_SESSION['add']);
				}

				if(isset($_SESSION['delete']))
				{
					echo $_SESSION['delete'];
					unset($_SESSION['delete']);
				}

				if(isset($_SESSION['update']))
				{
					echo $_SESSION['update'];
					unset($_SESSION['update']);
				}

				if(isset($_SESSION['delete_fail']))
				{
					echo $_SESSION['delete_fail'];
					unset($_SESSION['delete_fail']);
				}
			?>
		</p>

		<div class="all_tasks">
			<a href="<?php SITEURL; ?>add_task.php">Add Tasks</a>
				<table>
					<tr>
						<th>Order</th>
						<th>Task Name</th>
						<th>Priority</th>
						<th>Deadline</th>
						<th>Actions</th>
					</tr>

					<?php
						$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
						$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
						$sql = "SELECT * FROM table_of_tasks";
						$res = mysqli_query($conn, $sql);

						if($res == true)
						{
							$count_rows = mysqli_num_rows($res);
							$order = 1;

							if($count_rows > 0)
							{
								while($row = mysqli_fetch_assoc($res))
								{
									$task_order = $row['task_order'];
									$task_name = $row['task_name'];
									$priority = $row['priority'];
									$deadline = $row['deadline'];
									?>
									<tr>
										<td><?php echo $order++; ?></td>
										<td><?php echo $task_name; ?></td>
										<td><?php echo $priority; ?></td>
										<td><?php echo $deadline; ?></td>
										<td>
											<a href="<?php echo SITEURL; ?>update_task.php?task_order=<?php echo $task_order; ?>">UPDATE</a>
											<a href="<?php echo SITEURL; ?>delete_task.php?task_order=<?php echo $task_order; ?>">DELETE</a>
										</td>
									</tr>
									<?php
								}
							}
							else 
							{
								?>
									<tr>
										<td colspan="5">No tasks added yet.</td>
									</tr>
								<?php
							}
						}
					?>
				</table>
		</div>
		<!-- Tasks Ends Here -->

	</body>
</html>