<?php
include "configurasi/koneksi.php";
$sql=mysqli_query($con,"SELECT * FROM siswa WHERE id_siswa='$_POST[no_id]'");
$ketemu=mysqli_num_rows($sql);
echo $ketemu;
?>