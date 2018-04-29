<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Daftar</title>
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css">
	<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body style="margin: 100px;">
	<div class="col-md-2">
	</div>
	<div class="col-md-8">
		<center>
			<img style="width: 15%;" src="<?php echo base_url();?>assets/image/logo/email-sent.jpg">
			<div>
				<h1>Mohon Periksa Email anda . . </h1>
			</div>
			<div>
				<?php 
				$data=$this->session->flashdata('sukses');
				if($data!=""){ ?>
				<div class="alert alert-success"><strong>Sukses! </strong> <?=$data;?></div>
				<?php } ?>
				<?php 
				$data2=$this->session->flashdata('error');
				if($data2!=""){ ?>
				<div class="alert alert-danger"><strong> Error! </strong> <?=$data2;?></div>
				<?php } ?>
				<?php echo $this->session->flashdata('msg'); 
				?>						
				<p> Email Salah ? Silahkan masukkan kembali <a href="#" name="email" onclick="formResend()">email</a> anda . . .</p>
			</div>
			<div>
				<form id="formResend" action="<?php echo base_url(); ?>UserC/post_resend_email" method="post" style="display: none;" >
					<div class="row">
						<div class="form-group col-md-4 col-sm-4">
						</div>
						<div class="form-group col-md-4 col-sm-4">
							<div>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email" required> 
								<input type="hidden" name="id_pengguna" id="id_pengguna" value="<?php echo $_SESSION['id_pengguna']; ?>">  <!-- ambil data no identitas buat update email -->
								<span class="text-danger"><?php echo form_error('email'); ?></span><br>  
								<div class="form-group">
									<button type="submit" class="btn btn-success btn-outline" name="submit"> Kirim Ulang </button>
								</div>
							</div>
						</div> 
						<div class="form-group col-md-4 col-sm-4">
						</div> 
					</div>
					<div class="row">
						
					</div>
				</form>
			</div>
		</center>

	</div>
	<div class="col-md-2">
	</div>
</body>
</html>
<script type="text/javascript">
	function formResend(){
		$('#formResend').show();
	}
</script>