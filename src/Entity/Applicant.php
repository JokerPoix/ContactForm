<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
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
     * @Groups("applicant")
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("applicant")
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
    * @Groups("applicantRequest_details")
    * @ORM\OneToMany(targetEntity=ApplicantRequest::class, mappedBy="applicant")
     */
    private $applicantRequest;

    /**
     * @Groups("applicant") 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nonAnswered;

    public function __construct()
    {
        $this->applicantRequest = new ArrayCollection();
        $this->nonAnswered = 1;
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

    public function getNonAnswered(): ?int
    {
        return $this->nonAnswered;
    }

    public function setNonAnswered(?int $nonAnswered): self
    {
        $this->nonAnswered = $nonAnswered;

        return $this;
    }
}
