<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{
    
    private $id;

    
    private $oldPassword;

     /**
     * @Assert\Length(
     *      min = 10,     
     *      minMessage = "Votre password doit faire au moins 10 caractéres"    
     * )
     */
    private $newPassword;

    /**
     * @Assert\EqualTo(
     *     propertyPath="newPassword",
     *     message="Vous n'avez pas correctement confirmé votre mot de passe"
     * )
     */
    private $confirmPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
