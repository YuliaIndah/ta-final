 <?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class PenggunaM extends CI_Model  
 {  
 	function __construct(){
 		parent:: __construct();
 		$this->load->database();
 	}

 	// UMUM
 	public function get_data_diri(){ //ambil data diri user berdasarkan session
 		$id_pengguna = $this->session->userdata('id_pengguna');
 		$this->db->select('*');
 		$this->db->from('pengguna');
 		$this->db->where('pengguna.id_pengguna', $id_pengguna);
 		$this->db->join('data_diri', 'pengguna.no_identitas = data_diri.no_identitas');
 		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
 		$this->db->join('unit', 'pengguna.kode_unit = unit.kode_unit');
 		$query = $this->db->get();
 		if($query){
 			return $query;
 		}else{
 			return null;
 		}
 	} 

	public function edit_data_diri($no_identitas, $data){ //edit data diri
		$this->db->where('no_identitas', $no_identitas);
		$this->db->update('data_diri', $data);
		return TRUE;
	}

	public function simpan_upload($id_pengguna, $gambar){ // Fungsi untuk menyimpan data ke database
		$data = array(
			'file_profil' 	=> $gambar
		);
		$this->db->where('id_pengguna', $id_pengguna);
		$this->db->update('pengguna', $data);
	}

	public function get_akses_menu(){
		$kode_unit 	= $this->session->userdata('kode_unit');
		$kode_jabatan = $this->session->userdata('kode_jabatan');
		$this->db->select('kode_menu');
		$this->db->from('akses_menu');
		// $this->db->join('jabatan', 'akses_menu.kode_jabatan = jabatan.kode_jabatan');
		// $this->db->join('unit', 'akses_menu.kode_unit = unit.kode_unit');
		$this->db->where('akses_menu.kode_unit', $kode_unit);
		$this->db->where('akses_menu.kode_jabatan', $kode_jabatan);
		$query = $this->db->get();
		return $query;
	}

	public function cek_row($id_pengguna, $password){ //cek akun di db pengguna jabatan (berapa rows)
		$this->db->where('id_pengguna', $id_pengguna);
		$this->db->where('password', md5($password));
		return $this->db->get('pengguna')->num_rows();
	}

	public function update_pass($id_pengguna, $data){
		$this->db->where('id_pengguna', $id_pengguna);
		$this->db->update('pengguna', $data);
		return TRUE;
	}
}