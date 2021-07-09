<?php
	session_start();
	
	include('../conn.php');
	
	mysqli_query($conn,"update userlog set logout=NOW() where userlogid='".$_SESSION['userlog']."'");
	
	session_destroy();
	header('location:../index.php');

?>