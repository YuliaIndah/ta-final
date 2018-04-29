<?php echo form_open_multipart('KadepC/update_jabatan');?>
<!-- <?php var_dump($detail_jabatan);?> -->
<form role="form" action="<?php echo base_url(); ?>KadepC/update_jabatan" method="post">
  <div class="form-group">
    <label>Nama Jabatan</label>
    <input class="form-control" type="hidden" id="kode_jabatan" name="kode_jabatan" value="<?php echo $detail_jabatan->kode_jabatan;?>" required>
    <input class="form-control" type="text" id="nama_jabatan" name="nama_jabatan" value="<?php echo $detail_jabatan->nama_jabatan;?>" required>
  </div>
</div> 
<div class="modal-footer">
  <input type="Submit" class="btn btn-info col-lg-2" value="Simpan">
</div> 
<?php echo form_close()?>
</form>