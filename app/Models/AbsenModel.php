<?php namespace App\Models;
use CodeIgniter\Model;

class AbsenModel extends Model
{
	protected $table 			='tb_absensi';
	protected $useTimestamps 	= true;
	protected $allowedFields	= ['id_absensi', 'user_name', 'tgl_masuk', 'jam_masuk', 'tgl_pulang', 'jam_pulang', 'keterangan'];

	//-----------------------------------------------------------
	public function get_jamMasuk($tgl_masuk = false)
	{
		if($tgl_masuk == false){
			return $this->findAll();
		}
		return $this->where(['tgl_masuk'  => $tgl_masuk])->first();
	}

}