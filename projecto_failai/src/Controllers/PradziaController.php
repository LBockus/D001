<?php

namespace App\Controllers;

use App\Response;
use App\Request;

class PradziaController extends BaseController
{
    public function index(Request $request): Response
    {
        return $this->render('pradzia', $request->all());
    }
}