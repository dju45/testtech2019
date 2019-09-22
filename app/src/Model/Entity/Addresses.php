<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressesRepository")
 */
class Addresses
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=4)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 1,
     *     max = 4,
     *     minMessage = "Votre numéro doit contenir au moins {{ limit }} chiffre",
     *     maxMessage = "Votre numéro ne doit pas dépasser {{ limit }} chiffres"
     * )
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $street;

    /**
     * @ORM\Column(type="integer", length=6)
     * @Assert\NotBlank
     * @Assert\Length(
     *     min = 1,
     *     max = 6,
     *     minMessage = "Votre code postal doit contenir au moins {{ limit }} chiffre",
     *     maxMessage = "Votre code postal ne doit pas dépasser {{ limit }} chiffres"
     * )
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\Contacts", inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Addresses
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return Addresses
     */
    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    /**
     * @param int $postalCode
     * @return Addresses
     */
    public function setPostalCode(int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Addresses
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Addresses
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Contacts|null
     */
    public function getContact(): ?Contacts
    {
        return $this->contact;
    }

    /**
     * @param Contacts|null $contact
     * @return Addresses
     */
    public function setContact(?Contacts $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

}
