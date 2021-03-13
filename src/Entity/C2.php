<?php

namespace App\Entity;

use App\Repository\C2Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=C2Repository::class)
 */
class C2
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $count;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uid;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $temperature;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $confidence;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reflectivity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $room_temperature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(?string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(?string $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getConfidence(): ?string
    {
        return $this->confidence;
    }

    public function setConfidence(?string $confidence): self
    {
        $this->confidence = $confidence;

        return $this;
    }

    public function getReflectivity(): ?int
    {
        return $this->reflectivity;
    }

    public function setReflectivity(?int $reflectivity): self
    {
        $this->reflectivity = $reflectivity;

        return $this;
    }

    public function getRoomTemperature(): ?string
    {
        return $this->room_temperature;
    }

    public function setRoomTemperature(?string $room_temperature): self
    {
        $this->room_temperature = $room_temperature;

        return $this;
    }
}
