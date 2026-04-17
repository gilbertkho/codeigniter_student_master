<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'name', 'email', 'password', 'is_active'
    ];

    public function getAdmin($email = '', $password = ''){
        if($email != '' && $password != ''){
            return $this->select('admin.*')
            ->where('admin.email',$email)
            ->where('admin.password', $password)
            //->where('admin.is_active', 1)
            ->first();
        }
        else if($email != ''){
            return $this->select('count(admin.id) as admin_count')
            ->where('admin.email', $email)
            //->where('admin.is_active', 1)
            ->first();
        }
        return false;
    }

    public function getAdminById($id){
        return $this->select('admin.*')
        ->where('admin.id', $id)
        //->where('admin.is_active', 1)
        ->first();
    }
}