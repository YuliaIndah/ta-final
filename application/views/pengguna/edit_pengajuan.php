<?php echo form_open_multipart('KadepC/post_ubah_pengajuan_kegiatan_pegawai');?>
<form role="form" action="<?php echo base_url(); ?>KadepC/post_ubah_pengajuan_kegiatan_pegawai" method="post">
    <!-- Alert -->
    <!-- sampai sini -->
    <div class="form-group">
      <!-- <label>ID Pengguna Jabatan</label> -->

      <input class="form-control" type="hidden" id="id_pengguna" name="id_pengguna" value="<?php echo $data_diri->id_pengguna;?>" required> <!-- ambil id_pengguna_jabatan berdasarkan user yang login-->
  </div>
  <div class="form-group">
      <!-- <label>Kode Jenis Kegiatan</label> -->
      <?php 
      if($data_diri->kode_jabatan == '5'){
        ?>  
        <input class="form-control" type="hidden" id="kode_jenis_kegiatan" name="kode_jenis_kegiatan" value="2" required>
        <?php
    }else{
        ?>
        <input class="form-control" type="hidden" id="kode_jenis_kegiatan" name="kode_jenis_kegiatan" value="1" required>
        <?php
    }
    ?>
</div>
<div class="form-group">
  <label>Nama Kegiatan</label>
  <input class="form-control" placeholder="Nama Kegiatan" type="text" id="nama_kegiatan" name="nama_kegiatan" required>
  <span class="text-danger" style="color: red;"><?php echo form_error('nama_kegiatan'); ?></span>  
</div>
<div class="form-group">
  <label>Tanggal Pelaksanaan Kegiatan</label>
  <div class="row">
     <div class="col-md-5">
        <input type="text" class="form-control"  id="from" placeholder="hh/bb/ttt" name="tgl_kegiatan" required>
    </div>
    <div class="col-md-2 text-center">Sampai</div>
    <div class="col-md-5">
        <input type="text" class="form-control" id="to" placeholder="hh/bb/ttt" name="tgl_selesai_kegiatan" required>
    </div>
</div>
<span class="text-danger" style="color: red;"><?php echo form_error('tgl_kegiatan'); ?></span>  
</div>
<div class="form-group">
    <input type="hidden" class="form-control" placeholder id="tgl_pengajuan" name="tgl_pengajuan" required value="<?php echo date('Y-m-d');?>">
</div>
<div class="form-group">
    <label>Dana yang diajukan</label>
    <input class="form-control" placeholder="Dana yang diajukan" type="text" onkeypress="return hanyaAngka(event)" id="dana_diajukan" name="dana_diajukan" required>
    <span class="text-danger" style="color: red;"><?php echo form_error('dana_diajukan'); ?></span>  
</div>
<div class="form-group">
    <input class="form-control" type="hidden" id="dana_disetujui" name="dana_disetujui" value="0">
</div>

<div style="color: red;"><?php echo (isset($message))? $message : ""; ?></div>
<div class="form-group">
    <label>Unggah Berkas</label>
    <input type="file" name="file_upload">
</div>
</div> 
<!-- <button type="reset" class="btn btn-default">Reset Button</button> -->
<div class="modal-footer">
  <input type="submit" class="btn btn-info col-lg-2"  value="Submit">
</div> 
<?php echo form_close()?>
</form>

<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
