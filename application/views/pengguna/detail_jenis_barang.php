<?php echo form_open_multipart('KadepC/update_jenis_barang');?>
<form role="form" action="<?php echo base_url(); ?>KadepC/update_jenis_barang" method="post">
  <div class="form-group">
    <label>Nama Jenis Barang</label>
    <input class="form-control" type="hidden" id="kode_jenis_barang" name="kode_jenis_barang" value="<?php echo $detail_jenis_barang->kode_jenis_barang;?>" required>
    <input class="form-control" type="text" id="nama_jenis_barang" name="nama_jenis_barang" value="<?php echo $detail_jenis_barang->nama_jenis_barang;?>" required>
  </div>
</div> 
<div class="modal-footer">
  <input type="Submit" class="btn btn-info col-lg-2" value="Simpan">
</div> 
<?php echo form_close()?>
</form>