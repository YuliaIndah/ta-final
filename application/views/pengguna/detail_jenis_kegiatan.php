<?php echo form_open_multipart('KadepC/update_jenis_kegiatan');?>
<form role="form" action="<?php echo base_url(); ?>KadepC/update_jenis_kegiatan" method="post">
  <div class="form-group">
    <label>Nama Jenis Kegiatan</label>
    <input class="form-control" type="hidden" id="kode_jenis_kegiatan" name="kode_jenis_kegiatan" value="<?php echo $detail_jenis_kegiatan->kode_jenis_kegiatan;?>" required>
    <input class="form-control" type="text" id="nama_jenis_kegiatan" name="nama_jenis_kegiatan" value="<?php echo $detail_jenis_kegiatan->nama_jenis_kegiatan;?>" required>
  </div>
</div> 
<div class="modal-footer">
  <input type="Submit" class="btn btn-info col-lg-2" value="Simpan">
</div> 
<?php echo form_close()?>
</form>