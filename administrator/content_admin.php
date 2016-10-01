<script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
</script>
<?php
include "../configurasi/koneksi.php";
include "../configurasi/library.php";
include "../configurasi/fungsi_indotgl.php";
include "../configurasi/fungsi_combobox.php";
include "../configurasi/class_paging.php";

$aksi_kelas="modul/mod_kelas/aksi_kelas.php";
$aksi_mapel="modul/mod_matapelajaran/aksi_matapelajaran.php";

// Bagian Home
if ($_GET['module']=='home'){
  if ($_SESSION['leveluser']=='admin'){
  echo "<p>Hai <b>$_SESSION[namalengkap]</b>, Selamat datang di halaman Administrator E-learning IONs INTERNATIONAL EDUCATION<br>
          Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola website.</p>";
          ?>
         <h2>Quick Links</h2>
				<section class="icons">
					<ul>
						<li>
							<a href="?module=home">
								<img src="images/eleganticons/Home.png" />
								<span>Home</span>
							</a>
						</li>
						<li>
							<a href="?module=admin">
								<img src="images/eleganticons/Person-group.png" />
								<span>Administrator</span>
							</a>
						</li>
						<li>
							<a href="?module=admin&act=pengajar">
								<img src="images/eleganticons/Person-group.png" />
								<span>Pengajar</span>
							</a>
						</li>
						<li>
							<a href="?module=siswa">
								<img src="images/eleganticons/Person-group.png" />
								<span>Siswa</span>
							</a>
						</li>
						<li>
							<a href="?module=modul">
								<img src="images/eleganticons/Config.png" />
								<span>Module</span>
							</a>
						</li>
						<li>
							<a href="?module=kelas">
								<img src="images/eleganticons/Info.png" />
								<span>Kelas</span>
							</a>
						</li>
						<li>
							<a href="?module=materi">
								<img src="images/eleganticons/folder.png" />
								<span>Materi</span>
							</a>
						</li>
						<li>
							<a href="?module=quiz">
								<img src="images/eleganticons/info.png" />
								<span>Quiz</span>
							</a>
						</li>						
						<li>
							<a href="logout.php">
								<img src="images/eleganticons/X.png" />
								<span>Logout</span>
							</a>
						</li>
					</ul>
                                </section>
  <?php
  echo "<p align=right>Login : $hari_ini,
  <span id='date'></span>, <span id='clock'></span></p>";
  
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
  echo "<p>Hai <b>$_SESSION[namalengkap]</b>,  selamat datang di halaman Administrator.<br>
          Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola website.</p><br>";

          echo "<p align=right>Login : $hari_ini,
                <span id='date'></span>, <span id='clock'></span></p>";
          //detail pengajar
          $detail_pengajar=mysqli_query($con,"SELECT * FROM pengajar WHERE id_pengajar='$_SESSION[idadmin]'");
          $p=mysqli_fetch_array($detail_pengajar);
          $tgl_lahir   = tgl_indo($p[tgl_lahir]);
          echo "<form><fieldset>
              <legend>Detail Profil Anda</legend>
              <dl class='inline'>
          <table id='table1' class='gtable sortable'>
          <tr><td rowspan='14'>";if ($p[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_pengajar/medium_$p[foto]'>
                    <div class='links'>
                    <a href='../foto_pengajar/medium_$p[foto]' rel='facebox'>View</a>
                    <div>
                    </li>
                    </ul>";
          }echo "</td><td>ID</td>  <td> : $p[id_pengajar]</td><tr>
          <tr><td>Nama Lengkap</td> <td> : $p[nama_pengajar]</td></tr>
          <tr><td>Username</td>     <td> : $p[username_pengajar]</td></tr>
          <tr><td>E-mail</td>       <td> : $p[email_pengajar]</td></tr>
          <tr><td>HP</td> <td> : $p[hp_pengajar]</td></tr>";
          echo "<td>Aksi</td>         <td> : <input class='button small white' type=button value='Edit Profil' onclick=\"window.location.href='?module=admin&act=editpengajar';\"></td></tr>
          </table></dl></fieldset></form>";

         //kelas yang diampu
         echo"<form><fieldset>
              <legend>Kelas Yang anda ampu</legend>
              <dl class='inline'>
              <input class='button small blue' type=button value='Tambah' onclick=\"window.location.href='?module=kelas&act=tambahkelas';\">";
         
         $tampil_detail = mysqli_query($con,"SELECT * FROM detail_pengajar WHERE id_pengajar = '$_SESSION[idadmin]'");
         $ketemu=mysqli_num_rows($tampil_detail);
         if (!empty($ketemu)){
                echo "<br><br><table id='table1' class='gtable sortable'><thead>
                <tr><th>No</th><th>Kelas</th><th>Aksi</th></tr></thead>";

                $no=1;
                while ($r=mysqli_fetch_array($tampil_detail)){
                    echo "<tr><td>$no</td>";

                    $kelas = mysqli_query($con,"SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
                    $ada_kelas = mysqli_num_rows($kelas);
                    if(!empty($ada_kelas)){
                    while($k=mysqli_fetch_array($kelas)){
                            echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Kelas'>$k[nama_kelas]</a></td>";
                    }
                    }else{
                            echo "<td></td>";
                    }
                    echo "<td><a href='?module=kelas&act=editkelas&id=$r[id]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                    <a href=javascript:confirmdelete('$aksi_kelas?module=kelas&act=hapuswalikelas&id=$r[id]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a> |
                    <input class='button small white' type=button value='Lihat Siswa' onclick=\"window.location.href='?module=siswa&act=lihatmurid&id=$r[id_kelas]';\">
                    ";
                $no++;
                }
                echo "</table></dl></fieldset></form>";
                }else{
                    echo"<br><br>Tidak ada kelas yang anda ampu";
                }

   //mata pelajaran
  echo"
                <p>&nbsp;</p>";
 	}
        else{
             echo "<h2>Home</h2>
          <p>Hai <b>$_SESSION[namalengkap]</b>, selamat datang di E-Learning.</p>
          <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
          <p align=right>Login : $hari_ini, ";
  echo tgl_indo(date("Y m d"));
  echo " | ";
  echo date("H:i:s");
  echo " WIB</p>";
        }
}
// Bagian Modul
elseif ($_GET['module']=='modul'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_modul/modul.php";
  }
}
// Bagian user admin
elseif ($_GET['module']=='admin'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_admin/admin.php";
  }else{
      include "modul/mod_admin/admin.php";
  }
}

