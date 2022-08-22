<?php

namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\AdminModel;
use App\Models\UsersModel;
use App\Models\KegiatanModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Admin extends BaseController
{
	protected $AdminModel;
	public function __construct()
	{
		$this->AdminModel = new AdminModel();
		$this->UsersModel  = new UsersModel();
		$this->KegiatanModel  = new KegiatanModel();
	}
	//--------------------------------------------------------------------
	public function index()
	{
		$data = [
			'title'			=>	'KEPEGAWAIAN NHM',
			'detail'		=> $this->AdminModel->profile_users()
		];
		return view('admin/index', $data);
	}
	
	// MASTER USERS
	//--------------------------------------------------------------------
	public function registrasi()
	{
		$data =  [
			'title' 		=> 'USERS REGISTER',
		];
		return view('Auth/registrasi', $data);
	}
	//--------------------------------------------------------------------
	public function forgout()
	{
		$data =  [
			'title' 		=> 'FORGOUT PASSWORD',
		];
		return view('Auth/forgout', $data);
	}
	//--------------------------------------------------------------------
	public function setting()
	{

		$data = [

			'title'		=> 'MASTER DATA USERS',
			'users'		=> $this->AdminModel->get_users()

		];
		return view('admin/page/user/tampil_user', $data);
	}
	//--------------------------------------------------------------------
	public function myprofile()
	{

		$data = [

			'title'		=> 'PROFILE USER',
			'detail'		=> $this->AdminModel->profile_users()

		];
		return view('admin/page/user/tampil_detail', $data);
	}
	//--------------------------------------------------------------------
	public function get_updated_users($userid)
	{

		$data = [

			'title'		=> 'UPDATED DATA USERS',
			'users'		=> $this->AdminModel->get_update_users($userid),
			'role'		=> $this->AdminModel->get_role(),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/user/updated_users', $data);
	}
	//----------------------------------------------------------------------------
	public function updated_users($users)
	{
		$data = ['data' 				=> $this->request->getVar('userid')];

		if (!$this->validate([
			'foto_users' => [

				'rules'		=> 'mime_in[foto_users,image/png,image/jpg,image/jpeg]|is_image[foto_users]',

				'errors'	=> [
					'mime_in'	=> '{field} harus berformat jpg/jpeg/png.!',
					'is_image'	=> '{field} harus berformat jpg/jpeg/png.!'
				]
			]

		])) {
			return redirect()->to('/admin/get_updated_users/' . $data['data'])->withInput();
		}

		$foto_users = $this->request->getFile('foto_users');
		if ($foto_users->getError() == 4) {
			$nama_foto = $this->request->getVar('namafotolama');
		} else {
			$nama_foto = $foto_users->getRandomName();
			$foto_users->move('assets/home/images', $nama_foto);
			// unlink('assets/home/images/'. $this->request->getVar('namafotolama'));
		}
		$users = [
			'user_id'		=> $this->request->getVar('userid'),
			'group_id' 		=> $this->request->getVar('role'),

		];
		$this->AdminModel->updated_users_role($users);
		$users = [
			'id'			=> $this->request->getVar('userid'),
			'fullname' 		=> $this->request->getVar('fullname'),
			'username'  	=> $this->request->getVar('username'),
			'email'  		=> $this->request->getVar('email'),
			'no_wa'  		=> $this->request->getVar('no_wa'),
			'user_img'  	=> $nama_foto,


		];
		$this->AdminModel->updated_users($users);
		session()->setFlashdata('pesan', 'Data '. $users['fullname'] .' Berhasil diupdate.');
		return redirect()->to('/admin/setting');
	}
	//--------------------------------------------------------------------
	public function delete_users($userid)
	{

		$this->AdminModel->delete_users($userid);
		session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
		return redirect()->to('/admin/setting');
	}

	//--------------------------------------------------------------------
	public function get_users()
	{

		$data = [

			'title'		=> 'DATA USERS',
			'data'		=> $this->AdminModel->get_karyawan()

		];
		return view('admin/page/data_karyawan/tampil_data', $data);
	}
	//--------------------------------------------------------------------
	public function tambah_users()
	{
		$data = [

			'title'		=> 'TAMBAH DATA USERS',
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/data_karyawan/registrasi', $data);
	}

	//--------------------------------------------------------------------
	public function save_users()
	{
		if (!$this->validate([

			'nama_lengkap' => [

				'rules'		=> 'required|min_length[3]|max_length[55]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'min_length'	=>	'{field} minimal 3 huruf.!',
					'max_length'	=>	'{field} maximal 55 huruf.!'
				]
			],
			'email' => [

				'rules'		=> 'required|min_length[6]|max_length[50]|valid_email|is_unique[tb_users.user_email]',

				'errors'	=> [
					'required'		=> '{field} harus diisi.!',
					'min_length'	=>	'{field} minimal 6 character.!',
					'max_length'	=>	'{field} maximal 50 character.!',
					'is_unique'		=>	'{field} email sudah ada.!',
					'valid_email'	=>	'{field} format bukan Email.!'
				]
			],
			'username' => [

				'rules'		=> 'required|min_length[6]|max_length[12]|is_unique[tb_users.user_name]',

				'errors'	=> [
					'required'		=> '{field} harus diisi.!',
					'min_length'	=>	'{field} minimal 6 digit nomor.!',
					'max_length'	=>	'{field} maximal 12 digit nomor.!',
					'is_unique'		=>	'{field} email sudah ada.!'
					
				]
			],
			'password' => [

				'rules'		=> 'required|min_length[6]|max_length[200]',

				'errors'	=> [
					'required'		=> '{field} harus diisi.!',
					'min_length'	=>	'{field} minimal 6 character.!',
					'max_length'	=>	'{field} maximal 20 character.!',
					'valid_email'	=>	'{field} format bukan Email.!'
				]
			],
			'pass_confirm' => [

				'rules'		=> 'matches[password]',

				'errors'	=> [
					'matches'		=> '{field} tidak sama.!'
					
				]
			]


		])) {
			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('tambah_users')->withInput()->with('validation', $validation);
		}
		$data = [
				'user_name' 	=> $this->request->getVar('username'),
				'nama_lengkap' 	=> $this->request->getVar('nama_lengkap'),
				'foto' 			=> 'default.svg',
				'user_email' 	=> $this->request->getVar('email'),
				'user_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
			];
			// dd($data);
			$this->UsersModel->save($data);
			$data = [
				'user_name' 	=> $this->request->getVar('username')
			];
			// dd($data);
			$this->AdminModel->saveBiodata($data);
			session()->setFlashdata('pesan', "Data berhasil di tambahkan");
		return redirect()->to('/admin/get_users');
	}
	//--------------------------------------------------------------------
	public function update_users($user_id)
	{
		$data = [

			'title'		=> 'UPDATED DATA USERS',
			'users'		=> $this->AdminModel->update_users($user_id),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/data_karyawan/updated', $data);
	}

	public function save_update_users($user_id)
	{
		if (!$this->validate([

			'nama_lengkap' => [

				'rules'		=> 'required|min_length[3]|max_length[55]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'min_length'	=>	'{field} minimal 3 huruf.!',
					'max_length'	=>	'{field} maximal 55 huruf.!'
				]
			],
			'email' => [

				'rules'		=> 'required|min_length[6]|max_length[50]|valid_email',

				'errors'	=> [
					'required'		=> '{field} harus diisi.!',
					'min_length'	=>	'{field} minimal 6 character.!',
					'max_length'	=>	'{field} maximal 50 character.!',
					'valid_email'	=>	'{field} format bukan Email.!'
				]
			],
			'username' => [

				'rules'		=> 'required|min_length[6]|max_length[12]',

				'errors'	=> [
					'required'		=> '{field} harus diisi.!',
					'min_length'	=>	'{field} minimal 6 digit nomor.!',
					'max_length'	=>	'{field} maximal 12 digit nomor.!',
				]
			]


		])) {
			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('/admin/update_users/'.$this->request->getVar('id'))->withInput()->with('validation', $validation);
		}
		$data = [
				'user_id' 		=> $this->request->getVar('id'),
				'user_name' 	=> $this->request->getVar('username'),
				'nama_lengkap' 	=> $this->request->getVar('nama_lengkap'),
				'user_email' 	=> $this->request->getVar('email')
			];
			// dd($data);
			$this->AdminModel->save_update_users($data);
			session()->setFlashdata('pesan', "Data berhasil di update");
		return redirect()->to('/admin/get_users');
	}

	//-----------------------------------------------------------------------

	public function deleteUsers($user_id)
	{
		$this->AdminModel->deleteUsers($user_id);

			session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
			return redirect()->to('/admin/get_users');
	}

	//--------------------------------------------------------------------
	public function import()
	{

		$data = [

			'title'		=> 'DATA USERS',
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/data_karyawan/import_data', $data);
	}
	//---------------------------------------------------------------------
	// //SAVE INMPORT
	public function save_add_import()
	{
		if(!$this->validate([
			'data_karyawan' =>[
				'rules'		=> 'ext_in[data_karyawan,xlsx,xls]',
					'errors'	=> [
					'ext_in'	=> '{field} File harus berformat xlsx/xls.!',
				]
			]
		])){
			
			return redirect()->to('import')->withInput();
		}
		$file_excel = $this->request->getFile('data_karyawan');
		$ext = $file_excel->getClientExtension();
		if($ext == 'xls'){
			$render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		}else{
			$render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}

		$spreadsheet = $render->load($file_excel);

		$data = $spreadsheet->getActiveSheet()->toArray();
		$pesan_error = [];
		$jmlerror = 0;
		$jmlberhasil = 0;
		foreach ($data as $x => $row) {
			if($x == 0){
				continue;
			}
			$nama 		= $row[1];
			$user 		= $row[2];
			$pwd		= $row[3];
			$email		= $row[4];
			$foto		= $row[5];
			$db = \Config\Database::connect();
			$chekuser = $db->table('tb_users')->getWhere(['user_name' => $user])->getResult();
			if(count($chekuser) > 0) {
				$jmlerror++;
				session()->setFlashdata('gagal', "$jmlerror NIDN/KARPEG Sudah Ada/Duplicate");
			}else{
				$data = [
					'nama_lengkap'	=>$nama,
					'user_name'		=>$user,
					'user_password'	=> password_hash($pwd,PASSWORD_DEFAULT),
					'user_email' 	=>$email,
					'foto' 			=>$foto
				];
				// dd($data);
				$this->UsersModel->save($data);
				$data = [
					'user_name'		=>$user
				];
				$this->AdminModel->saveBiodata($data);
				$jmlberhasil++;
			}
		}
		session()->setFlashdata('pesan', "$jmlberhasil Data Berhasil Insert <br> $jmlerror Data Gagal Insert");
		return redirect()->to('/admin/import');
	}
	//-------------------------------------------------------------------------------
	public function setting_jam ()
	{
		$data = [

			'title'		=> 'SETTING JAM KANTOR',
			'data'		=> $this->AdminModel->get_jam(),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/setting/tampil_data', $data);
	}
	//-----------------------------------------------------------------------
	public function get_jam($id_waktu)
	{
		$data = [
			'title'			=> 'UPDATE JAM KANTOR',
			'validation'	=> \Config\Services::Validation(),
			'data'			=> $this->AdminModel->get_update_jam($id_waktu)

		];
		return view('admin/page/setting/update_data', $data);
	}
	//---------------------------------------------------------------------
	public function save_update_jam($data)
	{
		if (!$this->validate([
			'jam_masuk' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]

			],
			'jam_pulang' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]

			]

		])) {

			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('/admin/get_jam/' . $this->request->getVar('id_waktu'))->withInput()->with('validation', $validation);
		}

		$data = [
			'id_waktu'		=> $this->request->getVar('id'),
			'jam_masuk' 	=> $this->request->getVar('jam_masuk'),
			'jam_pulang' 	=> $this->request->getVar('jam_pulang'),
			'keterangan'  	=> $this->request->getVar('keterangan'),
			'tgl_buat'  	=> $this->request->getVar('tgl'),
		];
		// dd($data);
		$this->AdminModel->save_update_jam($data);
		session()->setFlashdata('pesan', 'Data Berhasil diupdate.');
		return redirect()->to('/admin/setting_jam');
	}

	//-------------------------------------------------------------------------------
	public function absensi ()
	{
		$data = [

			'title'		=> 'ABSENSI KARYAWAN',
			'data'		=> $this->AdminModel->get_absen(),
			'jam'		=> $this->AdminModel->get_jam(),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/absensi/tampil_absensi', $data);
	}

	//-------------------------------------------------------------------------------
	public function get_kegiatan ()
	{
		$data = [

			'title'		=> 'KEGIATAN KARYAWAN',
			'data'		=> $this->AdminModel->get_kegiatan(),
			'karyawan'	=> $this->AdminModel->get_karyawan(),
			
		];
		return view('admin/page/kegiatan/tampil_kegiatan', $data);
	}
	//-------------------------------------------------------------------------------
	public function tambah_kegiatan ()
	{
		$data = [

			'title'		=> 'FORM KEGIATAN',
			'validation'=> \Config\Services::Validation()
		];
		return view('admin/page/kegiatan/form_kegiatan', $data);
	}
	//-------------------------------------------------------------------------------
	public function save_kegiatan ()
	{
		if (!$this->validate([

			'nama_kegiatan' => [

				'rules'		=> 'required|is_unique[tb_kegiatan.nama_kegiatan]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			],
			'deskripsi_kegiatan' => [

				'rules'		=> 'required|is_unique[tb_kegiatan.deskripsi_kegiatan]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			]
		])) {
			return redirect()->to('tambah_kegiatan')->withInput();
		}
		$data = [
				'nama_kegiatan' 		=> $this->request->getVar('nama_kegiatan'),
				'deskripsi_kegiatan' 	=> $this->request->getVar('deskripsi_kegiatan'),
				'tgl_post' 				=> $this->request->getVar('tgl_post'),
				
			];
			//dd($data);
		$this->AdminModel->saveKegiatan($data);
		session()->setFlashdata('pesan', "Kegiatan berhasil di tambahkan");
		return redirect()->to('/admin/get_kegiatan');
	}
	//-------------------------------------------------------------------------------
	public function update_kegiatan($id_kegiatan)
	{
		$data = [

			'title'		=> 'UPDATED DATA KEGIATAN',
			'data'		=> $this->AdminModel->update_kegiatan($id_kegiatan),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/kegiatan/form_update', $data);
	}
	//-------------------------------------------------------------------------------
	public function saveUpdateKegiatan ($data)
	{
		if (!$this->validate([

			'nama_kegiatan' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!'
					
				]
			],
			'deskripsi_kegiatan' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!'
					
				]
			]
		])) {
			return redirect()->to('/admin/update_kegiatan/'. $this->request->getVar('id_kegiatan'))->withInput();
		}
		$data = [
				'nama_kegiatan' 		=> $this->request->getVar('nama_kegiatan'),
				'deskripsi_kegiatan' 	=> $this->request->getVar('deskripsi_kegiatan'),
				'id_kegiatan' 			=> $this->request->getVar('id_kegiatan'),
				
			];
			//dd($data);
		$this->AdminModel->save_update_kegiatan($data);
		session()->setFlashdata('pesan', "Kegiatan berhasil di Update");
		return redirect()->to('/admin/get_kegiatan');
	}
	//-------------------------------------------------------------------------------
	public function deleteKegiatan($id_kegiatan)
	{
		$this->AdminModel->deleteKegiatan($id_kegiatan);

		session()->setFlashdata('pesan', 'Data Kegiatan Berhasil Dihapus.');
		return redirect()->to('/admin/get_kegiatan');
	}

	//-------------------------------------------------------------------------------
	public function PresensiKegiatan()
	{
		$data = [

			'title'		=> 'GENERATE PRESENSI KEGIATAN',
			'data'		=> $this->AdminModel->get_kegiatan(),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/kegiatan/presensi_kegiatan', $data);
		
	}

	// //-------------------------------------------------------------------------------
	public function daftarPresensi($id_kegiatan)
	{
		
		$data = [
			'title'			=> 'DAFTAR KARYAWAN',
			'data'			=> $this->AdminModel->get_karyawan(),
			'kegiatan'		=> $this->AdminModel->GetKegiatanForm($id_kegiatan),
			'validation'	=> \Config\Services::Validation()
		];
		
		return view('admin/page/kegiatan/daftar_kegiatan', $data);

	}
	// //-------------------------------------------------------------------------------
	public function save_presensi_kegiatan()
	{
		//chek kegiatan apakah ada
		$idKegiatan = $this->request->getVar('id_kegiatan');
		$checkKegiatan = $this->KegiatanModel->where('id_kegiatan', $idKegiatan)->first();
		//chek username apakah ada
		$idusername = $this->request->getVar('user_name');
		$checkUser = $this->KegiatanModel->where('user_name', $idusername)->first();

		//jika kegiatan dan username ada
		if($checkKegiatan && $checkUser){
			session()->setFlashdata('warning', 'Karyawan NoPeg '.$idusername.' Telah ter Absen.');
			return redirect()->to('/admin/daftarPresensi/'. $idKegiatan);
		}else{
			$data = [
				'id_kegiatan' 	=> $this->request->getVar('id_kegiatan'),
				'user_name' 	=> $this->request->getVar('user_name'),
				'tgl_submite' 	=> $this->request->getVar('tgl_absen'),
				'status'		=> $this->request->getVar('status'),
				
			];
			//dd($data);
			$this->AdminModel->savePresensiKegiatan($data);
			session()->setFlashdata('pesan', 'Presensi noPeg '.$data['user_name'].' Berhasil dibuat');
			return redirect()->to('/admin/daftarPresensi/'. $idKegiatan);
		}
	}
	// //-------------------------------------------------------------------------------
	public function tampil_presensi_kegiatan()
	{
		$checkKegiatan = [
			'id_kegiatan'	=> $this->request->getVar('id_kegiatan'),
		]; 
		$data = [

			'title'			=> 'PRESENSI KEGIATAN',
			'data'			=> $this->AdminModel->get_presensiKegiatan($checkKegiatan),
			'kegiatan'		=> $this->AdminModel->get_kegiatan(),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/kegiatan/tampil_presensi', $data);
	}
	//GET GAJI KARYAWAN
	//---------------------------------------------------------------------------------
	public function getGaji ()
	{
		$data = [

			'title'		=> 'DATA GAJI KARYAWAN',
			'data'		=> $this->AdminModel->getGaji(),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/gaji/tampilGaji', $data);
		
	}
	//ADD GAJI KARYAWAN
	//---------------------------------------------------------------------------------
	public function addGaji ()
	{
		$data = [

			'title'		=> 'ENTRY GAJI KARYAWAN',
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/gaji/formGaji', $data);
	}
	//SAVE GAJI KARYAWAN
	//---------------------------------------------------------------------------------
	public function saveGaji ()
	{
		if (!$this->validate([

			'salaryGaji' => [

				'rules'		=> 'required|is_unique[tb_gaji.salary]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			],
			'jabatan' => [

				'rules'		=> 'required|is_unique[tb_gaji.jabatan]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			],
			'keterangan' => [

				'rules'		=> 'required|is_unique[tb_gaji.keterangan]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			]
		])) {
			return redirect()->to('addGaji')->withInput();
		}
		$data = [
				'salary' 				=> $this->request->getVar('salaryGaji'),
				'jabatan' 				=> $this->request->getVar('jabatan'),
				'keterangan' 			=> $this->request->getVar('keterangan'),
				'created_at' 			=> $this->request->getVar('tgl_post'),
				
			];
			//dd($data);
		$this->AdminModel->saveGaji($data);
		session()->setFlashdata('pesan', "Entry Gaji berhasil di Entry");
		return redirect()->to('/admin/getGaji');

	}
	//GET UPDATE GAJI
	//-------------------------------------------------------------------------------
	public function updateGaji($id_gaji)
	{
		$data = [

			'title'		=> 'FORM UPDATE SALARY GAJI',
			'data'		=> $this->AdminModel->updateGaji($id_gaji),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/gaji/formUpdate', $data);
	}
	//SAVE UPDATE GAJI
	//-------------------------------------------------------------------------------------------------------
	public function saveUpdateGaji ()
	{
		if (!$this->validate([

			'salaryGaji' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!'
				]
			],
			'jabatan' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!'
				]
			],
			'keterangan' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!'
				]
			]
		])) {
			return redirect()->to('/admin/updateGaji/'. $this->request->getVar('id_gaji'))->withInput();
		}
		$data = [
				'id_gaji'				=> $this->request->getVar('id_gaji'),
				'salary' 				=> $this->request->getVar('salaryGaji'),
				'jabatan' 				=> $this->request->getVar('jabatan'),
				'keterangan' 			=> $this->request->getVar('keterangan'),
				'updated_at' 			=> $this->request->getVar('tgl_update'),
				
			];
			//dd($data);
		$this->AdminModel->saveUpdateGaji($data);
		session()->setFlashdata('pesan', "Salary Gaji berhasil di Update");
		return redirect()->to('/admin/getGaji');
	}
	//DELETE GAJI
	//-------------------------------------------------------------------------------
	public function deleteGaji($id_gaji)
	{
		$this->AdminModel->deleteGaji($id_gaji);

		session()->setFlashdata('pesan', 'Data Gaji Berhasil Dihapus.');
		return redirect()->to('/admin/getGaji');
	}

	//ENTRY GAJI
	//--------------------------------------------------------------------
	public function rekapGaji()
	{

		$data = [

			'title'		=> 'DAFTAR GAJI KARYAWAN',
			'data'		=> $this->AdminModel->get_karyawan(),
			'gaji'		=> $this->AdminModel->getGaji(),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/entrygaji/tampil_data', $data);
	}
	//CHEK GAJI
	public function chekGaji ()
	{
		$chekKaryawan = [
			'user_name'	=> $this->request->getVar('user_name'),
		]; 
		$data = [

			'title'			=> 'REKAPITULASI GAJI',
			'data'			=> $this->AdminModel->getKaryawan($chekKaryawan),
			'gaji'			=> $this->AdminModel->getGaji($chekKaryawan),
			'jmlHadir'		=> $this->AdminModel->jmlHadir($chekKaryawan),
			'validation'	=> \Config\Services::Validation()
			

		];
		return view('admin/page/entryGaji/tampilGaji', $data);
	}































	//--------------------------------------------------------------------
	public function data_pasien()
	{

		$data = [

			'title'		=> 'DATA PASIEN',
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/diagnosa_pasien/form_diagnosa', $data);
	}
	//--------------------------------------------------------------------
	public function save_datapasien()
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'

			'nikpasien' => [

				'rules'		=> 'required|is_unique[data_pasien.nik]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]

			]

		])) {
			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('data_pasien')->withInput()->with('validation', $validation);
		}
		$data = [
			'nik'					=> $this->request->getVar('nikpasien'),
			'nama_pasien'			=> $this->request->getVar('namapasien'),
			'jenis_kelamin'			=> $this->request->getVar('jenis_kelamin'),
			'agama'					=> $this->request->getVar('agama'),
			'tempat_lahir'			=> $this->request->getVar('tempat_lahir'),
			'tgl_lahir'				=> $this->request->getVar('tgl_lahir'),
			'status_perkawinan'		=> $this->request->getVar('status_perkawinan'),
			'pendidikan_terakhir'	=> $this->request->getVar('pendidikan'),
			'pekerjaan'				=> $this->request->getVar('pekerjaan'),
			'alamat_domisili'		=> $this->request->getVar('alamat_ktp'),
			'nik_penanggung_jawab'	=> $this->request->getVar('nikpjpasien'),
			'nama_penanggung_jawab'	=> $this->request->getVar('namapjpasien'),
			'status_pembiayaan'		=> $this->request->getVar('status_pembiyaan'),
			'hubungan_dengan_pasien'=> $this->request->getVar('hubungan'),
			'no_wa_pj'				=> $this->request->getVar('no_wapj'),
			'alamat_pj'				=> $this->request->getVar('alamat_pj'),
			'created_at'			=> $this->request->getVar('tgl'),

		];
		$this->AdminModel->save_data_pasien($data);
		session()->setFlashdata('pesan', 'Data Berhasil ditambahkan.');
		return redirect()->to('/admin/data_pengkajian');
	}

	//--------------------------------------------------------------------
	public function data_pengkajian()
	{
		$data = [

			'title'		=> 'DATA PENGKAJIAN PASIEN',
			'data'		=> $this->AdminModel->get_data_pasien()

		];
		return view('admin/page/data_pengkajian/tampil_datapasien', $data);
	}
	//--------------------------------------------------------------------
	public function diagnosa($nik)
	{
		$data = [

			'title'		=> 'FORM PENGKAJIAN PASIEN',
			'data'		=> $this->AdminModel->tampil_datapasein($nik),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/pengkajian/form_pengkajian', $data);
	}
	//--------------------------------------------------------------------
	public function save_diagnosa()
	{
		//SAVE DATA DIAGNOSA
		$data = [
			'nik'								=> $this->request->getVar('nik'),
			'no_rm'								=> $this->request->getVar('coderm'),
			'tgl_mrs'							=> $this->request->getVar('tglmrs'),
			'jam_mrs'							=> $this->request->getVar('jammrs'),
			'hari_rawat'						=> $this->request->getVar('harirawat'),
			'tgl_pengkajian'					=> $this->request->getVar('tglkaji'),
			'jam_pengkajian'					=> $this->request->getVar('jangkaji'),
			'keluhan_utama_pasien'				=> $this->request->getVar('keluhanutama'),
			'riwayat_penyakit_saat_ini'			=> $this->request->getVar('riwayatpenyakit'),
			'riwayat_penyakit_pernah_diderita'	=> $this->request->getVar('riwayatpenyakitdiderita'),
			'riwayat_alergi'					=> $this->request->getVar('riwayat'),
			'keterangan_alergi'					=> $this->request->getVar('keteranganriwayat'),
			'ruangan'							=> $this->request->getVar('ruang'),

		];

		$this->AdminModel->save_data_diagnosa($data);
		// SAVE DATA B1
		$data = [
			'nik'								=> $this->request->getVar('nik'),
			'pola_nafas'						=> $this->request->getVar('polanafas'),
			'jenis_nafas1'						=> $this->request->getVar('jenisnafas1'),
			'jenis_nafas2'						=> $this->request->getVar('jenisnafas2'),
			'jenis_nafas3'						=> $this->request->getVar('jenisnafas3'),
			'jenis_nafas4'						=> $this->request->getVar('jenisnafas4'),
			'jenis_nafas5'						=> $this->request->getVar('jenisnafas5'),
			'jenis_nafas6'						=> $this->request->getVar('jenisnafas6'),
			'jenis_nafas7'						=> $this->request->getVar('jenisnafas7'),
			'jenis_nafas8'						=> $this->request->getVar('jenisnafas8'),
			'sesak_nafas1'						=> $this->request->getVar('sesaknafas1'),
			'sesak_nafas2'						=> $this->request->getVar('sesaknafas2'),
			'sesak_nafas3'						=> $this->request->getVar('sesaknafas3'),
			'sesak_nafas4'						=> $this->request->getVar('sesaknafas4'),
			'fatique'							=> $this->request->getVar('fatigue'),
			'rr'								=> $this->request->getVar('rr'),
			'retraksi_dada'						=> $this->request->getVar('retraksidada'),
			'bentuk_dada'						=> $this->request->getVar('bentukdada'),
			'taktilfremitus_kanan'				=> $this->request->getVar('taktilkanan'),
			'taktilfremitus_kiri'				=> $this->request->getVar('taktilkiri'),
			'perkusi'							=> $this->request->getVar('perkusi'),
			'perkusi_paru_kanan1'				=> $this->request->getVar('perkusikanan1'),
			'perkusi_paru_kanan2'				=> $this->request->getVar('perkusikanan2'),
			'perkusi_paru_kanan3'				=> $this->request->getVar('perkusikanan3'),
			'perkusi_paru_kiri1'				=> $this->request->getVar('perkusikiri1'),
			'perkusi_paru_kiri2'				=> $this->request->getVar('perkusikiri2'),
			'suara_nafas1'						=> $this->request->getVar('suaranafas1'),
			'suara_nafas2'						=> $this->request->getVar('suaranafas2'),
			'suara_nafas3'						=> $this->request->getVar('suaranafas3'),
			'suara_nafas4'						=> $this->request->getVar('suaranafas4'),
			'suara_nafas5'						=> $this->request->getVar('suaranafas5'),
			'suara_nafas_paru_kanan1'			=> $this->request->getVar('suaranafaskanan1'),
			'suara_nafas_paru_kanan2'			=> $this->request->getVar('suaranafaskanan2'),
			'suara_nafas_paru_kanan3'			=> $this->request->getVar('suaranafaskanan3'),
			'suara_nafas_paru_kiri1'			=> $this->request->getVar('suaranafaskiri1'),
			'suara_nafas_paru_kiri2'			=> $this->request->getVar('suaranafaskiri2'),
			'batuk1'							=> $this->request->getVar('batuk1'),
			'batuk2'							=> $this->request->getVar('batuk2'),
			'batuk3'							=> $this->request->getVar('batuk3'),
			'dahak_produktif'					=> $this->request->getVar('dahak'),
			'warna_sekret'						=> $this->request->getVar('warnasecret'),
			'pco2'								=> $this->request->getVar('pco'),
			'po2'								=> $this->request->getVar('po2'),
			'pharteri'							=> $this->request->getVar('pharteri'),
			'sao2'								=> $this->request->getVar('sao2'),
			'sianosis'							=> $this->request->getVar('sianosis'),
			'created_at'						=> $this->request->getVar('tgl'),

		];
		
		$this->AdminModel->save_data_b1($data);
		// SAVE DATA B2
		$data = [
			'nik'								=> $this->request->getVar('nik'),
			'irama_jantung1'					=> $this->request->getVar('irama_jantung1'),
			'irama_jantung2'					=> $this->request->getVar('irama_jantung2'),
			'irama_jantung3'					=> $this->request->getVar('irama_jantung3'),
			'irama_jantung4'					=> $this->request->getVar('irama_jantung4'),
			'irama_jantung5'					=> $this->request->getVar('irama_jantung5'),
			'perubahan_kontraktilitas1'			=> $this->request->getVar('kontraktilitas1'),
			'perubahan_kontraktilitas2'			=> $this->request->getVar('kontraktilitas2'),
			'perubahan_kontraktilitas3'			=> $this->request->getVar('kontraktilitas3'),
			'perubahan_kontraktilitas4'			=> $this->request->getVar('kontraktilitas4'),
			'perubahan_kontraktilitas5'			=> $this->request->getVar('kontraktilitas5'),
			'perubahan_afterload1'				=> $this->request->getVar('afterload1'),
			'perubahan_afterload2'				=> $this->request->getVar('afterload2'),
			'perubahan_afterload3'				=> $this->request->getVar('afterload3'),
			'perubahan_afterload4'				=> $this->request->getVar('afterload4'),
			'perubahan_afterload5'				=> $this->request->getVar('afterload5'),
			'perubahan_preload1'				=> $this->request->getVar('preload1'),
			'perubahan_preload2'				=> $this->request->getVar('preload2'),
			'perubahan_preload3'				=> $this->request->getVar('preload3'),
			'perubahan_preload4'				=> $this->request->getVar('preload4'),
			'perubahan_preload5'				=> $this->request->getVar('preload5'),
			'nadi'								=> $this->request->getVar('nadi'),
			'nyeri_dada'						=> $this->request->getVar('nyeridada'),
			'bentuk_dada'						=> $this->request->getVar('bentukdada2'),
			'bunyi_jantung'						=> $this->request->getVar('bunyijantung'),
			'clubbing_finger'					=> $this->request->getVar('clubbingfinger'),
			'konjungtiva'						=> $this->request->getVar('konjungtiva'),
			'crt'								=> $this->request->getVar('crt'),
			'sinosis'							=> $this->request->getVar('sinusis'),
			'suhu'								=> $this->request->getVar('suhu'),
			'akral'								=> $this->request->getVar('akral'),
			'ictus_cordis'						=> $this->request->getVar('ictuscordis'),
			'created_at'						=> $this->request->getVar('tgl'),
		];
		 $this->AdminModel->save_data_b2($data);
		//SAVE DATA B3
		$data = [
			'nik'								=> $this->request->getVar('nik'),
			'eye'								=> $this->request->getVar('eye'),
			'verbal'							=> $this->request->getVar('verbal'),
			'motorik'							=> $this->request->getVar('motorik'),
			'kesadaran_kuantitatif'				=> $this->request->getVar('kesadarankuantitatif'),
			'kesadaran_kualitatif'				=> $this->request->getVar('kesadarankualitatif'),
			'gangguan_tidur'					=> $this->request->getVar('gangguantidur'),
			'keterangan_gangguan_tidur'			=> $this->request->getVar('ketgangguantidur'),
			'istirahat_tidur'					=> $this->request->getVar('istirahattidur'),
			'buta_warna'						=> $this->request->getVar('butawarna'),
			'tes_visus_vos'						=> $this->request->getVar('visus_vos'),
			'tes_visus_vod'						=> $this->request->getVar('visus_vod'),
			'jarak_pandang'						=> $this->request->getVar('jarakpandang'),
			'lapang_pandang'					=> $this->request->getVar('lapangpandang'),
			'pupil'								=> $this->request->getVar('pupil'),
			'lainlain_pupil'					=> $this->request->getVar('lainlainpupil'),
			'konjungtiva'						=> $this->request->getVar('konjungtiva'),
			'lainlain_konjungtiva'				=> $this->request->getVar('konjungtivalainlain'),
			'respon_pupil1'						=> $this->request->getVar('respon_pupil1'),
			'respon_pupil2'						=> $this->request->getVar('respon_pupil2'),
			'tingkat_kesadaran1'				=> $this->request->getVar('tingkat_kesadaran1'),
			'tingkat_kesadaran2'				=> $this->request->getVar('tingkat_kesadaran2'),
			'serumen'							=> $this->request->getVar('serumen'),
			'jenis_penciuman'					=> $this->request->getVar('jenispenciuman'),
			'keterangan_jenis_penciuman'		=> $this->request->getVar('ketpenciuman'),
			'gangguan_penciuman'				=> $this->request->getVar('gangguanpenciuman'),
			'keterangan_gangguan_penciuman'		=> $this->request->getVar('ketgamgguanpenciuman'),
			'perdarahan'						=> $this->request->getVar('perdarahan'),
			'epistaksis'						=> $this->request->getVar('epistaksis'),
			'polip'								=> $this->request->getVar('polip'),
			'persyarafan1'						=> $this->request->getVar('persyarafan1'),
			'persyarafan2'						=> $this->request->getVar('persyarafan2'),
			'persyarafan3'						=> $this->request->getVar('persyarafan3'),
			'persyarafan4'						=> $this->request->getVar('persyarafan4'),
			'persyarafan5'						=> $this->request->getVar('persyarafan5'),
			'persyarafan6'						=> $this->request->getVar('persyarafan6'),
			'persyarafan7'						=> $this->request->getVar('persyarafan7'),
			'persyarafan8'						=> $this->request->getVar('persyarafan8'),
			'persyarafan9'						=> $this->request->getVar('persyarafan9'),
			'persyarafan10'						=> $this->request->getVar('persyarafan10'),
			'persyarafan11'						=> $this->request->getVar('persyarafan11'),
			'persyarafan12'						=> $this->request->getVar('persyarafan12'),
			'persyarafan13'						=> $this->request->getVar('persyarafan13'),
			'keterangan_persyarafan'			=> $this->request->getVar('ketsyaraf'),
			'reflex1'							=> $this->request->getVar('reflex1'),
			'reflex2'							=> $this->request->getVar('reflex2'),
			'reflex3'							=> $this->request->getVar('reflex3'),
			'reflex4'							=> $this->request->getVar('reflex4'),
			'reflex5'							=> $this->request->getVar('reflex5'),
			'reflex6'							=> $this->request->getVar('reflex6'),
			'pqrs'								=> $this->request->getVar('ketreflex'),
			'gangguan_indra1'					=> $this->request->getVar('indra1'),
			'gangguan_indra2'					=> $this->request->getVar('indra2'),
			'gangguan_indra3'					=> $this->request->getVar('indra3'),
			'gangguan_indra4'					=> $this->request->getVar('indra4'),
			'gangguan_indra5'					=> $this->request->getVar('indra5'),
			'gangguan_indra6'					=> $this->request->getVar('indra6'),
			'istirahat1'						=> $this->request->getVar('tidur1'),
			'istirahat2'						=> $this->request->getVar('tidur2'),
			'istirahat3'						=> $this->request->getVar('tidur3'),
			'istirahat4'						=> $this->request->getVar('tidur4'),
			'istirahat5'						=> $this->request->getVar('tidur5'),
			'istirahat6'						=> $this->request->getVar('tidur6'),
			'keterangan_istirahat'				=> $this->request->getVar('kettidur'),
			'created_at'						=> $this->request->getVar('tgl'),
		];
		 $this->AdminModel->save_data_b3($data);
		//SAVE DATA B4
		$data = [
			'nik'								=> $this->request->getVar('nik'),
			'produksi_urine'					=> $this->request->getVar('produksiurine'),
			'warna_urine'						=> $this->request->getVar('warnaurine'),
			'bau_urine'							=> $this->request->getVar('bauurine'),
			'kateter'							=> $this->request->getVar('kateter'),
			'distensi_kandung_kemih'			=> $this->request->getVar('distensikandungkemih'),
			'minuman'							=> $this->request->getVar('minuman'),
			'makanan'							=> $this->request->getVar('makanan'),
			'air_metabolisme'					=> $this->request->getVar('airmetabolisme'),
			'infus'								=> $this->request->getVar('infus'),
			'transfusi'							=> $this->request->getVar('transfusi'),
			'urine'								=> $this->request->getVar('urine'),
			'feses'								=> $this->request->getVar('feses'),
			'muntah'							=> $this->request->getVar('muntah'),
			'ngt'								=> $this->request->getVar('ngt'),
			'perdarahan_b4'						=> $this->request->getVar('perdarahan_b4'),
			'diare'								=> $this->request->getVar('diare'),
			'gangguan_eliminasi1'				=> $this->request->getVar('eliminasi1'),
			'gangguan_eliminasi2'				=> $this->request->getVar('eliminasi2'),
			'gangguan_eliminasi3'				=> $this->request->getVar('eliminasi3'),
			'gangguan_eliminasi4'				=> $this->request->getVar('eliminasi4'),
			'gangguan_eliminasi5'				=> $this->request->getVar('eliminasi5'),
			'gangguan_eliminasi6'				=> $this->request->getVar('eliminasi6'),
			'gangguan_eliminasi7'				=> $this->request->getVar('eliminasi7'),
			'gangguan_eliminasi8'				=> $this->request->getVar('eliminasi8'),
			'gangguan_eliminasi9'				=> $this->request->getVar('eliminasi9'),
			'gangguan_eliminasi10'				=> $this->request->getVar('eliminasi10'),
			'gangguan_eliminasi11'				=> $this->request->getVar('eliminasi11'),
			'gangguan_eliminasi12'				=> $this->request->getVar('eliminasi12'),
			
			'created_at'						=> $this->request->getVar('tgl'),

		];
		$this->AdminModel->save_data_b4($data);
		//SAVE DATA B5
		$data = [
			'nik'							=> $this->request->getVar('nik'),
			'pencernaan1'						=> $this->request->getVar('asites'),
			'pencernaan2'						=> $this->request->getVar('milena'),
			'pencernaan3'						=> $this->request->getVar('uluhati'),
			'pencernaan4'						=> $this->request->getVar('spidernevi'),
			'pencernaan5'						=> $this->request->getVar('nyerimc'),
			'pencernaan6'						=> $this->request->getVar('pembesaranhati'),
			'pencernaan7'						=> $this->request->getVar('bisingususaktif'),
			'pencernaan8'						=> $this->request->getVar('hipoaktif'),
			'antropometri1'						=> $this->request->getVar('kurus'),
			'antropometri2'						=> $this->request->getVar('normal'),
			'antropometri3'						=> $this->request->getVar('nafsumakanmenurun'),
			'antropometri4'						=> $this->request->getVar('nafsumakannormal'),
			'antropometri5'						=> $this->request->getVar('beratbadanturun'),
			'antropometri6'						=> $this->request->getVar('beratbadannormal'),
			'gangguan_nutrisi1'					=> $this->request->getVar('anoreksia'),
			'gangguan_nutrisi2'					=> $this->request->getVar('mual'),
			'gangguan_nutrisi3'					=> $this->request->getVar('muntah'),
			'gangguan_nutrisi4'					=> $this->request->getVar('sariawan'),
			'gangguan_nutrisi5'					=> $this->request->getVar('colostomy'),
			'gangguan_nutrisi6'					=> $this->request->getVar('nyeritelan'),
			'berat_badan'						=> $this->request->getVar('bb'),
			'tinggi_badan'						=> $this->request->getVar('tb'),
			'imt'								=> $this->request->getVar('imt'),
			'bising_usus'						=> $this->request->getVar('bisingusus'),
			'created_at'						=> $this->request->getVar('tgl'),
		];
		$this->AdminModel->save_data_b5($data);
		//SAVE B6
		$data = [
			'nik'								=> $this->request->getVar('nik'),
			'muskuloskeletal1'					=> $this->request->getVar('moskulo1'),
			'muskuloskeletal2'					=> $this->request->getVar('moskulo2'),
			'muskuloskeletal3'					=> $this->request->getVar('moskulo3'),
			'muskuloskeletal4'					=> $this->request->getVar('moskulo4'),
			'muskuloskeletal5'					=> $this->request->getVar('moskulo5'),
			'muskuloskeletal6'					=> $this->request->getVar('moskulo6'),
			'muskuloskeletal7'					=> $this->request->getVar('moskulo7'),
			'integumen1'						=> $this->request->getVar('integume1'),
			'integumen2'						=> $this->request->getVar('integume2'),
			'integumen3'						=> $this->request->getVar('integume3'),
			'integumen4'						=> $this->request->getVar('integume4'),
			'integumen5'						=> $this->request->getVar('integume5'),
			'integumen6'						=> $this->request->getVar('integume6'),
			'luka1'								=> $this->request->getVar('luka1'),
			'luka2'								=> $this->request->getVar('luka2'),
			'luka3'								=> $this->request->getVar('luka3'),
			'luka4'								=> $this->request->getVar('luka4'),
			'luka5'								=> $this->request->getVar('luka5'),
			'kerusakan_kulit'					=> $this->request->getVar('kerusakanjaringankulit'),
			'push'								=> $this->request->getVar('push'),
			'nekrosis'							=> $this->request->getVar('nekrosis'),
			'panjang_luka'						=> $this->request->getVar('panjang_luka'),
			'lebar_luka'						=> $this->request->getVar('lebar_luka'),
			'created_at'						=> $this->request->getVar('tgl'),
		];
		$this->AdminModel->save_data_b6($data);
		// dd($data);
		session()->setFlashdata('pesan', 'Data Diagnosa'.$data['nik'].'Berhasil ditambahkan.');
		return redirect()->to('/admin/hasil_diagnosa/'.$data['nik']);
	}
	//--------------------------------------------------------------------
	public function data_diagnosa()
	{
		$data = [

			'title'		=> 'DATA DIAGNOSA PASIEN',
			'data'		=> $this->AdminModel->get_diagnosa()

		];
		return view('admin/page/diagnosa_kep/data_diagnosa', $data);
	}
	//--------------------------------------------------------------------
	public function hasil_diagnosa($nik)
	{
		$data = [

			'title'		=> 'HASIL DIAGNOSA PASIEN',
			'data'		=> $this->AdminModel->hasil_diagnosa($nik),
			'validation'=> \Config\Services::Validation()

		];
		return view('admin/page/diagnosa_kep/hasil_diagnosa', $data);
	}
	//--------------------------------------------------------------------
	public function download_diagnosa($nik)
	{
		$data = [
			'title'		=> 'HASIL DIAGNOSA ONLINE',
			'data'		=> $this->AdminModel->hasil_diagnosa($nik)
		];
		$dompdf  = new \Dompdf\Dompdf();
		$options = new \Dompdf\Options();
		$options->setIsRemoteEnabled(true);
		$dompdf->setOptions($options);
		$dompdf->Output();
		$dompdf->loadHtml(view('admin/page/diagnosa_kep/hasil_diagnosa_pdf', $data));
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream('Bukti_Pendaftaran.pdf', array("Attachment" => false));
		exit();
	}
//update data diagnosa 

	public function update_diagnosa ($nik)
	{
		$data = [
			'title'		=> 'UPDATE DATA DIAGNOSA PASIEN ',
			'data'		=> $this->AdminModel->update_tampil_datapasein($nik),
			'validation'=> \Config\Services::Validation()
		];
		return view('admin/page/pengkajian/update_form_pengkajian', $data);
	}

	


















	// MASTER DATA SEKOLAH
	public function get_sekolah()
	{
		$data = [
			'title'		=> 'MASTER DATA SEKOLAH',
			'data'		=> $this->AdminModel->get_sekolah()

		];
		return view('admin/page/data_sekolah/tampil_sekolah', $data);
	}
	//-----------------------------------------------------------------
	public function form_sekolah()
	{

		$data = [
			'title'			=> 'TAMBAH DATA SEKOLAH',
			'validation'	=> \Config\Services::Validation()

		];
		return view('admin/page/data_sekolah/form_sekolah', $data);
	}
	//-------------------------------------------------------------------
	public function save_sekolah()
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'

			'nama_sekolah' => [

				'rules'		=> 'required|is_unique[tb_sekolah.nama_sekolah]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]

			]

		])) {
			// $validation = \Config\Services::Validation()->listErrors();
			// return redirect()->to('form_sekolah')->withInput()->with('validation', $validation);

			return redirect()->to('form_sekolah')->withInput();
		}
		$data = [
			'nama_sekolah' 	=> $this->request->getVar('nama_sekolah'),
			'keterangan'  	=> $this->request->getVar('keterangan'),
		];
		$this->AdminModel->save_sekolah($data);
		session()->setFlashdata('pesan', 'Data Berhasil ditambahkan.');
		return redirect()->to('get_sekolah');
	}
	//-----------------------------------------------------------------------
	public function get_update_sekolah($id_sekolah)
	{
		$data = [
			'title'			=> 'UPDATE DATA SEKOLAH',
			'validation'	=> \Config\Services::Validation(),
			'data'			=> $this->AdminModel->get_update_sekolah($id_sekolah)

		];
		return view('admin/page/data_sekolah/update_sekolah', $data);
	}

	//-----------------------------------------------------------------------

	public function updated_sekolah($data)
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'

			'nama_sekolah' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]

			]

		])) {

			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('/admin/get_update_sekolah/' . $this->request->getVar('id_sekolah'))->withInput()->with('validation', $validation);
		}

		$data = [
			'id_sekolah'	=> $this->request->getVar('id_sekolah'),
			'nama_sekolah' 	=> $this->request->getVar('nama_sekolah'),
			'keterangan'  	=> $this->request->getVar('keterangan'),
		];
		$this->AdminModel->updated_sekolah($data);
		session()->setFlashdata('pesan', 'Data Berhasil diupdate.');
		return redirect()->to('/admin/get_sekolah');
	}

	//-----------------------------------------------------------------------

	public function delete_sekolah($id_sekolah)
	{
		$this->AdminModel->delete_sekolah($id_sekolah);

		session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
		return redirect()->to('/admin/get_sekolah');
	}

	// MASTER KECAMATAN//
	//-------------------------------------------------------------------------------------
	public function get_kecamatan()
	{
		$data = [
			'title'		=> 'MASTER KECAMATAN',
			'data'		=> $this->AdminModel->get_kecamatan()
		];
		return view('admin/page/data_kecamatan/tampil_kecamatan', $data);
	}
	//--------------------------------------------------------------------------------------
	public function form_kecamatan()
	{
		$data = [
			'title'			=> 'TAMBAH DATA KECAMATAN',
			'validation'	=> \Config\Services::Validation()
		];
		return view('admin/page/data_kecamatan/form_kecamatan', $data);
	}

	//-----------------------------------------------------------------------------------------
	public function save_kecamatan()
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'

			'nama_kecamatan' => [

				'rules'		=> 'required|is_unique[tb_kecamatan.nama_kecamatan]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]

			]

		])) {
			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('form_kecamatan')->withInput()->with('validation', $validation);
		}
		$data = [
			'nama_kecamatan' 	=> $this->request->getVar('nama_kecamatan'),
			'status'  			=> $this->request->getVar('status'),
		];
		$this->AdminModel->save_kecamatan($data);
		session()->setFlashdata('pesan', 'Data Berhasil ditambahkan.');
		return redirect()->to('get_kecamatan');
	}
	//-----------------------------------------------------------------------

	public function get_update_kecamatan($id_kecamatan)
	{
		$data = [
			'title'			=> 'UPDATE DATA KECAMATAN',
			'validation'	=> \Config\Services::Validation(),
			'data'			=> $this->AdminModel->get_update_kecamatan($id_kecamatan)

		];
		return view('admin/page/data_kecamatan/update_kecamatan', $data);
	}

	//-----------------------------------------------------------------------

	public function updated_kecamatan($data)
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'
			'nama_kecamatan' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			]
		])) {

			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('/admin/get_update_kecamatan/' . $this->request->getVar('id_kecamatan'))->withInput()->with('validation', $validation);
		}

		$data = [
			'id_kecamatan'		=> $this->request->getVar('id_kecamatan'),
			'nama_kecamatan' 	=> $this->request->getVar('nama_kecamatan'),
			'status'  			=> $this->request->getVar('status'),
		];
		$this->AdminModel->updated_kecamatan($data);
		session()->setFlashdata('pesan', 'Data Berhasil diupdate.');
		return redirect()->to('/admin/get_kecamatan');
	}
	//-------------------------------------------------------------------------------
	public function delete_kecamatan($id_kecamatan)
	{
		$this->AdminModel->delete_kecamatan($id_kecamatan);

		session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
		return redirect()->to('/admin/get_kecamatan');
	}

	// MASTER KABUPATEN
	public function get_kabupaten()
	{
		$data = [
			'title'		=> 'MASTER KABUPATEN',
			'data'		=> $this->AdminModel->get_kabupaten()
		];
		return view('admin/page/data_kabupaten/tampil_kabupaten', $data);
	}
	//--------------------------------------------------------------------------------------
	public function form_kabupaten()
	{
		$data = [
			'title'			=> 'TAMBAH DATA KABUPATEN',
			'validation'	=> \Config\Services::Validation()
		];
		return view('admin/page/data_kabupaten/form_kabupaten', $data);
	}
	//-------------------------------------------------------------------------------------
	public function save_kabupaten()
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'

			'nama_kabupaten' => [

				'rules'		=> 'required|is_unique[tb_kabupaten.nama_kabupaten]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]

			]

		])) {
			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('form_kabupaten')->withInput()->with('validation', $validation);
		}
		$data = [
			'nama_kabupaten' 	=> $this->request->getVar('nama_kabupaten'),
			'status'  			=> $this->request->getVar('status'),
		];
		$this->AdminModel->save_kabupaten($data);
		session()->setFlashdata('pesan', 'Data Berhasil ditambahkan.');
		return redirect()->to('get_kabupaten');
	}
	//----------------------------------------------------------------------------------------------
	public function get_update_kabupaten($id_kabupaten)
	{
		$data = [
			'title'			=> 'UPDATE DATA KABUPATEN',
			'validation'	=> \Config\Services::Validation(),
			'data'			=> $this->AdminModel->get_update_kabupaten($id_kabupaten)

		];
		return view('admin/page/data_kabupaten/update_kabupaten', $data);
	}

	//-----------------------------------------------------------------------

	public function updated_kabupaten($data)
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'
			'nama_kabupaten' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			]
		])) {

			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('/admin/get_update_kabupaten/' . $this->request->getVar('id_kabupaten'))->withInput()->with('validation', $validation);
		}

		$data = [
			'id_kabupaten'		=> $this->request->getVar('id_kabupaten'),
			'nama_kabupaten' 	=> $this->request->getVar('nama_kabupaten'),
			'status'  			=> $this->request->getVar('status'),
		];
		$this->AdminModel->updated_kabupaten($data);
		session()->setFlashdata('pesan', 'Data Berhasil diupdate.');
		return redirect()->to('/admin/get_kabupaten');
	}
	//-------------------------------------------------------------------------------
	public function delete_kabupaten($id_kabupaten)
	{
		$this->AdminModel->delete_kabupaten($id_kabupaten);
		session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
		return redirect()->to('/admin/get_kabupaten');
	}


	// MASTER BEASISWA 
	public function get_beasiswa()
	{
		$data = [
			'title'		=> 'MASTER BEASISWA',
			'data'		=> $this->AdminModel->get_beasiswa()
		];
		return view('admin/page/data_beasiswa/tampil_beasiswa', $data);
	}
	//--------------------------------------------------------------------------------------

	public function form_beasiswa()
	{
		$data = [
			'title'			=> 'TAMBAH DATA BEASISWA',
			'validation'	=> \Config\Services::Validation()
		];
		return view('admin/page/data_beasiswa/form_beasiswa', $data);
	}
	//-------------------------------------------------------------------------------------

	public function save_beasiswa()
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'

			'nama_beasiswa' => [

				'rules'		=> 'required|is_unique[tb_beasiswa.nama_beasiswa]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]

			]

		])) {
			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('form_beasiswa')->withInput()->with('validation', $validation);
		}
		$data = [
			'nama_beasiswa' 	=> $this->request->getVar('nama_beasiswa'),
			'status'  			=> $this->request->getVar('status'),
		];
		$this->AdminModel->save_beasiswa($data);
		session()->setFlashdata('pesan', 'Data Berhasil ditambahkan.');
		return redirect()->to('get_beasiswa');
	}
	//----------------------------------------------------------------------------------------------

	public function get_update_beasiswa($id_beasiswa)
	{
		$data = [
			'title'			=> 'UPDATE DATA BEASISWA',
			'validation'	=> \Config\Services::Validation(),
			'data'			=> $this->AdminModel->get_update_beasiswa($id_beasiswa)

		];
		return view('admin/page/data_beasiswa/update_beasiswa', $data);
	}

	//--------------------------------------------------------------------------------------------------

	public function updated_beasiswa($data)
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'
			'nama_beasiswa' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			]
		])) {

			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('/admin/get_update_beasiswa/' . $this->request->getVar('id_beasiswa'))->withInput()->with('validation', $validation);
		}

		$data = [
			'id_beasiswa'		=> $this->request->getVar('id_beasiswa'),
			'nama_beasiswa' 	=> $this->request->getVar('nama_beasiswa'),
			'status'  			=> $this->request->getVar('status'),
		];
		$this->AdminModel->updated_beasiswa($data);
		session()->setFlashdata('pesan', 'Data Berhasil diupdate.');
		return redirect()->to('/admin/get_beasiswa');
	}
	//-------------------------------------------------------------------------------
	public function delete_beasiswa($id_beasiswa)
	{
		$this->AdminModel->delete_beasiswa($id_beasiswa);
		session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
		return redirect()->to('/admin/get_beasiswa');
	}

	// MASTER PENERIMAAN 
	public function get_penerimaan()
	{
		$data = [
			'title'		=> 'MASTER JALUR PENERIMAAN',
			'data'		=> $this->AdminModel->get_penerimaan()
		];
		return view('admin/page/data_penerimaan/tampil_penerimaan', $data);
	}
	//--------------------------------------------------------------------------------------

	public function form_penerimaan()
	{
		$data = [
			'title'			=> 'TAMBAH DATA JALUR PENERIMAAN',
			'gelombang'		=> $this->AdminModel->get_gelombang(),
			'validation'	=> \Config\Services::Validation()
		];
		return view('admin/page/data_penerimaan/form_penerimaan', $data);
	}
	//-------------------------------------------------------------------------------------

	public function save_penerimaan()
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'

			'nama_penerimaan' => [

				'rules'		=> 'required|is_unique[tb_jalur_penerimaan.nama_penerimaan]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]

			]

		])) {
			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('form_penerimaan')->withInput()->with('validation', $validation);
		}
		$data = [
			'nama_penerimaan' 	=> $this->request->getVar('nama_penerimaan'),
			'status'  			=> $this->request->getVar('status'),
			'keterangan'  		=> $this->request->getVar('keterangan'),
			'id_gelombang'  	=> $this->request->getVar('gelombang'),
		];
		$this->AdminModel->save_penerimaan($data);
		session()->setFlashdata('pesan', 'Data Berhasil ditambahkan.');
		return redirect()->to('get_penerimaan');
	}
	//----------------------------------------------------------------------------------------------

	public function get_update_penerimaan($id_penerimaan)
	{
		$data = [
			'title'			=> 'UPDATE DATA JALUR PENERIMAAN',
			'validation'	=> \Config\Services::Validation(),
			'data'			=> $this->AdminModel->get_update_penerimaan($id_penerimaan)

		];
		return view('admin/page/data_penerimaan/update_penerimaan', $data);
	}

	//--------------------------------------------------------------------------------------------------

	public function updated_penerimaan($data)
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'
			'nama_penerimaan' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			]
		])) {

			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('/admin/get_update_penerimaan/' . $this->request->getVar('id_penerimaan'))->withInput()->with('validation', $validation);
		}

		$data = [
			'id_penerimaan'		=> $this->request->getVar('id_penerimaan'),
			'nama_penerimaan' 	=> $this->request->getVar('nama_penerimaan'),
			'status'  			=> $this->request->getVar('status'),
			'id_gelombang'  	=> $this->request->getVar('gelombang'),
			'keterangan'  		=> $this->request->getVar('keterangan'),
		];

		$this->AdminModel->updated_penerimaan($data);
		session()->setFlashdata('pesan', 'Data Berhasil diupdate.');
		return redirect()->to('/admin/get_penerimaan');
	}
	//-------------------------------------------------------------------------------
	public function delete_penerimaan($id_penerimaan)
	{
		$this->AdminModel->delete_penerimaan($id_penerimaan);
		session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
		return redirect()->to('/admin/get_penerimaan');
	}

	// MASTER DATA PEMBAYARAN PENDAFTARAN

	public function get_biaya_pendaftaran()
	{
		$data = [
			'title'		=> 'VERIFIKASI BIAYA PENDAFATARAN',
			'data'		=> $this->AdminModel->get_biaya_pendafatarn()
		];
		return view('admin/page/data_biaya_pendaftaran/tampil_biaya_pendaftaran', $data);
	}

	public function view_biaya_pendaftaran($nikmaba)
	{
		$data = [
			'title'			=> 'DETAIL VERIFIKASI BIAYA PENDAFTARAN MABA',
			'validation'	=> \Config\Services::Validation(),
			'data'			=> $this->AdminModel->get_views_pembayaran($nikmaba)

		];
		return view('admin/page/data_biaya_pendaftaran/update_biaya_pendaftaran', $data);
	}

	public function updated_pembayaran($data)
	{

		$data = [
			'nik'					=> $this->request->getVar('nikmaba'),
			'nama_bank' 			=> $this->request->getVar('nama_bank'),
			'jenis_pembayaran'  	=> $this->request->getVar('metode_pembayaran'),
			'status_pembayaran'  	=> $this->request->getVar('status'),
			'tanggal_valid'  		=> $this->request->getVar('tgl_valid'),
			'keterangan'  			=> $this->request->getVar('keterangan')

		];

		$this->AdminModel->updated_pembayaran($data);
		session()->setFlashdata('pesan', 'Data Berhasil Divalidasi.');
		return redirect()->to('/admin/get_biaya_pendaftaran');
	}

	//forwaded email 
	public function forwad_email()
	{
		$email = \Config\Services::email();

		$to 		= $this->request->getVar('email');
		$subject 	= $this->request->getVar('subject');
		$message 	= $this->request->getVar('message');
		$email->setFrom('maba@stikesnhm.ac.id', 'PENERIMAAN MAHASISWA BARU STIKES NHM');
		$email->setTo($to);
		// $email->setCC('another@another-example.com');
		// $email->setBCC('them@their-example.com');
		$email->setSubject($subject);
		$email->setMessage($message);
		if ($email->send()) {
			session()->setFlashdata('pesan', 'Forwaded Message from Email Succes.');
			return redirect()->to('/admin/get_biaya_pendaftaran');
		} else {
			echo 'Error! email tidak dapat dikirim.';
		}
	}
	//MASTER GET VARIFIKASI
	public function get_verifikasi_pendaftaran()
	{
		$data = [
			'title'		=> 'ALL DATA BIAYA PENDAFATARAN YANG TELAH DIVERIFIKASI',
			'data'		=> $this->AdminModel->get_pendaftaran()
		];
		return view('admin/page/data_biaya_pendaftaran/tampil_biaya_pendaftaran_valid', $data);
	}

	//MASTER DATA BIAYA PSIKOTES DAN UKES
	public function get_biaya_testukes()
	{
		$data = [
			'title'		=> 'VERIFIKASI BIAYA PSIKOTEST DAN UKES',
			'data'		=> $this->AdminModel->get_biaya_psikotes()
		];
		return view('admin/page/data_biaya_psikotes/tampil_biaya_psikotes', $data);
	}
	//VIEWS DATA PEMBAYARAN PSIKOTES
	public function view_biaya_psikotes($nikmaba)
	{
		$data = [
			'title'			=> 'DETAIL VERIFIKASI BIAYA PSIKOTES DAN UKES MABA',
			'validation'	=> \Config\Services::Validation(),
			'data'			=> $this->AdminModel->get_views_psikotes($nikmaba)

		];
		return view('admin/page/data_biaya_psikotes/update_biaya_psikotes', $data);
	}
	//updated BIAYA PSIKOTES MABA
	public function updated_psikotes($data)
	{

		$data = [
			'nik'						=> $this->request->getVar('nikmaba'),
			'nama_bank_ujian' 			=> $this->request->getVar('nama_bank'),
			'jenis_pembayaran_ujian'  	=> $this->request->getVar('metode_pembayaran'),
			'status_pembayaran_ujian'  	=> $this->request->getVar('status'),
			'tanggal_valid_ujian'  		=> $this->request->getVar('tgl_valid'),
			'ket_bayar_ujian'  			=> $this->request->getVar('keterangan')

		];

		$this->AdminModel->updated_psikotes($data);
		session()->setFlashdata('pesan', 'Data Berhasil Divalidasi.');
		return redirect()->to('/admin/get_biaya_testukes');
	}
	//forwaded email psikotes
	public function forwad_email_psikotes()
	{
		$email = \Config\Services::email();

		$to 		= $this->request->getVar('email');
		$subject 	= $this->request->getVar('subject');
		$message 	= $this->request->getVar('message');
		$email->setFrom('maba@stikesnhm.ac.id', 'PENERIMAAN MAHASISWA BARU STIKES NHM');
		$email->setTo($to);
		// $email->setCC('another@another-example.com');
		// $email->setBCC('them@their-example.com');
		$email->setSubject($subject);
		$email->setMessage($message);
		if ($email->send()) {
			session()->setFlashdata('pesan', 'Forwaded Message from Email Succes.');
			return redirect()->to('/admin/get_biaya_testukes');
		} else {
			echo 'Error! email tidak dapat dikirim.';
		}
	}
	//MASTER GET VERIFIKASI PSIKOTES UKUES
	public function get_verifikasi_psikotes()
	{
		$data = [
			'title'		=> 'ALL DATA BIAYA PSIKOTES DAN UKES YANG TELAH DIVERIFIKASI',
			'data'		=> $this->AdminModel->get_psikotes()
		];
		return view('admin/page/data_biaya_psikotes/tampil_biaya_psikotes_valid', $data);
	}

	//MASTER DATA BERKAS MABA

	public function get_berkas_maba()
	{
		$data = [
			'title'		=> 'ALL DATA BERKAS MABA',
			'data'		=> $this->AdminModel->get_berkas_maba()
		];
		return view('admin/page/data_berkas_maba/tampil_berkas_maba', $data);
	}
	//Forwaded email Berkas
	public function forwad_email_berkas()
	{
		$email = \Config\Services::email();

		$to 		= $this->request->getVar('email');
		$subject 	= $this->request->getVar('subject');
		$message 	= $this->request->getVar('message');
		$email->setFrom('maba@stikesnhm.ac.id', 'PENERIMAAN MAHASISWA BARU STIKES NHM');
		$email->setTo($to);
		// $email->setCC('another@another-example.com');
		// $email->setBCC('them@their-example.com');
		$email->setSubject($subject);
		$email->setMessage($message);
		if ($email->send()) {
			session()->setFlashdata('pesan', 'Forwaded Message from Email Succes.');
			return redirect()->to('/admin/get_berkas_maba');
		} else {
			echo 'Error! email tidak dapat dikirim.';
		}
	}
	//VERIFIKASI BERKAS
	public function verifikasi_berkas($data)
	{

		$data = [
			'nik'						=> $this->request->getVar('nikmaba'),
			'status_berkas' 			=> $this->request->getVar('status'),
			'tanggal_valid_berkas'		=> $this->request->getVar('tgl_valid')
		];
		$this->AdminModel->updated_berkas($data);
		session()->setFlashdata('pesan', 'Data Berhasil Divalidasi.');
		return redirect()->to('/admin/get_berkas_maba');
	}
	//data berkas valid 
	public function get_berkas_maba_valid()
	{
		$data = [
			'title'		=> 'ALL DATA BERKAS MABA YANG TELAH DIVALIDASI',
			'data'		=> $this->AdminModel->get_berkas_maba_valid()
		];
		return view('admin/page/data_berkas_maba/tampil_berkas_maba_valid', $data);
	}
	//get prodi ketika data sdh valid
	public function bank_data()
	{
		$data = [
			'title'		=> 'ALL DATA MAHASISWA BARU',
			'data'		=> $this->AdminModel->get_maba_s1kep()
		];
		return view('admin/page/data_maba/tampil_data_maba', $data);
	}
	//SELEKSI MABA
	public function seleksi_maba($data)
	{
		$data = [
			'nik'				=> $this->request->getVar('nikmaba'),
			'status_maba' 		=> $this->request->getVar('status'),
			'tgl_terima'		=> $this->request->getVar('tgl_terima')
		];
		$this->AdminModel->updated_maba($data);
		session()->setFlashdata('pesan', 'Data Maba Berhasil Divalidasi.');
		return redirect()->to('/admin/bank_data');
	}
	//Forwaded email maba
	public function forwad_email_maba()
	{
		$email = \Config\Services::email();

		$to 		= $this->request->getVar('email');
		$subject 	= $this->request->getVar('subject');
		$message 	= $this->request->getVar('message');
		$email->setFrom('maba@stikesnhm.ac.id', 'PENERIMAAN MAHASISWA BARU STIKES NHM');
		$email->setTo($to);
		// $email->setCC('another@another-example.com');
		// $email->setBCC('them@their-example.com');
		$email->setSubject($subject);
		$email->setMessage($message);
		if ($email->send()) {
			session()->setFlashdata('pesan', 'Forwaded Message from Email Succes.');
			return redirect()->to('/admin/bank_data');
		} else {
			echo 'Error! email tidak dapat dikirim.';
		}
	}

	public function forwad_email_users()
	{
		$email = \Config\Services::email();

		$to 		= $this->request->getVar('email');
		$subject 	= $this->request->getVar('subject');
		$message 	= $this->request->getVar('message');
		$email->setFrom('maba@stikesnhm.ac.id', 'PENERIMAAN MAHASISWA BARU STIKES NHM');
		$email->setTo($to);
		// $email->setCC('another@another-example.com');
		// $email->setBCC('them@their-example.com');
		$email->setSubject($subject);
		$email->setMessage($message);
		if ($email->send()) {
			session()->setFlashdata('pesan', 'Forwaded Message from Email Succes.');
			return redirect()->to('/admin/get_users');
		} else {
			echo 'Error! email tidak dapat dikirim.';
		}
	}


	public function profile_maba($nik)
	{
		$data = [
			'title'		=> "PROFILE CALON MAHASISWA BARU",
			'data'		=> $this->AdminModel->profile_maba($nik)
		];
		return view('admin/page/data_maba/tampil_profile', $data);
	}
	//DOWNLOAD PDF
	public function report_data($nik)
	{
		$data = [
			'title'		=> 'BUKTI PENDAFTARAN',
			'data'		=> $this->AdminModel->repot_pdf($nik)
		];
		$dompdf  = new \Dompdf\Dompdf();
		$options = new \Dompdf\Options();
		$options->setIsRemoteEnabled(true);
		$dompdf->setOptions($options);
		$dompdf->Output();
		$dompdf->loadHtml(view('admin/page/data_maba/tampil_data_pdf', $data));
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream('Bukti_Pendaftaran.pdf', array("Attachment" => false));
		exit();
	}

	//REPORT REGULER ALL DATA EXCELL
	public function report_excel()
	{
		$data = ['reguler2'		=> $this->AdminModel->report_excel()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['reguler2'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA ALL DATA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT PMDP GEL 1 EXCELL
	public function pmdp1_excel()
	{
		$data = ['pmdp'		=> $this->AdminModel->pmdp1_excel()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['pmdp'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA PMDP GEL1';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT PMDP GEL 2 EXCELL
	public function pmdp2_excel()
	{
		$data = ['pmdp'		=> $this->AdminModel->pmdp2_excel()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['pmdp'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA PMDP GEL2';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT REGULER GEL 2 EXCELL
	public function reguler1_excel()
	{
		$data = ['reguler'		=> $this->AdminModel->reguler1_excel()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['reguler'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI REGUER GEL1';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT REGULER GEL 2 EXCELL
	public function reguler2_excel()
	{
		$data = ['reguler'		=> $this->AdminModel->reguler2_excel()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['reguler'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI REGUER GEL2';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	//REPORT REGULER GEL 3 EXCELL
	public function reguler3_excel()
	{
		$data = ['reguler'		=> $this->AdminModel->reguler3_excel()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['reguler'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA REGUER GEL3';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT EXCELL ALIH JENJANG & PROFESI GEL 1
	public function tf1_excel()
	{
		$data = ['tfprofesi'		=> $this->AdminModel->tf1_excel()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['tfprofesi'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA ALIH JENJANG DAN PROFESI GEL1';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	//REPORT EXCELL ALIH JENJANG & PROFESI GEL 1
	public function tf2_excel()
	{
		$data = ['tfprofesi'		=> $this->AdminModel->tf2_excel()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['tfprofesi'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA ALIH JENJANG DAN PROFESI GEL2';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	//REPORT EXCELL ALIH JENJANG & PROFESI GEL 3
	public function tf3_excel()
	{
		$data = ['tfprofesi'		=> $this->AdminModel->tf3_excel()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['tfprofesi'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA ALIH JENJANG DAN PROFESI GEL3';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}


	//REPORT EXCELL ALL DATA HUBUNGI PANITIA
	public function report_hubungipanitia()
	{
		$data = ['hubungipanitia'		=> $this->AdminModel->repot_hubungipanitia()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['hubungipanitia'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'ALL DATA HUBUNGI PANITIA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	//DATA TIDAK DITERIMA 


	public function report_tidakditerima()
	{
		$data = ['tidakditerima'		=> $this->AdminModel->repot_tidakditerima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Jalur Penerimaan')
			->setCellValue('T1', 'Peminatan Beasiswa')
			->setCellValue('U1', 'Status Maba')
			->setCellValue('V1', 'Tanggal Registrasi')
			->setCellValue('W1', 'Nama Orang Tua Ibu')
			->setCellValue('X1', 'No WA Ibu')
			->setCellValue('Y1', 'Nama Orang Tua Ayah')
			->setCellValue('Z1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['tidakditerima'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['jalur_penerimaan'])
				->setCellValue('T' . $column, $data['nama_beasiswa'])
				->setCellValue('U' . $column, $data['status_maba'])
				->setCellValue('V' . $column, $data['created_at'])
				->setCellValue('W' . $column, $data['nama_ibu'])
				->setCellValue('X' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Y' . $column, $data['nama_ayah'])
				->setCellValue('Z' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'ALL DATA TIDAK DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}



	//export data diterima
	//REPORT REGULER ALL DATA EXCELL DITERIMA
	public function report_excelterima()
	{
		$data = ['reguler2'		=> $this->AdminModel->report_excelterima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Tempat Tanggal Lahir')
			->setCellValue('G1', 'Agama')
			->setCellValue('H1', 'No WA')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'Kecamatan')
			->setCellValue('K1', 'Kabupaten')
			->setCellValue('L1', 'Asal Sekolah')
			->setCellValue('M1', 'Jurusan Sekolah')
			->setCellValue('N1', 'Pilihan Prodi 1')
			->setCellValue('O1', 'Pilihan Prodi 2')
			->setCellValue('P1', 'Berat Badan')
			->setCellValue('Q1', 'Tinggi Badan')
			->setCellValue('R1', 'Jalur Penerimaan')
			->setCellValue('S1', 'Peminatan Beasiswa')
			->setCellValue('T1', 'Status Maba')
			->setCellValue('U1', 'Tanggal Registrasi')
			->setCellValue('V1', 'Nama Orang Tua Ibu')
			->setCellValue('W1', 'No WA Ibu')
			->setCellValue('X1', 'Nama Orang Tua Ayah')
			->setCellValue('Y1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['reguler2'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('G' . $column, $data['agama'])
				->setCellValue('H' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, $data['kecamatan_diri'])
				->setCellValue('K' . $column, $data['kabupaten_diri'])
				->setCellValue('L' . $column, $data['asal_sekolah'])
				->setCellValue('M' . $column, $data['jurusan_sekolah'])
				->setCellValue('N' . $column, $data['prodi_satu'])
				->setCellValue('O' . $column, $data['prodi_dua'])
				->setCellValue('P' . $column, $data['berat_badan'])
				->setCellValue('Q' . $column, $data['tinggi_badan'])
				->setCellValue('R' . $column, $data['jalur_penerimaan'])
				->setCellValue('S' . $column, $data['nama_beasiswa'])
				->setCellValue('T' . $column, $data['status_maba'])
				->setCellValue('U' . $column, $data['created_at'])
				->setCellValue('V' . $column, $data['nama_ibu'])
				->setCellValue('W' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('X' . $column, $data['nama_ayah'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA CAMABA ALL DATA DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT PMDP GEL 1 EXCELL DITERIMA
	public function pmdp1_excelterima()
	{
		$data = ['pmdp'		=> $this->AdminModel->pmdp1_excelterima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Tempat Tanggal Lahir')
			->setCellValue('G1', 'Agama')
			->setCellValue('H1', 'No WA')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'Kecamatan')
			->setCellValue('K1', 'Kabupaten')
			->setCellValue('L1', 'Asal Sekolah')
			->setCellValue('M1', 'Jurusan Sekolah')
			->setCellValue('N1', 'Pilihan Prodi 1')
			->setCellValue('O1', 'Pilihan Prodi 2')
			->setCellValue('P1', 'Berat Badan')
			->setCellValue('Q1', 'Tinggi Badan')
			->setCellValue('R1', 'Jalur Penerimaan')
			->setCellValue('S1', 'Peminatan Beasiswa')
			->setCellValue('T1', 'Status Maba')
			->setCellValue('U1', 'Tanggal Registrasi')
			->setCellValue('V1', 'Nama Orang Tua Ibu')
			->setCellValue('W1', 'No WA Ibu')
			->setCellValue('X1', 'Nama Orang Tua Ayah')
			->setCellValue('Y1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['pmdp'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('G' . $column, $data['agama'])
				->setCellValue('H' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, $data['kecamatan_diri'])
				->setCellValue('K' . $column, $data['kabupaten_diri'])
				->setCellValue('L' . $column, $data['asal_sekolah'])
				->setCellValue('M' . $column, $data['jurusan_sekolah'])
				->setCellValue('N' . $column, $data['prodi_satu'])
				->setCellValue('O' . $column, $data['prodi_dua'])
				->setCellValue('P' . $column, $data['berat_badan'])
				->setCellValue('Q' . $column, $data['tinggi_badan'])
				->setCellValue('R' . $column, $data['jalur_penerimaan'])
				->setCellValue('S' . $column, $data['nama_beasiswa'])
				->setCellValue('T' . $column, $data['status_maba'])
				->setCellValue('U' . $column, $data['created_at'])
				->setCellValue('V' . $column, $data['nama_ibu'])
				->setCellValue('W' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('X' . $column, $data['nama_ayah'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA CAMABA PMDP GEL1 DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT PMDP GEL 2 EXCELL DITERIMA
	public function pmdp2_excelterima()
	{
		$data = ['pmdp'		=> $this->AdminModel->pmdp2_excelterima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Tempat Tanggal Lahir')
			->setCellValue('G1', 'Agama')
			->setCellValue('H1', 'No WA')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'Kecamatan')
			->setCellValue('K1', 'Kabupaten')
			->setCellValue('L1', 'Asal Sekolah')
			->setCellValue('M1', 'Jurusan Sekolah')
			->setCellValue('N1', 'Pilihan Prodi 1')
			->setCellValue('O1', 'Pilihan Prodi 2')
			->setCellValue('P1', 'Berat Badan')
			->setCellValue('Q1', 'Tinggi Badan')
			->setCellValue('R1', 'Jalur Penerimaan')
			->setCellValue('S1', 'Peminatan Beasiswa')
			->setCellValue('T1', 'Status Maba')
			->setCellValue('U1', 'Tanggal Registrasi')
			->setCellValue('V1', 'Nama Orang Tua Ibu')
			->setCellValue('W1', 'No WA Ibu')
			->setCellValue('X1', 'Nama Orang Tua Ayah')
			->setCellValue('Y1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['pmdp'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('G' . $column, $data['agama'])
				->setCellValue('H' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, $data['kecamatan_diri'])
				->setCellValue('K' . $column, $data['kabupaten_diri'])
				->setCellValue('L' . $column, $data['asal_sekolah'])
				->setCellValue('M' . $column, $data['jurusan_sekolah'])
				->setCellValue('N' . $column, $data['prodi_satu'])
				->setCellValue('O' . $column, $data['prodi_dua'])
				->setCellValue('P' . $column, $data['berat_badan'])
				->setCellValue('Q' . $column, $data['tinggi_badan'])
				->setCellValue('R' . $column, $data['jalur_penerimaan'])
				->setCellValue('S' . $column, $data['nama_beasiswa'])
				->setCellValue('T' . $column, $data['status_maba'])
				->setCellValue('U' . $column, $data['created_at'])
				->setCellValue('V' . $column, $data['nama_ibu'])
				->setCellValue('W' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('X' . $column, $data['nama_ayah'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA PMDP GEL2 DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT REGULER GEL 2 EXCELL DITERIMA
	public function reguler1_excelterima()
	{
		$data = ['reguler'		=> $this->AdminModel->reguler1_excelterima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Tempat Tanggal Lahir')
			->setCellValue('G1', 'Agama')
			->setCellValue('H1', 'No WA')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'Kecamatan')
			->setCellValue('K1', 'Kabupaten')
			->setCellValue('L1', 'Asal Sekolah')
			->setCellValue('M1', 'Jurusan Sekolah')
			->setCellValue('N1', 'Pilihan Prodi 1')
			->setCellValue('O1', 'Pilihan Prodi 2')
			->setCellValue('P1', 'Berat Badan')
			->setCellValue('Q1', 'Tinggi Badan')
			->setCellValue('R1', 'Jalur Penerimaan')
			->setCellValue('S1', 'Peminatan Beasiswa')
			->setCellValue('T1', 'Status Maba')
			->setCellValue('U1', 'Tanggal Registrasi')
			->setCellValue('V1', 'Nama Orang Tua Ibu')
			->setCellValue('W1', 'No WA Ibu')
			->setCellValue('X1', 'Nama Orang Tua Ayah')
			->setCellValue('Y1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['reguler'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('G' . $column, $data['agama'])
				->setCellValue('H' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, $data['kecamatan_diri'])
				->setCellValue('K' . $column, $data['kabupaten_diri'])
				->setCellValue('L' . $column, $data['asal_sekolah'])
				->setCellValue('M' . $column, $data['jurusan_sekolah'])
				->setCellValue('N' . $column, $data['prodi_satu'])
				->setCellValue('O' . $column, $data['prodi_dua'])
				->setCellValue('P' . $column, $data['berat_badan'])
				->setCellValue('Q' . $column, $data['tinggi_badan'])
				->setCellValue('R' . $column, $data['jalur_penerimaan'])
				->setCellValue('S' . $column, $data['nama_beasiswa'])
				->setCellValue('T' . $column, $data['status_maba'])
				->setCellValue('U' . $column, $data['created_at'])
				->setCellValue('V' . $column, $data['nama_ibu'])
				->setCellValue('W' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('X' . $column, $data['nama_ayah'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI REGUER GEL1 DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT REGULER GEL 2 EXCELL DITERIMA
	public function reguler2_excelterima()
	{
		$data = ['reguler'		=> $this->AdminModel->reguler2_excelterima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Tempat Tanggal Lahir')
			->setCellValue('G1', 'Agama')
			->setCellValue('H1', 'No WA')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'Kecamatan')
			->setCellValue('K1', 'Kabupaten')
			->setCellValue('L1', 'Asal Sekolah')
			->setCellValue('M1', 'Jurusan Sekolah')
			->setCellValue('N1', 'Pilihan Prodi 1')
			->setCellValue('O1', 'Pilihan Prodi 2')
			->setCellValue('P1', 'Berat Badan')
			->setCellValue('Q1', 'Tinggi Badan')
			->setCellValue('R1', 'Jalur Penerimaan')
			->setCellValue('S1', 'Peminatan Beasiswa')
			->setCellValue('T1', 'Status Maba')
			->setCellValue('U1', 'Tanggal Registrasi')
			->setCellValue('V1', 'Nama Orang Tua Ibu')
			->setCellValue('W1', 'No WA Ibu')
			->setCellValue('X1', 'Nama Orang Tua Ayah')
			->setCellValue('Y1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['reguler'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('G' . $column, $data['agama'])
				->setCellValue('H' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, $data['kecamatan_diri'])
				->setCellValue('K' . $column, $data['kabupaten_diri'])
				->setCellValue('L' . $column, $data['asal_sekolah'])
				->setCellValue('M' . $column, $data['jurusan_sekolah'])
				->setCellValue('N' . $column, $data['prodi_satu'])
				->setCellValue('O' . $column, $data['prodi_dua'])
				->setCellValue('P' . $column, $data['berat_badan'])
				->setCellValue('Q' . $column, $data['tinggi_badan'])
				->setCellValue('R' . $column, $data['jalur_penerimaan'])
				->setCellValue('S' . $column, $data['nama_beasiswa'])
				->setCellValue('T' . $column, $data['status_maba'])
				->setCellValue('U' . $column, $data['created_at'])
				->setCellValue('V' . $column, $data['nama_ibu'])
				->setCellValue('W' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('X' . $column, $data['nama_ayah'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI REGUER GEL2 DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT REGULER GEL 3 EXCELL DITERIMA
	public function reguler3_excelterima()
	{
		$data = ['reguler'		=> $this->AdminModel->reguler3_excelterima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Tempat Tanggal Lahir')
			->setCellValue('G1', 'Agama')
			->setCellValue('H1', 'No WA')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'Kecamatan')
			->setCellValue('K1', 'Kabupaten')
			->setCellValue('L1', 'Asal Sekolah')
			->setCellValue('M1', 'Jurusan Sekolah')
			->setCellValue('N1', 'Pilihan Prodi 1')
			->setCellValue('O1', 'Pilihan Prodi 2')
			->setCellValue('P1', 'Berat Badan')
			->setCellValue('Q1', 'Tinggi Badan')
			->setCellValue('R1', 'Jalur Penerimaan')
			->setCellValue('S1', 'Peminatan Beasiswa')
			->setCellValue('T1', 'Status Maba')
			->setCellValue('U1', 'Tanggal Registrasi')
			->setCellValue('V1', 'Nama Orang Tua Ibu')
			->setCellValue('W1', 'No WA Ibu')
			->setCellValue('X1', 'Nama Orang Tua Ayah')
			->setCellValue('Y1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['reguler'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('G' . $column, $data['agama'])
				->setCellValue('H' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, $data['kecamatan_diri'])
				->setCellValue('K' . $column, $data['kabupaten_diri'])
				->setCellValue('L' . $column, $data['asal_sekolah'])
				->setCellValue('M' . $column, $data['jurusan_sekolah'])
				->setCellValue('N' . $column, $data['prodi_satu'])
				->setCellValue('O' . $column, $data['prodi_dua'])
				->setCellValue('P' . $column, $data['berat_badan'])
				->setCellValue('Q' . $column, $data['tinggi_badan'])
				->setCellValue('R' . $column, $data['jalur_penerimaan'])
				->setCellValue('S' . $column, $data['nama_beasiswa'])
				->setCellValue('T' . $column, $data['status_maba'])
				->setCellValue('U' . $column, $data['created_at'])
				->setCellValue('V' . $column, $data['nama_ibu'])
				->setCellValue('W' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('X' . $column, $data['nama_ayah'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA REGUER GEL3 DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//REPORT EXCELL ALIH JENJANG & PROFESI GEL 1 DITERIMA
	public function tf1_excelterima()
	{
		$data = ['tfprofesi'		=> $this->AdminModel->tf1_excelterima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Tempat Tanggal Lahir')
			->setCellValue('G1', 'Agama')
			->setCellValue('H1', 'No WA')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'Kecamatan')
			->setCellValue('K1', 'Kabupaten')
			->setCellValue('L1', 'Asal Sekolah')
			->setCellValue('M1', 'Jurusan Sekolah')
			->setCellValue('N1', 'Pilihan Prodi 1')
			->setCellValue('O1', 'Pilihan Prodi 2')
			->setCellValue('P1', 'Berat Badan')
			->setCellValue('Q1', 'Tinggi Badan')
			->setCellValue('R1', 'Jalur Penerimaan')
			->setCellValue('S1', 'Peminatan Beasiswa')
			->setCellValue('T1', 'Status Maba')
			->setCellValue('U1', 'Tanggal Registrasi')
			->setCellValue('V1', 'Nama Orang Tua Ibu')
			->setCellValue('W1', 'No WA Ibu')
			->setCellValue('X1', 'Nama Orang Tua Ayah')
			->setCellValue('Y1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['tfprofesi'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('G' . $column, $data['agama'])
				->setCellValue('H' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, $data['kecamatan_diri'])
				->setCellValue('K' . $column, $data['kabupaten_diri'])
				->setCellValue('L' . $column, $data['asal_sekolah'])
				->setCellValue('M' . $column, $data['jurusan_sekolah'])
				->setCellValue('N' . $column, $data['prodi_satu'])
				->setCellValue('O' . $column, $data['prodi_dua'])
				->setCellValue('P' . $column, $data['berat_badan'])
				->setCellValue('Q' . $column, $data['tinggi_badan'])
				->setCellValue('R' . $column, $data['jalur_penerimaan'])
				->setCellValue('S' . $column, $data['nama_beasiswa'])
				->setCellValue('T' . $column, $data['status_maba'])
				->setCellValue('U' . $column, $data['created_at'])
				->setCellValue('V' . $column, $data['nama_ibu'])
				->setCellValue('W' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('X' . $column, $data['nama_ayah'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA ALIH JENJANG DAN PROFESI GEL1 DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	//REPORT EXCELL ALIH JENJANG & PROFESI GEL 2 DITERIMA
	public function tf2_excelterima()
	{
		$data = ['tfprofesi'		=> $this->AdminModel->tf2_excelterima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Tempat Tanggal Lahir')
			->setCellValue('G1', 'Agama')
			->setCellValue('H1', 'No WA')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'Kecamatan')
			->setCellValue('K1', 'Kabupaten')
			->setCellValue('L1', 'Asal Sekolah')
			->setCellValue('M1', 'Jurusan Sekolah')
			->setCellValue('N1', 'Pilihan Prodi 1')
			->setCellValue('O1', 'Pilihan Prodi 2')
			->setCellValue('P1', 'Berat Badan')
			->setCellValue('Q1', 'Tinggi Badan')
			->setCellValue('R1', 'Jalur Penerimaan')
			->setCellValue('S1', 'Peminatan Beasiswa')
			->setCellValue('T1', 'Status Maba')
			->setCellValue('U1', 'Tanggal Registrasi')
			->setCellValue('V1', 'Nama Orang Tua Ibu')
			->setCellValue('W1', 'No WA Ibu')
			->setCellValue('X1', 'Nama Orang Tua Ayah')
			->setCellValue('Y1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['tfprofesi'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('G' . $column, $data['agama'])
				->setCellValue('H' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, $data['kecamatan_diri'])
				->setCellValue('K' . $column, $data['kabupaten_diri'])
				->setCellValue('L' . $column, $data['asal_sekolah'])
				->setCellValue('M' . $column, $data['jurusan_sekolah'])
				->setCellValue('N' . $column, $data['prodi_satu'])
				->setCellValue('O' . $column, $data['prodi_dua'])
				->setCellValue('P' . $column, $data['berat_badan'])
				->setCellValue('Q' . $column, $data['tinggi_badan'])
				->setCellValue('R' . $column, $data['jalur_penerimaan'])
				->setCellValue('S' . $column, $data['nama_beasiswa'])
				->setCellValue('T' . $column, $data['status_maba'])
				->setCellValue('U' . $column, $data['created_at'])
				->setCellValue('V' . $column, $data['nama_ibu'])
				->setCellValue('W' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('X' . $column, $data['nama_ayah'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA ALIH JENJANG DAN PROFESI GEL2 DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	//REPORT EXCELL ALIH JENJANG & PROFESI GEL 3 DITERIMA
	public function tf3_excelterima()
	{
		$data = ['tfprofesi'		=> $this->AdminModel->tf3_excelterima()];
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Tempat Tanggal Lahir')
			->setCellValue('G1', 'Agama')
			->setCellValue('H1', 'No WA')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'Kecamatan')
			->setCellValue('K1', 'Kabupaten')
			->setCellValue('L1', 'Asal Sekolah')
			->setCellValue('M1', 'Jurusan Sekolah')
			->setCellValue('N1', 'Pilihan Prodi 1')
			->setCellValue('O1', 'Pilihan Prodi 2')
			->setCellValue('P1', 'Berat Badan')
			->setCellValue('Q1', 'Tinggi Badan')
			->setCellValue('R1', 'Jalur Penerimaan')
			->setCellValue('S1', 'Peminatan Beasiswa')
			->setCellValue('T1', 'Status Maba')
			->setCellValue('U1', 'Tanggal Registrasi')
			->setCellValue('V1', 'Nama Orang Tua Ibu')
			->setCellValue('W1', 'No WA Ibu')
			->setCellValue('X1', 'Nama Orang Tua Ayah')
			->setCellValue('Y1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['tfprofesi'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['jalur_penerimaan'] . '073154' . $no)
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('G' . $column, $data['agama'])
				->setCellValue('H' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, $data['kecamatan_diri'])
				->setCellValue('K' . $column, $data['kabupaten_diri'])
				->setCellValue('L' . $column, $data['asal_sekolah'])
				->setCellValue('M' . $column, $data['jurusan_sekolah'])
				->setCellValue('N' . $column, $data['prodi_satu'])
				->setCellValue('O' . $column, $data['prodi_dua'])
				->setCellValue('P' . $column, $data['berat_badan'])
				->setCellValue('Q' . $column, $data['tinggi_badan'])
				->setCellValue('R' . $column, $data['jalur_penerimaan'])
				->setCellValue('S' . $column, $data['nama_beasiswa'])
				->setCellValue('T' . $column, $data['status_maba'])
				->setCellValue('U' . $column, $data['created_at'])
				->setCellValue('V' . $column, $data['nama_ibu'])
				->setCellValue('W' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('X' . $column, $data['nama_ayah'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}
		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA ALIH JENJANG DAN PROFESI GEL3 DITERIMA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//data diterima
	public function data_diterima()
	{
		$data = [
			'title'		=> 'ALL DATA MAHASISWA BARU YANG TELAH DITERIMA',
			'data'		=> $this->AdminModel->get_maba_diterima()
		];
		return view('admin/page/data_maba/tampil_data_maba_diterima', $data);
	}
	//upload data diterima
	public function import_data()
	{
		$data = [
			'title'		=> 'IMPORT DATA MAHASISWA ',
			'validation'	=> \Config\Services::Validation()
		];
		return view('admin/page/data_maba/import_data', $data);
	}
	//SAVE INMPORT
	public function save_import()
	{
		if (!$this->validate([
			'data_maba' => [
				'rules'		=> 'ext_in[data_maba,xlsx,xls]',
				'errors'	=> [
					'ext_in'	=> '{field} File harus berformat xlsx/xls.!',
				]
			]
		])) {

			return redirect()->to('import_data')->withInput();
		}
		$file_excel = $this->request->getFile('data_maba');
		$ext = $file_excel->getClientExtension();
		if ($ext == 'xls') {
			$render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		} else {
			$render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}

		$spreadsheet = $render->load($file_excel);

		$data = $spreadsheet->getActiveSheet()->toArray();
		$pesan_error = [];
		foreach ($data as $x => $row) {
			if ($x == 0) {
				continue;
			}
			$user_id 	= $row[3];
			$jalur 		= $row[5];
			$prodi		= $row[6];
			$status 	= $row[7];
			$data = [
				'user_id'			=> $user_id,
				'jalur_penerimaan' 	=> $jalur,
				'prodi_satu' 		=> $prodi,
				'status_maba' 		=> $status
			];
			// dd($data);
			$this->AdminModel->save_import($data);
		}
		session()->setFlashdata('pesan', 'Data berhasil di Import.');
		return redirect()->to('/admin/import_data');
	}
	//HUBUNGI PANITIA
	public function hubungi_panitia()
	{
		$data = [
			'title'		=> 'DATA MAHASISWA BARU YANG HARUS MENGHUBUNGI PANITIA',
			'data'		=> $this->AdminModel->get_maba_hubungipanitia()
		];
		return view('admin/page/data_maba/tampil_data_maba_hubungipanitia', $data);
	}
	//DATA TIDAK DITERIMA
	public function tidakditerma()
	{
		$data = [
			'title'		=> 'DATA MAHASISWA BARU YANG TIDAK DITERIMA',
			'data'		=> $this->AdminModel->get_maba_tidakditerima()
		];
		return view('admin/page/data_maba/tampil_data_maba_tidakditerima', $data);
	}

	//CETAK KARTU PESERTA
	public function cetak_kartu()
	{
		$data = [
			'title'		=> 'CETAK KARTU PESERTA MAHASISWA BARU',
			'data'		=> $this->AdminModel->get_cetak_kartu()
		];
		return view('admin/page/cetak_kartu/tampil_cetak_kartu', $data);
	}
	//cetak kartu individu
	public function cetak_kartu_pdf($nik)
	{
		$data = [
			'title'		=> 'KARTU UJIAN MAHASISWA BARU',
			'data'		=> $this->AdminModel->cetak_kartu($nik)
		];
		$dompdf  = new \Dompdf\Dompdf();
		$options = new \Dompdf\Options();
		$options->setIsRemoteEnabled(true);
		$dompdf->setOptions($options);
		$dompdf->Output();
		$dompdf->loadHtml(view('admin/page/cetak_kartu/cetak_kartu_pdf', $data));
		$dompdf->setPaper('B5', 'landscape');
		$dompdf->render();
		$dompdf->stream('Kartu Ujian.pdf', array("Attachment" => false));
		exit();
	}

	//cetak kartu individu
	public function cetak_kartu_semua()
	{
		$data = [
			'title'		=> 'KARTU UJIAN MAHASISWA BARU',
			'data'		=> $this->AdminModel->cetak_kartu_semua()
		];
		$dompdf  = new \Dompdf\Dompdf();
		$options = new \Dompdf\Options();
		$options->setIsRemoteEnabled(true);
		$dompdf->setOptions($options);
		$dompdf->Output();
		$dompdf->loadHtml(view('admin/page/cetak_kartu/cetak_kartu_semua', $data));
		$dompdf->setPaper('B5', 'landscape');
		$dompdf->render();
		$dompdf->stream('Kartu Ujian.pdf', array("Attachment" => false));
		exit();
	}

	public function coba()
	{
		$data = [
			'title'		=> 'Profile Mahasiswa'

		];
		session()->setFlashdata('pesan', 'Data berhasil disimpan');
		return redirect()->to('home/profile', $data);
	}
	//SETTING JALUR
	public function get_gelombang()
	{
		$data = [
			'title'		=> 'MASTER GELOMBANG PENERIMAAN',
			'data'		=> $this->AdminModel->get_gelombang()
		];
		return view('admin/page/setting/gelombang/tampil_gelombang', $data);
	}
	//FORM GELOMBANG
	public function form_gelombang()
	{
		$data = [
			'title'		=> 'FORM GELOMBANG PENERIMAAN',
			'validation' => \Config\Services::Validation()
		];
		return view('admin/page/setting/gelombang/form_gelombang', $data);
	}
	//SAVE GELOMBANG 
	public function save_gelombang()
	{
		if (!$this->validate([
			'nama_gelombang' => [

				'rules'		=> 'required|is_unique[tb_gelombang.nama_gelombang]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			]
		])) {
			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('form_gelombang')->withInput()->with('validation', $validation);
		}
		$data = [
			'nama_gelombang' 	=> $this->request->getVar('nama_gelombang'),
			'status_gelombang'  => $this->request->getVar('status'),
			'tgl_buka'  		=> $this->request->getVar('tgl_buka'),
			'tgl_tutup'  		=> $this->request->getVar('tgl_tutup'),
			'status_pengumuman' => $this->request->getVar('statuspengumuman'),
		];

		$this->AdminModel->save_gelombang($data);
		session()->setFlashdata('pesan', 'Data Berhasil ditambahkan.');
		return redirect()->to('get_gelombang');
	}
	//UPDATE GELOMBANG
	public function get_update_gelombang($id_gelombang)
	{
		$data = [
			'title'			=> 'UPDATE DATA GELOMBANG',
			'validation'	=> \Config\Services::Validation(),
			'data'			=> $this->AdminModel->get_update_gelombang($id_gelombang)

		];
		return view('admin/page/setting/gelombang/update_gelombang', $data);
	}


	//--------------------------------------------------------------------------------------------------

	public function updated_gelombang($data)
	{
		if (!$this->validate([
			// 'nama_sekolah' => 'required|is_unique[tb_sekolah.nama_sekolah]'
			'nama_gelombang' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			]
		])) {

			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('/admin/get_update_gelombang/' . $this->request->getVar('id_gelombang'))->withInput()->with('validation', $validation);
		}

		$data = [
			'id_gelombang'		=> $this->request->getVar('id_gelombang'),
			'nama_gelombang' 	=> $this->request->getVar('nama_gelombang'),
			'status_gelombang' 	=> $this->request->getVar('status'),
			'tgl_buka'  		=> $this->request->getVar('tgl_buka'),
			'tgl_tutup'  		=> $this->request->getVar('tgl_tutup'),
			'status_pengumuman' => $this->request->getVar('statuspengumuman'),
		];
		$this->AdminModel->updated_gelombang($data);
		session()->setFlashdata('pesan', 'Data Berhasil diupdate.');
		return redirect()->to('/admin/get_gelombang');
	}
	//-------------------------------------------------------------------------------
	public function delete_gelombang($id_gelombang)
	{
		$this->AdminModel->delete_gelombang($id_gelombang);
		session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
		return redirect()->to('/admin/get_gelombang');
	}
	//-------------------------------------------------------------------------------
	public function get_export()
	{
		$data = [
			'title'		=> 'EXPORT DATA MAHASISWA ',
			'gelombang'	=> $this->AdminModel->get_gelombang(),
			'jalur'		=> $this->AdminModel->get_penerimaan(),
			'validation' => \Config\Services::Validation()
		];
		return view('admin/page/data_maba/export_data', $data);
	}

	//-------------------------------------------------------------------------------
	public function save_export()
	{
		$data = [

			'gelombang'			=> $this->request->getVar('gelombang'),
			'jalur_penerimaan' 	=> $this->request->getVar('jalur'),
			'status_maba' 		=> $this->request->getVar('status'),
		];
		$data = ['data' => $this->AdminModel->export_excel($data)];

		// dd($data1);
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'USERS_ID')
			->setCellValue('E1', 'Nama Lengkap')
			->setCellValue('F1', 'Jenis Kelamin')
			->setCellValue('G1', 'Tempat Tanggal Lahir')
			->setCellValue('H1', 'Agama')
			->setCellValue('I1', 'No WA')
			->setCellValue('J1', 'Alamat Domisili')
			->setCellValue('K1', 'Kecamatan')
			->setCellValue('L1', 'Kabupaten')
			->setCellValue('M1', 'Asal Sekolah')
			->setCellValue('N1', 'Jurusan Sekolah')
			->setCellValue('O1', 'Pilihan Prodi 1')
			->setCellValue('P1', 'Pilihan Prodi 2')
			->setCellValue('Q1', 'Berat Badan')
			->setCellValue('R1', 'Tinggi Badan')
			->setCellValue('S1', 'Gelombang')
			->setCellValue('T1', 'Jalur Penerimaan')
			->setCellValue('U1', 'Peminatan Beasiswa')
			->setCellValue('V1', 'Status Maba')
			->setCellValue('W1', 'Tanggal Registrasi')
			->setCellValue('X1', 'Nama Orang Tua Ibu')
			->setCellValue('Y1', 'No WA Ibu')
			->setCellValue('Z1', 'Nama Orang Tua Ayah')
			->setCellValue('AA1', 'No WA Ayah');
		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['data'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['no_pendaftaran'])
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['user_id'])
				->setCellValue('E' . $column, $data['fullname'])
				->setCellValue('F' . $column, $data['jenis_kelamin'])
				->setCellValue('G' . $column, $data['tempat_lahir'], $data['tanggal_lahir'])
				->setCellValue('H' . $column, $data['agama'])
				->setCellValue('I' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('J' . $column, $data['alamat_domisili'])
				->setCellValue('K' . $column, $data['kecamatan_diri'])
				->setCellValue('L' . $column, $data['kabupaten_diri'])
				->setCellValue('M' . $column, $data['asal_sekolah'])
				->setCellValue('N' . $column, $data['jurusan_sekolah'])
				->setCellValue('O' . $column, $data['prodi_satu'])
				->setCellValue('P' . $column, $data['prodi_dua'])
				->setCellValue('Q' . $column, $data['berat_badan'])
				->setCellValue('R' . $column, $data['tinggi_badan'])
				->setCellValue('S' . $column, $data['gelombang'])
				->setCellValue('T' . $column, $data['jalur_penerimaan'])
				->setCellValue('U' . $column, $data['nama_beasiswa'])
				->setCellValue('V' . $column, $data['status_maba'])
				->setCellValue('W' . $column, $data['created_at'])
				->setCellValue('X' . $column, $data['nama_ibu'])
				->setCellValue('Y' . $column, '+62 ' . $data['no_wa_ibu'])
				->setCellValue('Z' . $column, $data['nama_ayah'])
				->setCellValue('AA' . $column, '+62 ' . $data['no_wa_ayah']);
			$no++;
			$column++;
		}

		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'DATA SELEKSI CAMABA';
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
	//EXPORT DATA DITERIMA
	public function get_export_diterima()
	{
		$data = [
			'title'		=> 'EXPORT DATA MAHASISWA ',
			'data'		=> $this->AdminModel->get_masterdata(),
			'validation' => \Config\Services::Validation()
		];
		return view('admin/page/data_maba/export_data_diterima', $data);
	}
	//DATA BERKAS REGISTRASI
	public function get_berkas_register()
	{
		$data = [
			'title'		=> 'MASTER BERKAS REGISTRASI ULANG',
			'data'		=> $this->AdminModel->get_registrasi_ulang()
		];
		return view('admin/page/setting/registrasi_ulang/tampil_register', $data);
	}
	//FORM GELOMBANG
	public function form_berkas_register()
	{
		$data = [
			'title'		=> 'FORM BERKAS REGISTRASI ULANG',
			'gelombang'	=> $this->AdminModel->get_gelombang(),
			'jalur'		=> $this->AdminModel->get_penerimaan(),
			'validation' => \Config\Services::Validation()
		];
		return view('admin/page/setting/registrasi_ulang/form_register', $data);
	}
	//SAVE GELOMBANG 
	public function save_berkas_register()
	{
		if (!$this->validate([
			'nama_berkas' => [

				'rules'		=> 'required|is_unique[tb_registrasi_ulang.nama_berkas]',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!',
					'is_unique'	=>	'{field} sudah ada.!'
				]
			],
			'file_berkas' => [

				'rules'		=> 'uploaded[file_berkas]|ext_in[file_berkas,pdf]',

				'errors'	=> [
					'uploaded'	=> '{field} tidak boleh kosong.!',
					'ext_in'	=> '{field} File harus berformat pdf.!'
				]
			]
		])) {
			$validation = \Config\Services::Validation()->listErrors();
			return redirect()->to('form_berkas_register')->withInput()->with('validation', $validation);
		}
		$file_berkas = $this->request->getFile('file_berkas');
		$nama_file 	 = $file_berkas->getRandomName();
		$file_berkas->move('document_registrasi', $nama_file);
		$data = [
			'nama_berkas' 		=> $this->request->getVar('nama_berkas'),
			'gelombang'  		=> $this->request->getVar('gelombang'),
			'jalur_penerimaan'  => $this->request->getVar('jalur_penerimaan'),
			'prodi_diterima'  	=> $this->request->getVar('prodi'),
			'keterangan' 		=> $this->request->getVar('keterangan'),
			'status_document' 	=> $this->request->getVar('status'),
			'file_berkas' 		=> $nama_file
		];
		$this->AdminModel->save_register_ulang($data);
		session()->setFlashdata('pesan', 'Data Berhasil ditambahkan.');
		return redirect()->to('get_berkas_register');
	}
	//UPDATE GELOMBANG
	public function get_update_berkas_register($id_document)
	{
		$data = [
			'title'			=> 'UPDATE DATA BERKAS REGISTRASI ULANG',
			'validation'	=> \Config\Services::Validation(),
			'gelombang'		=> $this->AdminModel->get_gelombang(),
			'jalur'			=> $this->AdminModel->get_penerimaan(),
			'data'			=> $this->AdminModel->get_update_register($id_document)

		];
		return view('admin/page/setting/registrasi_ulang/update_register', $data);
	}
	//--------------------------------------------------------------------------------------------------

	public function updated_berkas_register($data)
	{
		if (!$this->validate([
			'nama_berkas' => [

				'rules'		=> 'required',

				'errors'	=> [
					'required'	=> '{field} harus diisi.!'
				]
			],
			'file_berkas' => [

				'rules'		=> 'ext_in[file_berkas,pdf]',

				'errors'	=> [
					'ext_in'	=> '{field} File harus berformat pdf.!'
				]
			]
		])) {
			return redirect()->to('/admin/get_update_berkas_register/' . $this->request->getVar('id_document'))->withInput();
		}

		$file_berkas = $this->request->getFile('file_berkas');
		if ($file_berkas->getError() == 4) {
			$nama_file = $this->request->getVar('file_lama');
		} else {
			$nama_file 	 = $file_berkas->getRandomName();
			$file_berkas->move('document_registrasi', $nama_file);
			unlink('document_registrasi/' . $this->request->getVar('file_lama'));
		}
		$data = [
			'id_document'		=> $this->request->getVar('id_document'),
			'nama_berkas' 		=> $this->request->getVar('nama_berkas'),
			'gelombang'  		=> $this->request->getVar('gelombang'),
			'jalur_penerimaan'  => $this->request->getVar('jalur_penerimaan'),
			'prodi_diterima'  	=> $this->request->getVar('prodi'),
			'keterangan' 		=> $this->request->getVar('keterangan'),
			'status_document' 	=> $this->request->getVar('status'),
			'file_berkas' 		=> $nama_file
		];
		// dd($data);
		$this->AdminModel->updated_berkas_register($data);
		session()->setFlashdata('pesan', 'Data Berhasil diupdate.');
		return redirect()->to('/admin/get_berkas_register');
	}
	//-------------------------------------------------------------------------------
	public function delete_berkas_register($id_document)
	{
		$data = [
			'file_berkas' => $this->AdminModel->get_update_register($id_document)
		];
		foreach ($data['file_berkas'] as $file) {
		}
		unlink('document_registrasi/' . $file['file_berkas']);
		$this->AdminModel->delete_berkas_register($id_document);
		session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
		return redirect()->to('/admin/get_berkas_register');
	}

	//EXPORT DATA KEUANGAN
	public function get_export_pendaftaran()
	{
		$data = [
			'title'		=> 'EXPORT DATA MAHASISWA ',
			'gelombang'	=> $this->AdminModel->get_gelombang(),
			'jalur'		=> $this->AdminModel->get_penerimaan(),
			'validation' => \Config\Services::Validation()
		];
		return view('admin/page/data_biaya_pendaftaran/export_data_pendaftaran.php', $data);
	}
	//SAVE EXPORT KEUANGAN
	public function save_export_pendaftaran()
	{
		$data = [

			'gelombang'			=> $this->request->getVar('gelombang'),
			'jalur_penerimaan' 	=> $this->request->getVar('jalur'),
		];
		$data = ['data' => $this->AdminModel->export_excel_pendaftaran($data)];

		// dd($data);
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Jalur Pendaftarn')
			->setCellValue('G1', 'Gelombang')
			->setCellValue('H1', 'Asal Sekolah')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'No Wa Peserta')
			->setCellValue('K1', 'Metode Pembayaran')
			->setCellValue('L1', 'Nama Bank')
			->setCellValue('M1', 'Tanggal Bayar')
			->setCellValue('N1', 'Keterangan');

		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['data'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['no_pendaftaran'])
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['jalur_penerimaan'])
				->setCellValue('G' . $column, $data['gelombang'])
				->setCellValue('H' . $column, $data['asal_sekolah'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('K' . $column, $data['jenis_pembayaran'])
				->setCellValue('L' . $column, $data['nama_bank'])
				->setCellValue('M' . $column, $data['tanggal_valid'])
				->setCellValue('N' . $column, $data['keterangan']);
			$no++;
			$column++;
		}

		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'LAPORAN KEUANGAN' . date('D-m-y');
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//EXPORT DATA KEUANGAN
	public function get_export_psikotest()
	{
		$data = [
			'title'		=> 'EXPORT DATA MAHASISWA ',
			'gelombang'	=> $this->AdminModel->get_gelombang(),
			'jalur'		=> $this->AdminModel->get_penerimaan(),
			'validation' => \Config\Services::Validation()
		];
		return view('admin/page/data_biaya_psikotes/export_data_psikotest.php', $data);
	}
	//SAVE EXPORT KEUANGAN
	public function save_export_psikotest()
	{
		$data = [

			'gelombang'			=> $this->request->getVar('gelombang'),
			'jalur_penerimaan' 	=> $this->request->getVar('jalur'),
		];
		$data = ['data' => $this->AdminModel->export_excel_psikotest($data)];

		// dd($data);
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom 
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'No Pendaftaran')
			->setCellValue('C1', 'N I K')
			->setCellValue('D1', 'Nama Lengkap')
			->setCellValue('E1', 'Jenis Kelamin')
			->setCellValue('F1', 'Jalur Pendaftarn')
			->setCellValue('G1', 'Gelombang')
			->setCellValue('H1', 'Asal Sekolah')
			->setCellValue('I1', 'Alamat Domisili')
			->setCellValue('J1', 'No Wa Peserta')
			->setCellValue('K1', 'Metode Pembayaran')
			->setCellValue('L1', 'Nama Bank')
			->setCellValue('M1', 'Tanggal Bayar')
			->setCellValue('N1', 'Keterangan');

		$column = 2;
		$no = 1;
		// tulis data mobil ke cell
		foreach ($data['data'] as $data) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $no)
				->setCellValue('B' . $column, $data['no_pendaftaran'])
				->setCellValue('C' . $column, "'" . $data['nik'])
				->setCellValue('D' . $column, $data['fullname'])
				->setCellValue('E' . $column, $data['jenis_kelamin'])
				->setCellValue('F' . $column, $data['jalur_penerimaan'])
				->setCellValue('G' . $column, $data['gelombang'])
				->setCellValue('H' . $column, $data['asal_sekolah'])
				->setCellValue('I' . $column, $data['alamat_domisili'])
				->setCellValue('J' . $column, '+62 ' . $data['no_wa'])
				->setCellValue('K' . $column, $data['jenis_pembayaran_ujian'])
				->setCellValue('L' . $column, $data['nama_bank_ujian'])
				->setCellValue('M' . $column, $data['tanggal_valid_ujian'])
				->setCellValue('N' . $column, $data['ket_bayar_ujian']);
			$no++;
			$column++;
		}

		// tulis dalam format .xlsx
		$writer = new Xlsx($spreadsheet);
		$fileName = 'LAPORAN BIAYA PSIKOTEST' . date('D-m-y');
		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

	//UPDATE DATA MABA
	public function get_update_datamaba($nik)
	{

		$data = [

			'title'				=> 'UPDATED DATA USERS',
			'data'				=> $this->AdminModel->profile_maba($nik),
			'data_kecamatan'	=> $this->AdminModel->get_kecamatan(),
			'data_kabupaten'	=> $this->AdminModel->get_kabupaten(),
			'data_sekolah'		=> $this->AdminModel->get_sekolah(),
			'data_jalur'		=> $this->AdminModel->get_penerimaan(),
			'validation'		=> \Config\Services::Validation()

		];
		return view('admin/page/data_maba/tampil_edit_profile', $data);
	}

	//UPDATED DATA MABA 
	public function updated_datamaba($data)
	{
		$data = ['data' 				=> $this->request->getVar('nikmaba')];

		if (!$this->validate([
			'foto_maba' => [

				'rules'		=> 'mime_in[foto_maba,image/png,image/jpg,image/jpeg]|is_image[foto_maba]',

				'errors'	=> [
					'mime_in'	=> '{field} harus berformat jpg/jpeg/png.!',
					'is_image'	=> '{field} harus berformat jpg/jpeg/png.!'
				]
			]

		])) {
			return redirect()->to('/admin/get_update_datamaba/' . $data['data'])->withInput();
			// echo $data['data'];
		}

		$foto_maba = $this->request->getFile('foto_maba');
		if ($foto_maba->getError() == 4) {
			$nama_foto = $this->request->getVar('namafotolama');
		} else {
			$nama_foto = $foto_maba->getRandomName();
			$foto_maba->move('file_foto_maba', $nama_foto);
			unlink('file_foto_maba/' . $this->request->getVar('namafotolama'));
		}

		$data = [
			'user_id'			=> $this->request->getVar('userid'),
			'nik' 				=> $this->request->getVar('nikmaba'),
			'tempat_lahir' 		=> $this->request->getVar('tempat_lahir'),
			'tanggal_lahir' 	=> $this->request->getVar('tgl_lahir'),
			'jenis_kelamin' 	=> $this->request->getVar('jenis_kelamin'),
			'agama' 			=> $this->request->getVar('agama'),
			'kecamatan_diri' 	=> $this->request->getVar('kecamatan_maba'),
			'kabupaten_diri' 	=> $this->request->getVar('kabupaten_maba'),
			'alamat_domisili'	=> $this->request->getVar('alamat_lengkap_maba'),
			'tinggi_badan'	 	=> $this->request->getVar('tinggi_badan'),
			'berat_badan'		=> $this->request->getVar('berat_badan'),
			'asal_sekolah'		=> $this->request->getVar('asal_sekolah'),
			'kecamatan_sekolah'	=> $this->request->getVar('kecamatan_sekolah'),
			'kabupaten_sekolah'	=> $this->request->getVar('kabupaten_sekolah'),
			'alamat_sekolah'	=> $this->request->getVar('alamat_sekolah'),
			'jurusan_sekolah'	=> $this->request->getVar('jurusan_sekolah_maba'),
			'tahun_lulus'		=> $this->request->getVar('th_lulus'),
			'foto_maba'			=> $nama_foto,
			'prodi_satu'		=> $this->request->getVar('prodi1'),
			'prodi_dua'			=> $this->request->getVar('prodi2'),
			'jalur_penerimaan'	=> $this->request->getVar('jalur_penerimaan')

		];
		$this->AdminModel->updated_datamasterbiodata($data);
		$data = [
			'user_id'			=> $this->request->getVar('userid'),
			'nik' 				=> $this->request->getVar('nikmaba'),
			'nik_ayah' 			=> $this->request->getVar('nik_ayah'),
			'nama_ayah' 		=> $this->request->getVar('nama_ayah'),
			'no_wa_ayah' 		=> $this->request->getVar('nowaayah'),
			'pendidikan_ayah' 	=> $this->request->getVar('pendidikan_ayah'),
			'pekerjaan_ayah' 	=> $this->request->getVar('pekerjaan_ayah'),
			'penghasilan_ayah' 	=> $this->request->getVar('penghasilan_ayah'),
			'kecamatan_ayah' 	=> $this->request->getVar('kecamatan_ayah'),
			'kabupaten_ayah' 	=> $this->request->getVar('kabupaten_ayah'),
			'alamat_ayah' 		=> $this->request->getVar('alamat_lengkap_ayah'),
		];
		$this->AdminModel->updated_dataortuayah($data);
		$data = [
			'user_id'			=> $this->request->getVar('userid'),
			'nik' 				=> $this->request->getVar('nikmaba'),
			'nik_ibu' 			=> $this->request->getVar('nik_ibu'),
			'nama_ibu' 			=> $this->request->getVar('nama_ibu'),
			'no_wa_ibu' 		=> $this->request->getVar('nowaibu'),
			'pendidikan_ibu' 	=> $this->request->getVar('pendidikan_ibu'),
			'pekerjaan_ibu' 	=> $this->request->getVar('pekerjaan_ibu'),
			'penghasilan_ibu' 	=> $this->request->getVar('penghasilan_ibu'),
			'kecamatan_ibu' 	=> $this->request->getVar('kecamatan_ibu'),
			'kabupaten_ibu' 	=> $this->request->getVar('kabupaten_ibu'),
			'alamat_ibu' 		=> $this->request->getVar('alamat_lengkap_ibu'),
		];
		$this->AdminModel->updated_dataortuibu($data);
		$data = ['data' 				=> $this->request->getVar('nikmaba')];
		if (!$this->validate([
			'ktp_maba' => [

				'rules'		=> 'ext_in[ktp_maba,png,jpg,jpeg,pdf]',

				'errors'	=> [
					'ext_in'	=> '{field} File harus berformat jpg/jpeg/png/pdf.!'
				]
			],
			'file_kk' => [

				'rules'		=> 'ext_in[file_kk,png,jpg,jpeg,pdf]',

				'errors'	=> [
					'ext_in'	=> '{field} File harus berformat jpg/jpeg/png/pdf.!'
				]
			],
			'file_ijazah' => [

				'rules'		=> 'ext_in[file_ijazah,png,jpg,jpeg,pdf]',

				'errors'	=> [
					'ext_in'	=> '{field} File harus berformat jpg/jpeg/png/pdf.!'
				]
			],
			'file_raport' => [

				'rules'		=> 'ext_in[file_raport,png,jpg,jpeg,pdf]',

				'errors'	=> [
					'ext_in'	=> '{field} File harus berformat jpg/jpeg/png/pdf.!'
				]
			]

		])) {
			return redirect()->to('/admin/get_update_datamaba/' . $data['data'])->withInput();
			// echo $data['data'];
		}
		//ktp_maba
		$ktp_maba = $this->request->getFile('ktp_maba');
		if ($ktp_maba->getError() == 4) {
			$nama_ktp = $this->request->getVar('ktplama');
		} else {
			$nama_ktp = $ktp_maba->getRandomName();
			$ktp_maba->move('file_berkas', $nama_ktp);
			unlink('file_berkas/' . $this->request->getVar('ktplama'));
		}
		// file_kk
		$file_kk = $this->request->getFile('file_kk');
		if ($file_kk->getError() == 4) {
			$nama_kk = $this->request->getVar('kklama');
		} else {
			$nama_kk = $file_kk->getRandomName();
			$file_kk->move('file_berkas', $nama_kk);
			unlink('file_berkas/' . $this->request->getVar('kklama'));
		}
		// file_ijazah
		$file_ijazah = $this->request->getFile('file_ijazah');
		if ($file_ijazah->getError() == 4) {
			$nama_ijazah = $this->request->getVar('ijazahlama');
		} else {
			$nama_ijazah = $file_ijazah->getRandomName();
			$file_ijazah->move('file_berkas', $nama_ijazah);
			unlink('file_berkas/' . $this->request->getVar('ijazahlama'));
		}
		// file_raport
		$file_raport = $this->request->getFile('file_raport');
		if ($file_raport->getError() == 4) {
			$nama_raport = $this->request->getVar('raportlama');
		} else {
			$nama_raport = $file_raport->getRandomName();
			$file_raport->move('file_berkas', $nama_raport);
			unlink('file_berkas/' . $this->request->getVar('raportlama'));
		}
		$data = [
			'user_id'			=> $this->request->getVar('userid'),
			'nik' 				=> $this->request->getVar('nikmaba'),
			'file_ktp' 			=> $nama_ktp,
			'file_kk' 			=> $nama_kk,
			'file_ijazah' 		=> $nama_ijazah,
			'file_raport' 		=> $nama_raport,

		];
		$this->AdminModel->updated_databerkasmaba($data);
		$data = ['data' 				=> $this->request->getVar('nikmaba')];
		if (!$this->validate([
			'file_bukti_bayar' => [

				'rules'		=> 'ext_in[file_bukti_bayar,png,jpg,jpeg,pdf]',

				'errors'	=> [
					'ext_in'	=> '{field} File harus berformat jpg/jpeg/png/pdf.!'
				]
			]

		])) {
			return redirect()->to('/admin/get_update_datamaba/' . $data['data'])->withInput();
			// echo $data['data'];
		}
		// file_raport
		$file_bukti_bayar = $this->request->getFile('file_bukti_bayar');
		if ($file_bukti_bayar->getError() == 4) {
			$nama_bukti_bayar = $this->request->getVar('buktibayarlama');
		} else {
			$nama_bukti_bayar = $file_bukti_bayar->getRandomName();
			$file_bukti_bayar->move('file_biaya_pendaftaran', $nama_bukti_bayar);
			unlink('file_biaya_pendaftaran/' . $this->request->getVar('buktibayarlama'));
		}
		$data = [
			'user_id'			=> $this->request->getVar('userid'),
			'nik' 				=> $this->request->getVar('nikmaba'),
			'file_bukti_bayar' 	=> $nama_bukti_bayar,

		];
		$this->AdminModel->updated_buktibayarmaba($data);

		$data = [
			'id'			=> $this->request->getVar('userid'),
			'fullname' 		=> $this->request->getVar('nama_lengkap'),
			'no_wa' 		=> $this->request->getVar('nowa'),
		];
		$this->AdminModel->updated_users($data);
		session()->setFlashdata('pesan', 'Data <b>' . $data['fullname'] . ' </b> Berhasil diupdate.');
		return redirect()->to('/admin/bank_data');
	}
	

}
