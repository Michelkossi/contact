<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartementRepository")
 */
class Departement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $namedep;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emaildep;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="idepartement")
     */
    private $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamedep(): ?string
    {
        return $this->namedep;
    }

    public function setNamedep(string $namedep): self
    {
        $this->namedep = $namedep;

        return $this;
    }

    public function getEmaildep(): ?string
    {
        return $this->emaildep;
    }

    public function setEmaildep(string $emaildep): self
    {
        $this->emaildep = $emaildep;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setIdepartement($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getIdepartement() === $this) {
                $contact->setIdepartement(null);
            }
        }

        return $this;
    }
}
