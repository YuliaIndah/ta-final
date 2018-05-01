<section id="main-content">
  <section class="wrapper">            
    <!--overview start-->
    <div class="row">
      <div class="col-lg-12">
        <h3 class="page-header" style="margin-top: 0;"><i class="fa fa-pencil"></i>Daftar Pengajuan Barang</h3>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-12">
       <!-- Alert -->
       <?php 
       // print_r($pilihan_barang_tambah);
       $data=$this->session->flashdata('sukses');
       if($data!=""){ ?>
       <div class="alert alert-success"><strong>Sukses! </strong> <?=$data;?></div>
       <?php } ?>
       <?php 
       $data2=$this->session->flashdata('error');
       if($data2!=""){ ?>
       <div class="alert alert-danger"><strong> Error! </strong> <?=$data2;?></div>
       <?php } ?>
       <!-- sampai sini -->
       <div style="color: red;"><?php echo (isset($message))? $message : ""; ?></div>

       <div class="card mb-3">
        <div class="card-header">
          <div class="card-body">
            <a class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="icon_plus_alt2"> </i>Ajukan Barang</a>
            <a class="btn btn-info" data-toggle="modal" data-target="#myModal1"><i class="icon_plus_alt2"> </i>Ajukan Barang Baru</a>
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Nama Item Pengajuan</th>
                    <th>File</th>
                    <th>Barang</th>
                    <th>Jenis Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah Barang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($data_ajukan_barang as $barang) {
                    ?>
                    <tr class="text-center">
                      <td><?php echo $barang->nama_item_pengajuan; ?></td>
                      <td><center><img style="height: 50px;" src="<?php echo base_url();?>assets/file_gambar/<?php echo $barang->file_gambar;?>"></center></td>
                      <td><?php echo $barang->nama_barang; ?></td>
                      <td><?php echo $barang->nama_jenis_barang; ?></td>
                      <td><?php echo $barang->harga_satuan; ?></td>
                      <td><?php echo $barang->jumlah; ?></td>
                      <td> 
                       <a href="#myModal2" id="custId" data-toggle="modal" data-id="<?php echo $barang->kode_item_pengajuan;?>" data-toggle="tooltip" title="Aksi"><?php echo $barang->status_pengajuan; ?></a>
                     </td>

                     <td>
                      <?php
                      $progress_saya = $Man_sarprasM->get_progress_barang_by_id($barang->kode_item_pengajuan, $data_diri->id_pengguna);

                      if($progress_saya == 1){?>
                      <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-<?php echo $barang->kode_item_pengajuan; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                      <?php
                    }else{?>
                    <a class="btn btn-success btn-sm" disabled><span class="glyphicon glyphicon-pencil"></span></a>
                    <?php
                  }
                  ?>
                </td>
              </tr>

              <!-- Modal Terima Item Pengajuan -->
              <div aria-hidden="true" aria-labelledby="myModal" role="dialog" tabindex="-1" id="modal-<?php echo $barang->kode_item_pengajuan; ?>" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title" id="titlemodal">Edit Pengajuan Barang</h4>
                    </div>
                    <form class="form-horizontal" action="<?php echo base_url('Man_sarprasC/post_persetujuan_barang');?>" method="post">
                      <div class="modal-body">
                        <div class="form-group">
                          <div class="modal-body">
                            <label class="col-lg-4 col-sm-2 control-label" for="jenis_barang"> Barang :</label>
                            <div class="col-lg-8">
                             <select class="form-control" name="kode_barang" id="kode_barang">
                              <option value="">---- Pilih Barang ---- </option>
                              <?php 
                              foreach ($pilihan_barang as $pilihan_barang) {
                                ?>
                                <option <?php if ($pilihan_barang->kode_barang == $barang->kode_barang) {echo "selected=selected";} ?> value="<?php echo $pilihan_barang->kode_barang ?>"><?php echo $pilihan_barang->nama_barang ?></option>
                                <?php
                              }
                              ?>
                            </select>
                            <span class="text-danger" style="color: red;"><?php echo form_error('kode_barang'); ?></span>  
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="modal-body">
                          <input class="form-control" type="hidden" id="id_pengguna" name="id_pengguna" value="<?php echo $data_diri->id_pengguna;?>" required> <!-- ambil id_pengguna_jabatan berdasarkan user yang login-->
                          <label class="col-lg-4 col-sm-2 control-label">Nama Item Pengajuan Barang :</label>
                          <div class="col-lg-8">
                            <input type="text" class="form-control" value="<?php echo $barang->nama_item_pengajuan ?>">
                          </div>
                        </div>
                      </div>
                      <input type="hidden" class="form-control" placeholder id="tgl_item_pengajuan" name="tgl_item_pengajuan" required value="<?php echo date('Y-m-d');?>">
                      <input type="hidden" class="form-control" placeholder id="pimpinan" name="pimpinan" required value="<?php echo $data_pimpinan;?>">
                      <div class="form-group">
                        <div class="modal-body">
                          <label class="col-lg-4 col-sm-2 control-label">url :</label>
                          <div class="col-lg-8">
                            <input type="text" class="form-control" id="url" name="url" value="<?php echo $barang->url ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="modal-body">
                          <label class="col-lg-4 col-sm-2 control-label">Harga Satuan :</label>
                          <div class="col-lg-8">
                            <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" value="<?php echo $barang->harga_satuan ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="modal-body">
                          <label class="col-lg-4 col-sm-2 control-label">Merk :</label>
                          <div class="col-lg-8">
                            <input type="text" class="form-control" id="merk" name="merk" value="<?php echo $barang->merk ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="modal-body">
                          <label class="col-lg-4 col-sm-2 control-label">Jumlah :</label>
                          <div class="col-lg-8">
                            <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $barang->jumlah ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="modal-body">
                          <label class="col-lg-4 col-sm-2 control-label">Unggah Foto :</label>
                          <div class="col-lg-8">
                           <img style="height: 50px; margin-bottom: 20px" src="<?php echo base_url();?>assets/file_gambar/<?php echo $barang->file_gambar;?>">
                           <input type="file" id="file_gambar" name="file_gambar" >
                         </div>
                       </div>
                     </div>           
                   </div>
                   <div class="modal-footer" style="margin-top: 70px">
                    <button class="btn btn-info" type="submit"> Simpan </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- END Modal Terima Item Pengajuan-->

      <?php
    }
    ?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<!-- project team & activity end -->

