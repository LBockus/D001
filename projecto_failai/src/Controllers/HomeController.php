<?php

namespace App\Controllers;

use App\FS;
use App\Request;
use App\Response;

class HomeController extends BaseController
{
    public function index(Request $request): Response
    {
        // Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/home.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        foreach ($request->all() as $key => $item) {
            $failoTurinys = str_replace("{\{$key}}", $item, $failoTurinys);
        }
        return new $this->response($failoTurinys);
    }
}