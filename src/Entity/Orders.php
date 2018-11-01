<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 */
class Orders
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
    private $numberOfTickets;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bookingCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tickets", mappedBy="orders")
     */
    private $Tickets;

    public function __construct()
    {
        $this->Tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberOfTickets(): ?int
    {
        return $this->numberOfTickets;
    }

    public function setNumberOfTickets(int $numberOfTickets): self
    {
        $this->numberOfTickets = $numberOfTickets;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBookingCode(): ?string
    {
        return $this->bookingCode;
    }

    public function setBookingCode(string $bookingCode): self
    {
        $this->bookingCode = $bookingCode;

        return $this;
    }

    /**
     * @return Collection|Tickets[]
     */
    public function getTickets(): Collection
    {
        return $this->Tickets;
    }

    public function addTicket(Tickets $ticket): self
    {
        if (!$this->Tickets->contains($ticket)) {
            $this->Tickets[] = $ticket;
            $ticket->setOrders($this);
        }

        return $this;
    }

    public function removeTicket(Tickets $ticket): self
    {
        if ($this->Tickets->contains($ticket)) {
            $this->Tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getOrders() === $this) {
                $ticket->setOrders(null);
            }
        }

        return $this;
    }
}