// Bagian user admin
elseif ($_GET['module']=='detailpengajar'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_admin/admin.php";
  }else{
      include "modul/mod_admin/admin.php";
  }
}

// Bagian kelas
elseif ($_GET['module']=='kelas'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_kelas/kelas.php";
  }
  elseif ($_SESSION['leveluser']=='pengajar'){
      include "modul/mod_kelas/kelas.php";
  }
  elseif ($_SESSION['leveluser']=='siswa'){
      include "modul/mod_kelas/kelas.php";
  }

}


// Bagian siswa
elseif ($_GET['module']=='siswa'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_siswa/siswa.php";
  }else{
      include "modul/mod_siswa/siswa.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='daftarsiswa'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_siswa/siswa.php";
  }else{
      include "modul/mod_siswa/siswa.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='detailsiswa'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_siswa/siswa.php";
  }else{
      include "modul/mod_siswa/siswa.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='detailsiswapengajar'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_siswa/siswa.php";
  }else{
      include "modul/mod_siswa/siswa.php";
  }
}

// Bagian mata pelajaran
elseif ($_GET['module']=='matapelajaran'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_matapelajaran/matapelajaran.php";
  }
  else{
      include "modul/mod_matapelajaran/matapelajaran.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='materi'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_materi/materi.php";
  }else{
      include "modul/mod_materi/materi.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='quiz'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquiz'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquizesay'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquizpilganda'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquiz'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquizesay'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquizpilganda'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_quiz/quiz.php";
  }else{
      include "modul/mod_quiz/quiz.php";
  }
}

// Bagian Templates
elseif ($_GET['module']=='templates'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_templates/templates.php";
  }
}

// Bagian Templates
elseif ($_GET['module']=='registrasi'){
  if ($_SESSION['leveluser']=='admin'){
    include "modul/mod_registrasi/registrasi.php";
  }
}
?>
