<?php
include "configurasi/koneksi.php";

$lokasi_file=$_FILES['gambar']['tmp_name'];
$tipe_file=$_FILES['gambar']['type'];
$nama_file=$_FILES['gambar']['name'];
$direktori_file="/foto_siswa/$nama_file";

function UploadFotoProfil($gambar_name){
	$vdir_upload = "foto_siswa/";
	$vfile_upload = $vdir_upload . $gambar_name;

	move_uploaded_file($_FILES["gambar"]["tmp_name"],$vfile_upload);

	$im_src = imagecreatefromjpeg($vfile_upload);
	$src_width = imageSX($im_src);
	$src_height = imageSY($im_src);

	$dst_width = 50;
	$dst_height = ($dst_width/$src_width)*$src_height;

	$im = imagecreatetruecolor($dst_width, $dst_height);
	imagecopyresampled($im, $im_src,0,0,0,0,$dst_width,$dst_height,$src_width,$src_height);

	imagejpeg($im,$vdir_upload."small_" .$gambar_name);

	$dst_width2 = 270;
	$dst_height2 = ($dst_width2/$src_width)*$src_height;

	$im2 = imagecreatetruecolor($dst_width2, $dst_height2);
	imagecopyresampled($im2,$im_src,0,0,0,0,$dst_width2,$dst_height2,$src_width,$src_height);

	imagejpeg($im2,$vdir_upload."medium_".$gambar_name);

	imagedestroy($im_src);
	imagedestroy($im);
	imagedestroy($im2);
}

if(!empty($_POST['no_id']) AND !empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['email']AND empty($lokasi_file))){
	$pass=md5($_POST['password']);
	mysqli_query($con,"INSERT INTO siswa(id_siswa,nama_lengkap,username,password,email,hp,id_kelas,status_id) VALUES ('$_POST[no_id]','$_POST[nama]','$_POST[username]','$pass','$_POST[email]','$_POST[hp]','$_POST[kelas]','0')");
	echo "<script>window.alert('Terimakasih telah mendaftarkan diri, silahkan konfirmasi ke admin untuk mengaktifkan akun.');
	window.location=(href='index.php')</script>";
}
elseif (!empty($lokasi_file)) {
	$pass=md5($_POST['password']);
	
	if (!empty($lokasi_file)) {
		if(file_exists($direktori_file)){
			echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu')
			window.location=(href='registrasi.php')</script>";
		}
		else{
			if($tipe_file != "image/jpeg" AND $tipe_file !="image/jpg"){
				echo "<script>window.alert('Tipe file tidak diijinkan.')";
			}
			else{
				UploadFotoProfil($nama_file);

				mysqli_query($con,"INSERT INTO siswa(id_siswa,nama_lengkap,username,password,email,hp,id_kelas,foto,status_id) VALUES ('$_POST[no_id]','$_POST[nama]','$_POST[username]','$pass','$_POST[email]','$_POST[hp]','$_POST[kelas]','$nama_file','0')");
	echo "<script>window.alert('Terimakasih telah mendaftarkan diri, silahkan konfirmasi ke admin untuk mengaktifkan akun.');
	window.location=(href='index.php')</script>";

			}
		}
	}
}
else{
	header('location:index.php');
}
?>