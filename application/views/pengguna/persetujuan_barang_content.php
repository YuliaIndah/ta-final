<section id="main-content">
  <section class="wrapper">            
    <!--overview start-->
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
       <h3 class="page-header" style="margin-top: 0;"><i class="fa fa-pencil"></i>Barang Diajukan</h3>
     </div>
   </div>
   <div class="row">
    <div class="col-lg-12">
      <div class="card mb-3">
        <div class="card-header">
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%">
                <thead>
                  <tr class="text-center">
                    <!-- <th>No. Identitas</th> -->
                    <th>Nama Pengajuan Barang</th>
                    <th>Nama Pengaju</th>
                    <th>Jabatan Pengaju</th>
                    <th>Gambar</th>
                    <th>Tgl Pengajuan</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($data_persetujuan_barang as $barang) {
                    ?>
                    <tr class="text-center" >
                      <td> 
                       <a href="#" data-toggle="modal" data-target="#modal-<?php echo $barang->kode_item_pengajuan; ?>"><?php echo $barang->nama_item_pengajuan ?></a>
                     </td>
                     <td><?php 
                     // mendapatkan nama pengaju dari kode item pengajuan berdasarkan id
                     $pengaju = $BarangM->get_data_item_pengajuan_by_id($barang->kode_item_pengajuan)->result()[0]->nama;
                     echo $pengaju;
                     ?>
                   </td>
                   <td>
                    <?php 
                    // mendapatkan nama jabatan dari kode item pengajuan berdasarkan id
                    $jabatan      = $BarangM->get_data_item_pengajuan_by_id($barang->kode_item_pengajuan)->result()[0]->nama_jabatan;
                    // mendapatkan kode jabatan dari kode item pengajuan berdasarkan id
                    $kode_jabatan = $BarangM->get_data_item_pengajuan_by_id($barang->kode_item_pengajuan)->result()[0]->kode_jabatan;
                    // mendapatkan nama unit dari kode item pengajuan berdasarkan id
                    $unit = $BarangM->get_data_item_pengajuan_by_id($barang->kode_item_pengajuan)->result()[0]->nama_unit;
                    // mendapatkan kode unit dari kode item pengajuan berdasarkan id
                    $kode_unit = $BarangM->get_data_item_pengajuan_by_id($barang->kode_item_pengajuan)->result()[0]->kode_unit;
                    //menampilkan nama jabatan dan unit dari pengaju item pengajuan
                    echo $jabatan." ".$unit;
                    ?>
                  </td>
                  <td><center><img style="height: 60px;" src="<?php echo base_url();?>assets/file_gambar/<?php echo $barang->file_gambar;?>"></center></td>
                  <td><?php echo $barang->tgl_item_pengajuan;?></td>
                  <td><?php echo $barang->jumlah;?></td>
                  <?php 
                  $jumlah = $barang->jumlah;
                  $harga = $barang->harga_satuan;
                  //menghitung hasil total biaya item pengajuan dari perkalian harga satuan dengan jumlah barang
                  $total = $jumlah*$harga;
                  ?>
                  <td><?php echo $total;?></td>
                  <td><?php echo $barang->status_pengajuan;?></td>
                  <td><center>
                    <?php 
                    // mengambil data progress dari semua item pengajuan pada halaman persetujuan man sarpras yang sudah memiliki progres yang diberikan oleh mas sarpras 
                    $progress_saya = $BarangM->get_progress_barang_by_id($barang->kode_item_pengajuan,$data_diri->id_pengguna);

                    // jika progress baru 1 maka belum diberikan progress oleh man sarpras tetapi sudah oleh pimpinan 
                    // jika lebih dari satu maka sudah ditambahkan progres oleh man sarpras

                    if($progress_saya == 1){?>
                    <div class="btn-group">
                      <a href="#" data-toggle="modal" data-target="#mymodal1-<?php echo $barang->kode_item_pengajuan; ?>" title="Terima" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span></a>
                      <a href="#" data-toggle="modal" data-target="#mymodal2-<?php echo $barang->kode_item_pengajuan; ?>" title="Tolak" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a>
                      <a href="<?php echo base_url('BarangC/post_persetujuan_tersedia/'.$barang->kode_item_pengajuan);?>" id="custId" data-toggle="tooltip" data-toggle="tooltip" title="tersedia" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-briefcase"></span></a>
                    </div>
                    <?php
                  }else{
                    echo "selesai";
                    ?>
                    <center><span class="glyphicon glyphicon-ok"></span></center>
                    <?php
                  }
                  ?>
                </center>
              </td>
            </tr>

            <!-- Modal Detail Item Pengajuan -->
            <div aria-hidden="true" aria-labelledby="myModal" role="dialog" tabindex="-1" id="modal-<?php echo $barang->kode_item_pengajuan; ?>" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title" id="titlemodal">Item Pengajuan Barang</h4>
                  </div>
                  <form class="form-horizontal" role="form">
                    <div class="modal-body">                        
                      <label class="control-label col-sm-5" style="text-align: left;">Nama Barang</label>
                      <p class="form-control-static"> <?php echo ": ".$barang->nama_barang; ?> </p>
                      <label class="control-label col-sm-5" style="text-align: left;">Nama Item Pengajuan</label>
                      <p class="form-control-static"> <?php echo ": ".$barang->nama_item_pengajuan; ?> </p>
                      <!-- // -->
                      <label class="control-label col-sm-5" style="text-align: left;">Nama Pengaju</label>
                      <p class="form-control-static"> <?php echo ": ".$barang->nama; ?> </p>
                      <label class="control-label col-sm-5" style="text-align: left;">Jabatan</label>
                      <p class="form-control-static"> <?php echo ": ".$barang->nama_jabatan." ".$barang->nama_unit; ?> </p>
                      <!-- // -->
                      <label class="control-label col-sm-5" style="text-align: left;">Status Persediaan</label>
                      <p class="form-control-static"> <?php echo ": ".$barang->status_persediaan; ?> </p>
                      <label class="control-label col-sm-5" style="text-align: left;">URL</label>
                      <p class="form-control-static"> <?php echo ": ".$barang->url; ?> </p>
                      <label class="control-label col-sm-5" style="text-align: left;">Harga Satuan</label>
                      <p class="form-control-static"> <?php echo ": ".$barang->harga_satuan; ?> </p>
                      <label class="control-label col-sm-5" style="text-align: left;">Merk</label>
                      <p class="form-control-static"> <?php echo ": ".$barang->merk; ?> </p>
                    </div>
                    <div class="modal-footer">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- END Modal Item Pengajuan-->

          <!-- Modal Terima Item Pengajuan -->
          <div aria-hidden="true" aria-labelledby="myModal1" role="dialog" tabindex="-1" id="mymodal1-<?php echo $barang->kode_item_pengajuan; ?>" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                  <h4 class="modal-title" id="titlemodal">Terima Item Pengajuan Barang</h4>
                </div>
                <form class="form-horizontal" action="<?php echo base_url('BarangC/post_persetujuan_barang');?>" method="post">
                  <div class="modal-body">
                    <div class="form-group">
                      <!-- ambil id_pengguna_jabatan berdasarkan user yang login-->
                      <input class="form-control" type="hidden" id="id_pengguna" name="id_pengguna" value="<?php echo $data_diri->id_pengguna;?>" required> 
                      <!-- kirim kode_fk berdasarkan kode_item_pengajuan dari barang yang terpilih -->
                      <input class="form-control" type="hidden" id="kode_fk" name="kode_fk" value="<?php echo $barang->kode_item_pengajuan;?>" required>
                      <!-- kirim kode_nama_progress = 1 untuk terima -->
                      <input type="hidden" class="form-control" placeholder id="kode_nama_progress" name="kode_nama_progress" required value="1">
                      <label class="col-lg-4 col-sm-2 control-label">Komentar Persetujuan:</label>
                      <div class="modal-body">
                       <textarea name="komentar" value="" class="form-control" placeholder="Komentar" rows="3" required></textarea>
                     </div>
                   </div>
                 </div>
                 <div class="modal-footer">
                  <button class="btn btn-info" type="submit"> Simpan </button>
                  <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- END Modal Terima Item Pengajuan-->

        <!-- Modal Tolak Item Pengajuan -->
        <div aria-hidden="true" aria-labelledby="myModal2" role="dialog" tabindex="-1" id="mymodal2-<?php echo $barang->kode_item_pengajuan; ?>" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title" id="titlemodal">Tolak Item Pengajuan Barang</h4>
              </div>
              <form class="form-horizontal" action="<?php echo base_url('BarangC/post_persetujuan_barang');?>" method="post">
                <div class="modal-body">
                  <div class="form-group">
                    <!-- ambil id_pengguna_jabatan berdasarkan user yang login-->
                    <input class="form-control" type="hidden" id="no_identitas" name="no_identitas" value="<?php echo $data_diri->id_pengguna;?>" required> 
                    <!-- kirim kode_fk berdasarkan kode_item_pengajuan dari barang yang terpilih -->
                    <input class="form-control" type="hidden" id="kode_fk" name="kode_fk" value="<?php echo $barang->kode_item_pengajuan;?>" required>
                    <!-- kirim kode_nama_progress = 2 untuk tolak -->
                    <input type="hidden" class="form-control" placeholder id="kode_nama_progress" name="kode_nama_progress" required value="2">
                    <label class="col-lg-4 col-sm-2 control-label">Komentar Penolakan:</label>
                    <div class="modal-body">
                      <input class="form-control" type="hidden" id="jenis_progress" name="jenis_progress" value="barang" required>
                      <textarea name="komentar" value="" class="form-control" placeholder="Komentar" rows="3" required></textarea>
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
      <!-- END Modal Tolak Item Pengajuan-->

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
</section>
<div class="text-center">
  <div class="credits">
    <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
  </div>
</div>
</section>

<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
