 <?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class UserM extends CI_Model  
 {  
 	function __construct(){
 		parent:: __construct();
 		$this->load->database();
 	} 
	public function insert_data_pengguna($data){ //post pengguna
		$this->db->insert('pengguna', $data);
		return $this->db->insert_id();

	}
	public function insert_data_diri($data){
		$this->db->insert('data_diri', $data);
		return TRUE;
	}
	public function hapus($id){
		$this->db->where('id_pengguna', $id);
		$this->db->delete('data_diri');
		return TRUE;
	}
	public function verifyemail($key){  //post konfirmasi email ubah value status_email jadi 1 (aktif)
		$data = array(
			'status_email' => '1',
		);  
		$this->db->where('md5(email)', $key);
		return $this->db->update('pengguna', $data);  
	}

	public function get_pengguna_by_email($key){
		// $this->db->select('')
		$this->db->where('md5(email)', $key);
		$query = $this->db->get('pengguna');
		return $query;
	}

	public function delete_pengguna_by_email($key){
		$this->db->where('md5(email)', $key);
		$this->db->delete('pengguna');
		return TRUE;
	}

	public function delete_data_diri_by_no_identitas($no_identitas){
		$this->db->where('no_identitas', $no_identitas);
		$this->db->delete('data_diri');
		return TRUE;
	}

	public function insert_data_resend($data, $id_pengguna){ //post resend data email
		$this->db->where('id_pengguna',$id_pengguna); 
		return $this->db->update('pengguna',$data);
	}  

	// jabatan
	public function get_pilihan_jabatan(){ //mengambil jabatan dari db jabatan
		$query = $this->db->get('jabatan');	
		return $query;
	}
	public function get_pilihan_jabatan_by_id($id){ //mengambil jabatan dari db jabatan berdasarkan id
		$this->db->where('kode_jabatan', $id);
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


	//jenis barang
	public function get_jenis_barang(){
		return $query = $this->db->get('jenis_barang');
	}
	public function get_jenis_barang_by_id($id){
		$this->db->where('kode_jenis_barang', $id);
		return $query = $this->db->get('jenis_barang');
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

	// nama progress
	public function get_nama_progress(){
		return $query = $this->db->get('nama_progress');
	}
	public function get_nama_progress_by_id($id){
		$this->db->where('kode_nama_progress', $id);
		return $query = $this->db->get('nama_progress');
	}

	public function update($id, $kode, $db, $data){
		$this->db->where($kode, $id);
		return $query = $this->db->update($db, $data);
	}
	public function insert($db, $data){
		return $query = $this->db->insert($db, $data);
	}

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


	public function edit_data_diri($no_identitas, $data){ //edit data diri
		$this->db->where('no_identitas', $no_identitas);
		$this->db->update('data_diri', $data);
		return TRUE;
	}
	
	function get_kegiatan_pegawai(){ //menampilkan kegiatan yang diajukan user sebagai pegwai
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

	public function insert_pengajuan_kegiatan($data){   //post pengguna_jabatan
		if($this->db->insert('kegiatan', $data)){
			return $this->db->insert_id(); //return last insert ID
		} 
	}  

	public function upload(){ // Fungsi untuk upload file ke folder
		$config['upload_path'] = './assets/file_upload';
		$config['allowed_types'] = 'pdf';
		$config['max_size']	= '';
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

	public function upload_profil(){ // Fungsi untuk upload file ke folder
		$config['upload_path'] = './assets/image/profil';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
		$config['remove_space'] = TRUE;
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config); // Load konfigurasi uploadnya
		if($this->upload->do_upload('foto_profil')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$file_data = $this->upload->data();

			$max_height = 300;
			$max_width = 300;
			if ($file_data['image_width']>$max_width || $file_data['image_height']>$max_height)
			{
			    $configResize = array(
			                        'source_image' => $file_data['upload_path'],
			                        'width' => $max_width,
			                        'height' => $max_height,
			                        'maintain_ratio' => TRUE
			                );

			      $this->load->library('image_lib',$configResize);
			      $this->image_lib->resize();  
			 }

			// $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			// return $return;
		}else{
			// Jika gagal :
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}

	public function simpan_upload($id_pengguna, $gambar){ // Fungsi untuk menyimpan data ke database
		$data = array(
			'file_profil' 	=> $gambar
		);
		$this->db->where('id_pengguna', $id_pengguna);
		$this->db->update('pengguna', $data);
	}

	public function save_prosedur($upload, $data_prosedur){ // Fungsi untuk menyimpan data ke database
		$data = array(
			'tipe_doc'		=> $data_prosedur['tipe_doc'],
			'nama_file' 	=> $upload['file']['file_name'],
			'size' 			=> $upload['file']['file_size']
		);
		$this->db->insert('dokumen_prosedur', $data);
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

	public function get_pilihan_nama_progress(){ //fungsi untuk ambil pilihan nama progress
		$query = $this->db->get('nama_progress');
		return $query;
	}

	public function insert_progress($data){   //post progress
		$query = $this->db->insert('progress', $data);
		return $query; 
	}

	public function get_id_pimpinan($kode_unit){
		$this->db->select('pengguna.id_pengguna');
		$this->db->from('pengguna');
		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
		$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
		$this->db->where('unit.kode_unit', $kode_unit);
		$this->db->where('jabatan.kode_jabatan != "4"');

		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			echo "kasiyan deh ga punya pimpinan";
		}
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

	// public function get_data_pengajuan_by_id($id){ //ambil data pengajuan sesuai id
	// 	$this->db->select('*');
	// 	$this->db->from('kegiatan');
	// 	$this->db->join('jenis_kegiatan', 'jenis_kegiatan.kode_jenis_kegiatan = kegiatan.kode_jenis_kegiatan');
	// 	$this->db->join('file_upload', 'file_upload.kode_kegiatan = kegiatan.kode_kegiatan');
	// 	$this->db->join('progress', 'progress.kode_fk = kegiatan.kode_kegiatan');
	// 	$this->db->join('pengguna', 'pengguna.id_pengguna = progress.id_pengguna');
	// 	$this->db->join('data_diri', 'pengguna.no_identitas = data_diri.no_identitas');
	// 	$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
	// 	$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
	// 	$this->db->where('progress.jenis_progress = "kegiatan"');
	// 	$this->db->where('kegiatan.kode_kegiatan', $id);
 // 		// $this->db->where('progress.kode_nama_progress = "1"');
	// 	$query = $this->db->get();
	// 	if($query){
	// 		return $query;
	// 	}else{
	// 		return null;
	// 	}
	// }	

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
	// =================BARANG================

	function get_barang(){ //menampilkan data seluruh barang
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->join('jenis_barang','jenis_barang.kode_jenis_barang = barang.kode_jenis_barang');
		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}

	}

	public function ubah_data_barang($id, $data){ //edit data diri
		$this->db->where('kode_barang', $id);
		$this->db->update('barang', $data);
		return TRUE;
	}

	function get_barang_by_kode_barang($kode_barang){ //menampilkan data seluruh barang
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->join('jenis_barang','jenis_barang.kode_jenis_barang = barang.kode_jenis_barang');
		$this->db->where('barang.kode_barang', $kode_barang);
		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}

	}

	function get_ajukan_barang(){ //menampilkan pengajuan barang yang diajukan user sebagai pegwai
		$no_identitas = $this->session->userdata('no_identitas');
		$this->db->select('*');
		$this->db->from('item_pengajuan');
		$this->db->join('pengguna', 'pengguna.no_identitas = item_pengajuan.no_identitas');
		$this->db->join('barang', 'barang.kode_barang = item_pengajuan.kode_barang');
		$this->db->join('jenis_barang', 'jenis_barang.kode_jenis_barang = barang.kode_jenis_barang');
		$this->db->where('pengguna.no_identitas', $no_identitas);

		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}
	} 

	public function get_pengguna_by_id($id_pengguna){
		$this->db->select('status_email');
		$this->db->from('pengguna');
		$this->db->where('id_pengguna', $id_pengguna);
		return $this->db->get();
	}
	
	public function get_pilihan_barang(){ // untuk menampilkan dropdown pilihan barang di halaman tambah pengajuan barang
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->join('jenis_barang', 'barang.kode_jenis_barang = jenis_barang.kode_jenis_barang');
		$query = $this->db->get();
		return $query;
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

	public function get_progress_who($id){
		$this->db->select('id_pengguna');
		$this->db->from('progress');
		$this->db->where('progress.kode_fk', $id);
		$this->db->where('progress.jenis_progress = "kegiatan"');
		$this->db->where('progress.kode_nama_progress = "1"');//diterima
		return $query = $this->db->get()->result();
		// return $query->num_rows();
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

	public function get_progress_by_id($id){
		$this->db->select('*');
		$this->db->from('progress');
		$this->db->join('nama_progress','nama_progress.kode_nama_progress = progress.kode_nama_progress');
		$this->db->where('progress.id_pengguna', $id);
		$this->db->where('progress.jenis_progress = "kegiatan"');
		$this->db->order_by('progress.created_at','DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query;
	}

	public function cek_max(){
		$this->db->select_max('ranking');
		$this->db->where('kode_jenis_kegiatan = "2"'); //mhs
		$query = $this->db->get('acc_kegiatan')->row(); 
		return $query;
	}

	public function cek_min_pegawai(){
		$this->db->select_min('ranking');
		$this->db->where('kode_jenis_kegiatan = "1"'); //peg
		$query = $this->db->get('acc_kegiatan')->row(); 
		return $query;
	}

	public function cek_min_mhs(){
		$this->db->select_min('ranking');
		$this->db->where('kode_jenis_kegiatan = "2"'); //mhs
		$query = $this->db->get('acc_kegiatan')->row(); 
		return $query;
	}

	public function cek_id_staf_keu(){
		$this->db->select('id_pengguna');
		$this->db->from('pengguna');
		$this->db->where('kode_unit = "3"');
		$this->db->where('kode_jabatan = "4"');
		$this->db->where('status = "aktif"');
		$query = $this->db->get();
		return $query;
	}
	public function cek_id_by_rank($rank){
		$this->db->select('*');
		$this->db->where('ranking', $rank);
		$this->db->where('kode_jenis_kegiatan = "2"'); //mhs
		if($query = $this->db->get('acc_kegiatan')->row()){
			return $query;
		}else{
			return "data tidak ada";
		}
	}

	public function cek_rank_by_id($id_pengguna){
		$this->db->select('ranking');
		$this->db->where('id_pengguna', $id_pengguna);
		$this->db->where('kode_jenis_kegiatan = "2"'); //mhs
		if($query = $this->db->get('acc_kegiatan')->row()){
			return $query;
		}else{
			return "no";
		}	
	}

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