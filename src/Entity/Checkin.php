<?php

namespace App\Entity;

use App\Repository\CheckinRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"checkin:read"}},
 * denormalizationContext={"groups"={"checkin:write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"trainee.id": "exact", "training.id": "exact"})
 * @ORM\Entity(repositoryClass=CheckinRepository::class)
 */
class Checkin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"checkin:read", "checkin:write"})
     * @ORM\ManyToOne(targetEntity=Trainee::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $trainee;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @Groups({"checkin:read", "checkin:write"})
     * @ORM\ManyToOne(targetEntity=Training::class, inversedBy="checkins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $training;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainee(): ?Trainee
    {
        return $this->trainee;
    }

    public function setTrainee(?Trainee $trainee): self
    {
        $this->trainee = $trainee;

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

    public function __construct()
    {
        $this->date = new \DateTimeImmutable();
        $this->date = $this->date->setTimezone(new \DateTimeZone('Asia/Shanghai'));
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }
}
