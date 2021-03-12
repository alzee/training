<?php

namespace App\Entity;

use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"training:read"}},
 * denormalizationContext={"groups"={"training:write"}}
 * )
 * @ORM\Entity(repositoryClass=TrainingRepository::class)
 */
class Training
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"trainee:read"})
     * @Groups({"training:read"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"trainee:read"})
     * @Groups({"training:read", "training:write"})
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @Groups({"trainee:read"})
     * @Groups({"training:read", "training:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Trainer::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $trainer;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @Groups({"training:read", "training:write"})
     * @ORM\ManyToMany(targetEntity=Trainee::class, mappedBy="training")
     */
    private $trainees;

    /**
     * @Groups({"training:read", "training:write"})
     * @ORM\OneToMany(targetEntity=Checkin::class, mappedBy="training")
     */
    private $checkins;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @Groups({"trainee:read"})
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @Groups({"trainee:read"})
     * @Groups({"training:read", "training:write"})
     * @ORM\Column(type="string", length=15)
     */
    private $instructor;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTrainer(): ?Trainer
    {
        return $this->trainer;
    }

    public function setTrainer(?Trainer $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function __construct()
    {
        $this->date = new \DateTimeImmutable();
        $this->date = $this->date->setTimezone(new \DateTimeZone('Asia/Shanghai'));
        $this->trainees = new ArrayCollection();
        $this->checkins = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title;
    }

    /**
     * @return Collection|Trainee[]
     */
    public function getTrainees(): Collection
    {
        return $this->trainees;
    }

    public function addTrainee(Trainee $trainee): self
    {
        if (!$this->trainees->contains($trainee)) {
            $this->trainees[] = $trainee;
            $trainee->addTraining($this);
        }

        return $this;
    }

    public function removeTrainee(Trainee $trainee): self
    {
        if ($this->trainees->removeElement($trainee)) {
            $trainee->removeTraining($this);
        }

        return $this;
    }

    /**
     * @return Collection|Checkin[]
     */
    public function getCheckins(): Collection
    {
        return $this->checkins;
    }

    public function addCheckin(Checkin $checkin): self
    {
        if (!$this->checkins->contains($checkin)) {
            $this->checkins[] = $checkin;
            $checkin->setTraining($this);
        }

        return $this;
    }

    public function removeCheckin(Checkin $checkin): self
    {
        if ($this->checkins->removeElement($checkin)) {
            // set the owning side to null (unless already changed)
            if ($checkin->getTraining() === $this) {
                $checkin->setTraining(null);
            }
        }

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getInstructor(): ?string
    {
        return $this->instructor;
    }

    public function setInstructor(string $instructor): self
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getStatus0(): ?string
    {
        $s = null;
        $d = new \Datetime();

        if ($d < $this->startAt){
            $s = '计划中';
        }
        else if ($d < $this->endAt) {
            $s = '进行中';
        }
        else 
            $s = '已结束';

        return $s;
    }
}
