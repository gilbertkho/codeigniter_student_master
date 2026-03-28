<?php

namespace App\Models;

use CodeIgniter\Model;

class MajorsModel extends Model
{
    protected $table = 'majors';
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function getAllMajors(){
        return $this->select('majors.id, majors.name')
        ->findAll();
    }
}