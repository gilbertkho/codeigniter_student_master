<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentsModel extends Model
{
    protected $table = 'students';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'name', 'student_id', 'email', 'major_id', 'gpa', 'enrollment_year', 'is_active'
    ];

    public function getStudents($id = '', $data_per_page = 10){
        if($id == ''){
            return $this->select('students.*, majors.name as major')
            ->join('majors','majors.id = students.major_id', 'left')
            ->orderBy('students.updated_at', 'DESC')
            ->paginate($data_per_page);
        }
        else{
            return $this->select('students.*, majors.name as major')
            ->join('majors','majors.id = students.major_id', 'left')
            ->where('students.id', $id)
            ->first();
        }
    }

    public function search($query, $data_per_page = 10){
        return $this->select('students.*, majors.name as major')
        ->join('majors', 'majors.id =  students.major_id', 'left')
        ->groupStart()
            ->like('students.name', $query)
            ->orLike('majors.name', $query)
            ->orLike('students.student_id', $query)
            ->orLike('students.email', $query)
            ->orLike('students.enrollment_year', $query)
        ->groupEnd()
        ->orderBy('students.updated_at', 'DESC')
        ->findAll();
        // ->paginate($data_per_page);
    }

    public function generateCounter($code){
        $result = $this->select('MAX(RIGHT(students.student_id, 4)) as max', false)
        ->like('students.student_id', $code, 'after')
        ->first();

        $currentMax = $result ? (int) $result['max'] : 0;

        $newCounter = $currentMax + 1;

        return str_pad($newCounter, 4, '0', STR_PAD_LEFT);
    }
}