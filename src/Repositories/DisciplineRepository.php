<?php
/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 13.11.2016
 * Time: 20:12
 */

namespace Repositories;


class DisciplineRepository implements RepositoryInterface
{
    private $connector;

    /**
     * StudentsRepository constructor.
     * Initialize the database connection with sql server via given credentials
     * @param $connector
     */
    public function __construct($connector)
    {
        $this->connector = $connector;
    }

    public function findAll($limit = 1000, $offset = 0)
    {
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM disciplines LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $this->fetchDisciplineData($statement);
    }

    private function fetchDisciplineData($statement)
    {
        $results = [];
        while ($result = $statement->fetch()) {
            $results[] = [
                'name' => $_POST['name'],
                'departament'      => $_POST['departament'],
                'id'         => (int) $_GET['id'],
            ];
        }

        return $results;
    }

    public function insert(array $disciplineData)
    {
        $statement = $this->connector->getPdo()->prepare('INSERT INTO disciplines (name, departament) VALUES(:name, :departament)');
        $statement->bindValue(':name', $disciplineData['name']);
        $statement->bindValue(':departament', $disciplineData['departament']);

        return $statement->execute();
    }

    public function find($id)
    {
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM disciplines WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $disciplineData = $this->fetchDisciplineData($statement);

        return $disciplineData[0];

    }

    public function update(array $disciplineData)
    {
        $statement = $this->connector->getPdo()->prepare("UPDATE disciplines SET name = :name, departament = :departament WHERE id = :id");

        $statement->bindValue(':name', $disciplineData['name'], \PDO::PARAM_STR);
        $statement->bindValue(':departament', $disciplineData['departament'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $disciplineData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function remove(array $disciplineData)
    {
        $statement = $this->connector->getPdo()->prepare("DELETE FROM disciplines WHERE id = :id");

        $statement->bindValue(':id', $disciplineData['id'], \PDO::PARAM_INT);

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