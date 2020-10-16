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
		</div>
		<!-- Menu Ends Here-->

		<h3>Manage Lists</h3>

		<p>
			<?php #Checks if set otherwise
				if (isset($_SESSION['add']))
				{
					echo $_SESSION['add'];	#Display message
					unset($_SESSION['add']);	#Remove after the display (once)
				}
			?>
		</p>

		<!-- Table to Display Lists Starts Here-->
		<div class="all_lists">
			<a href="<?php echo SITEURL; ?>add_lists.php">Add List</a>
					<table>
						<tr>
							<th>Order</th>
							<th>List Name</th>
							<th>Actions</th>
						</tr>

						<?php
							$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());	#Connect database
							$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());	#Select database
							$sql = "SELECT * FROM table_of_lists";	#SQL Query to display all the data from the database
							$res = mysqli_query($conn, $sql);	#Execute the Query

							if($res == true) #Checks if query added succesfully or otherwise
							{
								#test echo "Executed";

								echo $count_rows = mysqli_num_rows($res);	#Count the rows of data in the database
								
								$order = 1;#Create list order accordingly

								if($count_rows > 0)	#Chech if data is empty or otherwise
								{
									while($row = mysqli_fetch_assoc($res))	#Display in table
									{
										#Getting data's from database
										$list_order = $row['list_order'];
										$list_name = $row['list_name'];
										?>
											<tr>
												<td><?php echo $order++;?></td>
												<td><?php echo $list_name;?></td>
												<td>
													<a href="#">Update</a>
													<a href="#">Delete</a>
												</td>
											</tr>
										<?php
									}
								}
								else
								{
									#Data empty
									?>
										<tr>
											<td colspan="3">List is empty</td>
										</tr>
									<?php
								}
							}
						?>
					</table>
		</div>
		<!-- Table to Display Lists Ends Here-->

	</body>
</html>