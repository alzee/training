<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbsenceRepository::class)
 */
class Absence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $leaveAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $backAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Trainee::class, inversedBy="absences")
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $approved;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLeaveAt(): ?\DateTimeInterface
    {
        return $this->leaveAt;
    }

    public function setLeaveAt(?\DateTimeInterface $leaveAt): self
    {
        $this->leaveAt = $leaveAt;

        return $this;
    }

    public function getBackAt(): ?\DateTimeInterface
    {
        return $this->backAt;
    }

    public function setBackAt(?\DateTimeInterface $backAt): self
    {
        $this->backAt = $backAt;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getName(): ?Trainee
    {
        return $this->name;
    }

    public function setName(?Trainee $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(?bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }
}
