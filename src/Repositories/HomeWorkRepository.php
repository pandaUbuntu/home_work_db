<?php
/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 13.11.2016
 * Time: 20:12
 */

namespace Repositories;


class HomeWorkRepository implements RepositoryInterface
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
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM home_works LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $this->fetchHomeWorkData($statement);
    }

    private function fetchHomeWorkData($statement)
    {
        $results = [];
        while ($result = $statement->fetch()) {
            $results[] = [
                'name' => $_POST['name'],
                'discipline'      => $_POST['discipline'],
                'result'      => $_POST['result'],
                'id'         => (int) $_GET['id'],
            ];
        }

        return $results;
    }

    public function insert(array $homeWorkData)
    {
        $statement = $this->connector->getPdo()->prepare('INSERT INTO home_works (name, discipline, result) VALUES(:name, :discipline, :result)');
        $statement->bindValue(':name', $homeWorkData['name']);
        $statement->bindValue(':discipline', $homeWorkData['discipline']);
        $statement->bindValue(':result', $homeWorkData['result']);

        return $statement->execute();
    }

    public function find($id)
    {
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM home_works WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $homeWorkData = $this->fetchHomeWorkData($statement);

        return $homeWorkData[0];

    }

    public function update(array $homeWorkData)
    {
        $statement = $this->connector->getPdo()->prepare("UPDATE home_works SET name = :name, discipline = :discipline, result = :result WHERE id = :id");

        $statement->bindValue(':name', $homeWorkData['name'], \PDO::PARAM_STR);
        $statement->bindValue(':discipline', $homeWorkData['discipline'], \PDO::PARAM_STR);
        $statement->bindValue(':result', $homeWorkData['result'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $homeWorkData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function remove(array $homeWorkData)
    {
        $statement = $this->connector->getPdo()->prepare("DELETE FROM home_works WHERE id = :id");

        $statement->bindValue(':id', $homeWorkData['id'], \PDO::PARAM_INT);

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