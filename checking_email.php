<?php
include"configurasi/koneksi.php";
$sql=mysqli_query($con,"SELECT * FROM siswa WHERE email = '$_POST[email]'");
$ketemu=mysqli_num_rows($sql);
echo $ketemu;
?>