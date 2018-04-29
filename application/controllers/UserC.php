 <?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class UserC extends CI_Controller {  
   function __Construct(){  
    parent::__Construct();  
    $this->load->database();  
    $this->load->model('UserM');  
  }    
  public function halaman_daftar() //get option jabatan
  {
   $data['prosedur_pegawai'] = $this->UserM->get_prosedur_pegawai()->result();
   $data['prosedur_mahasiswa'] = $this->UserM->get_prosedur_mahasiswa()->result();
   $data['prosedur_barang'] = $this->UserM->get_prosedur_barang()->result();
   $data['jabatan'] = $this->UserM->get_pilihan_jabatan();
   $data['unit'] = $this->UserM->get_pilihan_unit();
   $this->load->view('RegisterV',$data);
 }   
  public function daftar()  //post pendaftaran
  {  
    $this->form_validation->set_rules('no_identitas', 'Nomor Identitas', 'required|is_unique[pengguna.no_identitas]');  
    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');  
    $this->form_validation->set_rules('jen_kel', 'Jenis Kelamin', 'required');  
    $this->form_validation->set_rules('tmp_lahir', 'Tempat Lahir', 'required');  
    $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');  
    $this->form_validation->set_rules('kode_jabatan', 'Kode Jabatan', 'required');  
    $this->form_validation->set_rules('kode_unit', 'Kode Unit', 'required');  
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');  
    $this->form_validation->set_rules('no_hp', 'Nomor Handphone', 'required');  
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[pengguna.email]');  
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[50]|matches[confirmpswd]');
    $this->form_validation->set_rules('confirmpswd', 'Password Confirmation', 'trim|required|min_length[6]|max_length[50]'); 
    $this->form_validation->set_message('is_unique', 'Data %s sudah dipakai'); 
    if ($this->form_validation->run() == FALSE)  
    {  
      $this->halaman_daftar();
      // redirect(base_url('UserC/halaman_daftar'));  
      // $this->load->view('RegisterV');  
    }else{  
      $no_identitas   = $_POST['no_identitas'];  
      $nama           = $_POST['nama'];  
      $jen_kel        = $_POST['jen_kel'];  
      $tmp_lahir      = $_POST['tmp_lahir'];  
      $tgl_lahir      = date('Y-m-d',strtotime($_POST['tgl_lahir']));      
      $kode_jabatan   = $_POST['kode_jabatan'];  
      $kode_unit      = $_POST['kode_unit'];  
      $alamat         = $_POST['alamat'];  
      $no_hp          = $_POST['no_hp'];  
      $email          = $_POST['email'];  
      $password       = $_POST['password'];  
      $passhash       = hash('md5', $password);  
      $email_encryption = md5($email);  
      $status_email   = "0";
      $status         = "tidak aktif"; 

      $exp_date = date('Y-m-d', strtotime(' + 1 days'));

      $data_pengguna  = array(
        'no_identitas'        => $no_identitas,
        'kode_unit'           => $kode_unit,
        'kode_jabatan'        => $kode_jabatan,  
        'email'               => $email,  
        'password'            => $passhash,  
        'status'              => $status,  
        'exp_date'            => $exp_date,
        'status_email'        => $status_email);  

      $data_diri      = array(  
        'no_identitas'        => $no_identitas,
        'nama'                => $nama,  
        'jen_kel'             => $jen_kel,  
        'tmp_lahir'           => $tmp_lahir,  
        'tgl_lahir'           => $tgl_lahir,  
        'alamat'              => $alamat,  
        'no_hp'               => $no_hp);


      if($this->UserM->insert_data_diri($data_diri)){  //jika berhasil register
        $insert_id = $this->UserM->insert_data_pengguna($data_pengguna);
        if($insert_id){
            $this->session->set_userdata('id_pengguna', $insert_id); //ambil no_identitas buat resend konfirmasi email
            try{
              $this->sendemail($email, $email_encryption); //kirim email
              redirect(base_url('UserC/resend_email'));  
            }catch(Exception $e){
              var_dump($e);
            }
            redirect(base_url('UserC/resend_email'));  

          }else{
            $this->hapus($no_identitas);
            $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Gagal melakukan pendaftaran. Silahkan mencoba kembali pengguna. . .</div>');  
            redirect(base_url('UserC/halaman_daftar')); 
          }
        }else{
          $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Gagal melakukan pendaftaran. Silahkan mencoba kembali. . data diri .</div>');  
          redirect(base_url('UserC/halaman_daftar'));  
        }
      }  
    }  

  function sendemail($email,$email_encryption){   //kirim email konfirmasi
    $url        = base_url()."UserC/confirmation/".$email_encryption;  
    $from_mail  = 'dtedi.svugm@gmail.com';
    $to         = $email;

    $subject    = 'Verifikasi Pedaftaran Akun';
    $data       = array(
      'email'=> $email_encryption
    );
    $message    = $this->load->view('email.php',$data,TRUE);
    // '<h1>'.$url.'</h1><span style="color: red;"> Departemen Teknik Elektro dan Informatika </span>';

    $headers    = 'MIME-Version: 1.0' . "\r\n";
    $headers    .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers    .= 'To:  <'.$to.'>' . "\r\n";
    $headers    .= 'From: Departemen Teknik Elektro dan Informatika <'.$from_mail.'>' . "\r\n";

    $sendtomail = mail($to, $subject, $message, $headers);
    if($sendtomail ) {
     $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Terima Kasih sudah melakukan pendaftaran akun. Silahkan cek email anda : <b>'.$email.'</b> dan klik tautan yang telah dikirimkan untuk <b>konfirmasi pendaftaran. </b><br> </div>');
     redirect(base_url('UserC/resend_email'));  
   }else {
    $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Gagal melakukan pendaftaran. Silahkan mencoba kembali. . .</div>');  
    redirect(base_url('UserC/halaman_daftar'));  
    // echo 'Failed';
  }
}

public function resend_email(){
  $this->load->view('resend_email');
}

public function post_resend_email(){
  $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[pengguna.email]');  
  $this->form_validation->set_rules('id_pengguna', 'ID pengguna', 'required');  
  $this->form_validation->set_message('is_unique', 'Data %s sudah dipakai'); 
  
  if ($this->form_validation->run() == FALSE) {
    $this->resend_email();
  }else{
    $id_pengguna  = $_POST['id_pengguna'];
    $email        = $_POST['email'];
    $email_encryption = md5($email);  

    $data_resend = array(
      'email'             => $email);

    $status = $this->UserM->get_pengguna_by_id($id_pengguna)->result()[0]->status_email;

    if($status == "1"){
     $this->session->set_flashdata('error','Email anda sudah berhasil dikonfirmasi. Silahkan <a href="'.base_url('LoginC').'">masuk</a> untuk melanjutkan...');
     redirect('UserC/resend_email');
   }else{
    if($this->UserM->insert_data_resend($data_resend, $id_pengguna)){
      $this->sendemail($email, $email_encryption);
      // $this->session->set_flashdata('sukses','Email anda berhasil sudah berhasil dikirim ulang. Silahkan cek email anda : <b>'.$email.'</b> dan klik tautan yang telah dikirimkan untuk <b>konfirmasi pendaftaran....');
    }else{
      echo "email gagal";
    } 
  }
}
}

  public function confirmation($key){  //post link konfirmasi
   $exp_date     = $this->UserM->get_pengguna_by_email($key)->result()[0]->exp_date; //ambil data exp by email
   $status_email = $this->UserM->get_pengguna_by_email($key)->result()[0]->status_email; //ambil data status by email
   $no_identitas = $this->UserM->get_pengguna_by_email($key)->result()[0]->no_identitas; //ambil no identitas by email
   $now_date     = date('Y-m-d');

   if($now_date > $exp_date && $status_email =='0'){ //jika konfirmasi diatas exp date maka akan hapus data diri dan pengguna si empunya email
    $this->UserM->delete_pengguna_by_email($key);
    $this->UserM->delete_data_diri_by_no_identitas($no_identitas);
    $this->session->set_flashdata('error','Tautan konfirmasi email anda sudah kadaluwarsa, Silahkan mencoba daftar kembali ...');
    redirect('LoginC');
  }else{
    if($this->UserM->verifyemail($key)){  
      $this->session->set_flashdata('sukses','Email anda berhasil dikonfirmasi. Silahkan masuk ...');
      redirect('LoginC');
    }else{  
      $this->session->set_flashdata('error','Email anda belum berhasil dikonfirmasi. Silahkan mencoba kembali ...');
      redirect('LoginC');
    }  
  }
}  
}  