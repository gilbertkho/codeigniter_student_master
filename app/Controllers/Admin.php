<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Admin extends BaseController
{
    protected $adminModel;

    public function __construct(){
        $this->adminModel = new AdminModel();
    }
     public function index()
    {
        $validation = session()->getFlashData('validation');
        $data = [
            'validation' => $validation,
        ];
        return view('login', $data);
    }

    public function setUserMethod($user){
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'is_active' => $user['is_active'],
            'is_logged_in' => true,
        ];

        session()->set($data);
    }


    public function logout(){
        session()->destroy();
        return redirect()->to('login');
    }

    public function login(){
        $email = $this->request->getVar('email');
        $pass = $this->request->getVar('password');
        if(!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ])){
            $validation = \Config\Services::validation();
            return redirect()->to('login')->withInput()->with('validation', $validation);
        }

        $checkEmail = $this->adminModel->getAdmin($email);
        //dd($checkEmail);
        if(!$checkEmail || $checkEmail['admin_count'] < 1){
            session()->setFlashdata('message', 'User not found!');
            return redirect()->to('login');
        }
        else{
            $check = $this->adminModel->getAdmin($email, $pass);
            //dd($check);
            $this->setUserMethod($check);
            return redirect()->to('/students');
        }
        //login logic
        
    }

    public function registerForm(){
        $validation = session()->getFlashdata('validation');
        $data = [
            'validation' => $validation,
        ];
        return view('register', $data);
    }

    public function registerUser(){
        if(!$this->validate([
            'name' => 'required',
            'email' => 'required|valid_email|is_unique[admin.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Confirm Password is required.',
                        'matches' => 'Confirm Password must match the Password field.'
                    ]
            ]
        ])){
            $validation = \Config\Services::validation();
            $data = [
                "validation" => $validation,
            ];
            // return view('register', $data);
            return redirect()->to('register')->withInput()->with('validation', $validation);
        }

        $this->adminModel->save([
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
        ]);

        session()->setFlashdata('message', 'User successfully registered! Please wait for admin approval or contact the administrator.');

        return redirect()->to('login');
    }

    public function profile(){
        $data = [
            'title' => 'Admin Profile',
        ];
        return view('admin/profile', $data);
    }
}