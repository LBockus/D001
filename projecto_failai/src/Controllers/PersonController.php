<?php

namespace App\Controllers;

use App\Database;
use App\Validator;
use App\FS;
use mysql_xdevapi\Exception;
use PDO;
use PDOException;
use App\Configs;


class PersonController
{
    public function index()
    {
        $config = new Configs();
        $db = new Database($config);

        $kiekis = $_GET['amount'] ?? 10;

        $asmenys = $db->query('SELECT * FROM persons ORDER BY id DESC LIMIT ' . $kiekis);

        $rez = '<table>
            <tr>
                <th>ID</th>
                <th>Vardas</th>
                <th>Pavarde</th>
                <th>Emailas</th>
                <th>Asmens kodas</th>
                <th>TEl</th>
                <th>Addr.ID</th>
                <th>Veiksmai</th>
            </tr>';
        foreach ($asmenys as $asmuo) {
            $rez .= '<tr>';
            $rez .= '<td>' . $asmuo['id'] . '</td>';
            $rez .= '<td>' . $asmuo['first_name'] . '</td>';
            $rez .= '<td>' . $asmuo['last_name'] . '</td>';
            $rez .= '<td>' . $asmuo['email'] . '</td>';
            $rez .= '<td>' . $asmuo['code'] . '</td>';
            $rez .= '<td>' . $asmuo['phone'] . '</td>';
            $rez .= '<td>' . $asmuo['address_id'] . '</td>';
            $rez .= "<td><a href='/person/edit?id={$asmuo['id']}'>Redaguoti</a></td>";
            $rez .= "<td><a href='/person/delete?id={$asmuo['id']}'>Šalinti</a></td>";
            $rez .= '</tr>';
        }
        $rez .= '</table>';

        $failoSistema = new FS('../src/html/persons.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        $failoTurinys = str_replace("{{body}}", $rez, $failoTurinys);

        return $failoTurinys;

    }

    public function new()
    {
//      Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/new_person.html');
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

        return $this->index();
    }

    public function delete()
    {
        $kuris = (int)$_GET['id'] ?? null;

        Validator::required($kuris);
        Validator::numeric($kuris);
        Validator::min($kuris, 1);

        $conf = new Configs();
        $db = new Database($conf);

        $db->query("DELETE FROM `persons` WHERE `id` = :id", ['id' => $kuris]);

        return $this->index();
    }

    public function edit()
    {
        $conf = new Configs();
        $db = new Database($conf);
        $kuris = (int)$_GET['id'] ?? null;
        Validator::required($kuris);
        Validator::numeric($kuris);
        Validator::min($kuris, 1);
        $asmuo = $db->query("SELECT * FROM `persons` WHERE `id` = :id", ['id' => $kuris]);

        $failoSistema = new FS('../src/html/update_person.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        $failoTurinys = str_replace("{{id}}", $kuris, $failoTurinys);
        $failoTurinys = str_replace("{{name}}", $asmuo[0]['first_name'], $failoTurinys);
        $failoTurinys = str_replace("{{surname}}", $asmuo[0]['last_name'], $failoTurinys);
        $failoTurinys = str_replace("{{email}}", $asmuo[0]['email'], $failoTurinys);
        $failoTurinys = str_replace("{{code}}", $asmuo[0]['code'], $failoTurinys);
        $failoTurinys = str_replace("{{phone}}", $asmuo[0]['phone'], $failoTurinys);
        $failoTurinys = str_replace("{{address}}", $asmuo[0]['address_id'], $failoTurinys);
        return $failoTurinys;
    }

    public function update()
    {
        $kuris = (int)$_POST['id'] ?? null;
        $vardas = $_POST['vardas'] ?? '';
        $pavarde = $_POST['pavarde'] ?? '';
        $email = $_POST['email'] ?? '';
        $kodas = (int)$_POST['kodas'] ?? '';
        $phone = $_POST['telefonas'] ?? '';
        $address_id = (int)$_POST['address_id'] ?? '';

        Validator::required($vardas);
        Validator::required($pavarde);
        Validator::required($kodas);
        Validator::numeric($kodas);
        Validator::asmensKodas($kodas);
        Validator::numeric($address_id);

        Validator::required($kuris);
        Validator::numeric($kuris);
        Validator::min($kuris, 1);

        $conf = new Configs();
        $db = new Database($conf);
        $db->query("UPDATE `persons` 
        SET `first_name` = :vardas, `last_name` = :pavarde, `email` = :email, `code` = :kodas, `phone` = :phone, `address_id` = :address_id
        WHERE `id` = :id",
            ['vardas' => $vardas, 'pavarde' => $pavarde, 'kodas' => $kodas, 'phone' => $phone,
                'address_id' => $address_id,'email'=>$email, 'id' => $kuris]);
        return $this->index();
    }
}
