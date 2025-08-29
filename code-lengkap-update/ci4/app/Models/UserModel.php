<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'useremail', 'userpassword'];

    public function getUserByEmail($email)
    {
        return $this->where('useremail', $email)->first();
    }
}
