<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booker;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ad", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ad;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention la date doit etre au bonne format")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention la date doit etre au bonne format")
     */
    private $endTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */

    public function prePersist()
    {
        if(empty($this->createAt))
        {
           $this->createAt=new \DateTime();
        }

        if(empty($this->amount))
        {
             $this->amount=$this->ad->getPrice() * $this->getDuration();
        }
    }
    public function isBookableDates()
    {
        //1 if faut connaitre les dates qui sont impossible pour annonce

        $notAvailableDays=$this->ad->notAvailableDays();
        //2 il faut comparer les dates choisies avec les dates impossible
        $bookingDays=$this->getDays();

        //transform bookingDays to array contain string

        $days=array_map(function($day){

            return $day->format('Y-m-d');
        },$bookingDays);

        //transform notAvailableDays to array contain string

        $notAvailable=array_map(function($day){

            return $day->format('Y-m-d');
        },$notAvailableDays);

        foreach ($days as $day) {
            
            if(array_search($day,$notAvailable)!==false) return false; 
        }

        return true;
    }

    public function getDays(){

        $result=range($this->startDate->getTimestamp(),
        $this->endTime->getTimestamp(),
        24*60*60);

        $days=array_map(function($days){

        return new \DateTime(date('Y-m-d',$days));
        },$result);

        return $days;
    }
   public function getDuration()
    {
       $diff= $this->endTime->diff($this->startDate);

        return  $diff->days;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
