<?php
include "../configurasi/koneksi.php";

if(!empty($_POST['no_id']) AND !empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['email'])){
	$pass=md5($_POST['password']);
	mysqli_query($con,"INSERT INTO pengajar(id_pengajar,nama_pengajar,username_pengajar,password_pengajar,email_pengajar,hp_pengajar,level,status_idpengajar) VALUES ('$_POST[no_id]','$_POST[nama]','$_POST[username]','$pass','$_POST[email]','$_POST[hp]','2','0')");
	echo "<script>window.alert('Terimakasih telah mendaftarkan diri, silahkan konfirmasi ke admin untuk mengaktifkan akun.');
	echo "$pass";</script>";
}
else{
}
?>