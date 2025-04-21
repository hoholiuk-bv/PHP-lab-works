<?php

namespace App\Entity;

use App\Repository\ReturnBookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReturnBookRepository::class)]
class ReturnBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: Loan::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Loan $loan;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $returnDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoan(): Loan
    {
        return $this->loan;
    }

    public function setLoan(Loan $loan): self
    {
        $this->loan = $loan;
        return $this;
    }

    public function getReturnDate(): \DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;
        return $this;
    }
}
