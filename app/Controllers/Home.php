<?php namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\UsersModel;
use App\Models\HomeModel;
use App\Models\AbsenModel;

class Home extends BaseController
{
    protected $HomeModel;
    public function __construct()
    {
        $this->HomeModel = new HomeModel();
        $this->AbsenModel = new AbsenModel();
    }
    //--------------------------------------------------------------------

    public function index()
    {
        $data = [
                    'title'             =>  'coba',
        ];
        return view('Auth/login', $data);
    }
    //---------------------------------------------------------------------------------
    
    public function dasboard()
    {
        if(empty($session = session('user_id'))){
            return redirect()->to('/');
        }else{
            
            $data = [
                'title'     =>  'HALAMAN USERS',
                'session'   =>  $session = session(),
                'validation'=> \Config\Services::Validation(),
                'jam_plg'   =>  $this->HomeModel->jam_plg(),
                'chekAbsen' =>  $this->HomeModel->chekAbsen(),
                'data'      =>  $this->HomeModel->getBiodata()
            ];
        return view('home/page/absensi/tampil_absensi', $data);
        }
        
    }
    //---------------------------------------------------------------------------------
    public function admin()
    {
        $data = [
                    'title' =>  'Login Administrator',
        ];
        return view('Auth/login_admin', $data);
    }
    //---------------------------------------------------------------------------------
    public function auth()
    {
        $session    = session();
        $model      = new UsersModel();
        $email      = $this->request->getVar('email');
        $password   = $this->request->getVar('password');
        $data       = $model->where('user_name', $email)->first();
        // dd($email);
        if($data){
            $pass = $data['user_password'];
            $verify_pass = password_verify($password, $pass);
            if($verify_pass){
                $ses_data = [
                    'user_id'       => $data['user_id'],
                    'user_name'     => $data['user_name'],
                    'nama_lengkap'  => $data['nama_lengkap'],
                    'user_email'    => $data['user_email'],
                    'foto'          => $data['foto'],
                    'logged_in'     => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/home/dasboard');
            }else{
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login');
            }
        }else{
            $session->setFlashdata('msg', 'Username belum terdaftar. hub Kepegawaian');
            return redirect()->to('/login');
        }
    }
    //--------------------------------------------------------------------------------------
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
    //---------------------------------------------------------------------------------
    public function masuk()
    {
        $chek = $this->HomeModel->chek_jam_masuk();
        $c = $chek[0]['jam_masuk'];
        if ($c <= $this->request->getVar('jam_masuk')){
               $a ='Late';
        }else{
               $a ='ontime';
        }
        $data = [
               'user_name' =>  $this->request->getVar('id'),
               'tgl_masuk' =>  $this->request->getVar('tgl_masuk'),
               'jam_masuk' =>  $this->request->getVar('jam_masuk'),
               'keterangan'=>  $a
        ];
        // dd($data);
        $this->HomeModel->save_masuk($data);
        if($a=='Late'){
            session()->setFlashdata('gagal', 'Byuuh Terlambat Reek!. Telat Lagi Potong Gaji!');
            return redirect()->to('dasboard');
        }else{
            session()->setFlashdata('pesan', 'Mantab Karyawan Teladan Memang, Tahun Depan Naik Gaji!');
               return redirect()->to('dasboard');
        }

    }
    //---------------------------------------------------------------------------------
    public function pulang($data)
    {
        $data = [
                    'user_id'    =>  $this->request->getVar('id'),
                    'tgl_pulang' =>  $this->request->getVar('tgl_plg'),
                    'jam_pulang' =>  $this->request->getVar('jam_plg')
        ];
        // dd($data);
        $this->HomeModel->save_plg($data);
        session()->setFlashdata('pesan', 'Oke anda telah pulang, terima kasih.');
        return redirect()->to('/home/dasboard');
    }
    //---------------------------------------------------------------------------------
    public function riwayat_absensi()
    {
        $data = [
                    'title'     =>  "RIWAYAT ABSENSI",
                    'session'   =>  $session = session(),
                    'data'      =>  $this->HomeModel->riwayatAbsensi(),
                    'biodata'   =>  $this->HomeModel->getBiodata()
                    
        ];
        return view('home/page/absensi/riwayat_absensi', $data);
       
    }
    //---------------------------------------------------------------------------------
    public function profileKu()
    {
        $data = [
                    'title'     =>  "PROFILE KARYAWAN",
                    'session'   =>  $session = session(),
                    'validation'=> \Config\Services::Validation(),
                    'data'      =>  $this->HomeModel->getBiodata()
                    
        ];
        return view('home/page/profile/tampil_profile', $data);
       
    }

    //---------------------------------------------------------------------------------
    public function savePp()
    {
        if (!$this->validate([

            'nama_lengkap' => [

                'rules'     => 'required|min_length[3]|max_length[55]',

                'errors'    => [
                    'required'  => '{field} harus diisi.!',
                    'min_length'    =>  '{field} minimal 3 huruf.!',
                    'max_length'    =>  '{field} maximal 55 huruf.!'
                ]
            ],
            'foto_profile' => [

                    'rules'     => 'mime_in[foto_profile,image/png,image/jpg,image/jpeg]|is_image[foto_profile]',

                    'errors'    => [
                        'mime_in'   => '{field} harus berformat jpg/jpeg/png.!',
                        'is_image'  => '{field} harus berformat jpg/jpeg/png.!'
                ]
            ],
            'ktp' => [

                    'rules'     => 'mime_in[ktp,image/png,image/jpg,image/jpeg]|is_image[ktp]',

                    'errors'    => [
                        'mime_in'   => '{field} harus berformat jpg/jpeg/png.!',
                        'is_image'  => '{field} harus berformat jpg/jpeg/png.!'
                ]
            ],
            'kk' => [

                    'rules'     => 'mime_in[kk,image/png,image/jpg,image/jpeg]|is_image[kk]',

                    'errors'    => [
                        'mime_in'   => '{field} harus berformat jpg/jpeg/png.!',
                        'is_image'  => '{field} harus berformat jpg/jpeg/png.!'
                ]
            ],
            'ijazah' => [

                    'rules'     => 'mime_in[ijazah,image/png,image/jpg,image/jpeg]|is_image[ijazah]',

                    'errors'    => [
                        'mime_in'   => '{field} harus berformat jpg/jpeg/png.!',
                        'is_image'  => '{field} harus berformat jpg/jpeg/png.!'
                ]
            ],
            'transkrip' => [

                    'rules'     => 'mime_in[transkrip,image/png,image/jpg,image/jpeg]|is_image[transkrip]',

                    'errors'    => [
                        'mime_in'   => '{field} harus berformat jpg/jpeg/png.!',
                        'is_image'  => '{field} harus berformat jpg/jpeg/png.!'
                ]
            ]


        ])) {
            $validation = \Config\Services::Validation()->listErrors();
            return redirect()->to('profileKu')->withInput()->with('validation', $validation);
        }
        //foto profile
        $foto_baru = $this->request->getFile('foto_profile');
            if ($foto_baru->getError() == 4) {
                $fotoPp = $this->request->getVar('foto_lama');
            } else {
                $fotoPp = $foto_baru->getRandomName();
                $foto_baru->move('file_foto', $fotoPp);
            // unlink('img/' . $this->request->getVar('foto_lama')); -> kalo mau hapus
            }

        $data = [
            'user_name'     => $this->request->getVar('id'),
            'nama_lengkap'  => $this->request->getVar('nama_lengkap'),
            'foto'          => $fotoPp

        ];
        //save updated Profile
       $this->HomeModel->updated_profile($data);
       //foto ktp
        $fotoktp = $this->request->getFile('ktp');
            if ($fotoktp->getError() == 4) {
                $fotoKtp = 'default.jpg';
            } else {
                $fotoKtp = $fotoktp->getRandomName();
                $fotoktp->move('file_berkas', $fotoKtp);
            // unlink('img/' . $this->request->getVar('foto_lama')); -> kalo mau hapus
            }
       //foto kk
        $fotokkBaru = $this->request->getFile('kk');
            if ($fotokkBaru->getError() == 4) {
                $fotoKk = 'default.jpg';
            } else {
                $fotoKk = $fotokkBaru->getRandomName();
                $fotokkBaru->move('file_berkas', $fotoKk);
            // unlink('img/' . $this->request->getVar('foto_lama')); -> kalo mau hapus
            }
        //foto ijazah
        $fotoijazahBaru = $this->request->getFile('ijazah');
            if ($fotoijazahBaru->getError() == 4) {
                $fotoIjazah = 'default.jpg';
            } else {
                $fotoIjazah = $fotoijazahBaru->getRandomName();
                $fotoijazahBaru->move('file_berkas', $fotoIjazah);
            // unlink('img/' . $this->request->getVar('foto_lama')); -> kalo mau hapus
            }
        //foto transkrip
        $fototranskripBaru = $this->request->getFile('transkrip');
            if ($fototranskripBaru->getError() == 4) {
                $fotoTranskrip = 'default.jpg';
            } else {
                $fotoTranskrip = $fototranskripBaru->getRandomName();
                $fototranskripBaru->move('file_berkas', $fotoTranskrip);
            // unlink('img/' . $this->request->getVar('foto_lama')); -> kalo mau hapus
            }

        $data = [
            'user_name'           => $this->request->getVar('id'),
            'tempat_lahir'        => $this->request->getVar('tmp_lahir'),
            'tanggal_lahir'       => $this->request->getVar('tgl_lahir'),
            'jenis_kelamin'       => $this->request->getVar('jk'),
            'pendidikan_terakhir' => $this->request->getVar('pendidikan_terakhir'),
            'jabatan'             => $this->request->getVar('jabatan'),
            'alamat_lengkap'      => $this->request->getVar('alamat'),
            'file_ktp'            => $fotoKtp,
            'file_kk'             => $fotoKk,
            'file_ijazah'         => $fotoIjazah,
            'file_transkrip'      => $fotoTranskrip,
            'tgl_upload'          => $this->request->getVar('tgl')

        ];
        $this->HomeModel->updateBiodata($data);
       session()->setFlashdata('pesan', 'Data Berhasil diupdate. Silahkan LogOut kemudian login kembali');
        return redirect()->to('/home/profileKu');
    }
    //---------------------------------------------------------------------------------
    public function proposal()
    {
        $data = [
                    'title'     =>  "Pengajuan Proposal",
                    'session'   =>  $session = session(),
                    'validation'=> \Config\Services::Validation()
        ];
        return view('home/page/proposal/form_proposal', $data);
       
    }
    //---------------------------------------------------------------------------------
    public function saveProposal()
    {
       
       session()->setFlashdata('pesan', 'Mohon Maaf halaman sedang dalam Maintenance !');
        return redirect()->to('/home/proposal');
    }
    //---------------------------------------------------------------------------------
    public function riwayatPengajuan()
    {
        $data = [
                    'title'     =>  "Riwayat Pengajuan",
                    'session'   =>  $session = session(),
                    'validation'=> \Config\Services::Validation()
        ];
        return view('home/page/proposal/riwayatProposal', $data);
       
    }
    //---------------------------------------------------------------------------------
    public function pekerjaan()
    {
        $data = [
                    'title'     =>  "Pekerjaan Saya Hari Ini",
                    'session'   =>  $session = session(),
                    'validation'=> \Config\Services::Validation(),
                    'data'      =>  $this->HomeModel->getPekerjaan()
        ];
        return view('home/page/pekerjaan/tampilPekerjaan', $data);
       
    }
    //---------------------------------------------------------------------------------
    public function addPekerjaan()
    {
        $data = [
                    'title'     =>  "Tambah Pekerjaan",
                    'session'   =>  $session = session(),
                    'validation'=> \Config\Services::Validation()
        ];
        return view('home/page/pekerjaan/formPekerjaan', $data);
       
    }
    //---------------------------------------------------------------------------------
    public function savePekerjaan()
    {
        $data = [
            'user_name'     => $this->request->getVar('id'),
            'pekerjaan'     => $this->request->getVar('pekerjaan'),
            'tanggal'       => $this->request->getVar('tgl'),
            'jam_mulai'     => $this->request->getVar('jamMulai'),
            'jam_selesai'   => $this->request->getVar('jamBerakhir'),
            'keterangan'    => $this->request->getVar('keterangan'),
            'status'        => $this->request->getVar('status'),
            'created_at'    => $this->request->getVar('createdAt')

        ];
        $this->HomeModel->savePekerjaan($data);
        // dd($data);
       
       session()->setFlashdata('pesan', 'Oke Pekerjaan Anda Sudah Tersimpan, Terima Kasih !');
        return redirect()->to('/home/pekerjaan');
    }
    //---------------------------------------------------------------------------------
    public function updatePekerjaan($id_pekerjaan)
    {
        $data = [
                    'title'     =>  "Update Pekerjaan",
                    'session'   =>  $session = session(),
                    'validation'=> \Config\Services::Validation(),
                    'data'      =>  $this->HomeModel->getUpdatePekerjaan($id_pekerjaan)
        ];
        return view('home/page/pekerjaan/formUpdate', $data);
    }
    //---------------------------------------------------------------------------------
    public function saveUpdatePekerjaan()
    {
        $data = [
            'id_pekerjaan'  => $this->request->getVar('id'),
            'pekerjaan'     => $this->request->getVar('pekerjaan'),
            'jam_mulai'     => $this->request->getVar('jamMulai'),
            'jam_selesai'   => $this->request->getVar('jamBerakhir'),
            'keterangan'    => $this->request->getVar('keterangan'),
            'status'        => $this->request->getVar('status'),
            'updated_at'    => $this->request->getVar('updatedAt')

        ];
        $this->HomeModel->saveUpdatePekerjaan($data);
        // dd($data);
       
       session()->setFlashdata('pesan', 'Updated Data Berhasil!');
        return redirect()->to('/home/pekerjaan');
    }
    //
    //user agent
    public function userAgent (){
        $agent = $this->request->getUserAgent();

            if ($agent->isBrowser()) {
                $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
            } elseif ($agent->isRobot()) {
                $currentAgent = $agent->getRobot();
            } elseif ($agent->isMobile()) {
                $currentAgent = $agent->getMobile();
            } elseif($agent->isReferral()){
                $currentAgent = $agent->referrer();
            }else{ 
                $currentAgent = 'Unidentified User Agent';
            }

        echo $currentAgent;

        echo $agent->getAgentString(); // Platform info (Windows, Linux, Mac, etc.)
    }
    
}


