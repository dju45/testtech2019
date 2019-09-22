<?php

class EmailDto
{
    /**
     * @var string $email
     * @Assert\NotBlank
     * @Assert\Email(
     *   message = "L'email '{{ value }}' n'est pas valide."
     * )
     */
    private $email;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

}
