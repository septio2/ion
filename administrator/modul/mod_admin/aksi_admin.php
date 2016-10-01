<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";
include "../../../configurasi/library.php";

$module=$_GET[module];
$act=$_GET[act];


//upadate pengajar

if ($module=='admin' AND $act=='update_pengajar'){
if (empty($_POST[password])) {
    mysqli_query($con,"UPDATE pengajar SET id_pengajar  = '$_POST[id]',
                                  nama_pengajar     = '$_POST[nama]',
                                  username_pengajar = '$_POST[username]',
                                  email_pengajar    = '$_POST[email]',
                                  hp_pengajar       = '$_POST[hp]',
                                  level             = '$_POST[level]',
                                  status_idpeng     ='$_POST[status]'                  
                           WHERE  id_pengajar           = '$_POST[id]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
    mysqli_query($con,"UPDATE pengajar SET id_pengajar  = '$_POST[id]',
                                  nama_pengajar     = '$_POST[nama]',
                                  username_pengajar = '$_POST[username]',
                                  password_pengajar = '$_POST[password]',
                                  email_pengajar    = '$_POST[email]',
                                  hp_pengajar       = '$_POST[hp]',
                                  level             = '$_POST[level]',
                                  status_idpeng     ='$_POST[status]'                  
                           WHERE  id_peng           = '$_POST[id]'");
  }
  header('location:../../media_admin.php?module=admin&act=pengajar');

}
// Update admin
elseif ($module=='admin' AND $act=='update_admin'){
  if (empty($_POST[password])) {
    mysqli_query($con,"UPDATE pengajar SET id_pengajar  = '$_POST[id]',
                                  nama_pengajar     = '$_POST[nama]',
                                  username_pengajar = '$_POST[username]',
                                  email_pengajar    = '$_POST[email]',
                                  hp_pengajar       = '$_POST[hp]',
                                  level             = '$_POST[level]',
                                  status_idpeng     ='$_POST[status]'                  
                           WHERE  id_pengajar           = '$_POST[id]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
    mysqli_query($con,"UPDATE pengajar SET id_pengajar  = '$_POST[id]',
                                  nama_pengajar     = '$_POST[nama]',
                                  username_pengajar = '$_POST[username]',
                                  password_pengajar = '$_POST[password]',
                                  email_pengajar    = '$_POST[email]',
                                  hp_pengajar       = '$_POST[hp]',
                                  level             = '$_POST[level]',
                                  status_idpeng     ='$_POST[status]'                  
                           WHERE  id_peng           = '$_POST[id]'");
  }
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='admin' AND $act=='update_pengajar2'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_pengajar/$nama_file";
  $tgl_lahir=$_POST[thn].'-'.$_POST[bln].'-'.$_POST[tgl];

  $cek_nip = mysqli_query($con,"SELECT * FROM pengajar WHERE id_pengajar = '$_POST[id]'");
  $ketemu=mysqli_fetch_array($cek_nip);

  if($_POST['nip']==$ketemu['nip']){

  //apabila foto tidak diubah dan password tidak di ubah
  if (empty($lokasi_file) AND empty($_POST[password])){
      mysqli_query($con,"UPDATE pengajar SET
                                  nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
  }
  //apabila foto diubah dan password tidak diubah
  elseif(!empty($lokasi_file) AND empty($_POST[password])){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=home')</script>";
            }else{
                if($tipe_file != "image/jpeg" AND
                    $tipe_file != "image/jpg"
                ){
                    echo "<script>window.alert('Tipe File tidak di ijinkan.');
                    window.location=(href='../../media_admin.php?module=home')</script>";
                }else{
                $cek = mysqli_query($con,"SELECT * FROM pengajar WHERE id_pengajar = '$_POST[id]'");
                $r = mysqli_fetch_array($cek);
                if(!empty($r[foto])){
                $img = "../../../foto_pengajar/$r[foto]";
                unlink($img);
                $img2 = "../../../foto_pengajar/medium_$r[foto]";
                unlink($img2);
                $img3 = "../../../foto_pengajar/small_$r[foto]";
                unlink($img3);

                UploadImage($nama_file);
                mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  foto           = '$nama_file',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
                }else{
                    UploadImage($nama_file);
                    mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  foto           = '$nama_file',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
                }
                }
            }
  }
  //apabila foto tidak diubah dan password diubah
  elseif(empty($lokasi_file) AND !empty($_POST[password])){
      $pass=md5($_POST[password]);
      mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  password_login = '$pass',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
  }else{
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=home)</script>";
            }else{
                if($tipe_file != "image/jpeg" AND
                $tipe_file != "image/jpg"
                ){
                    echo "<script>window.alert('Tipe File tidak di ijinkan.');
                    window.location=(href='../../media_admin.php?module=home')</script>";
                }else{
                $cek = mysqli_query($con,"SELECT * FROM pengajar WHERE id_pengajar = '$_POST[id]'");
                $r = mysqli_fetch_array($cek);
                if(!empty($r[foto])){
                $img = "../../../foto_pengajar/$r[foto]";
                unlink($img);
                $img2 = "../../../foto_pengajar/medium_$r[foto]";
                unlink($img2);
                $img3 = "../../../foto_pengajar/small_$r[foto]";
                unlink($img3);
                UploadImage($nama_file);
                $pass=md5($_POST[password]);
                mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  password_login = '$pass',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  foto           = '$nama_file',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
                }else{
                    UploadImage($nama_file);
                    $pass=md5($_POST[password]);
                    mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  password_login = '$pass',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  foto           = '$nama_file',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
                }
                }
            }
  }
    header('location:../../media_admin.php?module=home');
  }
  elseif($_POST['nip']!= $ketemu['nip']){
      $cek_nip2 = mysqli_query($con,"SELECT * FROM pengajar WHERE nip = '$_POST[nip]'");
      $c = mysqli_num_rows($cek_nip2);
      //apabila nip tersedia
      if(empty($c)){
          //apabila foto tidak diubah dan password tidak di ubah
        if (empty($lokasi_file) AND empty($_POST[password])){
        mysqli_query($con,"UPDATE pengajar SET
                                  nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
        header('location:../../media_admin.php?module=home');
        }
        //apabila foto diubah dan password tidak diubah
        elseif(!empty($lokasi_file) AND empty($_POST[password])){
             if (file_exists($direktori_file)){
                    echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
                    window.location=(href='../../media_admin.php?module=home')</script>";
             }else{
                if($tipe_file != "image/jpeg" AND
                    $tipe_file != "image/jpg"
                ){
                    echo "<script>window.alert('Tipe File tidak di ijinkan.');
                    window.location=(href='../../media_admin.php?module=home')</script>";
                }else{
                $cek = mysqli_query($con,"SELECT * FROM pengajar WHERE id_pengajar = '$_POST[id]'");
                $r = mysqli_fetch_array($cek);
                if(!empty($r[foto])){
                $img = "../../../foto_pengajar/$r[foto]";
                unlink($img);
                $img2 = "../../../foto_pengajar/medium_$r[foto]";
                unlink($img2);
                $img3 = "../../../foto_pengajar/small_$r[foto]";
                unlink($img3);

                UploadImage($nama_file);
                mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  foto           = '$nama_file',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
                }else{
                    UploadImage($nama_file);
                    mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  foto           = '$nama_file',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
                }
                }
            }
        }
        //apabila foto tidak diubah dan password diubah
        elseif(empty($lokasi_file) AND !empty($_POST[password])){
            $pass=md5($_POST[password]);
            mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  password_login = '$pass',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
       }else{
        if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=home)</script>";
            }else{
                if($tipe_file != "image/jpeg" AND
                $tipe_file != "image/jpg"
                ){
                    echo "<script>window.alert('Tipe File tidak di ijinkan.');
                    window.location=(href='../../media_admin.php?module=home')</script>";
                }else{
                $cek = mysqli_query($con,"SELECT * FROM pengajar WHERE id_pengajar = '$_POST[id]'");
                $r = mysqli_fetch_array($cek);
                if(!empty($r[foto])){
                $img = "../../../foto_pengajar/$r[foto]";
                unlink($img);
                $img2 = "../../../foto_pengajar/medium_$r[foto]";
                unlink($img2);
                $img3 = "../../../foto_pengajar/small_$r[foto]";
                unlink($img3);
                UploadImage($nama_file);
                $pass=md5($_POST[password]);
                mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  password_login = '$pass',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  foto           = '$nama_file',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
                }else{
                    UploadImage($nama_file);
                    $pass=md5($_POST[password]);
                    mysqli_query($con,"UPDATE pengajar SET nip  = '$_POST[nip]',
                                  nama_lengkap   = '$_POST[nama_lengkap]',
                                  username_login = '$_POST[username]',
                                  password_login = '$pass',
                                  alamat         = '$_POST[alamat]',
                                  tempat_lahir   = '$_POST[tempat_lahir]',
                                  tgl_lahir      = '$tgl_lahir',
                                  jenis_kelamin  = '$_POST[jk]',
                                  agama          = '$_POST[agama]',
                                  no_telp        = '$_POST[no_telp]',
                                  email          = '$_POST[email]',
                                  website        = '$_POST[website]',
                                  foto           = '$nama_file',
                                  jabatan        = '$_POST[jabatan]'
                           WHERE  id_pengajar     = '$_POST[id]'");
                }
                }
            }
        }
        header('location:../../media_admin.php?module=home');
      }
      else{
        echo "<script>window.alert('Nip sudah pernah digunakan.');
        window.location=(href='../../media_admin.php?module=home')</script>";
      }
  }
}


}
?>
