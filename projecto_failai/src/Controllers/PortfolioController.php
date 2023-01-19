<?php

namespace App\Controllers;

use App\Database;
use App\Validator;
use App\FS;
use mysql_xdevapi\Exception;
use PDO;
use PDOException;
use App\Configs;


class PortfolioController
{
    public function index()
    {
//      Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/portfolio.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        return $failoTurinys;
    }

    public function store()
    {
        $vardas = $_POST['vardas'] ?? '';
        $pavarde = $_POST['pavarde'] ?? '';
        $kodas = (int)$_POST['kodas'] ?? '';

        Validator::required($vardas);
        Validator::required($pavarde);
        Validator::required($kodas);
        Validator::numeric($kodas);
        Validator::asmensKodas($kodas);

        $conf = new Configs();
        $conn = new Database($conf);

        $conn->query(
            "INSERT INTO `persons` (`first_name`, `last_name`, `code`)
                    VALUES (:vardas, :pavarde, :kodas)",
            [
                'vardas' => $vardas,
                'pavarde' => $pavarde,
                'kodas' => $kodas,
            ]
        );

        echo "New record created successfully";
    }
}
