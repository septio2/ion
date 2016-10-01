<?php
include"configurasi/koneksi.php";
$sql=mysqli_query($con,"SELECT * FROM siswa WHERE username = '$_POST[username]'");
$ketemu=mysqli_num_rows($sql);
echo $ketemu;
?>