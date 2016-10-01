<!DOCTYPE HTML>
<html>
	<head>
		<title>Pendaftaran IONs Education</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style_register.css">
		<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png">
		<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="js/cufon-yui.js"></script>
		<script type="text/javascript" src="js/Delicious_500.font.js"></script>
		<script>
$(document).ready(function(){
   $("#no_id").change(function(){
		// tampilkan animasi loading saat pengecekan ke database
    $('#pesan').html(' <img src="../images/loading.gif" width="20" height="20"> checking ...');
    var no_id = $("#no_id").val();

    $.ajax({
     type:"POST",
     url:"checking_id.php",
     data: "no_id=" + no_id,
     success: function(data){
       if(data==0){
          $("#pesan").html('<img src="../images/tick.png">');
 	        $('#no_id').css('border', '3px #090 solid');
       }
       else{
          $("#pesan").html('<img src="../images/cross.png"> ID sudah digunakan!');
 	        $('#no_id').css('border', '3px #C33 solid');
                $("#no_id").val('');
       }
     }
    });
	})
});
</script>
		<script>
$(document).ready(function(){
   $("#username").change(function(){
		// tampilkan animasi loading saat pengecekan ke database
    $('#pesan_username').html(' <img src="../images/loading.gif" width="20" height="20"> checking ...');
    var username = $("#username").val();

    $.ajax({
     type:"POST",
     url:"checking_username.php",
     data: "username=" + username,
     success: function(data){
       if(data==0){
          $("#pesan_username").html('<img src="../images/tick.png">');
 	        $('#username').css('border', '3px #090 solid');
       }
       else{
          $("#pesan_username").html('<img src="../images/cross.png"> Username sudah digunakan!');
 	        $('#username').css('border', '3px #C33 solid');
                $("#username").val('');
       }
     }
    });
	})
});
</script>
		<script>
$(document).ready(function(){
   $("#email").change(function(){
		// tampilkan animasi loading saat pengecekan ke database
    $('#pesan_email').html(' <img src="../images/loading.gif" width="20" height="20"> checking ...');
    var email = $("#email").val();

    $.ajax({
     type:"POST",
     url:"checking_email.php",
     data: "email=" + email,
     success: function(data){
       if(data==0){
          $("#pesan_email").html('<img src="../images/tick.png">');
 	        $('#email').css('border', '3px #090 solid');
       }
       else{
          $("#pesan_email").html('<img src="../images/cross.png"> Email sudah digunakan!');
 	        $('#email').css('border', '3px #C33 solid');
                $("#email").val('');
       }
     }
    });
	})
});
</script>
		<script>
	$(document).ready(function(){
		$('#password_lagi').change(function(){
			var passpertama=$('#password').val();
			var passkedua=$('#password_lagi').val();
			if($('#password').val() != $('#password_lagi').val()){
			         $("#pesan_password").html('<img src="../images/cross.png"> Password Tidak Sama');
 	        $('#password_lagi').css('border', '3px #C33 solid');
			}else if(passpertama == passkedua){
				$("#pesan_password").html('<img src="../images/tick.png">');
 	        $('#password_lagi').css('border', '3px #090 solid');
			}
		});				
	});	
</script>
		<script language="javascript">
			function check_radio(radio)
			{
				for(i=0;i<radio.length;i++){
					if(radio[i].checked === true){
						return radio[i].value;
					}
				}
				return false;
			}
			function validasi(form){
				if (form.no_id.value==""){
					alert('ID Masih Kosong!');
					form.no_id.focus();
					return(false);
				}
				if (form.nama.value==""){
					alert('Nama Masih Kosong!');
					form.nama.focus();
					return(false);
				}
				if (form.username.value==""){
					alert('Username masih kosong!');
					form.username.focus();
					return(false);
				}
				if (form.password.value==""){
					alert('Password Masih Kosong!');
					form.password.focus();
					return(false);
				}
				if(form.email.value==""){
					alert('Email Masih Kosong!');
					form.email.focus();
					return(false);
				}
				
				if(form.hp.value==""){
					alert('No. HP Masih Kosong');
					form.hp.focus();
					return(false);
				}
				return(true);
			}
		</script>
	</head>
	<body>
		<header id="top">
			<div class="container_12 clearfix">
				<div id="logo" class="grid_12">
				<a id="site-title">E-Learning <span>IONs INTERNATIONAL EDUCATION | True Mandarin</span>
				</a>
			</div>
		</header>
		<div id="login2" class="box">
			<h2>Registrasi Pengajar</h2>
			<section>
				<form method="POST" enctype="multipart/form-data" action="input_registrasiadmin.php" onSubmit="return validasi(this)">
					<dl>
					<dt><label>ID :</label></dt>
					<dd><input type="text" name="no_id" size="20" id="no_id"/><span id="pesan"></span></dd>
					<dt><label>Nama Lengkap :</label></dt>
					<dd><input type="text" name="nama" size="40"></dd>
					<dt><label>Username :</label></dt>
					<dd><input type="text" name="username" size="20" id="username"/><span id="pesan_username"></span></dd>
					<dt><label>Password :</label></dt>
					<dd><input type="password" name="password" size="20" id="password"></dd>
					<dt><label>Konfirmasi Password :</label></dt>
					<dd><input type="password" name="password_lagi" size="20" id="password_lagi"><span id="pesan_password"></span></dd>
					<dt><label>Email :</label></dt>
					<dd><input type="text" name="email" size="20" id="email"><span id="pesan_email"></span></dd>
					<dt><label>HP :</label></dt>
					<dd><input type="text" name="hp" size="20"></dd>
					<hr>
					</dl>
					<p>
					<input type="submit" class="button white" value="Daftar"></input>
					<?php
					echo "<button type='button' class='button white' onclick=\" window.location.href='index.php';\">Batal</button>";
					?>
					</p>
				</form>
			</section>
		</div>
	</body>
</html>