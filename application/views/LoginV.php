<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Sistem</title>

  <!-- CSS -->
 <!--  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/form-elements.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style_2.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/media-queries.css"> -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
  <link href="<?php echo base_url();?>assets/css/jquery-ui-1.10.4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url()?>assets_2/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets_2/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets_2/css/form-elements.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style_2.css">
  <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets_2/css/style.css"> -->
  <link rel="shortcut icon" href="<?php echo base_url()?>assets_2/ico/favicon.png">
</head>

<body>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-left">
          <li class="dropdown" style="">
            <a href="#" class="dropdown-toggle btn " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Unduh Prosedur<span class="caret"></span></a>
            <ul class="dropdown-menu">
             <?php $link_peg = base_url()."assets/file_prosedur/".$prosedur_pegawai[0]->nama_file;?>
             <li class="dropdown-header">Kegiatan</li>
             <?php $link_mhs = base_url()."assets/file_prosedur/".$prosedur_mahasiswa[0]->nama_file;?>
             <li><a href="<?php echo $link_mhs?>" target="_blank">Pengajuan Kegiatan Mahasiswa</a></li>
             <li><a href="<?php echo $link_peg?>" target="_blank">Pengajuan Kegiatan Pegawai</a></li>
             <li role="separator" class="divider"></li>
             <li class="dropdown-header">Barang</li>
             <?php $link_brg = base_url()."assets/file_prosedur/".$prosedur_barang[0]->nama_file;?>
             <li><a href="<?php echo $link_brg;?>" target="_blank">Pengadaan Barang</a></li>
           </ul>
         </li>
       </ul>
     </div><!--/.nav-collapse -->
   </div>
 </nav>

 <!-- Loader -->
 <div class="loader" style="display: none;">
  <div class="loader-img" style="display: none;"></div>
</div>

<!-- Top content -->
<div class="top-content" style="position: relative; z-index: 0; background: none;">
 <header class="header-top">

 </header>
 <div class="background">
  <div class="inner-bg">
    <div class="container">
      <div class="row">
        <div class="col-sm-7 text sticky-top sticky-pills">
          <div class="">
            <img src="<?php echo base_url();?>assets/img/logo2.png" style="height: 20%; width: 20%;">
            <h4> Sistem Pengajuan Kegiatan dan Pengadaan Barang</h4>
            <h4>Departemen Teknik Elektro dan Informatika</h4>
            <h4>Sekolah Vokasi</h4>
            <h4>Universitas Gadjah Mada</h4>
          </div>
        </div>
        <div class="col-sm-5 form-box wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
          <div class="form-top">
            <div class="form-top-left">
              <h3>Silahkan Masuk </h3>
              <p>Masukkan email dan sandi anda disini : </p>
            </div>
            <div>
              <!--   <div>  
                  <p><?php echo $this->session->flashdata('msg'); ?></p>  
                </div> -->
              </div>
            </div>
            <div class="form-bottom">
             <form action="<?php echo site_url('LoginC/signin'); ?>" method="post">

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

              <div class="form-group">
                <label class="sr-only" for="form-email">Email</label>
                <input type="email" name="email" class="form-email form-control" placeholder="Masukkan Email" autofocus required oninvalid="this.setCustomValidity('email tidak boleh kosong')" oninput="setCustomValidity('')">
              </div>

              <div class="form-group">
                <label class="sr-only" for="form-password">Sandi</label>
                <!-- <div class="input-group"> -->
                  <input type="password" name="password" class="form-password form-control" placeholder="Masukkan Password" required oninvalid="this.setCustomValidity('Password tidak boleh kosong')" oninput="setCustomValidity('')">
                  <!-- <span class="input-group-btn"> -->
                    <!-- <button class="btn reveal" type="button"><i class="glyphicon glyphicon-eye-open"></i></button> -->
                    <!-- </span> -->
                    <!-- </div> -->
              </div>

              <div class="form-group">
                <?=$cap_img?>
              </div>

              <div class="form-group">
                <input type="text" name="captcha" class="form-control" placeholder="Masukkan Captcha" required oninvalid="this.setCustomValivdity('Captcha tidak boleh kosong')" oninput="setCustomValidity('')">
              </div>

              <button type="submit" class="btn">Masuk</button>
              <div class="form-links">
                <p>Belum punya akun? <a href="<?php echo site_url('UserC/daftar')?>" class="launch-modal" data-modal-id="modal-privacy"> - Daftar</a></p>
                <!-- <a href="" class="launch-modal" data-modal-id="modal-faq">FAQ</a> -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>       
</div>             
</body>
</html>
<!-- <script type="text/javascript">
  $(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
      $pwd.attr('type', 'text');
    } else {
      $pwd.attr('type', 'password');
    }
  });
</script> -->

<script src="<?php echo base_url()?>assets_2/js/jquery-1.11.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.4.min.js"></script>
<script src="<?php echo base_url()?>assets_2/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets_2/js/jquery.backstretch.min.js"></script>
<script src="<?php echo base_url()?>assets_2/js/retina-1.1.0.min.js"></script>
<script src="<?php echo base_url()?>assets_2/js/scripts.js"></script>