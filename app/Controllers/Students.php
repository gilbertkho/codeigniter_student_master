<?php
 
namespace App\Controllers;

use App\Models\StudentsModel;

class Students extends BaseController
{
    protected $studentsModel;

    public function __construct(){
        $this->studentsModel = new StudentsModel();
    }
    
    public function index(){
        // $students = [];
        //return view('students/index', ['students' => $students]);

        // $db = \Config\Database::connect();
        // $students = $db->query('SELECT * FROM students')->getResultArray();
        // dd($students);
        $students = $this->studentsModel->getAllStudentsWithMajor();

        $data = [
            'title' => 'UC Students Portal',
            'students' => $students,
        ];

        return view ('students/index', $data);

        // echo view('layout/header' , $data);
        // echo view('students/index', $data);
        // echo view('layout/footer');
    }
    
    public function studentForm($info = null){
        $data = [
            'title' => '',
            'info' => $info,
        ];
        if($info == 'add'){
            $data['title'] = 'Add Student';
            $data['info'] = 'add';
            // return view('students/form', ['info' => 'add']);
        }
        else if($info == 'edit'){        
            if(!isset($_GET['id'])) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            //search student else page not found
            $students = config('myConfig')->students;
            $student_id = $_GET['id'];

            $student = array_filter($students, function($s) use ($student_id){
                return $s['student_id'] == $student_id;
            });

            $data['title'] = 'Edit Student';
            $data['info'] = 'edit';
            $data['student'] = $student ? array_values($student)[0] : null;
        }
        else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }


        return view('students/form', $data);
    }
}