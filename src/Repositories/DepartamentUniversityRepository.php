<?php
/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 06.11.2016
 * Time: 15:49
 */

namespace Repositories;


class DepartamentUniversityRepository implements RepositoryInterface
{
    private $connector;


    public function __construct($connector)
    {
        $this->connector = $connector;
    }

    public function findAll($limit = 1000, $offset = 0)
    {
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM departament LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $this->fetchDepartamentData($statement);
    }

    private function fetchDepartamentData($statement)
    {
        $results = [];
        while ($result = $statement->fetch()) {
            $results[] = [
                'id' => $result['id'],
                'departament_name' => $result['departament_name'],
            ];
        }

        return $results;
    }

    public function insert(array $departamentData)
    {
        $statement = $this->connector->getPdo()->prepare('INSERT INTO departament (departament_name) VALUES(:departamentName)');
        $statement->bindValue(':departamentName', $departamentData['departament_name']);

        return $statement->execute();
    }

    public function find($id)
    {
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM departament WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $departamentData = $this->fetchDepartamentData($statement);

        return $departamentData[0];

    }

    public function update(array $departamentData)
    {
        $statement = $this->connector->getPdo()->prepare("UPDATE departament SET departament_name = :departamentName WHERE id = :id");

        $statement->bindValue(':departamentName', $departamentData['departament_name'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function remove(array $departamentData)
    {
        $statement = $this->connector->getPdo()->prepare("DELETE FROM departament WHERE id = :id");

        $statement->bindValue(':id', $departamentData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }


    /**
     * Search all entity data in the DB like $criteria rules
     * @param array $criteria
     * @return mixed
     */
    public function findBy($criteria = [])
    {
        // TODO: Implement findBy() method.
    }
}