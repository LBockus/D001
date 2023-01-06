<?php

namespace App\Controllers;

use App\FS;

class PortfolioController
{
    public function index()
    {
        $fileSystem = new FS('../src/html/portfolio.html');
        $fileContent = $fileSystem->getFileContent();
        return $fileContent;
    }
}