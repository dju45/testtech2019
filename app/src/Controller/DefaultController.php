<?php

namespace App\Controller;

use App\Model\Entity\Contacts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="homepage")
     */
    public function index(): Response
    {
        $contacts = $this->getDoctrine()
            ->getRepository(Contacts::class)
            ->findBy(['id' => 1]);

        return $this->render('contact/index.html.twig',
            ['contacts' => $contacts]);
    }

    /**
     * @Route("/login", methods={"GET", "POST"}, name="login")
     */
    public function login()
    {
        $errors = false;

        if (!empty($_POST)) {

            if ($this->auth->login($_POST['login'], $_POST['password'])) {
                header('Location: index.php?p=contact.index');
            } else {
                $errors = true;
            }
        }
        echo $this->twig->render('login.html.twig', ['errors' => $errors]);
    }
}
