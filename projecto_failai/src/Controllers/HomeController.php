<?php

namespace App\Controllers;

use App\FS;

class HomeController
{
    public function index()
    {
        $fileSystem = new FS('../src/html/home.html');
        $fileContent = $fileSystem->getFileContent();
        return $fileContent;
    }
}