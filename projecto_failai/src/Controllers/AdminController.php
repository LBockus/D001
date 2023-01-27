<?php

namespace App\Controllers;

use App\Authenticator;
use App\Exceptions\UnauthenticatedException;
use App\HtmlRender;
use App\Response;
use App\Request;

class AdminController extends BaseController
{
    private Authenticator $authenticator;

    public function __construct(Authenticator $authenticator = null)
    {
        $this->authenticator = $authenticator ?? new Authenticator();
        parent::__construct();
    }

    /**
     * @throws UnauthenticatedException
     */
    public function index(): Response
    {
        if (!$this->authenticator->isLoggedIn()) {
            throw new UnauthenticatedException();
        }

        return $this->response('Admin puslapis! ' . $_SESSION['username']);
    }

    /**
     * @throws UnauthenticatedException
     */
    public function login(Request $request): Response
    {
        $userName = $request->get('username');
        $password = $request->get('password');

        if(empty($userName) && empty($password)) {
            return $this->redirect('/', ['Neteisingi prisijungimo duomenys.']);
        }
        $this->authenticator->login($userName, $password);
        return $this->redirect('/admin', ['message' => 'Sveikiname prisijungus']);
    }

    public function logout(): Response
    {
        $this->authenticator->logout();
        return $this->redirect('/', ['message' => 'Sveikiname atsijungus']);
    }
}