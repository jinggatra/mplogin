<?php
// mengaktifkan session php
session_start();
 
// menghubungkan dengan koneksi
include 'koneksi.php';
 
// menangkap data yang dikirim dari form
// $username = $_POST['username'];
// $password = $_POST['password'];
 
// // menyeleksi data admin dengan username dan password yang sesuai
// $data = mysqli_query($koneksi,"select * from user where username='$username' and password='$password'");
 
// // menghitung jumlah data yang ditemukan
// $cek = mysqli_num_rows($data);
 
// if($cek > 0){
// 	$_SESSION['username'] = $username;
// 	$_SESSION['status'] = "login";
// 	header("location:index.php");
// }else{
// 	header("location:login.php?pesan=gagal");
// }

function antiinjection($data){
    $filter_sql = mysqli_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
    return $filter_sql;
}


$username = antiinjection($_POST['username']);
$password = antiinjection(md5($_POST['password']));

if (!ctype_alnum($username) OR !ctype_alnum($password)) {

    echo "<script type=text/javascript>
        alert('Hacker Gagall Mencoba Login');

        window.location = '#' //yang ini pengalihan ketika user salah

        </script>";
    //header('location:./');


} else {
    $login  = mysql_query("SELECT * FROM user WHERE username='$username' AND password='$password'");
    $ketemu = mysql_num_rows($login);
	$r      = mysql_fetch_array($login);
	
    // Apabila username dan password ditemukann
    if ($ketemu > 0) {
        mysql_query("UPDATE user SET batas_login = 0 where username='$username'");
        header('location:admin.php?module=home');
    } else {
        mysql_query("UPDATE user SET batas_login = batas_login + 1 where username='$username'");
        $a = mysql_fetch_array(mysql_query("SELECT batas_login from user where username = '$username'"));
        $b = $a['batas_login'];
        if ($b > 2) {
            mysql_query("UPDATE admin SET blokir = 'Y' where username='$username'");
            echo "<script type=text/javascript>
              alert('Username $username Telah Di Blokir, Silahkan Hubungi Administrator');
              window.location = './'
              </script>";
        } else {
            echo "<script type=text/javascript>
              alert('Username Atau Password Tidak Benar, Anda Sudah $b Kali Mencoba');
              window.location.href='./'
              </script>";
        }
    }
}

?>
?>