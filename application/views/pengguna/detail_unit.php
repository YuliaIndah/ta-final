<?php echo form_open_multipart('KadepC/update_unit');?>
<form role="form" action="<?php echo base_url(); ?>KadepC/update_unit" method="post">
  <div class="form-group">
    <label>Nama Unit</label>
    <input class="form-control" type="hidden" id="kode_unit" name="kode_unit" value="<?php echo $detail_unit->kode_unit;?>" required>
    <input class="form-control" type="text" id="nama_unit" name="nama_unit" value="<?php echo $detail_unit->nama_unit;?>" required>
  </div>
</div> 
<div class="modal-footer">
  <input type="Submit" class="btn btn-info col-lg-2" value="Simpan">
</div> 
<?php echo form_close()?>
</form>