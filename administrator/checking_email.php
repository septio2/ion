<?php
include "../configurasi/koneksi.php";
$sql=mysqli_query($con,"SELECT * FROM pengajar WHERE email_pengajar='$_POST[email]'");
$ketemu=mysqli_num_rows($sql);
echo $ketemu;
?>