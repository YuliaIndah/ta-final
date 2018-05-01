<form class="form-horizontal" action="" method="post">
    <div class="form-group">
        <div class="thumbnail col-sm-3" style="margin:2% 0 0 5%;">
          <?php
          if($data_pengguna->file_profil){
            ?>
            <img class="image " style="width:100%;" src="<?php echo base_url()."assets/image/profil/".$data_pengguna->file_profil;?>">
            <?php
          }else{
           ?> 
           <img class="image " style="width:100%;" src="<?php echo base_url()?>assets/image/logo/img_avatar.png">
           <?php
         }
         ?>
        </div>
      </div>
    </div>

    <!-- <?php var_dump($data_pengguna->nama); ?> -->
    <div class="form-group">
        <label class="control-label col-sm-4" for="tgl_pengajuan" style="text-align: left;">Nama Lengkap</label>
        <div class="col-sm-6">
            <p class="form-control-static"> <?php echo ": ".$data_pengguna->nama; ?> </p>
        </div>
        <label class="control-label col-sm-4" for="tgl_pengajuan" style="text-align: left;">Jenis Kelamin</label>
        <div class="col-sm-6">
            <p class="form-control-static"> <?php echo ": ".$data_pengguna->jen_kel; ?> </p>
        </div>
        <label class="control-label col-sm-4" for="tgl_pengajuan" style="text-align: left;">Tempat, Tanggal Lahir</label>
        <div class="col-sm-6">
           <?php
           $tgl_lahir = $data_pengguna->tgl_lahir;
           $new_tgl_lahir = date('d-m-Y', strtotime($tgl_lahir));
           ?>
           <p class="form-control-static"> <?php echo ": ".$data_pengguna->tmp_lahir.", ".$new_tgl_lahir; ?> </p>
        </div>
        <label class="control-label col-sm-4" for="tgl_pengajuan" style="text-align: left;">Alamat Lengkap</label>
        <div class="col-sm-6">
            <p class="form-control-static"> <?php echo ": ".$data_pengguna->alamat; ?> </p>
        </div>
        <label class="control-label col-sm-4" for="tgl_pengajuan" style="text-align: left;">No Handphone</label>
        <div class="col-sm-6">
            <p class="form-control-static"> <?php echo ": ".$data_pengguna->no_hp;?> </p>
        </div>
        <label class="control-label col-sm-4" for="tgl_pengajuan" style="text-align: left;">Jabatan</label>
        <div class="col-sm-6">
            <p class="form-control-static"> <?php echo ": ".$data_pengguna->nama_jabatan." ".$data_pengguna->nama_unit;?> </p>
        </div>
        <label class="control-label col-sm-4" for="tgl_pengajuan" style="text-align: left;">Email</label>
        <div class="col-sm-6">
            <p class="form-control-static"> <?php echo ": ".$data_pengguna->email;?> </p>
        </div>
   </div>
</form>