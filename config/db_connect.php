<?php 
    //Connect to Database 
	$conn=mysqli_connect('localhost','test','test123','notesapp');	//(hostName,username,password,databaseName)

	//check Connection
	if(!$conn){
		echo "Connection Error => ". mysqli_error();
	}
?>