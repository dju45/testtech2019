<?php

namespace App\Controller;

use App\Form\ContactsType;
use App\Model\Entity\Contacts;
use App\Model\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="contact_")
 *
 */
class ContactController extends AbstractController
{

    /**
     * Affichage de la liste des contacts de l'utilisateur connecté
     * @Route("/list/{user}", name="list")
     * @param User $user
     * @return Response
     */
    public function index(User $user): Response
    {
        $contacts = $user->getContacts();

        return $this->render('contact/index.html.twig',
            ['contacts' => $contacts]);
    }

    /**
     * Ajout d'un contact
     *
     * @Route("/add/{user}", methods={"GET", "POST"}, name="add")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function add(Request $request, User $user): Response
    {
        $contact = new Contacts();
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setUser($user);
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contact_list', [
                'user' => $user->getId()
            ]);
        }

        return $this->render('contact/add.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification d'un contact
     *
     * @Route("/edit/{id}", methods={"GET", "POST"}, name="edit")
     * @param Contacts $contact
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request, Contacts $contact): Response
    {
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_list', [
                'user' => $contact->getUser()->getId()
            ]);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Suppression d'un contact
     *
     * @Route("/delete/{id}", methods={"delete"}, name="delete")
     * @param Contacts $contact
     * @param Request $request
     * @return Response
     */
    public function delete(Contacts $contact, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $addresses = $contact->getAddresses();

            if ($addresses) {
                foreach ($addresses as $address) {
                    $contact->removeAddress($address);
                    $entityManager->remove($address);
                }
            }

            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_list', [
            'user' => $contact->getUser()->getId()
        ]);
    }
}
