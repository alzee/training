<?php

namespace App\Entity;

use App\Repository\TraineeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TraineeRepository::class)
 */
class Trainee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pstatus;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $politics;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=18, nullable=true)
     */
    private $idnum;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $skills = [];

    /**
     * @ORM\ManyToMany(targetEntity=Training::class, inversedBy="trainees")
     */
    private $training;

    public function __construct()
    {
        $this->training = new ArrayCollection();
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getPstatus(): ?string
    {
        return $this->pstatus;
    }

    public function setPstatus(string $pstatus): self
    {
        $this->pstatus = $pstatus;

        return $this;
    }

    public function getPolitics(): ?string
    {
        return $this->politics;
    }

    public function setPolitics(string $politics): self
    {
        $this->politics = $politics;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(?string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIdnum(): ?string
    {
        return $this->idnum;
    }

    public function setIdnum(string $idnum): self
    {
        $this->idnum = $idnum;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getSkills(): ?array
    {
        return $this->skills;
    }

    public function setSkills(?array $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTraining(): Collection
    {
        return $this->training;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->training->contains($training)) {
            $this->training[] = $training;
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        $this->training->removeElement($training);

        return $this;
    }
}