</section>
<div class="text-center">
  <div class="credits">
    <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
  </div>
</div>
</section>

<!-- Modal Tambah Pengajuan Barang -->
<div aria-hidden="true" aria-labelledby="myModal" role="dialog" tabindex="-1" id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Ajukan Barang</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url('Man_sarprasC/post_tambah_ajukan_barang');?>" method="post" enctype="multipart/form-data" role="form">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-lg-4 col-sm-2 control-label" for="barang"> Barang :</label>
            <div class="col-lg-8">
             <select class="form-control" name="kode_barang" id="kode_barang">
              <option value="">---- Pilih Barang ---- </option>
              <?php 
              foreach ($pilihan_barang_tambah as $barang) {
                ?>
                <option value="<?php echo $barang->kode_barang ;?>"> <?php echo $barang->nama_barang ;?> </option>
                <?php
              }
              ?>
            </select>
            <span class="text-danger" style="color: red;"><?php echo form_error('kode_barang'); ?></span>  
          </div>
        </div>
        <div class="form-group">
          <input class="form-control" type="hidden" id="id_pengguna" name="id_pengguna" value="<?php echo $data_diri->id_pengguna;?>" required> <!-- ambil id_pengguna_jabatan berdasarkan user yang login-->
          <label class="col-lg-4 col-sm-2 control-label">Nama Item Pengajuan Barang :</label>
          <div class="col-lg-8">
            <input type="text" class="form-control" id="nama_item_pengajuan" name="nama_item_pengajuan" placeholder="Nama Item Pengajuan Barang">
          </div>
        </div>
        <input type="hidden" class="form-control" placeholder id="tgl_item_pengajuan" name="tgl_item_pengajuan" required value="<?php echo date('Y-m-d');?>">
        <input type="hidden" class="form-control" placeholder id="pimpinan" name="pimpinan" required value="<?php echo $data_pimpinan;?>">
        <div class="form-group">
          <label class="col-lg-4 col-sm-2 control-label">url :</label>
          <div class="col-lg-8">
            <input type="text" class="form-control" id="url" name="url" placeholder="Url Barang">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 col-sm-2 control-label">Harga Satuan :</label>
          <div class="col-lg-8">
            <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" placeholder="Harga Satuan">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 col-sm-2 control-label">Merk :</label>
          <div class="col-lg-8">
            <input type="text" class="form-control" id="merk" name="merk" placeholder="Merk">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 col-sm-2 control-label">Jumlah :</label>
          <div class="col-lg-8">
            <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 col-sm-2 control-label">Unggah Foto :</label>
          <div class="col-lg-8">
            <input type="file" id="file_gambar" name="file_gambar" >
          </div>
        </div>           

      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit"> Simpan </button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>
<!-- END Modal Tambah Pengajuan Barang -->

<!-- Modal Tambah Pengajuan Barang Baru-->
<div aria-hidden="true" aria-labelledby="myModal1" role="dialog" tabindex="-1" id="myModal1" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Ajukan Barang Baru</h4>
      </div>
      <form class="form-horizontal" action="<?php echo base_url('Man_sarprasC/post_tambah_barang_baru');?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-lg-4 col-sm-2 control-label">Nama Barang :</label>
            <div class="col-lg-8">
              <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama Barang">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-info" type="submit"> Simpan </button>
          <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- END Modal Tambah Pengajuan Barang Baru-->

<!-- modal progress barang -->
<div class="modal fade" id="myModal2" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Progress Barang</h4>
      </div>
      <div class="modal-body">
        <div class="fetched-data"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Untuk sunting
    $('#myModal').on('show.bs.modal', function (event) {

    });
  });
</script>
<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    // js progress barang
    $(document).ready(function(){
      $('#myModal2').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
              type : 'get',
              url : '<?php echo base_url().'Man_sarprasC/detail_progress_barang/'?>'+rowid,
                //data :  'rowid='+ rowid, // $_POST['rowid'] = rowid
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
              }
            });
          });
    });

  </script>
