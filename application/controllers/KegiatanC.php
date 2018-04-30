<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KegiatanC extends CI_Controller {

	var $data = array();
	private $data_menu;

	public function __construct(){
		parent::__construct();
		$this->load->model(['UserM','PenggunaM','KegiatanM']);
		in_access(); //helper buat batasi akses login/session

		$data_akses_menu = $this->PenggunaM->get_akses_menu()->result();
		$data_array_akses_menu = array();
		foreach ($data_akses_menu as $menu) {
			array_push($data_array_akses_menu, $menu->kode_menu);
		}
		$this->data_menu = $data_array_akses_menu; // array akses menu berdasarkan user login
	}

	public function persetujuan_kegiatan_mahasiswa(){ //halaman persetujuan kegiatan mahasiswa (kadep)
		// menampilkan kegiatan mahasiswa yang telah di beri porgress oleh manajer Keuangan
		$data['menu'] = $this->data_menu;
		$id_pengguna = $this->session->userdata('id_pengguna');
		$kode_jenis_kegiatan = 2; //kegiatan mahasiswa
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Persetujuan Kegiatan Mahasiswa | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$this->data['data_pengajuan_kegiatan_mahasiswa'] = $this->KegiatanM->get_data_pengajuan($kode_jenis_kegiatan)->result();
		$this->data['KegiatanM'] = $this->KegiatanM ;
		$this->data['cek_max'] = $this->KegiatanM->cek_max();
		$this->data['cek_id_staf_keu'] = $this->KegiatanM->cek_id_staf_keu()->result();	
		$this->data['data_diri'] = $data_diri; //get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/persetujuan_kegiatan_mahasiswa_content', $this->data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}

	public function detail_progress($id){ //menampilkan modal dengan isi dari detail_kegiatan.php
		$data['detail_progress']	= $this->KegiatanM->get_detail_progress($id)->result();
		$this->load->view('pengguna/detail_progress', $data);
	}

	public function detail_kegiatan($id){ //menampilkan modal dengan isi dari detail_kegiatan.php
		$data['detail_kegiatan'] 	= $this->KegiatanM->get_data_pengajuan_by_id($id)->result()[0];
		$data['data_diri'] 			= $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$this->load->view('pengguna/detail_kegiatan', $data);
	}

	public function detail_pengajuan($id){ //menampilkan modal dengan isi dari detail_pengajuan.php
		$data['detail_kegiatan'] 	= $this->KegiatanM->get_data_pengajuan_by_id($id)->result()[0];
		$data['data_diri'] 			= $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['nama_progress'] 		= $this->KegiatanM->get_pilihan_nama_progress()->result();
		$this->load->view('pengguna/detail_pengajuan', $data);
	}


	public function persetujuan_kegiatan_pegawai(){ //halaman persetujuan kegiatan pegawai (kadep)
		$data['menu'] = $this->data_menu;
		$no_identitas = $this->session->userdata('no_identitas');
		$kode_jenis_kegiatan = 1; //kegiatan pegawai
		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Persetujuan Kegiatan Pegawai | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;
		$this->data['data_pengajuan_kegiatan_pegawai'] = $this->UserM->get_data_pengajuan($kode_jenis_kegiatan)->result();
		$this->data['UserM'] = $this->KegiatanM ;	
		$this->data['cek_id_staf_keu'] = $this->KegiatanM->cek_id_staf_keu()->result();
		$this->data['cek_max_pegawai'] = $this->KegiatanM->cek_max_pegawai();	
		$this->data['KegiatanM'] = $this->KegiatanM ;
		$this->data['data_diri'] = $data_diri;  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/persetujuan_kegiatan_pegawai_content', $this->data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}


	public function persetujuan_kegiatan_staf(){ //halaman persetujuan kegiatan staf (manajer keuangan)
		$data['menu'] = $this->data_menu;
		$id_pengguna = $this->session->userdata('id_pengguna');
		$kode_unit 	= $this->session->userdata('kode_unit');
		$kode_jabatan = $this->session->userdata('kode_jabatan');

		$data_diri = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['title'] = "Persetujuan Kegiatan Pegawai | ".$data_diri->nama_jabatan." ".$data_diri->nama_unit;

		$this->data['data_pengajuan_kegiatan'] = $this->KegiatanM->get_data_pengajuan_staf($kode_unit, $kode_jabatan)->result();
		$this->data['KegiatanM'] = $this->KegiatanM ;
		// $this->data['Man_keuanganM'] = $this->Man_keuanganM ;		
		$this->data['data_diri'] = $data_diri;  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/persetujuan_kegiatan_staf_content', $this->data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}



	// =================================POST+POST+POST+POST=================================



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
}