<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PenggunaC extends CI_Controller {

	var $data = array();
	private $data_menu;

	public function __construct(){
		parent::__construct();
		$this->load->model(['UserM','PenggunaM']);
		in_access(); //helper buat batasi akses login/session

		$data_akses_menu = $this->PenggunaM->get_akses_menu()->result();
		$data_array_akses_menu = array();
		foreach ($data_akses_menu as $menu) {
			array_push($data_array_akses_menu, $menu->kode_menu);
		}
		$this->data_menu = $data_array_akses_menu; // array akses menu berdasarkan user login
	}
	
	// pindah pindah halaman
	public function index(){ //halaman index kadep (dashboard)
		$data['menu'] = $this->data_menu;
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['data_diri'] = $data_diri;
		$data['title'] = "Beranda | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$data['body'] = $this->load->view('pengguna/index_content', $data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}

	public function data_diri(){ //halaman data diri
		$data['menu'] = $this->data_menu;
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['data_diri'] = $data_diri;
		$data['title'] = "Data Diri | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$data['body'] = $this->load->view('pengguna/data_diri_content', $data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}

	public function pengaturan_akun(){ //halaman pengaturan akun
		$data['menu'] = $this->data_menu;
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['data_diri'] = $data_diri;
		$data['title'] = "Pengaturan Akun | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$data['body'] = $this->load->view('pengguna/pengaturan_akun_content', $data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}

	public function pengguna(){//halaman pengguna (admin)
		$data['menu'] = $this->data_menu;
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$this->data['data_pengguna'] = $this->PenggunaM->get_data_pengguna()->result();
		$this->data['data_diri'] = $data_diri;  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Daftar Pengguna | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$data['body'] = $this->load->view('pengguna/pengguna_content', $this->data, true);
		$this->load->view('pengguna/index_template', $data);
	}

	public function konfigurasi_sistem(){
		$data['menu'] = $this->data_menu;
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Konfigurasi Sistem | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;

		$this->data['persetujuan_kegiatan']	= $this->PenggunaM->get_persetujuan_kegiatan()->result();
		// $this->data['detail_jabatan'] 		= $this->PenggunaM->get_pilihan_jabatan_by_id($kode_jabatan)->result()[0];
		$this->data['nama_pengguna']		= $this->PenggunaM->get_data_pengguna()->result();
		$this->data['nama_progress']		= $this->PenggunaM->get_nama_progress()->result();
		$this->data['jenis_kegiatan']		= $this->PenggunaM->get_jenis_kegiatan()->result();
		$this->data['jenis_kegiatan_persetujuan']	= $this->PenggunaM->get_jenis_kegiatan()->result();
		$this->data['jenis_barang']			= $this->PenggunaM->get_jenis_barang()->result();
		$this->data['jabatan']				= $this->PenggunaM->get_pilihan_jabatan()->result();
		$this->data['unit']					= $this->PenggunaM->get_pilihan_unit()->result();
		$this->data['data_diri'] 			= $data_diri;  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/konfigurasi_sistem_content', $this->data, true);
		$this->load->view('pengguna/index_template', $data);
	}

	public function prosedur(){ //halaman index kadep (dashboard)
		$data['menu'] = $this->data_menu;
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Konfigurasi Sistem | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;

		$this->data['data_diri'] = $data_diri;  	//get data diri buat nampilin nama di pjok kanan
		$this->data['data_prosedur'] = $this->PenggunaM->get_prosedur()->result();
		$data['body'] = $this->load->view('pengguna/prosedur_content', $this->data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}






	// umum
	public function detail_pengguna($id_pengguna){ //menampilkan modal dengan isi dari detail_kegiatan.php
		$data['data_pengguna'] 			= $this->PenggunaM->get_data_diri_by_id($id_pengguna)->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$this->load->view('pengguna/detail_pengguna', $data);
	}

	public function aktif($id_pengguna){ //aktifasi akun pengguna
		if($this->PenggunaM->aktif($id_pengguna)){
			$this->session->set_flashdata('sukses','Akun berhasil diaktifkan');	
			redirect('PenggunaC/pengguna');
		}else{
			$this->session->set_flashdata('error','Akun tidak berhasil diaktifkan');	
			redirect('PenggunaC/pengguna');
		}
	}

    public function non_aktif($id_pengguna){ //deaktifasi akun pengguna
    	if($this->PenggunaM->non_aktif($id_pengguna)){
    		$this->session->set_flashdata('sukses','Akun berhasil di non-aktifkan');	
    		redirect('PenggunaC/pengguna');
    	}else{
    		$this->session->set_flashdata('error','Akun tidak berhasil di non-aktifkan');	
    		redirect('PenggunaC/pengguna');
    	}
    }

    // Jabatan
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

			if($this->PenggunaM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}


	public function detail_jabatan($id){ //menampilkan modal dengan isi dari detail_jabatan.php
		$data['detail_jabatan'] = $this->PenggunaM->get_pilihan_jabatan_by_id($id)->result()[0];
		$this->load->view('pengguna/detail_jabatan', $data);
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

			if($this->PenggunaM->update($kode_jabatan, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	// Unit
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

			if($this->PenggunaM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function detail_unit($id){ //menampilkan modal dengan isi dari detail_jabatan.php
		$data['detail_unit'] = $this->PenggunaM->get_pilihan_unit_by_id($id)->result()[0];
		$this->load->view('pengguna/detail_unit', $data);
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

			if($this->PenggunaM->update($kode_unit, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	// Jenis Barang
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

			if($this->PenggunaM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function detail_jenis_barang($id){ //menampilkan modal dengan isi dari detail_jabatan.php
		$data['detail_jenis_barang'] = $this->PenggunaM->get_jenis_barang_by_id($id)->result()[0];
		$this->load->view('pengguna/detail_jenis_barang', $data);
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

			if($this->PenggunaM->update($kode_jenis_barang, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	// Jenis KEgiatan
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

			if($this->PenggunaM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function detail_jenis_kegiatan($id){ //menampilkan modal dengan isi dari detail_jenis_kegiatan.php
		$data['detail_jenis_kegiatan'] = $this->PenggunaM->get_jenis_kegiatan_by_id($id)->result()[0];
		$this->load->view('pengguna/detail_jenis_kegiatan', $data);
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

			if($this->PenggunaM->update($kode_jenis_kegiatan, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	// Nama Progress
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

			if($this->PenggunaM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	public function detail_nama_progress($id){ //menampilkan modal dengan isi dari detail_jenis_kegiatan.php
		$data['detail_nama_progress'] = $this->PenggunaM->get_nama_progress_by_id($id)->result()[0];
		$this->load->view('pengguna/detail_nama_progress', $data);
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

			if($this->PenggunaM->update($kode_nama_progress, $kode, $db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	// ACC KEgiatan

	public function hapus($id){//hapus persetujuan kegiatan
		if($this->PenggunaM->hapus($id)){
			$this->session->set_flashdata('sukses','Data anda berhasil dihapus');
			redirect_back();
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

			if($this->PenggunaM->insert($db, $data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect_back(); // redirect kembali ke halaman sebelumnya
			}else{
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
				redirect_back(); //kembali ke halaman sebelumnya -> helper
			}
		}
	}

	// Prosedur
	public function aktif_pro($kode_doc){ //aktifasi akun pengguna
		$this->PenggunaM->aktif_pro($kode_doc);
		redirect('PenggunaC/prosedur');
	}

    public function non_aktif_pro($kode_doc){ //deaktifasi akun pengguna
    	$this->PenggunaM->non_aktif_pro($kode_doc);
    	redirect('PenggunaC/prosedur');
    }



	// =================================POST+POST+POST+POST=================================

	public function edit_data_diri($no_identitas){ //edit data diri
		$this->form_validation->set_rules('jen_kel', 'Jenis Kelamin','required');
		$this->form_validation->set_rules('tmp_lahir', 'Tempat Lahir','required');
		$this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir','required');
		$this->form_validation->set_rules('alamat', 'Alamat','required');
		$this->form_validation->set_rules('no_hp', 'no_hp','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect('PenggunaC/data_diri');
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

			if($this->PenggunaM->edit_data_diri($no_identitas,$data)){
				$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
				redirect('PenggunaC/data_diri');
			}else{
				redirect('PenggunaC/data_diri');
				$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			}	
		}
	}

	public function upload_image(){
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
        		$this->PenggunaM->simpan_upload($id_pengguna,$gambar);
        		$this->session->set_flashdata('sukses','Foto berhasil diunggah');
        		redirect('PenggunaC/data_diri');
        		// echo "Image berhasil diupload";
        	}

        }else{
        	$this->session->set_flashdata('error','Foto tidak berhasil diunggah');
        	redirect('PenggunaC/data_diri');
        }

    }

    public function post_ganti_password(){
    	$this->form_validation->set_rules('sandi_lama', 'Sandi Lama', 'trim|required|min_length[6]|max_length[50]');
    	$this->form_validation->set_rules('sandi_baru', 'Sandi Baru', 'trim|required|min_length[6]|max_length[50]');
    	$this->form_validation->set_rules('konfirmasi_sandi_baru', 'Konfirmasi Sandi Baru', 'trim|required|min_length[6]|max_length[50]|matches[sandi_baru]'); 
    	if ($this->form_validation->run() == FALSE)  
    	{  
    		$this->session->set_flashdata('Error','Input yang anda masukkan salah, silahkan dicoba lagi . . .');
    		redirect('PenggunaC/pengaturan_akun');
    	}else{ 
    		$sandi_lama   = $_POST['sandi_lama'];  
    		$sandi_baru   = $_POST['sandi_baru'];  
    		$id_pengguna  = $_POST['id_pengguna']; 

    		$sandi_baru   = $_POST['sandi_baru'];  
    		$passhash     = md5($sandi_baru);

    		$data_update  = array(
    			'password'        => $passhash);

    		$ada = $this->PenggunaM->cek_row($id_pengguna, $sandi_lama);
    		if($ada > 0){
    			if($this->PenggunaM->update_pass($id_pengguna, $data_update)){
    				$this->session->set_flashdata('sukses','Data berhasil dirubah');
    				redirect('PenggunaC/pengaturan_akun');
    			}else{
    				$this->session->set_flashdata('error','Data tidak berhasil dirubah');
    				redirect('PenggunaC/pengaturan_akun');
    			}
    		}else{
    			$this->session->set_flashdata('error','Kata sandi lama tidak cocok');
    			redirect('PenggunaC/pengaturan_akun');
    		}	
    	}
    }

    public function post_prosedur(){ //fungsi post pengajuan kegiatan pegawai
    	$this->form_validation->set_rules('tipe_doc', 'Tipe Dokumen','required');
    	if($this->form_validation->run() == FALSE){
    		$this->session->set_flashdata('error','Data Prosedur anda tidak berhasil ditambahkan');
    		redirect('PenggunaC/prosedur');
    	}else{

    		$tipe_doc 	       		= $_POST['tipe_doc'];
    		$status 				= $_POST['status'];

    		$data_prosedur = array(
    			'tipe_doc' 			=> $tipe_doc,
    			'status' 			=> $status);


			$upload = $this->PenggunaM->upload_prosedur(); // lakukan upload file dengan memanggil function upload yang ada di UserM.php
			if($upload['result'] == "success"){ // Jika proses upload sukses
				$this->UserM->save_prosedur($upload, $data_prosedur); // Panggil function save_prosedur yang ada di UserM.php untuk menyimpan data ke database
			}else{ // Jika proses upload gagal
				$data['message'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
				$this->session->set_flashdata('error','Data Pengajuan Kegiatan anda tidak berhasil ditambahkan');
				redirect('PenggunaC/prosedur');
			}
			$this->session->set_flashdata('sukses','Data Pengajuan Kegiatan anda berhasil ditambahkan');
			redirect('PenggunaC/prosedur');
		}
	}
}