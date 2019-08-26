<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * 
     * 
     * 
     * // Generate Value = Auto Increment
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min=15)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Positive( message = "T'as pas compris ?! On te demande de pas mettre n'importe quoi")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     * ^$ permet de dire que la chaine commence strictement par et se termine strictement par. ->entre a et z minuscule, 0 et 9 , - autorisé 
     * @Assert\Regex("/^[a-z0-9\-]+$/")
     */ 

    private $slug;


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
