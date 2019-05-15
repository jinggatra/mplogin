<?php
include_once 'db_config.php';

class Dao
{
  var $link;
  public function __construct()
  {
    $this->link = new Dbconfig();
    $this->link = $this->link->ret_obj();
  }

  // proses login
  public function check_login($username, $password)
  {
    $query = "SELECT id from user WHERE username='$username' and password='$password' and bloki='N'";
    $result = $this->link->query($query) or die($this->link->error);
    $user_data = $result->fetch_array(MYSQLI_ASSOC);
    $count_row = $result->num_rows;
    $query2 = "SELECT blokir from user where username= '$username'";
    $result2 = $this->link->query($query2) or die($this->link->error);
    $user_data2 = $result2->fetch_array(MYSQLI_ASSOC);
    $ban = $user_data2['blokir'];
    if ($count_row == 1) {
      //mengembalikan logintime ke 0 jika berhasil login
      $qry = "UPDATE user SET batas_login = 0 where username='$username'";
      $reset = $this->link->query($qry) or die($this->link->error);
      //session untul digunakan di halaman lain sebagai tanda kalau sudah login apa belum
      $_SESSION['login'] = true;
      $_SESSION['id'] = $user_data['id'];
      return true;
    } else if ('Y' === $ban) {
      echo "<script type=text/javascript>
        alert('Username $username Telah Di Blokir, Silahkan Hubungi Administrator');
        window.location = 'index.php'
        </script>";
      return false;
    } else {
      $query = "UPDATE user SET batas_login = batas_login + 1 where username='$username'";
      $result = $this->link->query($query) or die($this->link->error);
      $query2 = "SELECT login_time from user_data where username= '$username'";
      $result2 = $this->link->query($query2) or die($this->link->error);
      $user_data = $result2->fetch_array(MYSQLI_ASSOC);
      $time = $user_data['login_time'];
      if ($time > 3) {
        $query = "UPDATE user_data SET banned = 'Y' where username='$username'";
        $result = $this->link->query($query) or die($this->link->error);
        echo "<script type=text/javascript>
          alert('Username $username Telah Di Blokir, Silahkan Hubungi Administrator');
          window.location = 'index.php'
          </script>";
      } else {
        echo "<script type=text/javascript>
                  alert('Username Atau Password Tidak Benar Anda, Sudah $time Kali Mencoba');
                  window.location.href='index.php'
                  </script>";
      }
      return false;
    }
  }

  //mengambil nama lengkap
  public function get_fullname($uid)
  {
    $query = "SELECT fullname FROM user_data WHERE id = $uid";

    $result = $this->link->query($query) or die($this->link->error);
    $user_data = $result->fetch_array(MYSQLI_ASSOC);
    echo $user_data['fullname'];
  }

  // memulai session
  public function get_session()
  {
    return $_SESSION['login'];
  }

  // fungsi logout
  public function user_logout()
  {
    $_SESSION['login'] = FALSE;
    unset($_SESSION);
    session_destroy();
  }
}
