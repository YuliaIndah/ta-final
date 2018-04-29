<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginC extends CI_Controller {

	var $data = array();

	public function __construct()
	{
		parent::__construct();	
		$this->load->model(['LoginM','UserM']);
		$this->load->helper('url');

	}
	public function index() //load captcha
	{
		$data['prosedur_pegawai'] = $this->UserM->get_prosedur_pegawai()->result();
		$data['prosedur_mahasiswa'] = $this->UserM->get_prosedur_mahasiswa()->result();
		$data['prosedur_barang'] = $this->UserM->get_prosedur_barang()->result();
		$data['cap_img'] = $this->LoginM->make_captcha();
		$this->load->view('LoginV', $data);
	}
	public function signin(){ //post login
		if($this->input->post('submit')){
			if($this->CaptchaM->check_captcha() == TRUE)
				echo "<span style=\"color:blue\">Captcha cocok</span>";
			else echo "<span style=\"color:red\">Captcha salah</span>";
			}
			$email		=$this->input->post('email');
			$password	=$this->input->post('password');
			$ceknum		=$this->LoginM->ceknum($email,$password)->num_rows();
			$query		=$this->LoginM->ceknum($email,$password)->row();
			if($ceknum>0){
				if($this->LoginM->check_captcha() == TRUE){
					$userData 	= array(
						'email' 		=> $query->email,
						'password' 		=> $query->password,
						'kode_jabatan' 	=> $query->kode_jabatan,
						'kode_unit' 	=> $query->kode_unit,
						'status'		=> $query->status,
						'status_email'	=> $query->status_email,
						'id_pengguna'	=> $query->id_pengguna,
						'logged_in' 	=> TRUE
					);
					$this->session->set_userdata($userData);
					if ($this->session->userdata('status_email') == 1) {
						if($this->session->userdata('status') == "aktif"){
							redirect('PenggunaC');	
						}else{
							$this->session->set_flashdata('error','Mohon maaf untuk saat ini akun anda belum aktif. Silahkan hubungi <b>Administrator </b> untuk melakukan konfirmasi aktifasi akun.');
							redirect('LoginC');	
						}
					}else{
						$this->session->set_flashdata('error','Sepertinya anda belum melakukan konfirmasi email. Silahkan cek email anda dan klik tautan yang dibagikan.');
						redirect('LoginC');
					}

				}else{
					$this->session->set_flashdata('error','Captcha salah');
					redirect('LoginC');
				}
			}else{
				if($this->LoginM->check_captcha() == TRUE){
					$this->session->set_flashdata('error','email atau password salah');
					redirect('LoginC');
				}else{
					$this->session->set_flashdata('error','email atau password dan captcha salah');
					redirect('LoginC');
				}
			}
			
		}	
		function logout(){
			$this->session->sess_destroy();	
			redirect(base_url().'LoginC/');	
		}

	}