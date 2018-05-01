<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BarangC extends CI_Controller {

	var $data = array();
	private $data_menu;

	public function __construct(){
		parent::__construct();
		$this->load->model(['UserM','PenggunaM','BarangM']);
		in_access(); //helper buat batasi akses login/session

		$data_akses_menu = $this->PenggunaM->get_akses_menu()->result();
		$data_array_akses_menu = array();
		foreach ($data_akses_menu as $menu) {
			array_push($data_array_akses_menu, $menu->kode_menu);
		}
		$this->data_menu = $data_array_akses_menu; // array akses menu berdasarkan user login
	}

	// =============================FUNGSI PER HALAMAN===============================

	public function persetujuan_barang(){ //halaman persetujuan barang (mansarpras)
		// menampilkan pengajuan item barang yang telah di beri porgress oleh pimpinan 
		$data['menu'] = $this->data_menu;
		$id_pengguna = $this->session->userdata('id_pengguna');
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Persetujuan Item Pengajuan | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$this->data['data_persetujuan_barang'] = $this->Man_sarprasM->get_data_item_pengajuan()->result();
		$this->data['Man_sarprasM'] = $this->Man_sarprasM ;
		$this->data['data_diri'] = $data_diri; //get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/persetujuan_barang_content', $this->data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}

	public function kelola_barang(){ //halaman kelola barang (mansarpras & staf sarpras)
		// menampilkan daftar semua barang
		$data['menu'] = $this->data_menu;
		$id_pengguna = $this->session->userdata('id_pengguna');
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Kelola Barang | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$this->data['data_barang'] = $this->Man_sarprasM->get_barang()->result();
		$this->data['jenis_barang'] = $this->Man_sarprasM->get_pilihan_jenis_barang()->result();
		$this->data['data_diri'] = $data_diri; //get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/barang_content', $this->data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}

	public function klasifikasi_barang(){ //halaman klasifikasi barang (mansarpras & staf sarpras)
		// menampilkan daftar barang yang belum terklasifikasi
		$data['menu'] = $this->data_menu;
		$id_pengguna = $this->session->userdata('id_pengguna');
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Klasifikasi Barang | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$this->data['data_klasifikasi'] = $this->Man_sarprasM->get_data_klasifikasi_barang()->result();
		$this->data['data_diri'] = $data_diri; //get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/klasifikasi_barang_content', $this->data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}

	public function ajukan_RAB(){ //halaman untuk pengajuan RAB(mansarpras )
		// menampilkan daftar barang untuk dijadikan RAB dan data RAB
		$data['menu'] = $this->data_menu;
		$id_pengguna = $this->session->userdata('id_pengguna');
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Pengajuan RAB | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$this->data['data_barang_setuju'] = $this->Man_sarprasM->get_barang_setuju()->result();
		$this->data['pengajuan'] = $this->Man_sarprasM->get_pengajuan_rab()->result();
		$this->data['Man_sarprasM'] = $this->Man_sarprasM;
		$this->data['data_diri'] = $data_diri; //get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/ajukan_RAB_content', $this->data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}

	public function buat_rab(){ //halaman untuk pengajuan RAB(mansarpras )
		// menampilkan daftar barang untuk dijadikan RAB dan data RAB
		$data['menu'] = $this->data_menu;
		$id_pengguna = $this->session->userdata('id_pengguna');
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Pengajuan RAB | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$this->data['data_pengajuan_all'] = $this->Man_sarprasM->data_rab_all()->result();
		$this->data['Man_sarprasM'] = $this->Man_sarprasM;
		$this->data['data_diri'] = $data_diri; //get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/data_rab_content', $this->data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}
	
	// ================================FUNGSI DI HALAMAN=====================

	public function detail_progress_barang($id){ //menampilkan modal dengan isi dari detail progres barang.php
		$data['detail_progress_barang']	= $this->Man_sarprasM->get_detail_progress_barang_by_id($id)->result();
		$this->load->view('man_sarpras/detail_progress_barang', $data);
	}

	public function ubah_barang($kode_barang){ //menampilkan modal dengan isi dari ubah_barang.php
		$data['ubah_barang']          = $this->UserM->get_barang_by_kode_barang($kode_barang)->result()[0];
		$data['pilihan_jenis_barang'] = $this->Man_sarprasM->get_pilihan_jenis_barang($kode_barang)->result();
		echo json_encode($data);
	}

	public function getListAjax() 
	{
		$data = $this->db->get('jenis_barang')->result();
		echo json_encode($data);
	}

	public function ubah_data_barang(){ //update data barang
		$id 				= $_POST['id'];
		$nama_barang 		= $_POST['nama_barang'];
		$kode_jenis_barang  = $_POST['kode_jenis_barang'];
		$data = array(
			'nama_barang'       => $nama_barang,
			'kode_jenis_barang' => $kode_jenis_barang
		);
		$this->UserM->ubah_data_barang($id,$data);
		redirect('Man_sarprasC/kelola_barang');
	}

	public function update_klasifikasi($kode_jenis_barang, $kode_barang){ //edit data diri
		$kode_barang     	= $kode_barang;
		$kode_jenis_barang  = $kode_jenis_barang;

		$data = array(
			'kode_barang'     	=> $kode_barang,
			'kode_jenis_barang' => $kode_jenis_barang
		);
		$this->Man_sarprasM->update_klasifikasi_barang($kode_barang,$data);
		$this->session->set_flashdata('sukses','Data anda berhasil disimpan');
		redirect('Man_sarprasC/klasifikasi_barang');
	}

	public function setuju($kode){ //mengubah status pengajuan menjadi diajukan karena barang disetujui untuk diajukan
		if($this->Man_sarprasM->setuju($kode)){
			$this->session->set_flashdata('sukses','Data anda tidak berhasil disimpan');
			redirect('Man_sarprasC/ajukan_RAB');
		}else{
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');	
			redirect('Man_sarprasC/ajukan_RAB');
		}
	}

	public function tunda($kode){ //mengubah status pengajuan menjadi tunda karena barang belum bisa diajukan untuk diajukan
		if($this->Man_sarprasM->tunda($kode)){
			$this->session->set_flashdata('sukses','Data anda tidak berhasil disimpan');
			redirect('Man_sarprasC/ajukan_RAB');
		}else{
			$this->session->set_flashdata('error','Data anda tidak berhasil disimpan');
			redirect('Man_sarprasC/ajukan_RAB');
		}
	}

	// =================================POST+POST+POST+POST=================================



	public function post_tambah_barang(){ //fungsi untuk tambah barang
		$this->form_validation->set_rules('nama_barang', 'Nama Barang','required');
		$this->form_validation->set_rules('kode_jenis_barang', 'Jenis Barang','required');
		if($this->form_validation->run() == FALSE)
		{
			$this->kelola_barang();
			//redirect ke halaman kelola barang
		}else{
			$nama_barang 		= $_POST['nama_barang'];
			$kode_jenis_barang	= $_POST['kode_jenis_barang'];
			$data_pengguna		= array(
				'nama_barang'		=> $nama_barang,
				'kode_jenis_barang'	=> $kode_jenis_barang
			);
			if($this->Man_sarprasM->insert_tambah_barang($data_pengguna)){
				$this->session->set_flashdata('sukses','Data Barang berhasil ditambahkan');
				redirect('Man_sarprasC/kelola_barang');
			}else{
				$this->session->set_flashdata('error','Data Barang tidak berhasil ditambahkan');
				redirect('Man_sarprasC/kelola_barang');
			}
		}

	}

	public function post_persetujuan_barang(){ //fungsi untuk tambah progress persetujuan barang
		$this->form_validation->set_rules('id_pengguna', 'Id Pengguna','required');
		$this->form_validation->set_rules('kode_fk', 'Kode FK','required');
		$this->form_validation->set_rules('kode_nama_progress', 'Kode Nama Progress','required');
		$this->form_validation->set_rules('komentar', 'Komentar','required');
		if($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error','Data Persetujuan anda tidak berhasil ditambahkan1 ');
			redirect('Man_sarprasC/persetujuan_barang') ;
			//redirect ke halaman pengajuan barang
		}else{
			
			$id_pengguna 		= $_POST['id_pengguna'];
			$kode_fk 		    = $_POST['kode_fk'];
			$kode_nama_progress = $_POST['kode_nama_progress'];
			$komentar           = $_POST['komentar'];
			$jenis_progress 	= "barang";

			$format_waktu 		= "%H:%i";
			$waktu_progress 	= mdate($format_waktu);

			$format_tgl 		= "%Y-%m-%d";
			$tgl_progress 		= mdate($format_tgl);


			$data_progress		= array(
				'id_pengguna'		=> $id_pengguna,
				'kode_fk'			=> $kode_fk,
				'kode_nama_progress'=> $kode_nama_progress,
				'komentar'			=> $komentar,
				'jenis_progress'	=> $jenis_progress,
				'tgl_progress'		=> $tgl_progress,
				'waktu_progress'	=> $waktu_progress

			);

			if($kode_nama_progress == '1'){
				$persetujuan = 'proses';
			}elseif ($kode_nama_progress == "2") {
				$persetujuan = 'tolak';
			}
			
			$data = array(
				'status_pengajuan' => $persetujuan
			);
			if($this->UserM->insert_progress($data_progress)){
				$this->Man_sarprasM->update_persetujuan($data,$kode_fk);
				$this->session->set_flashdata('sukses','Data Barang berhasil ditambahkan');
				redirect('Man_sarprasC/persetujuan_barang');
			}else{
				$this->session->set_flashdata('error','Data Barang tidak berhasil ditambahkan2');
				redirect('Man_sarprasC/persetujuan_barang');
			}

		}

	}	

	public function post_persetujuan_tersedia($kode_item_pengajuan){ // untuk mengubah status persediaan dan pengajuan jd selese serta tambah progres
		$data_diri = $this->UserM->get_data_diri()->result()[0];

		

		$data = array(
			'status_pengajuan' => 'selesai',
			'status_persediaan' => 'tersedia'
		);

		if($this->Man_sarprasM->update_persetujuan_tersedia($data, $kode_item_pengajuan)){
			$id_pengguna 		= $data_diri->id_pengguna;
			$kode_fk 		    = $kode_item_pengajuan;
			$kode_nama_progress = "1";
			$komentar           = "barang tersedia";
			$jenis_progress 	= "barang";

			$format_waktu 		= "%H:%i";
			$waktu_progress 	= mdate($format_waktu);

			$format_tgl 		= "%Y-%m-%d";
			$tgl_progress 		= mdate($format_tgl);


			$data_progress		= array(
				'id_pengguna'		=> $id_pengguna,
				'kode_fk'			=> $kode_fk,
				'kode_nama_progress'=> $kode_nama_progress,
				'komentar'			=> $komentar,
				'jenis_progress'	=> $jenis_progress,
				'tgl_progress'		=> $tgl_progress,
				'waktu_progress'	=> $waktu_progress

			);
			$this->UserM->insert_progress($data_progress);
			$this->session->set_flashdata('sukses','Sukses Menyetujui Barang');
			redirect('Man_sarprasC/persetujuan_barang');
		}else{
			$this->session->set_flashdata('error','Data Barang tidak berhasil ditambahkan2');
			redirect('Man_sarprasC/persetujuan_barang');
		}

	}

}