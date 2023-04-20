<?php

namespace App\Entity;

use App\Repository\KillersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KillersRepository::class)]
class Killers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $weapon = null;

    #[ORM\Column(nullable: true)]
    private ?int $kills = null;

    #[ORM\Column(nullable: true)]
    private ?int $votes = null;

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

    public function getWeapon(): ?string
    {
        return $this->weapon;
    }

    public function setWeapon(string $weapon): self
    {
        $this->weapon = $weapon;

        return $this;
    }

    public function getKills(): ?int
    {
        return $this->kills;
    }

    public function setKills(?int $kills): self
    {
        $this->kills = $kills;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(?int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }
}
