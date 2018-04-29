 <td class="text-center">
  <?php 
  if($progress_tolak == 1){
    ?>
    <a class="label label-danger" href="#modal_progress" id="custID" data-toggle="modal" data-id="<?php echo $kegiatan->kode_kegiatan;?>" title="klik untuk melihat detail progress"><b>Selesai</b></a>
    <?php
  }else{
   if($progress == 1){
                            if($unit->kode_unit == 1 && $jabatan->kode_jabatan == 1){ //kepala departemen
                             ?>
                             <a class="label label-success" href="#modal_progress" id="custID" data-toggle="modal" data-id="<?php echo $kegiatan->kode_kegiatan;?>" title="klik untuk melihat detail progress">Selesai</a>
                             <?php
                           }elseif ($unit->kode_unit == 1 && $jabatan->kode_jabatan == 2){ //sekretaris departemen
                            ?>
                            <a class="label label-info" id="custID" data-toggle="modal" title="klik untuk melihat detail progress">Baru</a>
                            <?php
                          }elseif (($unit->kode_unit != 1 && $jabatan->kode_jabatan == 1) || ($unit->kode_unit != 1 && $jabatan->kode_jabatan == 3)) { //kepala/manajer
                            ?>
                            <a class="label label-info" id="custID" data-toggle="modal" title="klik untuk melihat detail progress">Baru</a>
                            <?php
                          }else{
                            // echo $unit->kode_unit;
                            // echo $jabatan->kode_jabatan;
                            ?>
                            <a class="label label-default" href="#modal_progress" id="custID" data-toggle="modal" data-id="<?php echo $kegiatan->kode_kegiatan;?>" title="klik untuk melihat detail progress">Proses</a>
                            <?php
                          }
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