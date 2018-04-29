 <?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class PenggunaM extends CI_Model  
 {  
 	function __construct(){
 		parent:: __construct();
 		$this->load->database();
 	}

 	// UMUM

 	function get_data_diri(){ //ambil data diri user berdasarkan session
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
 }