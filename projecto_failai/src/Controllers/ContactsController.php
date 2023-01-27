<?php

namespace App\Controllers;

use App\FS;
use App\Response;
use Monolog\Logger;

class ContactsController extends BaseController
{
    private Logger $log;

    public function __construct($log)
    {
        $this->log = $log;
        parent::__construct();
    }

    public function index(): Response
    {
        {
            // Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
            $failoSistema = new FS('../src/html/contacts.html');
            $failoTurinys = $failoSistema->getFailoTurinys();
            $this->log->info('Kontaktai atidaryti');

            return $this->response($failoTurinys);
        }
    }
}