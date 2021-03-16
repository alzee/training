<?php

namespace App\Entity;

use App\Repository\TraineeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * normalizationContext={"groups"={"trainee:read"}},
 * denormalizationContext={"groups"={"trainee:write"}}
 * )
 * @ORM\Entity(repositoryClass=TraineeRepository::class)
 */
class Trainee
{
    /**
     * @ORM\Id
     * @Groups({"training:read"})
     * @ORM\GeneratedValue
     * @Groups({"trainee:read"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"training:read"})
     * @Groups({"trainee:read", "trainee:write"})
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @Groups({"training:read"})
     * @Groups({"trainee:read", "trainee:write"})
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sex;

    /**
     * @Groups({"training:read"})
     * @Groups({"trainee:read", "trainee:write"})
     * @ORM\Column(type="string", length=255)
     */
    private $pstatus;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $politics;

    /**
     * @Groups({"training:read"})
     * @Groups({"trainee:read", "trainee:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $area;

    static $allSkills = ['急救护理' => 0,'特殊装备操作' => 1, '机动车驾驶' => 2];
    static $pstatuses = ['民兵' => 0,'退役军人' => 1, '军人' => 2];
    static $allPolitics = ['群众' => 0,'党员' => 1, '团员' => 2];
    static $sexes = ['男' => 0,'女' => 1];
    static $areas = ['城关镇', '溢水镇', '官渡镇', '麻家渡镇', '宝丰镇', '擂鼓镇', '秦古镇', '得胜镇', '上庸镇', '田家坝镇', '楼台乡', '文峰乡', '潘口乡', '竹坪乡', '深河乡', '大庙乡', '双台乡', '柳林乡', '农林四场'];

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
     * @Groups({"trainee:read"})
     * @ORM\ManyToMany(targetEntity=Training::class, inversedBy="trainees")
     */
    private $training;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
