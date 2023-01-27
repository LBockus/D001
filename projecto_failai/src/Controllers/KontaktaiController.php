<?php

namespace App\Controllers;

use App\Response;

class KontaktaiController extends BaseController
{
    public function index(): Response
    {
        return $this->render('kontaktai');
    }
}