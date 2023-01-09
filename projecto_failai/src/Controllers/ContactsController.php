<?php

namespace App\Controllers;

use App\FS;
use Monolog\Logger;

class ContactsController
{
    private Logger $log;
    public function __construct($log)
    {
        $this->log = $log;
    }

    public function index()
    {
        {
            // Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
            $failoSistema = new FS('../src/html/contacts.html');
            $failoTurinys = $failoSistema->getFailoTurinys();
            $this->log->warning('Atidarytas contacts puslapis');
            return $failoTurinys;
        }
    }
}