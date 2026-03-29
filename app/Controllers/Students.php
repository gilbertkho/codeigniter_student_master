<?php
 
namespace App\Controllers;

use App\Models\StudentsModel;
use App\Models\MajorsModel;

class Students extends BaseController
{
    protected $studentsModel;
    protected $majorsModel;

    public function __construct(){
        $this->studentsModel = new StudentsModel();
        $this->majorsModel = new MajorsModel();
    }
    
    public function index(){
        // $students = [];
        //return view('students/index', ['students' => $students]);

        // $db = \Config\Database::connect();
        // $students = $db->query('SELECT * FROM students')->getResultArray();
        // dd($students);
        $students = $this->studentsModel->getStudents();

        $data = [
            'title' => 'UC Admin Dashboard - Students',
            'students' => $students,
            'pager' => $this->studentsModel->pager
        ];

        //dd($data['pager']->getDetails()['pageCount']);
        return view ('students/index', $data);

        // echo view('layout/header' , $data);
        // echo view('students/index', $data);
        // echo view('layout/footer');
    }
    
    public function studentForm($info = null){
        $majors = $this->majorsModel->getAllMajors();
        $validation = session()->getFlashdata('validation');
        $data = [
            'title' => '',
            'info' => $info,
            'majors' => $majors,
            'validation' => $validation
        ];

        if($info == 'add'){
            $data['title'] = 'Add Student';
        }
        else if($info == 'edit'){
            $student = $this->studentsModel->getStudents($this->request->getVar('id'));
            if(!$student || !$this->request->getVar('id')){
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
            }

            $data['title'] = 'Edit Student';
            $data['student'] = $student;
        }
        else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }


        return view('students/form', $data);
    }

    public function getLatestCounter(){
        $data = [
            'status' => 'success',
            'counter' => ''
        ];

        $code =  $this->request->getPost('code');
        

        try{
            $counter = $this->studentsModel->generateCounter($code);
            if($counter){
                $data['counter'] = $counter;
            }
        }
        catch(\Throwable $e){
            $data['status'] = 'error';
            $data['error'] = $e->getMessage();
        }

        return $this->response->setJSON($data);
    }

    public function add(){
        if(!$this->validate([
            'name' => 'required',
            'email' => 'required|is_unique[students.email]|valid_email',
            'enrollment_year' => 'required',
            'major_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'The major field is required' 
                ]
            ],
            'student_id' => [
                'rules' => 'required|is_unique[students.student_id]',
                'errors' => [
                    'required' => 'The student id field is required',
                    'is_unique' => 'The student id must be unique'  
                ]
            ]
        ])){
            $validation = \Config\Services::validation();
            $data = [
                "validation" => $validation,
                "info" => 'add',
                "title" => 'Add Student'
            ];
            //return view('students/form', $data);
            return redirect()->to('/students/add')->withInput()->with('validation', $validation);
        }
        
        $is_active = $this->request->getVar('is_active') ? 1 : 0;

        $this->studentsModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'enrollment_year' => $this->request->getVar('enrollment_year'),
            'major_id' => $this->request->getVar('major_id'),
            'student_id' => $this->request->getVar('student_id'),
            'is_active' => $is_active,
        ]);

        session()->setFlashdata('message', 'Data Successfully Created!');

        return redirect()->to('/students');        
    }

    public function edit(){
        $id = $this->request->getVar('id');
        if(!$id){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }
        if(!$this->validate([
            'name' => "required",
            'email' => "required|is_unique[students.email,id,{$id}]|valid_email",
            'enrollment_year' => "required",
            'major_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'The major field is required' 
                ]
            ],
            'student_id' => "required|is_unique[students.student_id,id,{$id}]",
        ])){
            $validation = \Config\Services::validation();
            $data = [
                "validation" => $validation,
                "info" => 'edit',
                "title" => 'Edit Student'
            ];
            //return view('students/form', $data);
            return redirect()->to('/students/edit?id='.$id)->withInput()->with('validation', $validation);
        }
        
        $is_active = $this->request->getVar('is_active') ? 1 : 0;

        $this->studentsModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'enrollment_year' => $this->request->getVar('enrollment_year'),
            'major_id' => $this->request->getVar('major_id'),
            'student_id' => $this->request->getVar('student_id'),
            'is_active' => $is_active,
        ]);

        session()->setFlashdata('message', 'Data Successfully Updated!');
    
        return redirect()->to('/students');        
    }

    public function delete(){
        $id = $this->request->getVar('id');        
        if(!$id){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found');
        }

        $this->studentsModel->delete($id);

        session()->setFlashData('message', 'Data Successfully Deleted!');

        return redirect()->to('/students');
    }

    public function searchStudent(){
        $query = $this->request->getVar('query');
        $data = [
            'status' => 'success',
            'results' => []
        ];
        //echo $query;
        try{
            $getData = $this->studentsModel->search($query);
            if($getData){
                $data['results'] = $getData;
            }
        }
        catch(\Throwable $e){
            $data['status'] = 'error';
            $data['error'] = $e->getMessage();
        }

        //dd($data);        
        return $this->response->setJSON($data);
    }
}