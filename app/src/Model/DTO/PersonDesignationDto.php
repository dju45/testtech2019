<?php

namespace App\Model\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator;


class PersonDesignationDto
{
    /**
     * @var string $firstName
     * @Assert\NotBlank
     * @Validator\PalindromeValidator
     *
     */
    private $field;

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField(string $field): void
    {
        $this->field = $field;
    }

}
