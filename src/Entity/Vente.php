<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VenteRepository::class)
 */
class Vente
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomEmploye;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numEmploye;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomVente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomEmploye;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date")
     */
    private $closeAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getPrenomEmploye(): ?string
    {
        return $this->prenomEmploye;
    }

    public function setPrenomEmploye(string $prenomEmploye): self
    {
        $this->prenomEmploye = $prenomEmploye;

        return $this;
    }

    public function getNumEmploye(): ?string
    {
        return $this->numEmploye;
    }

    public function setNumEmploye(string $numEmploye): self
    {
        $this->numEmploye = $numEmploye;

        return $this;
    }

    public function getNomVente(): ?string
    {
        return $this->nomVente;
    }

    public function setNomVente(string $nomVente): self
    {
        $this->nomVente = $nomVente;

        return $this;
    }

    public function getNomEmploye(): ?string
    {
        return $this->nomEmploye;
    }

    public function setNomEmploye(string $nomEmploye): self
    {
        $this->nomEmploye = $nomEmploye;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCloseAt(): ?\DateTimeInterface
    {
        return $this->closeAt;
    }

    public function setCloseAt(\DateTimeInterface $closeAt): self
    {
        $this->closeAt = $closeAt;

        return $this;
    }

    public function getFormattedMontant(): string
    {
        return number_format($this->montant, 0, '', ' ') . ' F cfa';
    }
}
