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

}