<?php
/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 13.11.2016
 * Time: 20:00
 */

namespace Controllers;
use Repositories\HomeWorkRepository;
use Views\Renderer;

class HomeWorkController
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
        $workData = $this->repository->findAll();

        return $this->twig->render('home_work.html.twig', ['work' => $workData]);
    }

    public function newAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->insert(
                [
                    'name' => $_POST['name'],
                    'discipline' => $_POST['discipline'],
                    'result'      => $_POST['result'],
                ]
            );
            return $this->indexAction();
        }
        return $this->twig->render('home_work_form.html.twig',
            [
                'name' => '',
                'discipline' => '',
                'result' => '',
            ]
        );
    }

    public function editAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->update(
                [
                    'name' => $_POST['name'],
                    'discipline'      => $_POST['discipline'],
                    'result'         => (int) $_GET['result'],
                ]
            );
            return $this->indexAction();
        }
        $disciplineData = $this->repository->find((int) $_GET['id']);
        return $this->twig->render('home_work_form.html.twig',
            [
                'name' => $disciplineData['name'],
                'discipline' => $disciplineData['discipline'],
                'result' => $disciplineData['result'],
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
        return $this->twig->render('home_work_delete.html.twig', array('home_work_id' => $_GET['id']));
    }
}