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

	public function get_data_pengguna(){ //ambil data seluruh pengguna yang terdaftar
		$this->db->select('*');
		$this->db->from('pengguna');
		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
		$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
		$this->db->join('data_diri', 'pengguna.no_identitas = data_diri.no_identitas');
		$query = $this->db->get(); 
		return $query;
	}

	public function get_data_diri_by_id($id_pengguna){ //ambil data diri user berdasarkan session
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

	public function aktif($id_pengguna){ //aktifasi akun pengguna
		$status = "aktif";
		$data = array('status' =>$status);

		$this->db->where('id_pengguna', $id_pengguna);
		$this->db->update('pengguna', $data);
		return TRUE;
	}

	public function non_aktif($id_pengguna){ //deaktifasi akun pengguna
		$status = "tidak aktif";
		$data = array('status' =>$status);

		$this->db->where('id_pengguna', $id_pengguna);
		$this->db->update('pengguna', $data);
		return TRUE;
	}

	public function insert($db, $data){
		return $query = $this->db->insert($db, $data);
	}

	public function update($id, $kode, $db, $data){
		$this->db->where($kode, $id);
		return $query = $this->db->update($db, $data);
	}

	// =====Konfigurasi Sistem=======
	//acc kegiatan (persetujuan  kegiatan)
	public function get_persetujuan_kegiatan(){
		$this->db->select('*');
		$this->db->from('acc_kegiatan');
		$this->db->join('pengguna','pengguna.id_pengguna = acc_kegiatan.id_pengguna');
		$this->db->join('jabatan', 'pengguna.kode_jabatan = jabatan.kode_jabatan');
		$this->db->join('unit', 'pengguna.kode_unit = unit.kode_unit');
		$this->db->join('data_diri', 'pengguna.no_identitas = data_diri.no_identitas');
		$this->db->join('jenis_kegiatan','acc_kegiatan.kode_jenis_kegiatan = jenis_kegiatan.kode_jenis_kegiatan');
		return $query = $this->db->get();
	}

	public function hapus($id){//hapus persetujuan kegiatan
		$this->db->where('kode_acc_kegiatan', $id);
		$this->db->delete('acc_kegiatan');
		return "berhasil";
	}

	public function get_pilihan_jabatan_by_id($id){ //mengambil jabatan dari db jabatan berdasarkan id
		$this->db->where('kode_jabatan', $id);
		$query = $this->db->get('jabatan');	
		return $query;
	}

	public function get_nama_progress(){
		return $query = $this->db->get('nama_progress');
	}
	public function get_nama_progress_by_id($id){
		$this->db->where('kode_nama_progress', $id);
		return $query = $this->db->get('nama_progress');
	}

	//jenis kegiatan
	public function get_jenis_kegiatan(){
		$this->db->select('*');
		$this->db->from('jenis_kegiatan');
		return $query = $this->db->get();
	}
	public function get_jenis_kegiatan_by_id($id){
		$this->db->where('kode_jenis_kegiatan', $id);
		return $query = $this->db->get('jenis_kegiatan');
	}

	//jenis barang
	public function get_jenis_barang(){
		return $query = $this->db->get('jenis_barang');
	}
	public function get_jenis_barang_by_id($id){
		$this->db->where('kode_jenis_barang', $id);
		return $query = $this->db->get('jenis_barang');
	}

	// jabatan
	public function get_pilihan_jabatan(){ //mengambil jabatan dari db jabatan
		$query = $this->db->get('jabatan');	
		return $query;
	}

	// Unit
	public function get_pilihan_unit(){
		$query = $this->db->get('unit');
		return $query;
	}
	public function get_pilihan_unit_by_id($id){ //mengambil jabatan dari db jabatan berdasarkan id
		$this->db->where('kode_unit', $id);
		$query = $this->db->get('unit');	
		return $query;
	}


	// Prosedur
	public function get_prosedur_pegawai(){
		$this->db->select('*');
		$this->db->from('dokumen_prosedur');
		$this->db->where('status = "aktif"');
		$this->db->where('tipe_doc = "pegawai"');
		$this->db->order_by('created_at','DESC');
		if($query = $this->db->get()){
			return $query;
		}else{
			return NULL;
		}
	}
	public function get_prosedur_mahasiswa(){
		$this->db->select('*');
		$this->db->from('dokumen_prosedur');
		$this->db->where('status = "aktif"');
		$this->db->where('tipe_doc = "mahasiswa"');
		$this->db->order_by('created_at','DESC');
		if($query = $this->db->get()){
			return $query;
		}else{
			return NULL;
		}
	}
	public function get_prosedur_barang(){
		$this->db->select('*');
		$this->db->from('dokumen_prosedur');
		$this->db->where('status = "aktif"');
		$this->db->where('tipe_doc = "barang"');
		$this->db->order_by('created_at','DESC');
		if($query = $this->db->get()){
			return $query;
		}else{
			return NULL;
		}
	}

	public function get_prosedur(){
		$this->db->order_by('created_at','DESC');
		$query = $this->db->get('dokumen_prosedur');
		return $query;
	}

	public function upload_prosedur(){ // Fungsi untuk upload file ke folder
		$config['upload_path'] = './assets/file_prosedur';
		$config['allowed_types'] = 'pdf';
		$config['remove_space'] = TRUE;
		$config['encrypt_name'] = TRUE;

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

	public function save_prosedur($upload, $data_prosedur){ // Fungsi untuk menyimpan data ke database
		$data = array(
			'tipe_doc'		=> $data_prosedur['tipe_doc'],
			'nama_file' 	=> $upload['file']['file_name'],
			'size' 			=> $upload['file']['file_size']
		);
		$this->db->insert('dokumen_prosedur', $data);
	}

	public function aktif_pro($kode_doc){ //aktifasi akun pengguna
		$status = "aktif";
		$data = array('status' =>$status);

		$this->db->where('kode_doc', $kode_doc);
		$this->db->update('dokumen_prosedur', $data);
		return TRUE;
	}

	public function non_aktif_pro($kode_doc){ //deaktifasi akun pengguna
		$status = "tidak";
		$data = array('status' =>$status);

		$this->db->where('kode_doc', $kode_doc);
		$this->db->update('dokumen_prosedur', $data);
		return TRUE;
	}
}