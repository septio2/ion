<?php
include "configurasi/koneksi.php";
$username=$_POST['username'];
$pass=md5($_POST['password']);
$login=mysqli_query($con,"SELECT * FROM siswa WHERE username='$username' AND password='$pass' AND status_id='1'");
$ketemu=mysqli_num_rows($login);
$r=mysqli_fetch_array($login);
if($ketemu > 0){
	session_start();
	include "timeout.php";

	$_SESSION[username]=$r[username];
	$_SESSION[namalengkap]=$r[nama_lengkap];
	$_SESSION[password]=$r[password];
	$_SESSION[idsiswa]=$r[id_siswa];
	$_SESSION[leveluser]='siswa';

	$_SESSION[login]=1;
	timer();
	$sid_lama = session_id();
	session_regenerate_id();
	$sid_baru=session_id();
	mysqli_query($con,"UPDATE siswa SET id_session='$sid_baru' WHERE username_login='$username'");
	$user =mysqli_query($con,"SELECT * FROM online WHERE id_siswa='$_SESSION[idsiswa]'");
	if(mysqli_num_rows($user)==0){
		$ip=$_SERVER['REMOTE_ADDR'];
		$tanggal=date("Ymd");
		$waktu=time("U");
		mysqli_query($con,"INSERT INTO online (ip,id_siswa,tanggal,online) VALUES ('$ip','$_SESSION[idsiswa]','$tanggal','Y')");
	}
	else{
		$ip=$_SERVER['REMOTE_ADDR'];
		$tanggal=date("Ymd");
		$waktu=time("U");
		mysqli_query($con,"UPDATE online SET ip='$ip',tanggal='$tanggal',online='Y' WHERE id_siswa=$_SESSION[idsiswa]'");
	}
	header('location:home');
}
else{
	echo "<script>window.alert('LOGIN GAGAL! Username atau Password tidak benar. Atau Account anda sedang di blokir!');
	window.location=(href='index.php')</script>";
}
?>