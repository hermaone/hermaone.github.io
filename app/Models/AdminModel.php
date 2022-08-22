<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
	protected $useTimestamps 	= true;
	protected $database, $db;
	public function __construct()
	{
		$this->database  	= \Config\Database::connect();
	}


	//---------------------------------------------------------------------------------------
	public function save_users($data)
	{
		$query = $this->db = $this->database->table('tb_users');
		$this->db->insert($data);
	}
	//---------------------------------------------------------------------------------
	// MASTER USERS
	public function get_karyawan()
	{
		$this->db = $this->database->table('tb_users');
		$this->db->select('*');
		$query = $this->db->get();
		return $query->getResultArray();
	}
	// GET DAFTAR GAJI
	public function getKaryawan($data)
	{
		// $this->db = $this->database->table('tb_users');
		// $this->db->select('tb_users.*, tb_gaji.*');
		// $this->db->join('tb_gaji', 'tb_users.id_gaji = tb_gaji.id_gaji');
		// $this->db->where('tb_users.user_name',$data['user_name']);
		// $this->db->where('tb_gaji.id_gaji','4');
		// $query = $this->db->get();
		// return $query->getResultArray();


		$this->db = $this->database->table('tb_users');
		$this->db->select('*');
		$this->db->where('user_name', $data['user_name']);
		$query = $this->db->get();
		return $query->getResultArray();
	}

	public function jmlHadir($data)
	{
		$this->db = $this->database->table('tb_absensi');
		$this->db->select('*');
		$this->db->where('user_name', $data['user_name']);
		$query = $this->db->countAllResults();
		return $query;
	}

	//---------------------------------------------------------------------------------
	// MASTER USERS
	public function update_users($user_id)
	{
		$this->db = $this->database->table('tb_users');
		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//---------------------------------------------------------------------------------
	// MASTER USERS
	public function save_update_users($user_id)
	{
		$this->db = $this->database->table('tb_users');
		$this->db->where('user_id', $user_id['user_id']);
		$this->db->update($user_id);
	}
	//------------------------------------------------------------------------------------------
	public function deleteUsers($user_id)
	{
		$this->db = $this->database->table('tb_users');
		$this->db->where('user_id', $user_id);
		$this->db->delete();
	}
	//------------------------------------------------------------------------------------------
	public function get_jam()
	{
		$this->db = $this->database->table('tb_waktu');
		$this->db->select('*');
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//------------------------------------------------------------------------------------------
	public function get_update_jam($id_waktu)
	{
		$this->db = $this->database->table('tb_waktu');
		$this->db->select('*');
		$this->db->where('id_waktu', $id_waktu);
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//---------------------------------------------------------------------------------------
	public function save_update_jam($data)
	{
		$this->db = $this->database->table('tb_waktu');
		$this->db->where('id_waktu', $data['id_waktu']);
		$this->db->update($data);
	}
	//------------------------------------------------------------------------------------------
	public function get_absen()
	{
		$this->db = $this->database->table('tb_users');
		$this->db->select('nama_lengkap, tb_absensi.*');
		$this->db->join('tb_absensi', 'tb_absensi.user_name = tb_users.user_name');
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//---------------------------------------------------------------------------------------
	public function saveBiodata($data)
	{
		$query = $this->db = $this->database->table('tb_biodata');
		$this->db->insert($data);
	}
	//---------------------------------------------------------------------------------
	
	public function get_kegiatan()
	{
		$this->db = $this->database->table('tb_kegiatan');
		$this->db->select('*');
		$this->db->orderby('id_kegiatan', 'DESC');
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//---------------------------------------------------------------------------------------
	public function saveKegiatan($data)
	{
		$query = $this->db = $this->database->table('tb_kegiatan');
		$this->db->insert($data);
	}
	//---------------------------------------------------------------------------------------
	public function update_kegiatan($id_kegiatan)
	{
		$this->db = $this->database->table('tb_kegiatan');
		$this->db->select('*');
		$this->db->where('id_kegiatan', $id_kegiatan);
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//---------------------------------------------------------------------------------------
	public function save_update_kegiatan($data)
	{
		$this->db = $this->database->table('tb_kegiatan');
		$this->db->where('id_kegiatan', $data['id_kegiatan']);
		$this->db->update($data);
	}
	//------------------------------------------------------------------------------------------
	public function deleteKegiatan($id_kegiatan)
	{
		$this->db = $this->database->table('tb_kegiatan');
		$this->db->where('id_kegiatan', $id_kegiatan);
		$this->db->delete();
	}
	//---------------------------------------------------------------------------------------
	public function addPresensiKegiatan($data)
	{
		$query = $this->db = $this->database->table('tb_prsensi_kegiatan');
		$this->db->insert($data);
	}
	//------------------------------------------------------------------------------------------
	public function GetKegiatanForm($a)
	{
		$this->db = $this->database->table('tb_kegiatan');
		$this->db->select('*');
		$this->db->where('id_kegiatan', $a);
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//---------------------------------------------------------------------------------------
	public function savePresensiKegiatan($data)
	{
		$query = $this->db = $this->database->table('tb_prsensi_kegiatan');
		$this->db->insert($data);
	}
	//---------------------------------------------------------------------------------------
	public function get_presensiKegiatan($data)
	{
		$this->db = $this->database->table('tb_prsensi_kegiatan');
		$this->db->select('nama_lengkap, foto, tb_prsensi_kegiatan.user_name, status, tgl_submite, tb_kegiatan.nama_kegiatan');
		$this->db->join('tb_users', 'tb_users.user_name = tb_prsensi_kegiatan.user_name');
		$this->db->join('tb_kegiatan', 'tb_kegiatan.id_kegiatan = tb_prsensi_kegiatan.id_kegiatan');
		$this->db->where('tb_prsensi_kegiatan.id_kegiatan',$data['id_kegiatan']);
		$query = $this->db->get();
		return $query->getResultArray();
	}
	// SAVE GAJI
	//---------------------------------------------------------------------------------------
	public function saveGaji($data)
	{
		$query = $this->db = $this->database->table('tb_gaji');
		$this->db->insert($data);
	}
	// MENAMPILKAN GAJI
	//---------------------------------------------------------------------------------------
	public function getGaji($data = null)
	{
		if($data != null){

			$this->db = $this->database->table('tb_users');
			$this->db->select('tb_users.*, tb_gaji.*');
			$this->db->join('tb_gaji', 'tb_users.id_gaji = tb_gaji.id_gaji');
			$this->db->where('tb_users.user_name',$data['user_name']);
			//$this->db->where('tb_gaji.id_gaji','1');
			$query = $this->db->get();
			return $query->getResultArray();	
		}else{
			
			$this->db = $this->database->table('tb_gaji');
			$this->db->select('*');
			$this->db->orderby('id_gaji', 'ASC');
			$query = $this->db->get();
			return $query->getResultArray();

		}	

		

	}
	//GET UPDATE GAJI
	//---------------------------------------------------------------------------------------
	public function updateGaji($id_gaji)
	{
		$this->db = $this->database->table('tb_gaji');
		$this->db->select('*');
		$this->db->where('id_gaji', $id_gaji);
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//save update gaji
	//---------------------------------------------------------------------------------------
	public function saveUpdateGaji($data)
	{
		$this->db = $this->database->table('tb_gaji');
		$this->db->where('id_gaji', $data['id_gaji']);
		$this->db->update($data);
	}
	//DELETE GAJI
	//------------------------------------------------------------------------------------------
	public function deleteGaji($id_gaji)
	{
		$this->db = $this->database->table('tb_gaji');
		$this->db->where('id_gaji', $id_gaji);
		$this->db->delete();
	}








	// MASTER USERS
	public function get_users()
	{
		$this->db = $this->database->table('users');
		$this->db->select('users.id as userid, fullname, email,no_wa, name, username,user_img');
		$this->db->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
		$this->db->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//--------------------------------------------------------------------------------------------
	public function profile_users()
	{
		$this->db = $this->database->table('users');
		$this->db->select('users.id as userid, fullname, email,no_wa, name, username,user_img, created_at as tgl_registrasi');
		$this->db->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
		$this->db->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		$this->db->where('users.id', user()->id);
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//----------------------------------------------------------------------------------------
	public function get_update_users($userid)
	{
		$this->db = $this->database->table('users');
		$this->db->select('users.id as userid, fullname, email,no_wa, name, username, user_img,auth_groups.id as id_group');
		$this->db->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
		$this->db->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		$this->db->where('users.id', $userid);
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//----------------------------------------------------------------------------------------
	public function get_role()
	{
		$this->db = $this->database->table('auth_groups');
		$this->db->select('*');
		$this->db->orderby('id', 'ASC');
		$query = $this->db->get();
		return $query->getResultArray();
	}
	//------------------------------------------------------------------------------------------
	public function updated_users($users)
	{
		$this->db = $this->database->table('users');
		$this->db->where('users.id', $users['id']);
		$this->db->update($users);
	}
	//------------------------------------------------------------------------------------------
	public function updated_users_role($users)
	{
		$this->db = $this->database->table('auth_groups_users');
		$this->db->where('user_id', $users['user_id']);
		$this->db->update($users);
	}
	//------------------------------------------------------------------------------------------
	public function delete_users($userid)
	{
		$this->db = $this->database->table('users');
		$this->db->where('users.id', $userid);
		$this->db->delete();
	}
	
	

}