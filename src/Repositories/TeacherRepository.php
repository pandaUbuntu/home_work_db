<?php
/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 13.11.2016
 * Time: 20:07
 */

namespace Repositories;


class TeacherRepository implements RepositoryInterface
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
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM teachers LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $this->fetchTeacherData($statement);
    }

    private function fetchTeacherData($statement)
    {
        $results = [];
        while ($result = $statement->fetch()) {
            $results[] = [
                'first_name' => $_POST['first_name'],
                'last_name'  => $_POST['last_name'],
                'departament'      => $_POST['departament'],
                'id'         => (int) $_GET['id'],
            ];
        }

        return $results;
    }

    public function insert(array $studentData)
    {
        $statement = $this->connector->getPdo()->prepare('INSERT INTO teachers (first_name, last_name, departament) VALUES(:firstName, :lastName, :departament)');
        $statement->bindValue(':firstName', $studentData['first_name']);
        $statement->bindValue(':lastName', $studentData['last_name']);
        $statement->bindValue(':departament', $studentData['departament']);

        return $statement->execute();
    }

    public function find($id)
    {
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM teachers WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $teacherData = $this->fetchTeacherData($statement);

        return $teacherData[0];

    }

    public function update(array $teacherData)
    {
        $statement = $this->connector->getPdo()->prepare("UPDATE teachers SET first_name = :firstName, last_name = :lastName, departament = :departament WHERE id = :id");

        $statement->bindValue(':firstName', $teacherData['first_name'], \PDO::PARAM_STR);
        $statement->bindValue(':lastName', $teacherData['last_name'], \PDO::PARAM_STR);
        $statement->bindValue(':departament', $teacherData['departament'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $teacherData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function remove(array $teacherData)
    {
        $statement = $this->connector->getPdo()->prepare("DELETE FROM teachers WHERE id = :id");

        $statement->bindValue(':id', $teacherData['id'], \PDO::PARAM_INT);

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