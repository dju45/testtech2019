<?php

namespace App\Services;

class PalindromeChecker
{
    private $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    public function isPalindrome(): bool
    {
        //nettoie la chaine de caractères
        $field = str_replace(' ', '', $this->field);
        $field = strtolower($field);

        //reverse the string
        $reverseField = strrev($field);

        return $field === $reverseField;
    }

}