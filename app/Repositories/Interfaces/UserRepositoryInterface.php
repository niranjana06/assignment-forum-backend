<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function loginUser(array $data);
    public function logoutUser($data);
    public function authUser();

}
