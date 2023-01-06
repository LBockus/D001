<?php

namespace App;

use Exception;

class Authenticator
{
    /**
     * @throws Exception
     */
    public function authenticate(string|null $userName, string|null $password) : bool
    {
        if(!empty($userName) && !empty($password) && !$this->login($userName, $password))
        {
            throw new Exception();
        }
        return ($this->isLoggedIn() || !empty($userName) && !empty($password) && $this->login($userName, $password));
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['logged']) && $_SESSION['logged'] === true;
    }

    public function login(string $userName, string $password): bool
    {
        return ($userName === 'admin' && $password === 'admin');
    }
}