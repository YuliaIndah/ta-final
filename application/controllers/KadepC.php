<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KadepC extends CI_Controller {

	var $data = array();

	public function __construct(){
		parent::__construct();
		$this->load->model(['UserM','KadepM']);
		Kadep_access(); //helper buat batasi akses login/session
	}

	// sebagai semua
	public function data_diri(){ //halaman data diri
		$data['title'] = "Data Diri | Kepala Departemen";
		$this->data['data_diri'] = $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('kadep/data_diri_content', $this->data, true) ;
		$this->load->view('kadep/index_template', $data);
	}

	// Sebagai kepala Departemen
	public function index(){ //halaman index kadep (dashboard)
		$data['title'] = "Beranda | Kepala Departemen";
		$this->data['data_diri'] = $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('kadep/index_content', $this->data, true) ;
		$this->load->view('kadep/index_template', $data);
	}

	public function prosedur(){ //halaman index kadep (dashboard)
		$data['title'] = "Prosedur | Kepala Departemen";
		$this->data['data_diri'] = $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$this->data['data_prosedur'] = $this->UserM->get_prosedur()->result();
		$data['body'] = $this->load->view('kadep/prosedur_content', $this->data, true) ;
		$this->load->view('kadep/index_template', $data);
	}

	public function aktif_pro($kode_doc){ //aktifasi akun pengguna
		$this->KadepM->aktif_pro($kode_doc);
		redirect('KadepC/prosedur');
	}

    public function non_aktif_pro($kode_doc){ //deaktifasi akun pengguna
    	$this->KadepM->non_aktif_pro($kode_doc);
    	redirect('KadepC/prosedur');
    }

	public function post_prosedur(){ //fungsi post pengajuan kegiatan pegawai
		$this->form_validation->set_rules('tipe_doc', 'Tipe Dokumen','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data Prosedur anda tidak berhasil ditambahkan');
			redirect('KadepC/prosedur');
		}else{

			$tipe_doc 	       		= $_POST['tipe_doc'];
			$status 				= $_POST['status'];
			
			$data_prosedur = array(
				'tipe_doc' 			=> $tipe_doc,
				'status' 			=> $status);


			$upload = $this->UserM->upload_prosedur(); // lakukan upload file dengan memanggil function upload yang ada di UserM.php
			if($upload['result'] == "success"){ // Jika proses upload sukses
				$this->UserM->save_prosedur($upload, $data_prosedur); // Panggil function save_prosedur yang ada di UserM.php untuk menyimpan data ke database
			}else{ // Jika proses upload gagal
				$data['message'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
				$this->session->set_flashdata('error','Data Pengajuan Kegiatan anda tidak berhasil ditambahkan');
				redirect('KadepC/prosedur');
			}
			$this->session->set_flashdata('sukses','Data Pengajuan Kegiatan anda berhasil ditambahkan');
			redirect('KadepC/prosedur');
		}
	}

	function upload_image(){
		$id_pengguna=$this->input->post('id_pengguna');

        $config['upload_path'] = './assets/image/profil'; //path folder
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = FALSE; //Enkripsi nama yang terupload
        $config['overwrite'] = TRUE;
        $new_name = md5($id_pengguna);
        $config['file_name'] = $new_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if(!empty($_FILES['foto_profil']['name'])){

        	if ($this->upload->do_upload('foto_profil')){
        		$gbr = $this->upload->data();
                //Compress Image
        		$config['image_library']='gd2';
        		$config['source_image']='./assets/image/profil/'.$gbr['file_name'];
        		$config['create_thumb']= FALSE;
        		$config['maintain_ratio']= FALSE;
        		$config['quality']= '50%';
        		$config['width']= 100;
        		$config['height']= 100;
        		$config['new_image']= './assets/image/profil/'.$gbr['file_name'];
        		$this->load->library('image_lib', $config);
        		// $this->image_lib->crop();
        		$this->image_lib->resize();

        		$gambar=$gbr['file_name'];
        		$this->UserM->simpan_upload($id_pengguna,$gambar);
        		$this->session->set_flashdata('sukses','Foto berhasil diunggah');
        		redirect('KadepC/data_diri');
        		// echo "Image berhasil diupload";
        	}

        }else{
        	$this->session->set_flashdata('error','Foto tidak berhasil diunggah');
        	redirect('KadepC/data_diri');
        }

    }

    public function post_ganti_password(){
    	$this->form_validation->set_rules('sandi_lama', 'Sandi Lama', 'trim|required|min_length[6]|max_length[50]');
    	$this->form_validation->set_rules('sandi_baru', 'Sandi Baru', 'trim|required|min_length[6]|max_length[50]');
    	$this->form_validation->set_rules('konfirmasi_sandi_baru', 'Konfirmasi Sandi Baru', 'trim|required|min_length[6]|max_length[50]|matches[sandi_baru]'); 
    	if ($this->form_validation->run() == FALSE)  
    	{  
    		redirect_back();
    	}else{ 
    		$sandi_lama   = $_POST['sandi_lama'];  
    		$sandi_baru   = $_POST['sandi_baru'];  
    		$id_pengguna  = $_POST['id_pengguna']; 

    		$sandi_baru   = $_POST['sandi_baru'];  
    		$passhash     = md5($sandi_baru);

    		$data_update  = array(
    			'password'        => $passhash);

    		$ada = $this->UserM->cek_row($id_pengguna, $sandi_lama);
    		if($ada > 0){
    			if($this->UserM->update_pass($id_pengguna, $data_update)){
    				$this->session->set_flashdata('sukses','Data berhasil dirubah');
    				redirect('KadepC/pengaturan_akun');
    			}else{
    				$this->session->set_flashdata('error','Data tidak berhasil dirubah');
    				redirect('KadepC/pengaturan_akun');
    			}
    		}else{
    			$this->session->set_flashdata('error','Kata sandi lama tidak cocok');
    			redirect('KadepC/pengaturan_akun');
    		}	
    	}
    }

	public function persetujuan_kegiatan_mahasiswa(){ //halaman persetujuan kegiatan mahasiswa (kadep)
		// menampilkan kegiatan mahasiswa yang telah di beri porgress oleh manajer Keuangan
		$id_pengguna = $this->session->userdata('id_pengguna');
		$kode_jenis_kegiatan = 2; //kegiatan mahasiswa
		$data['title'] = "Persetujuan Kegiatan Mahasiswa | Kepala Departemen";
		$this->data['data_pengajuan_kegiatan_mahasiswa'] = $this->UserM->get_data_pengajuan($kode_jenis_kegiatan)->result();
		
		$this->data['UserM'] = $this->UserM ;
		$this->data['cek_max'] = $this->UserM->cek_max();
		$this->data['cek_id_staf_keu'] = $this->UserM->cek_id_staf_keu()->result();	
		$this->data['KadepM'] = $this->KadepM ;	
		$this->data['data_diri'] = $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('kadep/persetujuan_kegiatan_mahasiswa_content', $this->data, true) ;
		$this->load->view('kadep/index_template', $data);
	}

	public function persetujuan_kegiatan_pegawai(){ //halaman persetujuan kegiatan pegawai (kadep)
		$no_identitas = $this->session->userdata('no_identitas');
		$kode_jenis_kegiatan = 1; //kegiatan pegawai
		$data['title'] = "Persetujuan Kegiatan Pegawai | Kepala Departemen";
		$this->data['data_pengajuan_kegiatan_pegawai'] = $this->UserM->get_data_pengajuan($kode_jenis_kegiatan)->result();
		$this->data['UserM'] = $this->UserM ;	
		$this->data['cek_id_staf_keu'] = $this->UserM->cek_id_staf_keu()->result();
		$this->data['cek_max_pegawai'] = $this->UserM->cek_max_pegawai();	
		$this->data['KadepM'] = $this->KadepM ;	
		$this->data['data_diri'] = $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('kadep/persetujuan_kegiatan_pegawai_content', $this->data, true) ;
		$this->load->view('kadep/index_template', $data);
	}

	public function pengaturan_akun(){ //halaman pengaturan akun
		$data['title'] = "Pengaturan Akun | Kepala Departemen";
		$this->data['data_diri'] = $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('kadep/pengaturan_akun_content', $this->data, true) ;
		$this->load->view('kadep/index_template', $data);
	}

	public function aktif($id_pengguna){ //aktifasi akun pengguna
		if($this->KadepM->aktif($id_pengguna)){
			$this->session->set_flashdata('sukses','Akun berhasil diaktifkan');	
			redirect('KadepC/pengguna');
		}else{
			$this->session->set_flashdata('error','Akun tidak berhasil diaktifkan');	
			redirect('KadepC/pengguna');
		}
	}

    public function non_aktif($id_pengguna){ //deaktifasi akun pengguna
    	if($this->KadepM->non_aktif($id_pengguna)){
    		$this->session->set_flashdata('sukses','Akun berhasil di non-aktifkan');	
    		redirect('KadepC/pengguna');
    	}else{
    		$this->session->set_flashdata('error','Akun tidak berhasil di non-aktifkan');	
    		redirect('KadepC/pengguna');
    	}
    }

 	// sebagai pegawai
	public function pengajuan_kegiatan(){ //halaman pengajuan kegiatan
		$data['title'] = "Pengajuan Kegiatan | Kepala Departemen";
		$this->data['data_diri'] = $this->UserM->get_data_diri()->result()[0]; //get data diri buat nampilin nama di pjok kanan
		$this->data['cek_max_pegawai'] = $this->UserM->cek_max_pegawai();	
		$this->data['cek_id_staf_keu'] = $this->UserM->cek_id_staf_keu()->result();
		$this->data['data_kegiatan'] = $this->UserM->get_kegiatan_pegawai()->result();	//menampilkan kegiatan yang diajukan user sebagai pegwai
		$this->data['UserM'] = $this->UserM ;	
		$data['body'] = $this->load->view('kadep/pengajuan_kegiatan_content', $this->data, true);
		$this->load->view('kadep/index_template', $data);
	}

	// sebagai admin

	public function pengguna(){//halaman pengguna (admin)
		$data['title'] = "Daftar Pengguna | Kepala Departemen";
		$this->data['data_pengguna'] = $this->KadepM->get_data_pengguna()->result();
		$this->data['data_diri'] = $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('kadep/pengguna_content', $this->data, true);
		$this->load->view('kadep/index_template', $data);
	}

	public function jabatan(){ //halaman jabatan
		$data['title'] = "Daftar Jabatan | Kepala Departemen";
		$this->data['data_diri'] = $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('kadep/jabatan_content', $this->data, true);
		$this->load->view('kadep/index_template', $data);
	}

	public function konfigurasi_sistem(){
		$data['title'] = "Konfigurasi Sistem | Kepala Departemen";
		$this->data['persetujuan_kegiatan']	= $this->UserM->get_persetujuan_kegiatan()->result();
		$this->data['detail_jabatan'] 		= $this->UserM->get_pilihan_jabatan_by_id(1)->result()[0];
		$this->data['nama_pengguna']		= $this->KadepM->get_data_pengguna()->result();
		$this->data['nama_progress']		= $this->UserM->get_nama_progress()->result();
		$this->data['jenis_kegiatan']		= $this->UserM->get_jenis_kegiatan()->result();
		$this->data['jenis_kegiatan_persetujuan']	= $this->UserM->get_jenis_kegiatan()->result();
		$this->data['jenis_barang']			= $this->UserM->get_jenis_barang()->result();
		$this->data['jabatan']				= $this->UserM->get_pilihan_jabatan()->result();
		$this->data['unit']					= $this->UserM->get_pilihan_unit()->result();
		$this->data['data_diri'] 			= $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('kadep/konfigurasi_sistem_content', $this->data, true);
		$this->load->view('kadep/index_template', $data);
	}

	// =============================
	
	public function post_pengajuan_kegiatan_pegawai(){ //fungsi post pengajuan kegiatan pegawai
		$this->form_validation->set_rules('id_pengguna', 'ID Pengguna','required');
		$this->form_validation->set_rules('kode_jenis_kegiatan', 'Kode Jenis Kegiatan','required');
		$this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan','required');
		$this->form_validation->set_rules('tgl_kegiatan', 'Tanggal Kegiatan','required');
		$this->form_validation->set_rules('tgl_selesai_kegiatan', 'Tanggal Selesai Kegiatan','required');
		$this->form_validation->set_rules('dana_diajukan', 'Dana Diajukan','required');
		$this->form_validation->set_rules('tgl_pengajuan', 'Tanggal Pengajuan','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data Pengajuan Kegiatan anda tidak berhasil ditambahkan');
			redirect('KadepC/pengajuan_kegiatan');
		}else{
			$id_pengguna 	       	= $_POST['id_pengguna'];
			$kode_jenis_kegiatan 	= $_POST['kode_jenis_kegiatan'];
			$nama_kegiatan 			= $_POST['nama_kegiatan'];
			$tgl_kegiatan 			= date('Y-m-d',strtotime($_POST['tgl_kegiatan']));
			$tgl_selesai_kegiatan 	= date('Y-m-d',strtotime($_POST['tgl_selesai_kegiatan']));
			$dana_diajukan 			= $_POST['dana_diajukan'];
			$tgl_pengajuan 			= $_POST['tgl_pengajuan'];

			$data_pengajuan_kegiatan = array(
				'id_pengguna' 			=> $id_pengguna,
				'kode_jenis_kegiatan' 	=> $kode_jenis_kegiatan,
				'nama_kegiatan' 		=> $nama_kegiatan,
				'tgl_kegiatan'			=> $tgl_kegiatan,
				'tgl_selesai_kegiatan'	=> $tgl_selesai_kegiatan,
				'dana_diajukan' 		=> $dana_diajukan,
				'tgl_pengajuan'			=> $tgl_pengajuan,
				'pimpinan'				=> $id_pengguna);

			

			$insert_id = $this->UserM->insert_pengajuan_kegiatan($data_pengajuan_kegiatan);
			if($insert_id){ //get last insert id
				$upload = $this->UserM->upload(); // lakukan upload file dengan memanggil function upload yang ada di UserM.php
				if($upload['result'] == "success"){ // Jika proses upload sukses
					$this->UserM->save($upload,$insert_id); // Panggil function save yang ada di UserM.php untuk menyimpan data ke database

					$format_tgl 	= "%Y-%m-%d";
					$tgl_progress 	= mdate($format_tgl);
					$format_waktu 	= "%H:%i:%s";
					$waktu_progress	= mdate($format_waktu);

					$kode_nama_progress	= "1";
					$komentar			= "insert otomatis";
					$jenis_progress		= "kegiatan";

					$data = array(
						'id_pengguna	' 			=> $id_pengguna	,
						'kode_fk'				=> $insert_id,
						'kode_nama_progress' 	=> $kode_nama_progress,
						'komentar'				=> $komentar,
						'jenis_progress'		=> $jenis_progress,
						'tgl_progress'			=> $tgl_progress,
						'waktu_progress'		=> $waktu_progress

					);
					$this->UserM->insert_progress($data); //insert progress langsung ketika mengajukan kegiatan untuk manajer, kepala, dan pimpinan yang lain
				}else{ // Jika proses upload gagal
					$data['message'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
					$this->UserM->delete($insert_id);//hapus data pengajuan kegiatan ketka gagal upload file
					$this->session->set_flashdata('error','Data Pengajuan Kegiatan anda tidak berhasil ditambahkan');
					redirect('KadepC/pengajuan_kegiatan');
				}
				$this->session->set_flashdata('sukses','Data Pengajuan Kegiatan anda berhasil ditambahkan');
				redirect('KadepC/pengajuan_kegiatan');
			}else{
				$this->session->set_flashdata('error','Data Pengajuan Kegiatan anda tidak berhasil ditambahkan');
				redirect('KadepC/pengajuan_kegiatan');
			}
		}
	}

	public function edit_data_diri($no_identitas){ //edit data diri
		$this->form_validation->set_rules('jen_kel', 'Jenis Kelamin','required');
		$this->form_validation->set_rules('tmp_lahir', 'Tempat Lahir','required');
		$this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir','required');
		$this->form_validation->set_rules('alamat', 'Alamat','required');
		$this->form_validation->set_rules('no_hp', 'no_hp','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect('KadepC/pengajuan_kegiatan');
		}else{
			$jen_kel    = $_POST['jen_kel'];
			$tmp_lahir  = $_POST['tmp_lahir'];
			$tgl_lahir  = date('Y-m-d',strtotime($_POST['tgl_lahir']));
			$alamat     = $_POST['alamat'];
			$no_hp      = $_POST['no_hp'];

			$data = array(
				'jen_kel'     => $jen_kel,
				'tmp_lahir'   => $tmp_lahir,
				'tgl_lahir'   => $tgl_lahir,
				'alamat'      => $alamat,
				'no_hp'       => $no_hp
			);

			if($this->UserM->edit_data_diri($no_identitas,$data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect('KadepC/data_diri');
			}else{
				redirect('KadepC/pengajuan_kegiatan');
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			}	
		}
	}

	public function hapus_pengajuan($kode_kegiatan){//hapus pengajuan kegiatan
		if($this->KadepM->hapus_pengajuan($kode_kegiatan)){
			$this->session->set_flashdata('sukses','Data anda berhasil dihapus');
			redirect_back();
		}else{
			$this->session->set_flashdata('error','Data anda tidak berhasil dihapus');
			redirect_back();
		}
	}

	public function detail_pengajuan($id){ //menampilkan modal dengan isi dari detail_pengajuan.php
		$data['detail_kegiatan'] 	= $this->UserM->get_data_pengajuan_by_id($id)->result()[0];
		$data['data_diri'] 			= $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['nama_progress'] 		= $this->UserM->get_pilihan_nama_progress()->result();
		$this->load->view('kadep/detail_pengajuan', $data);
	}

	public function edit_pengajuan($id){ //menampilkan modal dengan isi dari detail_pengajuan.php
		$data['detail_kegiatan'] 	= $this->UserM->get_data_pengajuan_by_id($id)->result()[0];
		$data['data_diri'] 			= $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['nama_progress'] 		= $this->UserM->get_pilihan_nama_progress()->result();
		$this->load->view('kadep/edit_pengajuan', $data);
	}

	public function detail_kegiatan($id){ //menampilkan modal dengan isi dari detail_kegiatan.php
		$data['detail_kegiatan'] 	= $this->UserM->get_data_pengajuan_by_id($id)->result()[0];
		$data['data_diri'] 			= $this->UserM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$this->load->view('kadep/detail_kegiatan', $data);
	}

	public function detail_pengguna($id_pengguna){ //menampilkan modal dengan isi dari detail_kegiatan.php
		$data['data_pengguna'] 			= $this->KadepM->get_data_diri_by_id($id_pengguna)->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$this->load->view('kadep/detail_pengguna', $data);
	}

	public function detail_progress($id){ //menampilkan modal dengan isi dari detail_kegiatan.php
		$data['detail_progress']	= $this->UserM->get_detail_progress($id)->result();
		$this->load->view('kadep/detail_progress', $data);
	}

	public function post_progress(){ //posting progress dan update kegiatan (dana disetujuin)
		$this->form_validation->set_rules('id_pengguna', 'No Identitas','required');
		$this->form_validation->set_rules('kode_fk', 'Kode Kegiatan','required');
		$this->form_validation->set_rules('kode_nama_progress', 'Nama Progress','required'); //diterima/ditolak
		$this->form_validation->set_rules('komentar', 'Komentar','required');
		$this->form_validation->set_rules('jenis_progress', 'Jenis Progress','required'); //kegiatan/barang
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$id_pengguna		= $_POST['id_pengguna'];
			$kode_fk			= $_POST['kode_fk'];
			$kode_nama_progress	= $_POST['kode_nama_progress'];
			$komentar			= $_POST['komentar'];
			$jenis_progress		= $_POST['jenis_progress'];


			$format_tgl 	= "%Y-%m-%d";
			$tgl_progress 	= mdate($format_tgl);
			$format_waktu 	= "%H:%i";
			$waktu_progress	= mdate($format_waktu);

			$data = array(
				'id_pengguna' 			=> $id_pengguna,
				'kode_fk'				=> $kode_fk,
				'kode_nama_progress' 	=> $kode_nama_progress,
				'komentar'				=> $komentar,
				'jenis_progress'		=> $jenis_progress,
				'tgl_progress'			=> $tgl_progress,
				'waktu_progress'		=> $waktu_progress

			);

			if($this->UserM->insert_progress($data)){ //insert progress
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}


	public function detail_jabatan($id){ //menampilkan modal dengan isi dari detail_jabatan.php
		$data['detail_jabatan'] = $this->UserM->get_pilihan_jabatan_by_id($id)->result()[0];
		$this->load->view('kadep/detail_jabatan', $data);
	}

	public function update_jabatan(){
		$this->form_validation->set_rules('kode_jabatan', 'Kode Jabatan','required');
		$this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$kode_jabatan = $_POST['kode_jabatan'];
			$nama_jabatan = $_POST['nama_jabatan'];
			$db = "jabatan";
			$kode = "kode_jabatan";

			$data = array(
				'nama_jabatan'      => $nama_jabatan);

			if($this->UserM->update($kode_jabatan, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function tambah_jabatan(){
		$this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$nama_jabatan = $_POST['nama_jabatan'];
			$db 		= "jabatan";

			$data = array(
				'nama_jabatan'      => $nama_jabatan);

			if($this->UserM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function detail_unit($id){ //menampilkan modal dengan isi dari detail_jabatan.php
		$data['detail_unit'] = $this->UserM->get_pilihan_unit_by_id($id)->result()[0];
		$this->load->view('kadep/detail_unit', $data);
	}

	public function update_unit(){
		$this->form_validation->set_rules('kode_unit', 'Kode Unit','required');
		$this->form_validation->set_rules('nama_unit', 'Nama Unit','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$kode_unit = $_POST['kode_unit'];
			$nama_unit = $_POST['nama_unit'];
			$db = "unit";
			$kode = "kode_unit";

			$data = array(
				'nama_unit'      => $nama_unit);

			if($this->UserM->update($kode_unit, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function tambah_unit(){
		$this->form_validation->set_rules('nama_unit', 'Nama Unit','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$nama_unit = $_POST['nama_unit'];
			$db 		= "unit";

			$data = array(
				'nama_unit'      => $nama_unit);

			if($this->UserM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function detail_jenis_barang($id){ //menampilkan modal dengan isi dari detail_jabatan.php
		$data['detail_jenis_barang'] = $this->UserM->get_jenis_barang_by_id($id)->result()[0];
		$this->load->view('kadep/detail_jenis_barang', $data);
	}

	public function update_jenis_barang(){
		$this->form_validation->set_rules('kode_jenis_barang', 'Kode Jenis barang','required');
		$this->form_validation->set_rules('nama_jenis_barang', 'Nama Jenis barang','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$kode_jenis_barang = $_POST['kode_jenis_barang'];
			$nama_jenis_barang = $_POST['nama_jenis_barang'];
			$db = "jenis_barang";
			$kode = "kode_jenis_barang";

			$data = array(
				'nama_jenis_barang'      => $nama_jenis_barang);

			if($this->UserM->update($kode_jenis_barang, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function tambah_jenis_barang(){
		$this->form_validation->set_rules('nama_jenis_barang', 'Nama Jenis Barang','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$nama_jenis_barang = $_POST['nama_jenis_barang'];
			$db 		= "jenis_barang";

			$data = array(
				'nama_jenis_barang'      => $nama_jenis_barang);

			if($this->UserM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function detail_jenis_kegiatan($id){ //menampilkan modal dengan isi dari detail_jenis_kegiatan.php
		$data['detail_jenis_kegiatan'] = $this->UserM->get_jenis_kegiatan_by_id($id)->result()[0];
		$this->load->view('kadep/detail_jenis_kegiatan', $data);
	}

	public function update_jenis_kegiatan(){
		$this->form_validation->set_rules('kode_jenis_kegiatan', 'Kode Jenis Kegiatan','required');
		$this->form_validation->set_rules('nama_jenis_kegiatan', 'Nama Jenis Kegiatan','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$kode_jenis_kegiatan = $_POST['kode_jenis_kegiatan'];
			$nama_jenis_kegiatan = $_POST['nama_jenis_kegiatan'];
			$db = "jenis_kegiatan";
			$kode = "kode_jenis_kegiatan";

			$data = array(
				'nama_jenis_kegiatan'      => $nama_jenis_kegiatan);

			if($this->UserM->update($kode_jenis_kegiatan, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function tambah_jenis_kegiatan(){
		$this->form_validation->set_rules('nama_jenis_kegiatan', 'Nama Jenis kegiatan','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$nama_jenis_kegiatan = $_POST['nama_jenis_kegiatan'];
			$db 		= "jenis_kegiatan";

			$data = array(
				'nama_jenis_kegiatan'      => $nama_jenis_kegiatan);

			if($this->UserM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function detail_nama_progress($id){ //menampilkan modal dengan isi dari detail_jenis_kegiatan.php
		$data['detail_nama_progress'] = $this->UserM->get_nama_progress_by_id($id)->result()[0];
		$this->load->view('kadep/detail_nama_progress', $data);
	}

	public function update_nama_progress(){
		$this->form_validation->set_rules('kode_nama_progress', 'Kode Nama Progress','required');
		$this->form_validation->set_rules('nama_progress', 'Nama Progress','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$kode_nama_progress = $_POST['kode_nama_progress'];
			$nama_progress = $_POST['nama_progress'];
			$db = "nama_progress";
			$kode = "kode_nama_progress";

			$data = array(
				'nama_progress'      => $nama_progress);

			if($this->UserM->update($kode_nama_progress, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function tambah_nama_progress(){
		$this->form_validation->set_rules('nama_progress', ' Nama Progress','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$nama_progress = $_POST['nama_progress'];
			$db 		= "nama_progress";

			$data = array(
				'nama_progress'      => $nama_progress);

			if($this->UserM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function tambah_persetujuan_kegiatan(){
		$this->form_validation->set_rules('id_pengguna', ' ID Pengguna','required');
		$this->form_validation->set_rules('ranking', 'Rangking','required');
		$this->form_validation->set_rules('kode_jenis_kegiatan', ' Kode Jenis Kegiatan','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect_back(); //kembali ke halaman sebelumnya -> helper
		}else{
			$id_pengguna 			= $_POST['id_pengguna'];
			$ranking 				= $_POST['ranking'];
			$kode_jenis_kegiatan 	= $_POST['kode_jenis_kegiatan'];

			$data = array(
				'id_pengguna'      			=> $id_pengguna,
				'ranking'      				=> $ranking,
				'kode_jenis_kegiatan'      	=> $kode_jenis_kegiatan);
			$db = "acc_kegiatan";

			if($this->UserM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function hapus($id){//hapus persetujuan kegiatan
		if($this->KadepM->hapus($id)){
			$this->session->set_flashdata('sukses','Data anda berhasil dihapus');
			redirect_back();
		}
	}
}