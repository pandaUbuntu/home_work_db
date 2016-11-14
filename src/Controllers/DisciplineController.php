<?php
/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 13.11.2016
 * Time: 19:52
 */

namespace Controllers;
use Repositories\DisciplineRepository;
use Views\Renderer;

class DisciplineController
{
    private $repository;

    private $loader;

    private $twig;

    public function __construct($connector)
    {
        $this->repository = new DisciplineRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }

    public function indexAction()
    {
        $disciplineData = $this->repository->findAll();

        return $this->twig->render('discipline.html.twig', ['discipline' => $disciplineData]);
    }

    public function newAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->insert(
                [
                    'name' => $_POST['name'],
                    'departament'      => $_POST['departament'],
                ]
            );
            return $this->indexAction();
        }
        return $this->twig->render('discipline_form.html.twig',
            [
                'name' => '',
                'departament' => '',
            ]
        );
    }

    public function editAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->update(
                [
                    'name' => $_POST['name'],
                    'departament'      => $_POST['departament'],
                    'id'         => (int) $_GET['id'],
                ]
            );
            return $this->indexAction();
        }
        $disciplineData = $this->repository->find((int) $_GET['id']);
        return $this->twig->render('discipline_form.html.twig',
            [
                'name' => $disciplineData['name'],
                'departament' => $disciplineData['departament'],
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
        return $this->twig->render('discipline_delete.html.twig', array('discipline_id' => $_GET['id']));
    }
}