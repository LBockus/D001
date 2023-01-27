<?php

namespace App\Managers;

use App\Database;
use App\Request;

class PersonsManager
{
    public function __construct(protected Database $db)
    {
    }

    public function getAll(): array
    {
        return $this->db->query('SELECT p.*, concat(c.title, \' - \', a.city, \' - \', a.street, \' - \', a.postcode) address
                    FROM persons p
                        LEFT JOIN addresses a on p.address_id = a.id 
                        LEFT JOIN countries c on a.country_iso = c.iso');

// TODO: Velesniam Filtravimui
//
//                        ' . $searchQuery . '
//                        ORDER BY ' . $orderBy . ' DESC LIMIT ' . $kiekis,
//            $params);
    }

    public function getOne(int $id): array
    {
        return $this->db->query('SELECT p.*, concat(c.title, \' - \', a.city, \' - \', a.street, \' - \', a.postcode) address
                    FROM persons p
                        LEFT JOIN addresses a on p.address_id = a.id 
                        LEFT JOIN countries c on a.country_iso = c.iso
                    WHERE p.id = :id',
            ['id' => $id])[0];
    }

    public function storeOne(Request $request): void
    {
        $this->db->query(
            "INSERT INTO `persons` (`first_name`, `last_name`, `code`)
                    VALUES (:vardas, :pavarde, :kodas)",
            $request->all()
        );
    }

    public function deleteOne(int $id): void
    {
        $this->db->query("DELETE FROM `persons` WHERE `id` = :id", ['id' => $id]);
    }

    public function edit(Request $request): void
    {
        $this->db->query(
            "UPDATE `persons` 
                    SET `first_name` = :vardas, 
                        `last_name` = :pavarde, 
                        `code` = :kodas, 
                        `email` = :email,          
                        `phone` = :telefonas, 
                        `address_id` = :address_id 
                    WHERE `id` = :id",
            $request->all()
        );
    }

    public function filter(Request $request): array
    {
        $filter = $request->get('filter');
        $filterKey = $request->get('filter_key');

        $sql = "SELECT p.*, concat(c.title, ' - ', a.city, ' - ', a.street, ' - ', a.postcode) address
                    FROM persons p
                        LEFT JOIN addresses a on p.address_id = a.id 
                        LEFT JOIN countries c on a.country_iso = c.iso
        WHERE $filterKey LIKE $filter";
        dd($this->db->query($sql, [$filterKey, $filter]));
    }
}