 <?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Man_sarprasM extends CI_Model  
 {  
 	function __construct(){
 		parent:: __construct();
 		$this->load->database();
 	}

 	// Ambil Data Pengajuan Barang 
 	function get_data_item_pengajuan(){
 		$this->db->select('*');
 		$this->db->from('item_pengajuan');
 		$this->db->join('pengguna', 'pengguna.id_pengguna = item_pengajuan.id_pengguna');
 		$this->db->join('data_diri', 'pengguna.no_identitas = pengguna.no_identitas');
 		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
 		$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
 		$this->db->join('barang', 'barang.kode_barang = item_pengajuan.kode_barang');
 		$this->db->join('jenis_barang', 'jenis_barang.kode_jenis_barang = barang.kode_jenis_barang');
 		$this->db->join('progress', 'progress.kode_fk = item_pengajuan.kode_item_pengajuan');
 		$this->db->where('progress.jenis_progress ="barang"');
 		$this->db->where('progress.kode_nama_progress ="1"');
 		$this->db->group_by('item_pengajuan.kode_item_pengajuan');
 		$query = $this->db->get();
 		if($query){
 			return $query;
 		}else{
 			return null;
 		}
 	}

	function get_data_item_pengajuan_by_id($id){ // menampilkan detail item pengajuan berdasarkan id
		$this->db->select('*');
		$this->db->from('item_pengajuan');
		$this->db->join('pengguna', 'pengguna.id_pengguna = item_pengajuan.id_pengguna');
		$this->db->join('data_diri', 'pengguna.no_identitas = data_diri.no_identitas');
		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
		$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
		$this->db->join('barang', 'barang.kode_barang = item_pengajuan.kode_barang');
		$this->db->join('jenis_barang', 'jenis_barang.kode_jenis_barang = barang.kode_jenis_barang');
		$this->db->where('kode_item_pengajuan', $id);
		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}
	}

 	public function insert_tambah_barang($data){ //post barang
 		return $this->db->insert('barang', $data);
 	}

	public function get_pilihan_jenis_barang(){ // untuk menampilkan pilihan jenis barang dengan dropdown
		$this->db->select('*');
		$this->db->from('jenis_barang');
		$query = $this->db->get();
		return $query;
	}

	public function get_pilihan_jenis_barang_by_id($kode_barang){ // untuk menampilkan pilihan jenis barang dengan dropdown
		$this->db->select('*');
		$this->db->from('jenis_barang');
		$this->db->join('barang', 'barang.kode_jenis_barang = jenis_barang.kode_jenis_barang');
		$this->db->where('barang.kode_barang',$kode_barang);
		$query = $this->db->get();
		return $query;
	}

	public function insert_pengajuan_barang($data){   //insert tabel item_pengajuan
		if($this->db->insert('item_pengajuan', $data)){
			return $this->db->insert_id(); //return last insert ID
		} 
	} 

	public function upload(){ // Fungsi untuk upload gambar ke folder
		$config['upload_path'] = './assets/file_gambar'; // alamat folder penyimpanan gambar
		$config['allowed_types'] = 'jpg|png|jpeg|PNG';	 // tipe file yang boleh diunggah
		$config['max_size']	= '2048';					 // maksimal ukuran file yang diunggah
		$config['remove_space'] = TRUE;					 // menghilangkan spasi pada nama file
		$config['encrypt_name'] = TRUE;					 // mengenkripsi nama file yang diunggah

		$this->load->library('upload', $config); // Load konfigurasi uploadnya
		if($this->upload->do_upload('file_gambar')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => ''); // file akan di upload dan pindah ke folder penyimpanan gambar
			return $return;
		}else{
			// Jika gagal :
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors()); // akan muncul pesan error 
			return $return;
		}
	}

	function get_data_klasifikasi_barang(){ // menampilkan data barang yang belum memiliki jenis barang / belum terklasifikasi
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->join('jenis_barang','jenis_barang.kode_jenis_barang=barang.kode_jenis_barang');
		$this->db->where('barang.kode_jenis_barang = "3"');
		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}
	}

	public function update_klasifikasi_barang($kode_barang, $data){ //update barang dengan klasifikasi
		$this->db->where('kode_barang', $kode_barang);
		$this->db->update('barang', $data);
		return TRUE;
	}

	public function update_persetujuan($data, $kode_fk){ //update persetujuan progres jadi proses
		$this->db->where('item_pengajuan.kode_item_pengajuan', $kode_fk);
		$this->db->update('item_pengajuan', $data);
		return TRUE;
	}

	public function update_persetujuan_tersedia($data, $kode_item_pengajuan){ //update persetujuan status persediaan sama progres
		$this->db->where('item_pengajuan.kode_item_pengajuan', $kode_item_pengajuan);
		$this->db->update('item_pengajuan', $data);
		return TRUE;
	}

	function get_ajukan_barang(){ //menampilkan pengajuan barang yang diajukan user sebagai pegwai
		$id_pengguna = $this->session->userdata('id_pengguna');
		$this->db->select('*');
		$this->db->from('item_pengajuan');
		$this->db->join('pengguna', 'pengguna.id_pengguna = item_pengajuan.id_pengguna');
		$this->db->join('barang', 'barang.kode_barang = item_pengajuan.kode_barang');
		$this->db->join('jenis_barang', 'jenis_barang.kode_jenis_barang = barang.kode_jenis_barang');
		$this->db->where('pengguna.id_pengguna', $id_pengguna);

		$query = $this->db->get();
		if($query){
			return $query;
		}else{
			return null;
		}
	} 

	public function get_barang_setuju(){ // menampilkan data item pengajuan barag yang memiliki status pengajuan proses atau pending
		$this->db->select('*');
		$this->db->from('item_pengajuan');
		$this->db->join('pengguna', 'pengguna.id_pengguna = item_pengajuan.id_pengguna');
		$this->db->join('jabatan', 'jabatan.kode_jabatan = pengguna.kode_jabatan');
		$this->db->join('unit', 'unit.kode_unit = pengguna.kode_unit');
		$this->db->join('barang', 'barang.kode_barang = item_pengajuan.kode_barang');
		$this->db->join('jenis_barang', 'jenis_barang.kode_jenis_barang = barang.kode_jenis_barang');
		$this->db->join('progress', 'progress.kode_fk = item_pengajuan.kode_item_pengajuan');
		$this->db->where('item_pengajuan.status_pengajuan ="proses" OR item_pengajuan.status_pengajuan = "tunda" OR item_pengajuan.status_pengajuan = "pengajuan"');
		$this->db->where('progress.jenis_progress ="barang"');
		$this->db->where('progress.kode_nama_progress ="1"');
		$this->db->group_by('item_pengajuan.kode_item_pengajuan');
		$query = $this->db->get();
		return $query;


	}

	public function get_progress_barang_by_id($kode_item_pengajuan, $id_pengguna){ //untuk mengecek apakah user sudah memberikan progres barang di item pengajuan . Berhubungan dengan tombol persetujuan akan hilang jika sudah dimasukan persetujuan
		$this->db->select('*');
		$this->db->from('progress');
		$this->db->where('jenis_progress = "barang"');
		$this->db->where('kode_fk', $kode_item_pengajuan);
		$this->db->where('id_pengguna', $id_pengguna);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_detail_progress_barang_by_id($id){ //menampilkan progress masing masing item pengajuan
		$this->db->select('*');
		$this->db->from('progress');
		$this->db->join('pengguna', 'progress.id_pengguna = pengguna.id_pengguna');
		$this->db->join('data_diri', 'pengguna.no_identitas = data_diri.no_identitas');
		$this->db->join('jabatan', 'pengguna.kode_jabatan = jabatan.kode_jabatan');
		$this->db->join('unit', 'pengguna.kode_unit = unit.kode_unit');
		$this->db->join('nama_progress', 'progress.kode_nama_progress = nama_progress.kode_nama_progress');
		$this->db->where('progress.kode_fk', $id);
		$this->db->where('progress.jenis_progress = "barang"'); //barang
		$query = $this->db->get();
		return $query;
	}

	public function get_pilihan_barang(){ // untuk menampilkan dropdown pilihan barang di halaman tambah pengajuan barang
		$this->db->select('*');
		$this->db->from('barang');
		$this->db->join('jenis_barang', 'barang.kode_jenis_barang = jenis_barang.kode_jenis_barang');
		$query = $this->db->get();
		return $query;
	}

	public function setuju($kode){ //mengubah status item_pengajuan menjadi pengajuan karena item pengajuan masuk ke dalam RAb
		$status = 'pengajuan';
		$data = array(
			'status_pengajuan' => $status
		);
		$this->db->where('kode_item_pengajuan', $kode);
		$this->db->update('item_pengajuan',$data);
		return TRUE;
	}

	public function tunda($kode){ //mengubah status item_pengajuan menjadi pengajuan karena item pengajuan masuk ke dalam RAb
		$status = 'tunda';
		$data = array(
			'status_pengajuan' => $status
		);
		$this->db->where('kode_item_pengajuan', $kode);
		$this->db->update('item_pengajuan',$data);
		return TRUE;
	}

	public function data_rab_all(){ // menampilkan data yang siap untuk diajukan untuk RAB
		$this->db->select('*');
		$this->db->from('item_pengajuan');
		$this->db->join('pengguna', 'pengguna.id_pengguna=item_pengajuan.id_pengguna');
		$this->db->join('barang', 'barang.kode_barang=item_pengajuan.kode_barang');
		$this->db->join('data_diri', 'data_diri.no_identitas=pengguna.no_identitas');
		$this->db->join('jabatan', 'jabatan.kode_jabatan=pengguna.kode_jabatan');
		$this->db->join('unit', 'unit.kode_unit=pengguna.kode_unit');
		$this->db->where('item_pengajuan.status_pengajuan = "pengajuan"');
		$query = $this->db->get()->result();
		return $query;
	}

	public function get_pengajuan_rab(){
		$this->db->select('*');
		$this->db->from('pengajuan');
		$query = $this->db->get();
		return $query;
	}
}