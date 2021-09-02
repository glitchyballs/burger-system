<?php include('partials/menu.php'); ?>
<?php include('../config/constants.php'); ?> 
<div class="main-content">
	<div class="wrapper">
		<h1>Add Admin</h1>
		<br><br>

		<?php   
			if(isset($_SESSION['add'])) { //checks whether the session is set or not
				echo $_SESSION['add'];	//display message 
				unset($_SESSION['add']);	//remove message
			}


		?>

		<form action="" method="POST">
			
			<table class="tbl-30">
				<tr>
					<td>Name: </td>
					<td><input type="text" name="name" placeholder="Full Name"></td>			
				</tr>

				<tr>
					<td>Email: </td>
					<td><input type="text" name="email" placeholder="something@smth.com"></td>
				</tr>

				<tr>
					<td>Password: </td>
					<td><input type="Password" name="password" placeholder="Enter your Password"></td>
				</tr>

				<tr>
					<td colspan="5">
						<input type="submit" name="Submit" value="Submit" class="btn-second">
					</td>
				</tr>

			</table>

		</form> 


	</div>
</div>

<?php include('partials/footer.php'); ?>



<?php 
	//Process the Valur form and save it in our database
	//check whether the submit button is clicked or not

	if(isset($_POST['Submit'])) {
		//echo "Button clicked";

		//1.get data from form
		$Name = $_POST['name'];
		$Email = $_POST['email'];
		$Password = md5($_POST['password']); //password encrypted

		//2.SQL Query to save the data into database
		$sql = "INSERT INTO admin SET 
			name='$Name',
			email='$Email',
			password='$Password'
		";
		

		//3. Execute query and save data in database
		$res = mysqli_query($conn, $sql) or die(msqli_error());

		//4. checks whether the query is executed, data is inserted or not and message is displayed
		if ($res==TRUE) {
		 	//echo "Data Inserted";

		 	$_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>";
		 	header("location:".SITEURL.'/admin/manage-admin.php');
		}
		 else{
		 	//echo "Failed";
		 	$_SESSION['add'] = "<div class='error'> Failed to add admin </div>";
		 	header("location:".SITEURL.'/admin/manage-admin.php');
		 } 
	}
	


?>