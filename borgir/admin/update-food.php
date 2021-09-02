<?php include('partials/menu.php'); ?>
<?php include('../config/constants.php'); ?>

<?php 
    //CHeck whether id is set or not 
    if(isset($_GET['id']))
    {
        //Get all the details
        $id = $_GET['id'];

        //SQL Query to Get the Selected Food
        $sql2 = "SELECT * FROM product_list WHERE id=$id";
        //execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //Get the Individual Values of Selected Food
        $current_category = $row2['category_id'];
        $name = $row2['name'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];

    }
    else
    {
        //Redirect to Manage Food
        header('location:'.SITEURL.'/admin/manage-product_list.php');
    }
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
        
        <table class="tbl-30">

            <tr>
                <td>Name: </td>
                <td>
                    <input type="text" name="name" value="<?php echo $name; ?>">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php 
                        if($current_image == "")
                        {
                            //Image not Available 
                            echo "<div class='error'>Image not Available.</div>";
                        }
                        else
                        {
                            //Image Available  
                            ?> 
                            <img src="<?php echo SITEURL; ?>/images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Select New Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>






            <tr>
                <td>Category: </td>
                <td>
                    <select name="Category">

                        <?php 
                            //Query to Get ACtive Categories
                            $sql = "SELECT * FROM menu";
                            //Execute the Query
                            $res = mysqli_query($conn, $sql);
                            //Count Rows
                            $count = mysqli_num_rows($res);

                            //Check whether category available or not
                            if($count>0)
                            {
                                //CAtegory Available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['Category'];
                                    $category_id = $row['id'];
                                    
                                    ?>
                                    <option <?php if($current_category == $category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //CAtegory Not Available
                                echo "<option value='0'>Category Not Available.</option>";
                            }

                        ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="image" value="<?php echo $current_image; ?>">

                    <input type="submit" name="submit" value="Update Food" class="btn-second">
                </td>
            </tr>
        
        </table>
        
        </form>

        <?php 
        
            if(isset($_POST['submit']))
            {

                //1. Get all the details from the form
                $id = $_POST['id'];
                $category = $_POST['Category'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];

                //2. Upload the image if selected

                //CHeck whether upload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name']; 

                    //CHeck whether th file is available or not
                    if($image_name!="") {

                        //REname the Image
                        $ext = end(explode('.', $image_name));

                        $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;

                        $src_path = $_FILES['image']['tmp_name']; //Source Path
                        $dest_path = "../images/food/".$image_name; //Destination Path
                        $upload = move_uploaded_file($src_path, $dest_path);


                        if($upload==false)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload new Image.</div>";
                            header('location:'.SITEURL.'/admin/manage-product_list.php');
                            die(); //process stopped
                        }

                        if($current_image!="")
                        {
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);


                            if($remove==false)
                            {
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                                header('location:'.SITEURL.'/admin/manage-product_list.php');
                                die();
                            }
                        }
                    }
                    else {
                        $image_name = $current_mage; //Default Image when Image is Not Selected
                    }
                }
                else{
                    $image_name = $current_image; //Default Image when Button is not Clicked 
                }          
                

                //4. Update the Food in Database
                $sql3 = "UPDATE product_list SET 
                    category_id = '$category',
                    name = '$name',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name'
                    WHERE id=$id"; 

                $res3 = mysqli_query($conn, $sql3);
 
                if($res3==true)
                {
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.SITEURL.'/admin/manage-product_list.php');
                } 
                else
                {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                    header('location:'.SITEURL.'/admin/manage-product_list.php');
                } 

                
            }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>