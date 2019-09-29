<?php

namespace App\Controller;

use App\Form\AddressesType;
use App\Model\Entity\Addresses;
use App\Model\Entity\Contacts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/address", name="address_")
 *
 */
class AddressController extends AbstractController
{

    /**
     * Affichage de la liste des adresses d'un Contact
     *
     * @Route("/list/contact/{id}", methods={"GET"}, name="contact_list")
     * @return Response
     * @param Contacts $contact
     *
     */
    public function index(Contacts $contact): Response
    {
        $addresses = $contact->getAddresses();

        return $this->render('address/index.html.twig', [
            'addresses' => $addresses,
            'contact' => $contact
        ]);
    }

    /**
     * Ajout d'adresse pour un contact
     *
     * @Route("/add/contact/{id}", methods={"GET", "POST"}, name="add")
     * @param Request $request
     * @param Contacts $contact
     * @return Response
     */
    public function add(Request $request, Contacts $contact): Response
    {
        $address = new Addresses();
        $form = $this->createForm(AddressesType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $address->setContact($contact);
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute(
                'address_contact_list',
                ['id' => $contact->getId()]
            );
        }

        return $this->render('address/add.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modification d'une adresse d'un contact
     *
     * @Route("/edit/{id}", methods={"GET", "POST"}, name="edit")
     * @param Addresses $address
     * @param Request $request
     * @return Response
     *
     */
    public function edit(Addresses $address, Request $request): Response
    {
        $form = $this->createForm(AddressesType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'address_contact_list',
                ['id' => $address->getContact()->getId()]
            );
        }

        return $this->render('address/edit.html.twig', [
            'address' => $address,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Suppression d'une adresse d'un contact
     *
     * @Route("/delete/{id}", methods={"DELETE"}, name="delete")
     * @param Addresses $address
     * @param Request $request
     * @return  Response
     */
    public function delete(Addresses $address, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($address);
            $entityManager->flush();
        }

        return $this->redirectToRoute(
            'address_contact_list',
            ['id' => $address->getContact()->getId()]

        );
    }

}
