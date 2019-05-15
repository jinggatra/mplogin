<?php 
 
$koneksi = mysqli_connect("localhost","root","","utsmp");
 
// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}else{
	echo "koneski berhasil";
}
 
?>

