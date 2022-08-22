<?php namespace App\Models;
use CodeIgniter\Model;

class HomeModel extends Model
{
	protected $useTimestamps 	= true;
	protected $database, $db;
	public function __construct(){
		$this->database  	= \Config\Database::connect();
	}

	// MASTER USERS
	public function save_masuk($data)
	{
		$query = $this->db = $this->database->table('tb_absensi');
		$this->db->insert($data);
		
	}
	public function save_plg($data)
	{
		$this->db = $this->database->table('tb_absensi');
		$this->db->where('user_id', $data['user_id']);
		$this->db->update($data);
		
	}
	
	// jam masuk
	public function chek_jam_masuk()
	{
		$this->db = $this->database->table('tb_waktu');
		$this->db->select('jam_masuk');
		$this->db->where('id_waktu', '1');
		$query = $this->db->get();
		return $query->getResultArray();
	}

	// chek absen
	public function chekAbsen()
	{
		date_default_timezone_set("Asia/Bangkok");
        $tanggalMasuk = date('d-M-Y');

		$this->db = $this->database->table('tb_absensi');
		$this->db->select('user_name, tb_absensi.tgl_masuk as t_masuk');
		$this->db->where('user_name', session('user_name'));
		$this->db->where('tgl_masuk', $tanggalMasuk);
		$query = $this->db->get();
		return $query->getResultArray();
	}
	
	// jam pulang
	public function jam_plg()
	{
		$this->db = $this->database->table('tb_waktu');
		$this->db->select('jam_pulang');
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//------------------------------------------------------------------------------------------
	public function riwayatAbsensi()
	{
		$this->db = $this->database->table('tb_users');
		$this->db->select('nama_lengkap, tb_absensi.*');
		$this->db->join('tb_absensi', 'tb_absensi.user_name = tb_users.user_name');
		$this->db->where('tb_absensi.user_name', session('user_name'));
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//-------------------------------------------------------------------------------------------
	//udpated profile
	public function updated_profile($data)
	{
		$this->db = $this->database->table('tb_users');
		$this->db->where('user_name', $data['user_name']);
		$this->db->update($data);
		
	}
	//------------------------------------------------------------------------------------------
	public function updateBiodata($data)
	{
		$this->db = $this->database->table('tb_biodata');
		$this->db->where('user_name', $data['user_name']);
		$this->db->update($data);
		
	}
	//------------------------------------------------------------------------------------------
	public function getBiodata()
	{
		$this->db = $this->database->table('tb_users');
		$this->db->select('nama_lengkap, foto, tb_biodata.*');
		$this->db->join('tb_biodata', 'tb_biodata.user_name = tb_users.user_name');
		$this->db->where('tb_biodata.user_name', session('user_name'));
		$query = $this->db->get();
		return $query->getResultArray();
	}
	// SAVE PEKERJAAN
	public function savePekerjaan($data)
	{
		$query = $this->db = $this->database->table('tb_pekerjaan');
		$this->db->insert($data);
		
	}
	
	//------------------------------------------------------------------------------------------
	public function getPekerjaan()
	{
		$this->db = $this->database->table('tb_pekerjaan');
		$this->db->select('*');
		$this->db->where('user_name', session('user_name'));
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//udpated pekerjaan
	public function getUpdatePekerjaan($id_pekerjaan)
	{
		$this->db = $this->database->table('tb_pekerjaan');
		$this->db->select('*');
		$this->db->where('id_pekerjaan',$id_pekerjaan);
		$query = $this->db->get();
		return $query->getResultArray();
		
	}
	//save udpated pekerjaan
	public function saveUpdatePekerjaan($data)
	{
		$this->db = $this->database->table('tb_pekerjaan');
		$this->db->where('id_pekerjaan', $data['id_pekerjaan']);
		$this->db->update($data);
		
	}

	

}