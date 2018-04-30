<section id="main-content">
  <section class="wrapper">            
    <!--overview start-->
    <div class="row">
      <div class="col-lg-12">
        <h3 class="page-header" style="margin-top: 0;"><i class="fa fa-gears"></i> Pengaturan Akun </h3>
      </div>
    </div>
    <div class="row">
      <div class="container">
       <?php
       // var_dump($data_kegiatan); 
       $data=$this->session->flashdata('sukses');
       if($data!=""){ ?>
       <div class="alert alert-success"><strong>Sukses! </strong> <?=$data;?></div>
       <?php } ?>
       <?php 
       $data2=$this->session->flashdata('error');
       if($data2!=""){ ?>
       <div class="alert alert-danger"><strong> Error! </strong> <?=$data2;?></div>
       <?php } ?>

       <div class="panel panel-primary">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
          <div class="col-sm-10">
           <form role="form" method="post" action="<?php echo base_url();?>PenggunaC/post_ganti_password">
            <div class="form-group row">
              <label for="sandi_lama" class="col-sm-2 col-form-label">Kata Sandi Lama</label>
              <div class="col-sm-4">
                <input type="password" class="form-control" id="sandi_lama" name="sandi_lama" required placeholder="Kata Sandi Lama">
                <span class="text-danger"><?php echo form_error('sandi_lama'); ?></span>
                <input type="hidden" class="form-control" id="id_pengguna" name="id_pengguna" placeholder="Kata Sandi Baru" value="<?php echo $data_diri->id_pengguna;?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="sandi_baru" class="col-sm-2 col-form-label">Kata Sandi Baru</label>
              <div class="col-sm-4">
                <input type="password" class="form-control" id="sandi_baru" name="sandi_baru" required placeholder="Kata Sandi Baru">
                <span class="text-danger"><?php echo form_error('sandi_baru'); ?></span>
              </div>
            </div>
            <div class="form-group row">
              <label for="konfirmasi_sandi_baru" class="col-sm-2 col-form-label">Konfirmasi Kata Sandi Baru</label>
              <div class="col-sm-4">
                <input type="password" class="form-control" id="konfirmasi_sandi_baru" name="konfirmasi_sandi_baru" required placeholder="Konfirmasi Kata Sandi Baru">
                <span class="text-danger"><?php echo form_error('konfirmasi_sandi_baru'); ?></span>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-info">Ganti Kata Sandi</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="panel-footer">    
      </div>
    </div>
  </div>
</div>

</section>
<div class="text-center">
  <div class="credits">
    <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
  </div>
</div>
</section>