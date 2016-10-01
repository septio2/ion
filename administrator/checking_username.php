<?php
include "../configurasi/koneksi.php";
$sql=mysqli_query($con,"SELECT * FROM pengajar WHERE username_pengajar='$_POST[username]'");
$ketemu=mysqli_num_rows($sql);
echo $ketemu;
?>