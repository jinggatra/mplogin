<!DOCTYPE html>
<html>
<head>
	<title>Selamat Datang</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
	<body>
	<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan'] == "gagal"){
				echo "Login gagal! username dan password salah!";
			}else if($_GET['pesan'] == "logout"){
				echo "Anda telah berhasil logout";
			}else if($_GET['pesan'] == "belum_login"){
				echo "Anda harus login untuk mengakses halaman admin";
			}
		}
		?>
	<h1 style="bold" align="center">Silahkan Login</h1>
	<container>
	<form method="post" action="cek_login.php">
		<div class="col-md-3">
			<div class="form-group">
				<label>Username :</label>
				<input type="text" name="username" class="form-control">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Password :</label>
				<input type="password" name="password" class="form-control">
			</div>
		</div>
	<input  class="btn btn-primary" type="submit" value="LOGIN">
	<button class="btn btn-primary" type="reset">Reset</button>
	</form>
	</container>
	</body>
</html>