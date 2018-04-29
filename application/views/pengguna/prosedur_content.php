<section id="main-content">
  <section class="wrapper">            
    <!--overview start-->
    <div class="row">
      <div class="col-lg-12">

        <h3 class="page-header text-center" style="margin-top: 0;"> Prosedur Pengajuan Kegiatan dan Pengadaan Barang</h3>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-12">

       <?php
       // var_dump($data_prosedur); 
       $data=$this->session->flashdata('sukses');
       if($data!=""){ ?>
       <div class="alert alert-success"><strong>Sukses! </strong> <?=$data;?></div>
       <?php } ?>
       <?php 
       $data2=$this->session->flashdata('error');
       if($data2!=""){ ?>
       <div class="alert alert-danger"><strong> Error! </strong> <?=$data2;?></div>
       <?php } ?>

       <div class="card mb-3">
        <div class="card-header">
          <div class="card-body">
            <a class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="icon_plus_alt2"> </i>Tambah Prosedur</a>

            <div class="table-responsive">
              <table id="prosedur" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="text-center" width="15px;">No.</th>
                    <th class="text-center">Tipe Prosedur</th>
                    <th class="text-center">Ukuran File</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Tanggal Upload</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Asksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($data_prosedur as $prosedur) {
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $i;?></td>
                      <td class="text-center"><?php echo $prosedur->tipe_doc; ?></td>
                      <td class="text-center"><?php echo $prosedur->size; ?></td>

                      <?php $link = base_url()."assets/file_prosedur/".$prosedur->nama_file;?>
                      <td class="text-center"><a target="_blank" href="<?php echo $link?>"><span><img src="<?php echo base_url()?>assets/image/logo/pdf.svg" style="height: 30px;"></span></a></td>
                      <td class="text-center"><?php echo $prosedur->created_at; ?></td>
                      <td class="text-center"><?php echo $prosedur->status; ?></td>
                      <td class="text-center">
                        <?php 
                        if($prosedur->status == "aktif"){ ?>
                        <a  data-toggle='tooltip' title='Aktif' class="btn btn-info btn-sm" disabled><span class="glyphicon glyphicon-ok"></span></a>
                        <a data-toggle='tooltip' title='Non-aktif' class="btn btn-danger btn-sm" href="<?php echo base_url('KadepC/non_aktif_pro')."/".$prosedur->kode_doc;?>" ><span class="glyphicon glyphicon-remove"></span></a> 
                        <?php
                      }else{
                        ?>  
                        <a  data-toggle='tooltip' title='Aktif' class="btn btn-info btn-sm" href="<?php echo base_url('KadepC/aktif_pro')."/".$prosedur->kode_doc;?>"><span class="glyphicon glyphicon-ok"></span></a>
                        <a data-toggle='tooltip' title='Non-aktif' class="btn btn-danger btn-sm" disabled><span class="glyphicon glyphicon-remove"></span></a>
                        <?php
                      }
                      ?>



                    </tr>
                    <?php
                    $i++;
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

<div aria-hidden="true" aria-labelledby="myModal" role="dialog" tabindex="-1" id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Tambah Prosedur</h4>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="panel-body">
            <?php echo form_open_multipart('KadepC/post_prosedur');?>
            <form role="form" action="<?php echo base_url(); ?>KadepC/post_prosedur" method="post">
              <!-- Alert -->
              <!-- sampai sini -->
              <div class="form-group">
                <select class="form-control" name="tipe_doc" id="tipe_doc" required>
                  <option value="">---- Pilih Tipe Prosedur ---- </option>
                  <option value="pegawai"> Prosedur Pengajuan Kegiatan Pegawai</option>
                  <option value="mahasiswa">Prosedur Pengajuan Kegiatan Mahasiswa</option>
                  <option value="barang">Prosedur Pengajuan Barang</option>
                </select>
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
        </div>
        <div class="col-lg-1"></div>
      </div>
    </div>
  </div>
</div>