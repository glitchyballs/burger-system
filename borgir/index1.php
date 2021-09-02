<?php 

session_start();

	if(!isset($_SESSION['userlogin'])){
		header("Location: login.php");
	}

	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION);
		header("Location: login.php");
	}

?>

<p>You Have Logged in sucessfully Pess on the button below to proceed </p>



<a href="../order.php ">Take me to the ordering zone                                             . </a>

<a href="index.php?logout=true">log out</a>
