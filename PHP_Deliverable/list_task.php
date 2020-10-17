<?php
	include('config/constants.php');

	$list_order_url = $_GET['list_order']
?>

<html>
	<head>
		<title>No Shilly-Shally</title>
	</head>

	<body>
		<h1>NO SHILLY-SHALLY</h1>

		<!-- Menu Starts Here-->
		<div class="menu">
			<a href="<?php echo SITEURL; ?>">HOME</a>	<!-- Static Link -->
		
			<?php
				 $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
				 $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_errror());
				 $sql2 = "SELECT * FROM table_of_lists";
				 $res2 = mysqli_query($conn2, $sql2);

				 if($res2 == true)
				 {
					  while($row2 = mysqli_fetch_assoc($res2))
					  {
						$list_order = $row2['list_order'];
						$list_name = $row2['list_name'];
						?>

							<a href="<?php echo SITEURL; ?>list_task.php?list_order=<?php echo $list_order; ?>"><?php echo $list_name; ?></a>	

						<?php
					  }
				 }
			?>

			<a href="<?php echo SITEURL; ?>manage_list.php">MANAGE LISTS</a>	<!-- Static Link -->
		</div>
		<!-- Menu Ends Here-->

		<div class="all_task">
			<a href="<?php echo SITEURL; ?>add_task.php">ADD TASK</a>
		
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
					$sql = "SELECT * FROM table_of_tasks WHERE list_order = $list_order_url";
					$res = mysqli_query($conn, $sql);

					if($res == true)
					{
						$count_rows = mysqli_num_rows($res);

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
										<td>1.</td>
										<td><?php echo $task_name; ?></td>
										<td><?php echo $priority; ?></td>
										<td><?php echo $deadline; ?></td>
										<td>
											<a href="<?php echo SITEURL; ?>update_task.php?task_order=<?php echo $task_order; ?>">UPDATE</a>
											<a href="<?php echo SITEURL; ?>delete_task.php?task_order=<?php echo $task_order; ?>">DELETE</a
										</td>
									</tr>
								<?php
							}
						}
						else 
						{
							?>
								<tr>
									<td colspan="5">No tasks added on the list yet.</td>
								</tr>
							<?php
						}
					}
				?>

			</table>
		</div>
	</body>
</html>