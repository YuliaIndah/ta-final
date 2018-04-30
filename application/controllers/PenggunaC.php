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
}