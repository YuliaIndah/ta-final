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
              <div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Nama Item Pengajuan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($data_klasifikasi as $barang) {
                        ?>
                        <tr>
                          <td><?php echo $barang->nama_barang; ?></td>
                             <td><center>
                                <a href="<?php echo base_url('Man_sarprasC/update_klasifikasi/'."2/".$barang->kode_barang);?>" id="custId" data-toggle="tooltip" data-toggle="tooltip" title="Aksi" class="btn btn-success btn-sm">Aset</span></a>
                                 <a href="<?php echo base_url('Man_sarprasC/update_klasifikasi/'."1/".$barang->kode_barang);?>" id="custId" data-toggle="tooltip" data-toggle="tooltip" title="Aksi" class="btn btn-danger btn-sm">Habis Pakai</span></a>
                              </center></td>
                        </tr>

                        <?php
                        # code...
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
                <label class="col-lg-4 col-sm-2 control-label" for="jenis_barang"> Barang :</label>
                <div class="col-lg-8">
                   <select class="form-control" name="kode_barang" id="kode_barang">
                <option value="">---- Pilih Barang ---- </option>
                <?php 
                foreach ($pilihan_barang as $pilihan_barang) {
                  ?>
                  <option value="<?php echo $pilihan_barang->kode_barang ;?>"> <?php echo $pilihan_barang->nama_barang ;?> </option>
                  <?php
                }
                ?>
              </select>
              <span class="text-danger" style="color: red;"><?php echo form_error('kode_barang'); ?></span>  
                </div>
              </div>
              <div class="form-group">
                <input class="form-control" type="hidden" id="no_identitas" name="no_identitas" value="<?php echo $data_diri->no_identitas;?>" required> <!-- ambil id_pengguna_jabatan berdasarkan user yang login-->
                <label class="col-lg-4 col-sm-2 control-label">Nama Item Pengajuan Barang :</label>
                <div class="col-lg-8">
                  <input type="text" class="form-control" id="nama_item_pengajuan" name="nama_item_pengajuan" placeholder="Nama Item Pengajuan Barang">
                </div>
              </div>
              <input type="hidden" class="form-control" placeholder id="tgl_item_pengajuan" name="tgl_item_pengajuan" required value="<?php echo date('Y-m-d');?>">
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

<!-- modal ubah barang -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ubah Barang</h4>
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
    // js 
    $(document).ready(function(){
      $('#myModal1').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
              type : 'get',
              url : '<?php echo base_url().'Man_sarprasC/ubah_barang/'?>'+rowid,
                //data :  'rowid='+ rowid, // $_POST['rowid'] = rowid
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
              }
            });
          });
    });

  </script>
