<?php

namespace App\Controllers;

use App\FS;

class AdminController
{
    public function index()
    {
        $fileSystem = new FS('../src/html/dashboard.html');
        $fileContent = $fileSystem->getFileContent();
        return $fileContent;
    }
}