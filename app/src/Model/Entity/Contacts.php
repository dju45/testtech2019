<?php

namespace App\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\ContactsRepository")
 * @ORM\Table(indexes={@ORM\Index(name="search_idx", columns={"last_name", "first_name", "email"})})
 *
 * @ORM\HasLifecycleCallbacks()
 *
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="port",
 *     message="Cet email est dejà utilisé."
 * )
 *
 */
class Contacts implements SanitizeInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank
     *
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Entity\Addresses", mappedBy="contact")
     * @Assert\NotBlank
     */
    private $addresses;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\User", inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Contacts constructor.
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Contacts
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Contacts
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Contacts
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Addresses $address
     * @return Contacts
     */
    public function addAddress(Addresses $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setContact($this);
        }

        return $this;
    }

    /**
     * @param Addresses $address
     * @return Contacts
     */
    public function removeAddress(Addresses $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getContact() === $this) {
                $address->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Contacts
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * Cette fonction se déclenche avant l'enregistrement
     * de la création ou de la mise a jour d'un contact.
     *
     * @see SanitizeInterface
     */
    public function sanitizeFields(): void
    {
        $this->firstName = ucfirst($this->firstName);
        $this->lastName = ucfirst($this->lastName);
        $this->email = strtolower($this->email);

    }

}
