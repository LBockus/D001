<?php

namespace App\Controllers;

use App\Authenticator;
use App\Exceptions\UnauthenticatedException;
use App\HtmlRender;

class AdminController
{
    private Authenticator $authenticator;

    public function __construct(Authenticator $authenticator = null)
    {
        $this->authenticator = $authenticator ?? new Authenticator();
    }

    /**
     * @throws UnauthenticatedException
     */
    public function index()
    {
        if (!$this->authenticator->isLoggedIn()) {
            throw new UnauthenticatedException();
        }

        return 'ADMIN puslapis';
//        $render = new HtmlRender($output);
//        $render->render();
    }

    /**
     * @throws UnauthenticatedException
     */
    public function login()
    {
        $userName = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if(!empty($userName) && !empty($password)) {
            $this->authenticator->login($userName, $password);
            header('Location: /admin');
        }
    }

    public function logout()
    {
        $this->authenticator->logout();
        return '';
    }
}