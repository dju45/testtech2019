<?php

namespace App\Components\Api;

use App\Services\PalindromeChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Api extends AbstractController
{
    /**
     * Palindrome
     * @Route("/api/palindrome", methods={"GET","POST"}, name="api_palindrome")
     */
    public function palindrome(Request $request)
    {
        $response = [];
        if (!$request->isMethod('POST')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $name = $request->get('name');
        $palindrome = new PalindromeChecker($name);

        if ($name) {
            if ($palindrome->isPalindrome()) {
                $response = ['response' => true];
            } else {
                $response = ['response' => false];
            }
        }

        return new JsonResponse($response);
    }

    /**
     * Vérification du format de l'email
     * @Route("/api/email", methods={"GET","POST"}, name="api_email")
     */
    public function email(Request $request)
    {
        $response = [];
        if (!$request->isMethod('POST')) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $email = $request->get('email');
        if ($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response = [
                    'response' => true,
                    'message' => "L'email est au bon format"
                ];
            } else {
                $response = [
                    'response' => false,
                    'message' => "Le format de l'email n'est pas correct"
                ];
            }
        }

        return new JsonResponse($response);

    }
}
