<?php
/**
 * Created by PhpStorm.
 * User: Panda
 * Date: 13.11.2016
 * Time: 19:33
 */

namespace Controllers;

use Repositories\TeacherRepository;
use Views\Renderer;

class TeacherController
{
    private $repository;

    private $loader;

    private $twig;

    public function __construct($connector)
    {
        $this->repository = new TeacherRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }

    public function indexAction()
    {
        $teacherData = $this->repository->findAll();

        return $this->twig->render('teacher.html.twig', ['teacher' => $teacherData]);
    }

    public function newAction()
    {
        if (isset($_POST['first_name'])) {
            $this->repository->insert(
                [
                    'first_name' => $_POST['first_name'],
                    'last_name'  => $_POST['last_name'],
                    'departament'      => $_POST['departament'],
                ]
            );
            return $this->indexAction();
        }
        return $this->twig->render('teacher_form.html.twig',
            [
                'first_name' => '',
                'last_name' => '',
                'departament' => '',
            ]
        );
    }

    public function editAction()
    {
        if (isset($_POST['first_name'])) {
            $this->repository->update(
                [
                    'first_name' => $_POST['first_name'],
                    'last_name'  => $_POST['last_name'],
                    'departament'      => $_POST['departament'],
                    'id'         => (int) $_GET['id'],
                ]
            );
            return $this->indexAction();
        }
        $teacherData = $this->repository->find((int) $_GET['id']);
        return $this->twig->render('teacher_form.html.twig',
            [
                'first_name' => $teacherData['firstName'],
                'last_name' => $teacherData['lastName'],
                'departament' => $teacherData['departament'],
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
        return $this->twig->render('teacher_delete.html.twig', array('teacher_id' => $_GET['id']));
    }
}