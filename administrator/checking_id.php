<?php
include "../configurasi/koneksi.php";
$sql=mysqli_query($con,"SELECT * FROM pengajar WHERE id_pengajar='$_POST[no_id]'");
$ketemu=mysqli_num_rows($sql);
echo $ketemu;
?>