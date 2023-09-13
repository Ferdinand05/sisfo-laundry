<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;

class Admin extends BaseController
{
    protected $db, $userModel;
    protected $helper = 'auth';
    protected $config, $auth;

    public function  __construct()
    {
        $this->userModel = new UserModel();
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }


    public function index()
    {

        $dataJoin = $this->userModel->builder('users')->join('auth_groups_users', 'users.id=user_id')
            ->join('auth_groups', 'auth_groups.id=group_id')
            ->get()->getResult();



        $data = [
            'data' => $dataJoin
        ];

        return view('admin/index', $data);
    }
}
