<?php

namespace App\Services;

class LoginsService extends BaseService
{

    public function autenticate($username, $password)
    {
        return $this->db->fetchAll("SELECT * FROM users WHERE username = '". strtolower($username)."'AND password = '". $password."'");
    }


}