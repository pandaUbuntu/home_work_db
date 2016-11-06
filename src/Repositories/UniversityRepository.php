<?php
/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 06.11.2016
 * Time: 15:19
 */

namespace Repositories;


class UniversityRepository implements RepositoryInterface
{
    private $connector;


    public function __construct($connector)
    {
        $this->connector = $connector;
    }

    public function findAll($limit = 1000, $offset = 0)
    {
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM university LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $statement->execute();
        return $this->fetchUniversityData($statement);
    }

    private function fetchUniversityData($statement)
    {
        $results = [];
        while ($result = $statement->fetch()) {
            $results[] = [
                'id' => $result['id'],
                'name_university' => $result['name_university'],
                'city' => $result['city'],
                'email' => $result['email'],
            ];
        }

        return $results;
    }

    public function insert(array $universityData)
    {
        $statement = $this->connector->getPdo()->prepare('INSERT INTO students (first_name, last_name, email) VALUES(:firstName, :lastName, :email)');
        $statement->bindValue(':name_university', $universityData['name_university']);
        $statement->bindValue(':city', $universityData['city']);
        $statement->bindValue(':email', $universityData['email']);

        return $statement->execute();
    }

    public function find($id)
    {
        $statement = $this->connector->getPdo()->prepare('SELECT * FROM univercity WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $studentsData = $this->fetchUniversityData($statement);

        return $studentsData[0];

    }

    public function update(array $universityData)
    {
        $statement = $this->connector->getPdo()->prepare("UPDATE university SET name_university = :name_university, city = :city, email = :email WHERE id = :id");

        $statement->bindValue(':name_university', $universityData['name_university'], \PDO::PARAM_STR);
        $statement->bindValue(':lastName', $universityData['city'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $universityData['email'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $universityData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function remove(array $universityData)
    {
        $statement = $this->connector->getPdo()->prepare("DELETE FROM university WHERE id = :id");

        $statement->bindValue(':id', $universityData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }

    public function findBy($criteria = [])
    {
        // TODO: Implement findBy() method.
    }
}