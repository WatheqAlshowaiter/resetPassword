<?php 

$con = mysqli_connect("localhost", 'root', '', 'resetPassword'); 
if (mysqli_connect_errno($con)) {
	echo "connection failed :(" . mysqli_connect_errno($con);
}