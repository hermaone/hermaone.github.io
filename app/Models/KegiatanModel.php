<?php namespace App\Models;
use CodeIgniter\Model;

class KegiatanModel extends Model
{
	protected $table 			='tb_prsensi_kegiatan';
	protected $useTimestamps 	= true;
	protected $allowedFields	= ['id_presensi', 'id_kegiatan', 'user_name', 'status', 'tgl_submite'];

	//-----------------------------------------------------------
	public function get_presensi($id_presensi = false)
	{
		if($id_presensi == false){
			return $this->findAll();
		}
		return $this->where(['id_presensi'  => $id_presensi])->first();
	}

}