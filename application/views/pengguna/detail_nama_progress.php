<?php echo form_open_multipart('KadepC/update_nama_progress');?>
<form role="form" action="<?php echo base_url(); ?>KadepC/update_nama_progress" method="post">
  <div class="form-group">
    <label>Nama Progress</label>
    <input class="form-control" type="hidden" id="kode_nama_progress" name="kode_nama_progress" value="<?php echo $detail_nama_progress->kode_nama_progress;?>" required>
    <input class="form-control" type="text" id="nama_progress" name="nama_progress" value="<?php echo $detail_nama_progress->nama_progress;?>" required>
  </div>
</div> 
<div class="modal-footer">
  <input type="Submit" class="btn btn-info col-lg-2" value="Simpan">
</div> 
<?php echo form_close()?>
</form>