<?php

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
    private $firstName;

    /**
     * @var string $lastName
     * @Assert\NotBlank
     * @Validator\PalindromeValidator
     *
     */
    private $lastName;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

}
