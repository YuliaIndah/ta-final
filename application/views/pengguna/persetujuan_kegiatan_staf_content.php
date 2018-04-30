<section id="main-content">
  <section class="wrapper">            
    <!--overview start-->
    <div class="row">
      <div class="col-lg-12">
        <h3 class="page-header text-center" style="margin-top: 0;">Persetujuan Kegiatan Staf</h3>
       <!--  <ol class="breadcrumb">
          <li><i class="fa fa-user"></i><a href="#">Kepala Departemen</a></li>
          <li><i class="fa fa-pencil"></i>Pengajuan Kegiatan</li>                
        </ol> -->
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
       
       <div class="card mb-3">
        <div class="card-header">
          <div class="card-body">
            <div class="table-responsive">
              <?php
                  // var_dump($detail_kegiatan);
              ?>
              <table id="example" class="table table-striped table-bordered table-condensed" cellspacing="0" width="100%">
                <thead>
                 <tr class="text-center">
                  <th class="text-center">Nama Kegiatan</th>
                  <th class="text-center">Nama Pengaju</th>
                  <th class="text-center">Jabatan Pengaju</th>
                  <th class="text-center">Tgl Pengajuan</th>
                  <th class="text-center">Tgl Kegiatan</th>
                  <th class="text-center">Dana Diajukan</th>
                  <th class="text-center">File</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // print_r($data_pengajuan_kegiatan);
                foreach ($data_pengajuan_kegiatan as $kegiatan) {
                  $jabatan        = $UserM->get_data_pengajuan_by_id_staf($kegiatan->kode_kegiatan)->result();
                  $unit           = $UserM->get_data_pengajuan_by_id_staf($kegiatan->kode_kegiatan)->result();
                  // print_r($kegiatan->kode_kegiatan);
                  ?>
                  <tr>
                    <td class="text-center relative">
                      <div class="relative">
                        <strong><?php echo $kegiatan->nama_kegiatan;?></strong>
                        <a href="#myModal1" id="custID" data-toggle="modal" data-id="<?php echo $kegiatan->kode_kegiatan;?>" title="klik untuk melihat detail kegiatan"><small class="kecil">Lihat detail</small></a>
                      </div>
                    </td>
                    <td><?php echo $kegiatan->nama;?></td>
                    <td><?php echo $kegiatan->nama_jabatan;?></td>
                    <!-- <td class="text-center"><?php echo $jabatan->nama;?></td> -->
                    <!-- <td class="text-center"><?php echo $jabatan->nama_jabatan." ".$unit->nama_unit;?></td> -->
                    <?php 
                    $tgl_pengajuan = $kegiatan->tgl_pengajuan;
                    $new_tgl_pengajuan = date('d-m-Y',strtotime($tgl_pengajuan));
                    $tgl_kegiatan = $kegiatan->tgl_kegiatan;
                    $new_tgl_kegiatan = date('d-m-Y', strtotime($tgl_kegiatan));
                    $tgl_selesai = $kegiatan->tgl_selesai_kegiatan;
                    $new_tgl_selesai = date('d-m-Y', strtotime($tgl_selesai));
                    ?>
                    <td class="text-center"><?php echo $new_tgl_pengajuan; ?></td>
                    <td class="text-center">
                      <div class="relative">
                       <small class="kecil"><strong><?php echo $new_tgl_kegiatan?></strong></small>
                       <small class="kecil">sampai</small>
                       <small class="kecil"><strong><?php echo $new_tgl_selesai; ?></strong></small>
                     </div>
                   </td>
                   <td><?php echo $kegiatan->dana_diajukan;?></td>
                   <?php $link = base_url()."assets/file_upload/".$kegiatan->nama_file;?>
                   <td class="text-center"><a target="_blank" href="<?php echo $link?>"><span><img src="<?php echo base_url()?>assets/image/logo/pdf.svg" style="height: 30px;"></span></a></td>
                   <!-- <td><?php echo $kegiatan->nama;?></td> -->
                   <!-- <td><?php echo $kegiatan->nama_jabatan." ".$kegiatan->nama_unit;?></td> -->
                   <td class="text-center">
                    <?php 
                    $progress       = $UserM->get_progress($kegiatan->kode_kegiatan);
                    $progress_tolak = $UserM->get_progress_tolak($kegiatan->kode_kegiatan);
                          // echo $progress;
                          // echo $progress_tolak;
                    if($progress_tolak == 1){
                      ?>
                      <a class="label label-danger" href="#modal_progress" id="custID" data-toggle="modal" data-id="<?php echo $kegiatan->kode_kegiatan;?>" title="klik untuk melihat detail progress"><b>Selesai</b></a>
                      <?php
                    }else{
                     if($progress == 1){
                      ?>
                      <a class="label label-default" href="#modal_progress" id="custID" data-toggle="modal" data-id="<?php echo $kegiatan->kode_kegiatan;?>" title="klik untuk melihat detail progress">Proses</a>
                      <?php
                    }elseif ($progress > 1) {
                      ?>
                      <a class="label label-success" href="#modal_progress" id="custID" data-toggle="modal" data-id="<?php echo $kegiatan->kode_kegiatan;?>" title="klik untuk melihat detail progress">Selesai</a>
                      <?php
                    }elseif ($progress == 0) {
                      ?>
                      <a class="label label-info" id="custID" data-toggle="modal" title="klik untuk melihat detail progress">Baru</a>
                      <?php
                    }
                  }
                  ?>
                </td>
                <td class="text-center">
                  <?php 
                  $kode = $kegiatan->kode_kegiatan;
                  $id   = $data_diri->id_pengguna;
                  $own  = $UserM->get_own_progress($kode, $id);
                        // print_r($own);
                  if($own > 0){
                    ?>
                    <a href="#" disabled title="Sudah"><span class="glyphicon glyphicon-ok"></a>
                      <?php
                    }elseif ($own == 0) {
                      ?>
                      <a href="#myModal" id="custId" data-toggle="modal" data-id="<?php echo $kegiatan->kode_kegiatan;?>" data-toggle="tooltip" title="Masukkan Persetujuan" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-edit"></span></a>
                      <?php
                    }
                    ?>

                  </td>
                </tr>
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


<!-- modal persetujuan kegiatan -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Persetujuan Kegiatan</h4>
      </div>
      <div class="modal-body">
        <div class="fetched-data"></div>
      </div>
    </div>
  </div>
</div>

<!-- modal detail kegiatan -->
<div class="modal fade" id="myModal1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Kegiatan</h4>
      </div>
      <div class="modal-body">
        <div class="fetched-data"></div>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    // js persetujuan kegiatan
    $(document).ready(function(){
      $('#myModal').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        var kode  = 3;
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
              type : 'get',
              url : '<?php echo base_url().'Man_keuanganC/detail_pengajuan/'?>'+rowid,
                //data :  'rowid='+ rowid, // $_POST['rowid'] = rowid
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
              }
            });
          });
    });

    // js detail_kegiatan
    $(document).ready(function(){
      $('#myModal1').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
              type : 'get',
              url : '<?php echo base_url().'Man_keuanganC/detail_kegiatan/'?>'+rowid,
                //data :  'rowid='+ rowid, // $_POST['rowid'] = rowid
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
              }
            });
          });
    });

  </script>
