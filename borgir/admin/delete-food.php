<?php 

    include('../config/constants.php'); 
    if (isset($_GET['id']) && isset($_GET['image_name'])) {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];


        if($image_name != ""){
            //set path for image
            $path = "../images/food/".$image_name;
            $remove = unlink($path);

            if($remove==false){
                $_SESSION['upload'] = "<div class = 'error'>Failed to remove Image file.</div> ";
                //redirect to manage-food.php
                header('location:'.SITEURL.'/admin/manage-product_list.php');
                die();
            }

        }


        //Delete Food from Database
        $sql = "DELETE FROM product_list WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
            //redirect to manage-product_list.php
            header('location:'.SITEURL.'/admin/manage-product_list.php');
        }
        else{
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
            //redirect to manage-product_list.php
            header('location:'.SITEURL.'/admin/manage-product_list.php');
        }

        

    }

    else {
        $_SESSION['unauthorize'] = "<div class = 'error'>Unauthorised Access</div>";
        //header page location needs to be added
        header('location:'.SITEURL.'/admin/manage-product_list.php');
    }

?>
