<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    /**
     * @param string $token
     * @return bool
     */
    public function isValid(string $token)
    {
        return $this->getToken() === $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return sha1($this->secret . date('H'));
    }
}
