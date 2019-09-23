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
     * @Route("/list", name="list")
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id' => 1]);

        $contacts = $user->getContacts();

        return $this->render('contact/index.html.twig',
            ['contacts' => $contacts]);
    }

    /**
     * Ajout d'un contact
     * @Route("/add", methods={"GET", "POST"}, name="add")
     */
    public function add(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['id' => 1]);

        $contact = new Contacts();
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setUser($user);
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/add.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification d'un contact
     * @param Contacts $contacts
     * @Route("/edit/{id}", methods={"GET", "POST"}, name="edit")
     */
    public function edit(Request $request, Contacts $contact): Response
    {
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Suppression d'un contact
     * @Route("/delete/{id}", methods={"delete"}, name="delete")
     * @param Contacts $contacts
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

        return $this->redirectToRoute('contact_list');
    }
}
