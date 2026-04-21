<?php
 
namespace App\Controllers;

use App\Models\StudentsModel;
use App\Models\MajorsModel;

class Majors extends BaseController
{

    protected $majorsModel;

    public function __construct(){
        $this->majorsModel = new MajorsModel();
    }

    public function index(){
        $data_per_page = 10;
        if($this->request->getVar('data_per_page') != null){
            $data_per_page = (int) $this->request->getVar('data_per_page');
        }
        //dd($data_per_page);
        $majors = $this->majorsModel->getMajors(null, $data_per_page);
        //dd($majors);
        $data = [
            'title' => 'UC Admin Dashboard - Majors',
            'majors' => $majors,
            'pager' => $this->majorsModel->pager,
            'data_per_page' => $data_per_page,
        ];

        return view('majors/index', $data);
    }

    public function searchMajor(){
        $query =  $this->request->getVar('query');
        $data_per_page = $this->request->getVar('data_per_page') ? (int) $this->request->getVar('data_per_page') : 10;
        $data = [
            'status' => 'success',
            'results' => []
        ];

        try{
            $majors = $this->majorsModel->getMajors($query, $data_per_page);
            if($majors){
                $data['results'] = $majors;
            }
        } catch (\Exception $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return $this->response->setJSON($data);
    }

    public function majorForm($info = null){
        $validation = session()->getFlashdata('validation');
        $data = [
            'title' => '',
            'info' => $info,
            'validation' => $validation,
        ];

        if($info == 'add'){
            $data['title'] = 'Add Major';
        }
        else if($info == 'edit'){
            $major = $this->majorsModel->getMajorsById($this->request->getVar('id'));
            if(!$major || !$this->request->getVar('id')){
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Major not found');
            }

            $data['title'] = 'Edit Major';
            $data['major'] = $major;
            //dd($major);
        }
        else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('majors/form', $data);
    }

    public function add(){
        $validationRules = [
            'name' => 'required|is_unique[majors.name]',
        ];

        if(!$this->validate($validationRules)){
            $validation = \Config\Services::validation();
            return redirect('majors/add')->withInput()->with('validation', $validation);
            // return redirect('majors/add')->withInput()->with('validation', $this->validator);
        }
        
        $this->majorsModel->save([
            'name' => $this->request->getVar('name'),
        ]);

        session()->setFlashdata('message', 'Major successfully added!');

        return redirect('majors');
    }

    public function edit(){
        $id = $this->request->getVar('id');
        //dd($this->request->getVar());
        if(!$id){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Major not found');
        }

        $validationRules = [
            'name' => "required|is_unique[majors.name,id,{$id}]",
        ];
        if(!$this->validate($validationRules)){
            $validation = \Config\Services::validation();

            return redirect()->to('/majors/edit?id='.$id)->withInput()->with('validation', $validation);
        }

        $this->majorsModel->save([
            'id' => $id,
            'name' => $this->request->getVar('name'),
        ]);
        
        session()->setFlashdata('message', 'Major successfully updated!');

        return redirect('majors');
    }

    public function delete(){
        $id = $this->request->getVar('id');
        if(!$id){
           throw new \CodeIgniter\Exceptions\PageNotFoundException('Major not found'); 
        }

        $this->majorsModel->delete($id);
        session()->setFlashdata('message', 'Major successfully deleted!');
        return redirect('majors');
    }

}