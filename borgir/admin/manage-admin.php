<?php include ('partials/menu.php'); ?>
<?php include('../config/constants.php'); ?>
		<!-- Main content Section Starts -->
		<div class = "main-content">
			<div class="wrapper">
				<h1>MANAGE ADMIN</h1>

				<br />

				<?php   
					if(isset($_SESSION['add'])) {
						echo $_SESSION['add'];	//display message
						unset($_SESSION['add']);	//remove message
					}

					if(isset($_SESSION['delete'])){
            			echo $_SESSION['delete'];
                		unset($_SESSION['delete']);
            		}
                    
            		if(isset($_SESSION['update'])){
                		echo $_SESSION['update'];
                		unset($_SESSION['update']);
            		}

            		if(isset($_SESSION['user-not-found'])){
                		echo $_SESSION['user-not-found'];
                		unset($_SESSION['user-not-found']);
            		}

				?>
				<br><br><br>

				<!-- Button to Add Admin -->
				<a href="add-admin.php" class="btn-first">Add Admin</a>
				<br /><br /><br />

				<table class="tbl-full">
					<tr>
						<th>S.N</th>
						<th>Full Name</th>
						<th>Username</th>
						<th>Actions</th>
					</tr>

					<?php 
						//Query to get all admin
						$sql = "SELECT * FROM admin";

						//execute query
						$res = mysqli_query($conn, $sql);

						//checks whether query is executed or not
						if($res==TRUE) {

							//count rows to check whether we have data in database
							$count = mysqli_num_rows($res); //function to get all rows 

							$sn=1; //Create a Variable and Assign the value

							//checks the num of rows
							if($count>0) {
								
								while($rows=mysqli_fetch_assoc($res)) {
									$id=$rows['id'];
									$name=$rows['name'];
									$Username=$rows['email'];
 

									?>

									<!--display table values-->
									<tr>
									<td><?php echo $sn++; ?>. </td>
                        			<td><?php echo $name; ?></td>
                        			<td><?php echo $Username; ?></td>
                        			<td>
                                        <a href="<?php echo SITEURL; ?>/admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-third">Delete Admin</a>
									</td>
									</tr>

									<?php

								}
							}
							else{

							}
						}
									?>

				</table>
				
			</div>			
		</div>
		<!-- Main content Ends -->

<?php include('partials/footer.php'); ?>