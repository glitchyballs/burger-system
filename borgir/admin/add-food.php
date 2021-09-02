<?php include ('partials/menu.php');?>
<?php include('../config/constants.php'); ?>

<div class ="main-content">
    <div class = "wrapper"> 
        <h1>Add Food</h1>
        
        <br></br>
        
        <?php
            if(isset($_SESSION['upload'])){
                echo ($_SESSION['upload']);
                unset($_SESSION['upload']);
            }
        ?>

        <form action = "" method = "POST" enctype = "multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td> Name: </td>
                    <td>
                        <input type="text" name="name" placeholder="Name of the food">
                    </td>
                </tr>

                <tr>
                    <td> Description: </td>
                    <td>
                        <textarea name ="description" cols ="20" rows ="5" placeholder="description of the item"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Select Image : </td>
                    <td>
                        <input type="file" name = "image">
                    </td>
                </tr>                

                <tr>
                    <td> Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php 
                                //Create PHP Code to display categories from Database
                                //1. CReate SQL to get all active categories from database
                                $sql = "SELECT * FROM menu";
                                
                                //Executing qUery
                                $res = mysqli_query($conn, $sql);

                                //Count Rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //IF count is greater than zero, we have categories else we donot have categories
                                if($count>0)
                                {
                                    //WE have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details of categories
                                        $id = $row['id'];
                                        $category = $row['Category'];

                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $category; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //WE do not have category
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                            

                                //2. Display on Drpopdown
                            ?>

                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td colspan = "2">
                        <input type="submit" name = "submit" value = "Add Food" class = "btn-second">
                    </td>
                </tr>
            
            </table>
        
        </form>

        <?php
            if(isset($_POST['submit']))
            {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];


                //Image
                if(isset($_FILES['image']['name'])) {
                    $image_name = $_FILES['image']['name'];

                    if($image_name!=""){
                        $ext = end(explode('.', $image_name));

                        $image_name = "Food-Name-".rand(0000,9999).".".$ext; 

                        $src = $_FILES['image']['tmp_name'];

                        $dst = "../images/food/".$image_name;

                        $upload = move_uploaded_file($src, $dst);

                        if($upload==false) {

                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'/admin/add-food.php');
                            die();
                        }

                    }

                }
                else
                {
                    $image_name = ""; 
                }

        
                $sql2 = "INSERT INTO product_list SET 
                    category_id = '$category',
                    name = '$name',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name' 
                ";                    

                $res2 = mysqli_query($conn, $sql2);


                if($res2 == true){
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    header('location:'.SITEURL.'/admin/manage-product_list.php');
                }
                else
                {
                    //FAiled to Insert Data
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                    header('location:'.SITEURL.'/admin/manage-product_list.php');
                }

                
            }

        ?>


    </div>
</div>

<?php include('partials/footer.php'); ?>