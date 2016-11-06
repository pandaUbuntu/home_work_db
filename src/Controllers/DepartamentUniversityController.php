<?php
/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 06.11.2016
 * Time: 13:11
 */

namespace Controllers;


class DepartamentUniversityController
{
    private $repository;

    private $loader;

    private $twig;

    public function __construct($connector)
    {
        $this->repository = new DepartamentUniversityRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }

    public function indexAction()
    {
        $departamentData = $this->repository->findAll();

        return $this->twig->render('departament.html.twig', ['departament' => $departamentData]);
    }

    public function newAction()
    {
        if (isset($_POST['departament_name'])) {
            $this->repository->insert(
                [
                    'departament_name' => $_POST['departament_name'],
                ]
            );
            return $this->indexAction();
        }
        return $this->twig->render('departament_form.html.twig',
            [
                'departament_name' => '',
            ]
        );
    }

    public function editAction()
    {
        if (isset($_POST['departament_name'])) {
            $this->repository->update(
                [
                    'departament_name' => $_POST['departament_name'],
                ]
            );
            return $this->indexAction();
        }
        $departamentData = $this->repository->find((int) $_GET['id']);
        return $this->twig->render('departament_form.html.twig',
            [
                'departament_name' => $departamentData['departament_name'],
            ]
        );
    }

    public function deleteAction()
    {
        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $this->repository->remove(['id' => $id]);
            return $this->indexAction();
        }
        return $this->twig->render('departament_delete.html.twig', array('departament_id' => $_GET['id']));
    }
}