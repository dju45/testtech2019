<?php

namespace App\Controller;

use App\Model\Entity\Addresses;
use App\Model\Entity\Contacts;
use App\Model\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/address", name="address_")
 *
 */
class AddressController extends AbstractController
{

    /**
     *
     * Affichage de la liste des adresses d'un Contact
     * @Route("/list/contact/{id}", methods={"GET"}, name="contact_list")
     * @return Response
     * @param Contacts $contact
     *
     */
    public function index(Contacts $contact): Response
    {

        $addresses = $contact->getAddresses();

        return $this->render('addresslist.html.twig', [
            'addresses' => $addresses,
            'contact' => $contact
        ]);
    }

    /**
     * Ajout d'adresse pour un contact
     * @Route("/add", methods={"GET", "POST"}, name="add")
     */
    public function add(): void
    {
        $error = false;
        $id = intval($_GET['id']);

        if (!empty($_POST)) {
            // Nettoyage
            $response = $this->sanitize($_POST);

            if ($response["response"]) {

                $idContact = $response['idContact'];
                $result = $this->Addresse->create([
                    'number'     => $response['number'],
                    'city'       => $response['city'],
                    'country'    => $response['country'],
                    'postalCode' => $response['postalCode'],
                    'street'     => $response['street'],
                    'idContact'  => $response['idContact']
                ]);

                if ($result) {
                    header("Location: /index.php?p=address.index&id=$idContact");
                } else {
                    $error = true;
                    $this->twig->render('addressadd.html.twig',
                        ["idContact" => $id,'error' => $error]);
                }
            } else {
                $error = true;
                $this->twig->render('addressadd.html.twig',
                    ["idContact" => $id,'error' => $error]);

            }
        }
        echo $this->twig->render('addressadd.html.twig',
            ["idContact" => $id,'error' => $error]);
    }

    /**
     * Modification d'une adresse d'un contact
     * @Route("/edit/{id}", methods={"GET", "POST"}, name="edit")
     * @param Addresses $addresses
     *
     */
    public function edit(Addresses $addresses)
    {
        $error = false;
        $id = intval($_GET['id']);
        if (!empty($_POST)) {
            $response = $this->sanitize($_POST);


            if ($response["response"]) {
                $addresse = $this->Addresse->findById($id);
                $result = $this->Addresse->update($id,
                    [
                        'number'     => $response['number'],
                        'city'       => $response['city'],
                        'country'    => $response['country'],
                        'postalCode' => $response['postalCode'],
                        'street'     => $response['street'],
                    ]);
                if ($result) {
                    header("Location: /index.php?p=address.index&id=$addresse->idContact");
                } else {
                    $error = true;
                    $this->twig->render('addressadd.html.twig',
                        ["idContact" => $id,'error' => $error]);

                }
            } else {

                $error = true;
                $this->twig->render('addressadd.html.twig',
                    ["idContact" => $id,'error' => $error]);

            }
        }

        $data = $this->Addresse->findById($id);
        echo $this->twig->render('addressadd.html.twig',
            [
                'data'      => $data,
                "idContact" => $data->idContact
            ]);
    }

    /**
     * Suppression d'une adresse d'un contact
     * @Route("/delete/{id}", methods={"DELETE"}, name="delete")
     * @param Addresses $addresses
     */
    public function delete(Addresses $addresses)
    {
        //@todo
    }

}
