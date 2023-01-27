<?php

namespace App\Controllers;

use App\Database;
use App\HtmlRender;
use App\Managers\PersonsManager;
use App\Response;
use App\Validator;
use App\FS;
use mysql_xdevapi\Exception;
use PDO;
use PDOException;
use App\Configs;
use App\Request;


class PersonController extends BaseController
{
    public const TITLE = 'Asmenys';

    public function __construct(protected PersonsManager $manager)
    {
        parent::__construct();
    }

    public function list(Request $request): Response
    {

// TODO: Perkelti Filtravima
//
//        $kiekis = $request->get('amount', 10);
//        $orderBy = $request->get('orderby', 'id');
//
//        $searchQuery = '';
//        $params = [];
//        $search = $request->get('search');
//        if ($search) {
//            $searchQuery = "WHERE first_name LIKE :search OR last_name LIKE :search OR code LIKE :search";
//            $params['search'] = '%' . $search . '%';
//        }

        $asmenys = $this->manager->getAll();

        $rez = $this->generatePersonsTable($asmenys);

        $failoSistema = new FS('../src/html/person/list.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        $failoTurinys = str_replace("{{body}}", $rez ?? '', $failoTurinys);

        return $this->response($failoTurinys);
    }

    public function new(): Response
    {
//      Nuskaitomas HTML failas ir siunciam jo teksta i Output klase
        $failoSistema = new FS('../src/html/person/new.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        return $this->response($failoTurinys);
    }

    public function store(Request $request): Response
    {
        Validator::required($request->get('vardas'));
        Validator::required($request->get('pavarde'));
        Validator::required((int)$request->get('kodas'));
        Validator::numeric((int)$request->get('kodas'));
        Validator::asmensKodas((int)$request->get('kodas'));

        $this->manager->storeOne($request);

        return $this->redirect('/persons', "New record created successfully");
    }

    public function delete(Request $request): Response
    {
        $kuris = $request->get('id');
        Validator::required($kuris);
        Validator::numeric($kuris);
        Validator::min($kuris, 1);

        $this->manager->deleteOne($kuris);

        return $this->redirect('/persons', "Record deleted successfully");
    }

    public function edit(Request $request): Response
    {
        $failoSistema = new FS('../src/html/person/edit.html');
        $failoTurinys = $failoSistema->getFailoTurinys();

        $person = $this->manager->getOne((int)$request->get('id'));

        foreach ($person as $key => $item) {
            $failoTurinys = str_replace("{{" . $key . "}}", $item ?? '', $failoTurinys);
        }

        return $this->response($failoTurinys);
    }

    public function update(Request $request): Response
    {
        Validator::required($request->get('vardas'));
        Validator::required($request->get('pavarde'));
        Validator::required($request->get('kodas'));
        Validator::numeric($request->get('kodas'));
        Validator::asmensKodas($request->get('kodas'));

        $this->manager->edit($request);

        return $this->redirect('/person/show?id=' . $request->get('id'), ['message' => "Record updated successfully"]);
    }

    public function show(Request $request): Response
    {
        $failoSistema = new FS('../src/html/person/show.html');
        $failoTurinys = $failoSistema->getFailoTurinys();

        $person = $this->manager->getOne($request->get('id'));

        foreach ($person as $key => $item) {
            $failoTurinys = str_replace("{{" . $key . "}}", $item ?? '', $failoTurinys);
        }

        return $this->response($failoTurinys);
    }

    public function filter(): Response
    {
        $failoSistema = new FS('../src/html/person/filter.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        return $this->response($failoTurinys);
    }

    public function filteredList(Request $request): Response
    {
        $asmenys = $this->manager->filter($request);

        $rez = $this->generatePersonsTable($asmenys);

        $failoSistema = new FS('../src/html/person/list.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        $failoTurinys = str_replace("{{body}}", $rez ?? '', $failoTurinys);

        return $this->response($failoTurinys);
    }

    /**
     * @param mixed $asmuo
     * @return string
     */
    protected function generatePersonRow(array $asmuo): string
    {
        $failoSistema = new FS('../src/html/person/person_row.html');
        $failoTurinys = $failoSistema->getFailoTurinys();
        foreach ($asmuo as $key => $item) {
            $failoTurinys = str_replace("{{" . $key . "}}", $item ?? '', $failoTurinys);
        }

        return $failoTurinys;
    }

    /**
     * @param array $asmenys
     * @return string
     */
    protected function generatePersonsTable(array $asmenys): string
    {
        $rez = '<table class="highlight striped">
            <tr>
                <th>ID</th>
                <th>Vardas</th>
                <th>Pavarde</th>
                <th>Emailas</th>
                <th>Asmens kodas</th>
                <th><a href="/persons?orderby=phone">TEl</a></th>
                <th>Addr.ID</th>
                <th>Veiksmai</th>
            </tr>';
        foreach ($asmenys as $asmuo) {
            $rez .= $this->generatePersonRow($asmuo);
        }
        $rez .= '</table>';
        return $rez;
    }
}
