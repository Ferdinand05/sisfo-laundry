<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelGroups;
use Myth\Auth\Models\UserModel;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Authorization\GroupModel;
use \Myth\Auth\Config\Auth as AuthConfig;
use \Myth\Auth\AuthTrait;
use \Myth\Auth\Authorization;

class Admin extends BaseController
{
    protected $db, $userModel;
    protected $authorize, $auth;

    public function  __construct()
    {
        $this->authorize = service('authorization');
        $this->auth = service('authentication');
        $this->userModel = new UserModel();
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

    public function edit($id)
    {
    }

    public function delete($userid)
    {
    }
}
