<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentsModel extends Model
{
    protected $table = 'students';
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllStudentsWithMajor(){
        return $this->select('students.*, majors.name as major')
        ->join('majors','majors.id = students.major_id')
        ->findAll();
    }
}