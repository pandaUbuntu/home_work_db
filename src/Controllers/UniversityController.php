<?php

namespace Controllers;

use Views\Renderer;

class UniversityController
{
    private $repository;

    private $loader;

    private $twig;

    public function __construct($connector)
    {
        $this->repository = new UniversityRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }

    public function indexAction()
    {
        $universityData = $this->repository->findAll();

        return $this->twig->render('university.html.twig', ['university' => $universityData]);
    }

    public function newAction()
    {
        if (isset($_POST['name_university'])) {
            $this->repository->insert(
                [
                    'name_university' => $_POST['name_university'],
                    'city'  => $_POST['city'],
                    'email'      => $_POST['email'],
                ]
            );
            return $this->indexAction();
        }
        return $this->twig->render('university_form.html.twig',
            [
                'name_university' => '',
                'city' => '',
                'email' => '',
            ]
        );
    }

    public function editAction()
    {
        if (isset($_POST['name_university'])) {
            $this->repository->update(
                [
                    'name_university' => $_POST['name_university'],
                    'city'  => $_POST['city'],
                    'email'      => $_POST['email'],
                    'id'         => (int) $_GET['id'],
                ]
            );
            return $this->indexAction();
        }
        $universityData = $this->repository->find((int) $_GET['id']);
        return $this->twig->render('university_form.html.twig',
            [
                'name_university' => $universityData['name_university'],
                'city' => $universityData['city'],
                'email' => $universityData['email'],
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
        return $this->twig->render('university_delete.html.twig', array('university_id' => $_GET['id']));
    }
}