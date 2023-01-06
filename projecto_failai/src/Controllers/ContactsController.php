<?php

namespace App\Controllers;

use App\FS;

class ContactsController
{
    public function index()
    {
        $fileSystem = new FS('../src/html/contacts.html');
        $fileContent = $fileSystem->getFileContent();
        return $fileContent;
    }
}