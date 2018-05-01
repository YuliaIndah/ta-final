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
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Nama Item Pengajuan Barang</th>
                    <th>Nama Pengaju</th>
                    <th>Jabatan Pengaju</th>
                    <th>Merk</th>
                    <th>Tgl Pengajuan</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Url</th>
                    <th>Total Harga</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($data_pengajuan_all as $barang) {
                    ?>
                    <tr class="text-center" >
                      <td><?php echo $no ?></td>
                      <td><?php echo $barang->nama_barang ?></td>
                      <td><?php echo $barang->nama_item_pengajuan ?></td>
                      <td><?php echo $barang->nama ?></td>
                      <td><?php echo $barang->nama_jabatan;?></td>
                      <td><?php echo $barang->merk ?></td>
                      <td><?php echo $barang->tgl_item_pengajuan;?></td>
                      <td><?php echo $barang->harga_satuan ?></td>
                      <td><?php echo $barang->jumlah;?></td>
                      <?php 
                      $jumlah = $barang->jumlah;
                      $harga = $barang->harga_satuan;
                  //menghitung hasil total biaya item pengajuan dari perkalian harga satuan dengan jumlah barang
                      $total = $jumlah*$harga;
                      ?>
                      <td><?php echo $barang->url ?></td>
                      <td><?php echo $total;?></td>
                    </tr>
                    <?php
                    $no++;
                  }
                  ?>
                </tbody>
              </table>
              <center>
                <a  class="btn btn-info" href="<?php echo base_url("ExcelC/export"); ?>">Export ke Excel</a>
              </center>
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

