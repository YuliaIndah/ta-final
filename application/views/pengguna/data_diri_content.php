<section id="main-content">
  <section class="wrapper">            
    <!--overview start-->
    <div class="row">
      <div class="col-lg-12">
        <h3 class="page-header" style="margin-top: 0;"><i class="fa fa-user"></i> Data Diri</h3>
      </div>
    </div>
    <div class="row">
      <div class="container">
       <div class="panel panel-default">
       <!--  <div class="panel-heading">
       </div> -->
       <div class="panel-body">
        <div>
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

          <div style="color: red;"><?php echo (isset($message))? $message : ""; ?></div>
          <!-- sampai sini -->
        </div>
        <div class="hover thumbnail col-lg-2 col-md-3 col-sm-4 col-xs-12">
          <?php
          if($data_diri->file_profil){
            ?>
            <img class="image " style="width:100%;" src="<?php echo base_url()."assets/image/profil/".$data_diri->file_profil;?>">
            <?php
          }else{
           ?> 
           <img class="image " style="width:100%;" src="<?php echo base_url()?>assets/image/logo/img_avatar.png">
           <?php
         }
         ?>
         <div class="middle">
          <label for="upload"><a href="#" class="btn btn-primary" data-target="#myModal" data-id="profil" data-toggle="modal"><i class="glyphicon glyphicon-camera"></i> Ganti Foto</a></label>
        </div>
      </div>
      <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
        <ul>
          <li><h2><?php echo $data_diri->nama;?></h2></li>
          <li><h4><?php echo $data_diri->no_identitas;?></h4></li>
          <li><h4><?php echo $data_diri->nama_jabatan." ". $data_diri->nama_unit;?></h4></li>
          <br>
        </ul>
      </div>  
    </div>
    <table class="table table-striped  table-hover table-condensed">
      <tr>
        <td class="default" width="23%" style="padding-left: 30px;">Jenis Kelamin</td>
        <td>: &nbsp;<?php echo $data_diri->jen_kel;?></td>
      </tr>
      <tr>
        <td class="default" width="23%" style="padding-left: 30px;">Tempat Lahir</td>
        <td>: &nbsp;<?php echo $data_diri->tmp_lahir;?></td>
      </tr>
      <tr>
        <?php
        $tgl_lahir = $data_diri->tgl_lahir;
        $new_tgl_lahir = date('d-m-Y', strtotime($tgl_lahir));
        ?>
        <td class="default" width="23%" style="padding-left: 30px;">Tanggal Lahir</td>
        <td>: &nbsp;<?php echo $new_tgl_lahir;?></td>
      </tr>
      <tr>
        <td class="default" width="23%" style="padding-left: 30px;">Alamat</td>
        <td>: &nbsp;<?php echo $data_diri->alamat;?></td>
      </tr>
      <tr>
        <td class="default" width="23%" style="padding-left: 30px;">No. Handphone</td>
        <td>: &nbsp;<?php echo $data_diri->no_hp;?></td>
      </tr>
      <tr>
        <!-- <td colspan="2" style="padding-left: 30px;"><button class="btn btn-info active" style="width: 75px;">Ubah</button></td> -->
        <td colspan="2" style="padding-left: 30px;"><a class="btn btn-primary" style="width: 75px;"
          href="javascript:;"
          data-jen_kel="<?php echo $data_diri->jen_kel;?>"
          data-tmp_lahir="<?php echo $data_diri->tmp_lahir;?>"
          data-tgl_lahir="<?php echo $data_diri->tgl_lahir;?>"
          data-alamat="<?php echo $data_diri->alamat;?>"
          data-no_hp="<?php echo $data_diri->no_hp?>"
          data-toggle="modal" data-target="#edit-data">
          Ubah
        </a>
      </tr>
    </table>
    <div class="panel-footer"></div>
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

