<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ApplicantRequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicantRequestRepository::class)
 */
class ApplicantRequest
{
    /**
     * @ORM\Id
     * @Groups("applicantRequest")
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("applicant")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Groups("applicant")
     * @ORM\Column(type="string", length=1000)
     */
    private $question;

    /**
     * @Groups("applicant")
     * @ORM\Column(type="boolean")
     */
    private $answered;

    /**
     * @Groups("applicant")
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $additionnalInformations;

    /**
     * @Groups("applicant")
     * @ORM\ManyToOne(targetEntity=Applicant::class, inversedBy="applicantRequest",cascade={"persist"})
     */
    private $applicant;

    /**
     * @Groups("applicant")
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @Groups("applicant")
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    /**
     * @Groups("applicant")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswered(): ?bool
    {
        return $this->answered;
    }

    public function setAnswered(bool $answered): self
    {
        $this->answered = $answered;

        return $this;
    }

    public function getAdditionnalInformations(): ?string
    {
        return $this->additionnalInformations;
    }

    public function setAdditionnalInformations(?string $additionnalInformations): self
    {
        $this->additionnalInformations = $additionnalInformations;

        return $this;
    }

    public function getApplicant(): ?Applicant
    {
        return $this->applicant;
    }

    public function setApplicant(?Applicant $applicant): self
    {
        $this->applicant = $applicant;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
