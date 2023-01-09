<?php

namespace App\Controllers;

use App\FS;

class HomeController
{
    public function index()
    {
        // Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/home.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        foreach ($_REQUEST as $key => $item) {
            $failoTurinys = str_replace("{{$key}}", $item, $failoTurinys);
        }
        return $failoTurinys;
    }
}