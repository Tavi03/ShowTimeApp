<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Festival $festival = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Email is required')]
    #[Assert\Email(message: 'Email is not valid')]
    private string $email;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Full name is required')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Full name must be at least {{ limit }} characters long',
        maxMessage: 'Full name cannot be longer than {{ limit }} characters'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z\s\-\'\.]+$/u',
        message: 'Full name can only contain letters, spaces, hyphens, apostrophes, and dots'
    )]
    private string $fullName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFestival(): ?Festival
    {
        return $this->festival;
    }

    public function setFestival(?Festival $festival): static
    {
        $this->festival = $festival;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }
}