<script>
  $(document).ready(function() {
        // Untuk sunting
        $('#edit-data').on('show.bs.modal', function (event) {
            var div   = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)

            // Isi nilai pada field
            // modal.find('#jen_kel').attr("value",div.data('jen_kel'));
            modal.find('#tmp_lahir').attr("value",div.data('tmp_lahir'));
            modal.find('#tgl_lahir').attr("value",div.data('tgl_lahir'));
            modal.find('#alamat').attr("value",div.data('alamat'));
            modal.find('#no_hp').attr("value",div.data('no_hp'));
          });

        $('#myModal').on('show.bs.modal', function (event) {

        });


      });


    </script>

    <!-- Modal Ubah -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="edit-data" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Ubah Data</h4>
          </div>
          <form class="form-horizontal" action="<?php echo base_url('KadepC/edit_data_diri')."/".$data_diri->no_identitas?>" method="post" enctype="multipart/form-data" role="form">
            <div class="modal-body">
              <div class="form-group">
                <label class="col-lg-4 col-sm-2 control-label">Jenis Kelamin</label>
                <div class="col-lg-8" style="margin-top: 7px;">
                  <!-- <input type="text" class="form-control" id="jen_kel" name="jen_kel" placeholder="Tampat Lahir"> -->
                  <?php 
                  if($data_diri->jen_kel == "Laki - laki"){
                    ?>
                    <input type="radio" name="jen_kel" id="Laki - laki" value="Laki - laki" checked> Laki - laki
                    <input style="margin-left: 10px;" type="radio" name="jen_kel" id="Perempuan" value="Perempuan"> Perempuan
                    <?php
                  }else{
                    ?>
                    <input type="radio" name="jen_kel" id="Laki - laki" value="Laki - laki" > Laki - laki
                    <input style="margin-left: 10px;" type="radio" name="jen_kel" id="Perempuan" value="Perempuan" checked > Perempuan
                    <?php
                  }
                  ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 col-sm-2 control-label">Tempat Lahir</label>
                <div class="col-lg-8">
                  <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir" placeholder="Tampat Lahir">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 col-sm-2 control-label">Tanggal Lahir</label>
                <div class="col-lg-8">
                  <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 col-sm-2 control-label">Alamat</label>
                <div class="col-lg-8">
                  <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 col-sm-2 control-label">No Handphone</label>
                <div class="col-lg-8">
                  <input type="text" onkeypress="return hanyaAngka(event)" class="form-control" id="no_hp" name="no_hp" placeholder="No. Handphone">
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
  <!-- END Modal Ubah -->



  <div aria-hidden="true" aria-labelledby="myModal" role="dialog" tabindex="-1" id="myModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
          <h4 class="modal-title">Upload Foto Profil</h4>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel-body">
              <?php echo form_open_multipart('KadepC/upload_image');?>
              <form role="form" action="<?php echo base_url(); ?>KadepC/upload_image" method="post">
                <div style="color: red;"><?php echo (isset($message))? $message : ""; ?></div>
                <div class="form-group">
                  <label>Unggah Foto</label>
                  <input type="file" name="foto_profil">
                  <input type="hidden" name="id_pengguna" id="id_pengguna" value="<?php echo $data_diri->id_pengguna;?>">
                </div>
              </div> 
              <!-- <button type="reset" class="btn btn-default">Reset Button</button> -->
              <div class="modal-footer">
                <input type="submit" class="btn btn-primary col-lg-2 pull-left"  value="Kirim">
              </div> 
              <?php echo form_close()?>
            </form>
          </div>
          <div class="col-lg-1"></div>
        </div>
      </div>
    </div>
  </div>

  <style>
  .hover {
    position: relative;
    width: 20%;
  }

  .image {
    opacity: 1;
    display: block;
    width: 100%;
    height: auto;
    transition: .5s ease;
    backface-visibility: hidden;
  }

  .middle {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%)
  }

  .hover:hover .image {
    opacity: 0.3;
  }

  .hover:hover .middle {
    opacity: 1;
  }
</style>


