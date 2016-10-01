<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Input kelas
if ($module=='kelas' AND $act=='input_kelas'){
  mysqli_query($con,"INSERT INTO kelas(id_kelas,
                                 nama_kelas)
	                       VALUES('$_POST[id_kelas]',
                                '$_POST[nama]')");
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='kelas' AND $act=='hapuskelas'){
  mysqli_query($con,"DELETE FROM kelas WHERE id_kelas = '$_GET[id]'");
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='kelas' AND $act=='hapuswalikelas'){
  $kelas = mysql_query("SELECT * FROM siswa WHERE id_kelas = '$_GET[id]'");
  $r = mysql_fetch_array($kelas);

  mysql_query("UPDATE siswa SET jabatan = 'Siswa'
                                WHERE id_siswa = '$r[id_siswa]'");
  mysql_query("UPDATE kelas SET id_pengajar  = '0',
                                id_siswa  = '0'
                        WHERE id = '$_GET[id]'");
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='kelas' AND $act=='update_kelas'){
  mysqli_query($con,"UPDATE kelas SET nama_kelas = '$_POST[nama]' WHERE id_kelas = '$_POST[id]'");
  header('location:../../media_admin.php?module='.$module);
}
elseif ($module=='kelas' AND $act=='input_walikelas'){
  //$cari = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$_POST[kelas]'");
  //$r = mysql_fetch_array($cari);
  //mysql_query("UPDATE kelas SET id_pengajar  = '$_SESSION[idpengajar]',
  //                              id_siswa  = '$_POST[ketua]'
 //                       WHERE id = '$r[id]'");
  //mysql_query("UPDATE siswa SET jabatan = 'Ketua Kelas'
   //                             WHERE id_siswa = '$_POST[ketua]'");
  mysqli_query($con,"insert into detail_pengajar(id_kelas, id_pengajar) VALUES ('$_POST[kelas]','$_SESSION[idadmin]')");
  header('location:../../media_admin.php?module=home');
}

elseif ($module=='kelas' AND $act=='update_walikelas'){
  $cek = mysql_query("SELECT * FROM kelas WHERE id = '$_POST[id]'");
  $c = mysql_fetch_array($cek);
  $cek_siswa = mysql_query("SELECT id_siswa FROM kelas WHERE id = '$_POST[id]'");
  $s=mysql_num_rows($cek_siswa);
  $cari = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$_POST[kelas]'");
  $r = mysql_fetch_array($cari);

  if ($_POST['kelas']==$c[id_kelas]){

    if(!empty($s)){
         mysql_query("UPDATE siswa SET jabatan = 'siswa'
                                WHERE id_siswa = '$c[id_siswa]'");
         mysql_query("UPDATE kelas SET id_siswa  = '$_POST[ketua]'
                        WHERE id = '$_POST[id]'");
         mysql_query("UPDATE siswa SET jabatan = 'Ketua Kelas'
                                WHERE id_siswa = '$_POST[ketua]'");
    }else{
        mysql_query("UPDATE kelas SET id_siswa  = '$_POST[ketua]'
                        WHERE id = '$_POST[id]'");
    }
  }else{
      if (!empty($s)){
      mysql_query("UPDATE siswa SET jabatan = 'siswa'
                                WHERE id_siswa = '$c[id_siswa]'");
      mysql_query("UPDATE kelas SET id_pengajar  = '0',
                                id_siswa  = '0'
                        WHERE id = '$_POST[id]'");

      mysql_query("UPDATE kelas SET id_pengajar  = '$_SESSION[idpengajar]',
                                id_siswa  = '$_POST[ketua]'
                        WHERE id = '$r[id]'");
      mysql_query("UPDATE siswa SET jabatan = 'Ketua Kelas'
                                WHERE id_siswa = '$_POST[ketua]'");
      }else{
          mysql_query("UPDATE kelas SET id_pengajar  = '0',
                                id_siswa  = '0'
                        WHERE id = '$_POST[id]'");

          mysql_query("UPDATE kelas SET id_pengajar  = '$_SESSION[idpengajar]',
                                id_siswa  = '$_POST[ketua]'
                        WHERE id = '$r[id]'");
          mysql_query("UPDATE siswa SET jabatan = 'Ketua Kelas'
                                WHERE id_siswa = '$_POST[ketua]'");
      }
  }
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='kelas' AND $act=='update_kelas_siswa'){
    mysql_query("UPDATE siswa SET id_kelas         = '$_POST[id_kelas]'
                                WHERE  id_siswa    = '$_SESSION[idsiswa]'");

header('location:../../../media.php?module=kelas');
}

}
?>
