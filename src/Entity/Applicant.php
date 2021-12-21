<?php

namespace App\Entity;

use App\Repository\ApplicantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicantRepository::class)
 */
class Applicant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\OneToMany(targetEntity=ApplicantRequest::class, mappedBy="applicant")
     */
    private $applicantRequest;

    public function __construct()
    {
        $this->applicantRequest = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection|ApplicantRequest[]
     */
    public function getApplicantRequest(): Collection
    {
        return $this->applicantRequest;
    }

    public function addApplicantRequest(ApplicantRequest $applicantRequest): self
    {
        if (!$this->applicantRequest->contains($applicantRequest)) {
            $this->applicantRequest[] = $applicantRequest;
            $applicantRequest->setApplicant($this);
        }

        return $this;
    }

    public function removeRequest(ApplicantRequest $applicantRequest): self
    {
        if ($this->applicantRequest->removeElement($applicantRequest)) {
            // set the owning side to null (unless already changed)
            if ($applicantRequest->getApplicant() === $this) {
                $applicantRequest->setApplicant(null);
            }
        }

        return $this;
    }
}
