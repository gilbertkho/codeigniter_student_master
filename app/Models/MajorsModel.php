<?php

namespace App\Models;

use CodeIgniter\Model;

class MajorsModel extends Model
{
    protected $table = 'majors';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';


    public function getMajorsById($id){
        return $this->select('majors.id, majors.name')
        ->where('majors.id', $id)
        ->first();
    }

    public function getMajors($query = null, $data_per_page = 10){
        $result = '';
        if($query == null){
            $result = $this->select('majors.id, majors.name');
        }
        else{
            $result = $this->select('majors.*')
            ->like('majors.name', $query)
            ->orLike('majors.id', $query);
        }
        //dd('TESSS');
        if($data_per_page == 0){
            return $result->findAll();
        }
        else{
            return $result->paginate($data_per_page);
        }
        return false;
    }
}