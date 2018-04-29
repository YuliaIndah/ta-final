<form class="form-horizontal" action="<?php echo base_url(); ?>KadepC/post_progress" method="post">
    <div class="form-group">
        <label class="control-label col-sm-5" for="nama_kegiatan" style="text-align: left;">Nama Kegiatan</label>
        <div class="col-sm-5">
            <p class="form-control-static"> <?php echo ": ".$detail_kegiatan->nama_kegiatan; ?> </p>
        </div>
        <input type="hidden" name="kode_fk" value="<?php echo $detail_kegiatan->kode_kegiatan?>"> <!-- buat input ke tabel progress -->
        <input type="hidden" name="id_pengguna" value="<?php echo $data_diri->id_pengguna;?>"> <!-- buat input ke tabel progress -->

        <input type="hidden" name="jenis_progress" id="jenis_progress" value="kegiatan"> <!-- buat input ke tabel progress -->
        
    </div>
    <div class="form-group">
        <label class="control-label col-sm-5" for="tgl_pengajuan" style="text-align: left;">Tanggal Pengajuan Kegiatan</label>
        <div class="col-sm-5">
            <?php
            $tgl_pengajuan = $detail_kegiatan->tgl_pengajuan;
            $new_tgl_pengajuan = date('d-m-Y',strtotime($tgl_pengajuan));
            ?>
            <p class="form-control-static"> <?php echo ": ".$new_tgl_pengajuan; ?> </p>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-5" for="tgl_kegiatan" style="text-align: left;">Tanggal Pelaksanaan Kegiatan</label>
        <div class="col-sm-5">
            <?php
            $tgl_mulai = $detail_kegiatan->tgl_kegiatan;
            $new_tgl_mulai = date('d-m-Y',strtotime($tgl_mulai));
            $tgl_selesai = $detail_kegiatan->tgl_selesai_kegiatan;
            $new_tgl_selesai = date('d-m-Y', strtotime($tgl_selesai));
            ?>
            <p class="form-control-static"> <?php echo ": ".$new_tgl_mulai." - ".$new_tgl_selesai; ?> </p>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-5" for="dana_diajukan" style="text-align: left;">Dana Yang Diajukan</label>
        <div class="col-sm-5">
            <p class="form-control-static"> <?php echo ": Rp".$detail_kegiatan->dana_diajukan.",-"; ?> </p>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-5" for="dana_disetujui" style="text-align: left;">Dana Yang Disetujui</label>
        <div class="col-sm-5">
            <p class="form-control-static"> <?php echo ": Rp".$detail_kegiatan->dana_disetujui.",-"; ?> </p>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-5" for="status" name="kode_nama_progress" id="kode_nama_progress" style="text-align: left;">Status</label>
        <div class="col-sm-5">
            <select class="form-control" name="kode_nama_progress" id="kode_nama_progress">
                <!-- <option> ----- pilih nama progress ----- </option> -->
                <?php 
                foreach ($nama_progress as $nama_progress) {
                    ?>
                    <option value="<?php echo $nama_progress->kode_nama_progress ;?>"> <?php echo $nama_progress->nama_progress ;?> </option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-5" for="komentar" style="text-align: left;">Komentar</label>
        <div class="col-sm-5">
            <textarea name="komentar" id="komentar" class="form-control" id="focusedInput"> </textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-5"></div>
        <div class="col-sm-5">
            <button class="btn btn-info">Simpan</button>
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button> -->
        </div>
    </div>
</form>