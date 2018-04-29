<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PenggunaC extends CI_Controller {

	var $data = array();

	public function __construct(){
		parent::__construct();
		$this->load->model(['UserM','PenggunaM']);
		in_access(); //helper buat batasi akses login/session
	}

	public function index(){ //halaman index kadep (dashboard)
		$data_akses_menu = $this->PenggunaM->get_akses_menu()->result();
		$data_array_akses_menu = array();
		foreach ($data_akses_menu as $menu) {
			array_push($data_array_akses_menu, $menu->kode_menu);
		}

		$data['menu'] = $data_array_akses_menu;

		$data['title'] = "Beranda | Kepala Departemen";
		$data['data_diri'] = $this->PenggunaM->get_data_diri()->result()[0];  	//get data diri buat nampilin nama di pjok kanan
		$data['body'] = $this->load->view('pengguna/index_content', $data, true) ;
		$this->load->view('pengguna/index_template', $data);
	}
		
}