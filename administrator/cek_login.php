<?php
include "../configurasi/koneksi.php";
$username = $_POST['username'];
$pass = md5($_POST['password']);

$login_admin=mysqli_query($con,"SELECT * FROM pengajar WHERE username_pengajar='$username' AND password_pengajar='$pass' AND level='1' AND status_idpeng='1'");
$ketemu=mysqli_num_rows($login_admin);
$r=mysqli_fetch_array($login_admin);

$login_guru=mysqli_query($con,"SELECT * FROM pengajar WHERE username_pengajar='$username' AND password_pengajar='$pass' AND level='2' AND status_idpeng='1'");
$ketemu_guru=mysqli_num_rows($login_guru);
$k=mysqli_fetch_array($login_guru);

if($ketemu>0){
	session_start();
  include "timeout.php";

  $_SESSION[namauser]     = $r[username_pengajar];
  $_SESSION[namalengkap]  = $r[nama_pengajar];
  $_SESSION[passuser]     = $r[password_pengajar];
  $_SESSION[leveluser]    = 'admin';
  $_SESSION[idadmin]      = $r[id_pengajar];

  // session timeout
  $_SESSION[login] = 1;
  timer();

	$sid_lama = session_id();

	session_regenerate_id();

	$sid_baru = session_id();

  mysqli_query($con,"UPDATE admin SET id_session='$sid_baru' WHERE username='$username'");
  header('location:media_admin.php?module=home');
}
else if($ketemu_guru>0){
	session_start();
  include "timeout.php";

  $_SESSION[namauser]     = $k[username_pengajar];
  $_SESSION[namalengkap]  = $k[nama_pengajar];
  $_SESSION[passuser]     = $k[password_pengajar];
  $_SESSION[leveluser]    = 'pengajar';
  $_SESSION[idadmin]      = $k[id_pengajar];

  // session timeout
  $_SESSION[login] = 1;
  timer();

	$sid_lama = session_id();

	session_regenerate_id();

	$sid_baru = session_id();

  mysqli_query($con,"UPDATE pengajar SET id_session='$sid_baru' WHERE username_login='$username'");
  header('location:media_admin.php?module=home');
}
else{
   echo "<link href=css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Login Gagal, Username atau Password salah, atau account anda sedang di blokir. ";
  echo "<a href=index.php><b>ULANGI LAGI</b></a></center></div>";
}
?>