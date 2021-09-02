<?php include('partials/menu.php'); ?>
<?php include('../config/constants.php'); ?>
<div class="main-content">
	<div class="wrapper">
		<h1>Category</h1>
		<br /><br />

		<?php 
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['remove']))
            {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }

            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['no-category-found']))
            {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if(isset($_SESSION['failed-remove']))
            {
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }
        
        ?>
        	<br />
				<table class="tbl-full">
					<tr>
						<th>S.N</th>
						<th>Category</th>
						<th>Image</th>
						<th>Actions</th>
					</tr>

					<?php 

                        //Query to Get all CAtegories from Database
                        $sql = "SELECT * FROM menu";

                        //Execute Query
                        $res = mysqli_query($conn, $sql);

                        //Count Rows
                        $count = mysqli_num_rows($res);

                        //Create Serial Number Variable and assign value as 1
                        $sn=1;

                        //Check whether we have data in database or not
                        if($count>0)
                        {
                            //We have data in database
                            //get the data and display
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $category = $row['Category'];
                                $image_name = $row['image_name'];
                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?>. </td>
                                        <td><?php echo $category; ?></td>

                                        <td>

                                            <?php  
                                                //Chcek whether image name is available or not
                                                if($image_name!="")
                                                {
                                                    //Display the Image
                                                    ?>
                                                    
                                                    <img src="<?php echo SITEURL; ?>/images/category/<?php echo $image_name; ?>" width="100px" >
                                                    
                                                    <?php
                                                }
                                                else
                                                {
                                                    //DIsplay the MEssage
                                                    echo "<div class='error'>Image not Added.</div>";
                                                }
                                            ?>

                                        </td>
\
                                        <td>
                                        	<form action="" method="post">
                                            	<select name="Actions">
                                            		<option value="" disabled selected>Choose Sauce options</option>
        											<option value="BBQ Sauce">BBQ Sauce</option>
        											<option value="Ranch">Ranch</option>
        											<option value="Honey Mustard">Honey Mustard</option>
                                            	</select>

                                            	<select name="Actions">
                                            		<option value="" disabled selected>Choose Spice Levels</option>
        											<option value="Mild">Mild</option>
        											<option value="Spicy">Spicy</option>
        											<option value="Very Spice">Very Spicy</option>
                                            	</select>
                                            	<input type="submit" name="submit" vlaue="Choose Spice Levels">

                                            </form>
                                        </td>
                                    </tr>

                                <?php

                            }
                        }
                        else
                        {
                            //WE do not have data
                            //We'll display the message inside table
                            ?>

                            <tr>
                                <td colspan="6"><div class="error">No Category Added.</div></td>
                            </tr>

                            <?php
                        }
                    
                    ?>

                    

                    
                </table>
    </div>
    
</div>


<?php include('partials/footer.php'); ?>