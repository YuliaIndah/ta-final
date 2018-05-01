 <?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class KegiatanM extends CI_Model  
 {  
 	function __construct(){
 		parent:: __construct();
 		$this->load->database();
 	}

 	public function get_data_pengajuan($kode_jenis_kegiatan){
 		$this->db->select('*');
 		$this->db->from('kegiatan');
 		$this->db->join('jenis_kegiatan', 'jenis_kegiatan.kode_jenis_kegiatan = kegiatan.kode_jenis_kegiatan');
 		$this->db->join('file_upload', 'file_upload.kode_kegiatan = kegiatan.kode_kegiatan');
 		$this->db->join('pengguna', 'pengguna.id_pengguna = kegiatan.id_pengguna');
 		$this->db->join('data_diri', 'data_diri.no_identitas = pengguna.no_identitas');
 		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
 		$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
 		$this->db->where('kegiatan.kode_jenis_kegiatan', $kode_jenis_kegiatan);
 		$this->db->order_by('kegiatan.created_at', 'DESC');
 		$this->db->group_by('kegiatan.kode_kegiatan');
 		// $this->db->where('progress.kode_nama_progress = "1"');
 		$query = $this->db->get();
 		if($query){
 			return $query;
 		}else{
 			return null;
 		}

 	}

 	public function cek_id_staf_keu(){
 		$this->db->select('id_pengguna');
 		$this->db->from('pengguna');
		$this->db->where('kode_unit = "3"'); //keuangan
		$this->db->where('kode_jabatan = "4"'); //staf
		$this->db->where('status = "aktif"');
		$query = $this->db->get();
		return $query;
	}

	public function get_data_pengajuan_by_id($id){ //ambil data kegiatan yang diajukan sesuai id
		$this->db->select('*');
		$this->db->from('kegiatan');
		$this->db->join('pengguna', 'pengguna.id_pengguna = kegiatan.id_pengguna');
		$this->db->join('data_diri','pengguna.no_identitas = data_diri.no_identitas');
		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
		$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
		$this->db->join('jenis_kegiatan', 'jenis_kegiatan.kode_jenis_kegiatan = kegiatan.kode_jenis_kegiatan');
		$this->db->join('file_upload', 'file_upload.kode_kegiatan = kegiatan.kode_kegiatan');
		$this->db->where('kegiatan.kode_kegiatan', $id);
		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}
	}	

	public function get_progress($id){
		$this->db->select('*');
		$this->db->from('progress');
		$this->db->join('nama_progress', 'nama_progress.kode_nama_progress = progress.kode_nama_progress');
		$this->db->where('progress.kode_fk', $id);
		$this->db->where('progress.jenis_progress = "kegiatan"');
		$this->db->where('progress.kode_nama_progress = "1"');//diterima
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_progress_tolak($id){
		$this->db->select('*');
		$this->db->from('progress');
		$this->db->where('progress.kode_fk', $id);
		$this->db->where('progress.jenis_progress = "kegiatan"');
		$this->db->where('progress.kode_nama_progress = "2"');//ditolak
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_own_progress($kode, $id_pengguna){
		$this->db->select('*');
		$this->db->from('progress');
		$this->db->where('progress.kode_fk', $kode);
		$this->db->where('progress.jenis_progress = "kegiatan"');
		$this->db->where('progress.id_pengguna', $id_pengguna);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_progress_by_id($id, $kode_kegiatan){
		$this->db->select('*');
		$this->db->from('progress');
		$this->db->join('nama_progress','nama_progress.kode_nama_progress = progress.kode_nama_progress');
		$this->db->join('kegiatan', 'kegiatan.kode_kegiatan = progress.kode_fk');
		$this->db->where('progress.id_pengguna', $id);
		$this->db->where('progress.kode_fk = kegiatan.kode_kegiatan');
		$this->db->where('kegiatan.kode_kegiatan', $kode_kegiatan);
		$this->db->where('progress.jenis_progress = "kegiatan"');
		$this->db->order_by('progress.created_at','DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query;
	}

	public function get_detail_progress($id){
		$this->db->select('*');
		$this->db->from('progress');
		$this->db->join('pengguna', 'progress.id_pengguna = pengguna.id_pengguna');
		$this->db->join('data_diri', 'pengguna.no_identitas = data_diri.no_identitas');
		$this->db->join('jabatan', 'pengguna.kode_jabatan = jabatan.kode_jabatan');
		$this->db->join('unit', 'pengguna.kode_unit = unit.kode_unit');
		$this->db->join('nama_progress', 'progress.kode_nama_progress = nama_progress.kode_nama_progress');
		$this->db->where('progress.kode_fk', $id);
		$this->db->where('progress.jenis_progress = "kegiatan"'); //kegiatan bukan barang
		$query = $this->db->get();
		return $query;
	}

	public function get_pilihan_nama_progress(){ //fungsi untuk ambil pilihan nama progress
		$query = $this->db->get('nama_progress');
		return $query;
	}




 	//Kegiatan Mahasiswa
	public function cek_max(){
		$this->db->select_max('ranking');
		$this->db->where('kode_jenis_kegiatan = "2"'); //mhs
		$query = $this->db->get('acc_kegiatan')->row(); 
		return $query;
	}

	public function cek_id_by_rank_mhs($rank){
		$this->db->select('*');
		$this->db->where('ranking', $rank);
		$this->db->where('kode_jenis_kegiatan = "2"'); //mhs
		if($query = $this->db->get('acc_kegiatan')->row()){
			return $query;
		}else{
			return "data tidak ada";
		}
	}

	public function cek_rank_by_id_mhs($id_pengguna){
		$this->db->select('ranking');
		$this->db->where('id_pengguna', $id_pengguna);
		$this->db->where('kode_jenis_kegiatan = "2"'); //mhs
		if($query = $this->db->get('acc_kegiatan')->row()){
			return $query;
		}else{
			return "no";
		}	
	}

	public function insert_pengajuan_kegiatan($data){   //post pengguna_jabatan
		if($this->db->insert('kegiatan', $data)){
			return $this->db->insert_id(); //return last insert ID
		} 
	}  

	public function save($upload,$insert_id){ // Fungsi untuk menyimpan data ke database
		$data = array(
			'kode_kegiatan' => $insert_id, //last insert id
			'nama_file' 	=> $upload['file']['file_name'],
			'ukuran_file' 	=> $upload['file']['file_size']
		);
		
		$this->db->insert('file_upload', $data);
	}

	public function delete($id){ //hapus data pengajuan kegiatan ketika gagal upload file
		$this->db->where('kode_kegiatan', $id);
		$this->db->delete('kegiatan');
		return "berhasil delete";
	}

	public function upload(){ // Fungsi untuk upload file ke folder
		$config['upload_path'] = './assets/file_upload';
		$config['allowed_types'] = 'pdf';
		$config['max_size']	= '';
		$config['remove_space'] = TRUE;
		$config['encrypt_name'] = FALSE;
		$config['overwrite'] = TRUE;
		$new_name = md5($id_pengguna);
		$config['file_name'] = $new_name;

		$this->load->library('upload', $config); // Load konfigurasi uploadnya
		if($this->upload->do_upload('file_upload')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			// Jika gagal :
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}

	public function cek_min_mhs(){
		$this->db->select_min('ranking');
		$this->db->where('kode_jenis_kegiatan = "2"'); //mhs
		$query = $this->db->get('acc_kegiatan')->row(); 
		return $query;
	}

	// Kegiatan Pegawai
	public function cek_max_pegawai(){
		$this->db->select_max('ranking');
		$this->db->where('kode_jenis_kegiatan = "1"'); //pegawai
		$query = $this->db->get('acc_kegiatan')->row(); 
		return $query;
	}

	public function cek_id_by_rank_pegawai($rank){
		$this->db->select('*');
		$this->db->where('ranking', $rank);
		$this->db->where('kode_jenis_kegiatan = "1"'); //pegawai
		if($query = $this->db->get('acc_kegiatan')->row()){
			return $query;
		}else{
			return "data tidak ada";
		}
	}

	public function get_progress_who($id){
		$this->db->select('id_pengguna');
		$this->db->from('progress');
		$this->db->where('progress.kode_fk', $id);
		$this->db->where('progress.jenis_progress = "kegiatan"');
		$this->db->where('progress.kode_nama_progress = "1"');//diterima
		return $query = $this->db->get()->result();
	}

	public function cek_rank_by_id_pegawai($id_pengguna){
		$this->db->select('ranking');
		$this->db->where('id_pengguna', $id_pengguna);
		$this->db->where('kode_jenis_kegiatan = "1"'); //pegawai
		if($query = $this->db->get('acc_kegiatan')->row()){
			return $query;
		}else{
			return "data tidak ada";
		}	
	}

	public function get_kegiatan_pegawai(){ //menampilkan kegiatan yang diajukan user sebagai pegwai
		$id_pengguna = $this->session->userdata('id_pengguna');
		$this->db->select('*');
		$this->db->from('kegiatan');
		$this->db->join('pengguna', 'pengguna.id_pengguna = kegiatan.id_pengguna');
		$this->db->join('file_upload', 'kegiatan.kode_kegiatan = file_upload.kode_kegiatan');
		$this->db->where('pengguna.id_pengguna', $id_pengguna);

		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}
	} 

	public function hapus_pengajuan($kode_kegiatan){//hapus persetujuan kegiatan
		$this->db->where('kode_kegiatan', $kode_kegiatan);
		$this->db->delete('kegiatan');
		return TRUE;
	}

	public function cek_min_pegawai(){
		$this->db->select_min('ranking');
		$this->db->where('kode_jenis_kegiatan = "1"'); //peg
		$query = $this->db->get('acc_kegiatan')->row(); 
		return $query;
	}


	// kegiatan staf

	public function get_data_pengajuan_staf($kode_unit, $kode_jabatan){ //ambil semua kegiatan yang diajukan staf
		$this->db->select('*');
		$this->db->from('kegiatan');
		$this->db->join('pengguna', 'pengguna.id_pengguna = kegiatan.id_pengguna');
		$this->db->join('data_diri', 'data_diri.no_identitas = pengguna.no_identitas');
		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
		$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
		$this->db->join('jenis_kegiatan', 'jenis_kegiatan.kode_jenis_kegiatan = kegiatan.kode_jenis_kegiatan');
		$this->db->join('file_upload', 'file_upload.kode_kegiatan = kegiatan.kode_kegiatan');
		$this->db->where('unit.kode_unit', $kode_unit);
		$this->db->where('jabatan.kode_jabatan !=', $kode_jabatan);
		$this->db->where('jenis_kegiatan.kode_jenis_kegiatan = 1'); //kegiatan pegawai

		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}
	}

	public function get_data_pengajuan_by_id_staf($id){ //ambil data pengajuan sesuai id
		$this->db->select('*');
		$this->db->from('kegiatan');
		$this->db->join('jenis_kegiatan', 'jenis_kegiatan.kode_jenis_kegiatan = kegiatan.kode_jenis_kegiatan');
		$this->db->join('file_upload', 'file_upload.kode_kegiatan = kegiatan.kode_kegiatan');
		$this->db->join('pengguna', 'pengguna.id_pengguna = kegiatan.id_pengguna');
		$this->db->join('data_diri', 'pengguna.no_identitas = data_diri.no_identitas');
		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
		$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
		$this->db->where('kegiatan.kode_kegiatan', $id);
		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}
	}		
}