<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model{
    protected $table = 'tb_users';
    protected $allowedFields = ['user_name','nama_lengkap','user_email','user_password','foto','user_created_at'];
}