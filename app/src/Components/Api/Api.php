<?php

namespace App\Components\Api;

use App\Services\PalindromeChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Api extends AbstractController
{
    /**
     * Vérifie si le champ est un palindrome
     *
     * @Route("/api/palindrome", methods={"POST"}, name="api_palindrome")
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return JsonResponse
     */
    public function palindrome(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $response = [];
        if (!$request->isMethod('POST')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $name = $request->get('name');
        $palindrome = new PalindromeChecker($name);

        if ($name) {
            if ($palindrome->isPalindrome()) {
                $response = [
                    'response' => true,
                    'message' => "Le champ ne doit pas être un palindrome"
                ];
            } else {
                $response = [
                    'response' => false,
                    'message' => "Le champ est valide"
                ];
            }
        }

        return new JsonResponse($response);
    }

    /**
     * Vérification du format de l'email
     *
     * @Route("/api/email", methods={"POST"}, name="api_email")
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return JsonResponse
     */
    public function email(Request $request, ValidatorInterface $validator): JsonResponse
    {
        if (!$request->isMethod('POST')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $email = $request->get('email');
        $emailConstraint = new Assert\Email();
        $emailConstraint->message = "L'email n'est pas au bon format";

        $errors = $validator->validate($email, $emailConstraint);

        if (isset($errors[0])) {
            $response = [
                'response' => false,
                'message' => $errors[0]->getMessage()
            ];

        } else {
            $response = [
                'response' => true,
                'message' => "L'email est valide"
            ];
        }

        return new JsonResponse($response);
    }
}
