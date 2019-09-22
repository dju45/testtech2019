<?php

namespace App\Services;

class PalindromeChecker
{
    private $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * Vérifie si une chaine de caractères est un palindrome
     * @return bool
     *
     */
    public function isPalindrome(): bool
    {
        //nettoie la chaine de caractères
        $field = str_replace(' ', '', $this->field);
        $field = strtolower($field);

        //inverse la chaine
        $reverseField = strrev($field);

        // retourne vrai si la chaine inversée vaut $field
        return $field === $reverseField;
    }

}