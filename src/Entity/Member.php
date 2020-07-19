<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 * @UniqueEntity(
 * fields={"email", "pseudo"},
 * message="l'email indiquée est déjà utilisé"
 * )
 * @UniqueEntity("pseudo")
 */
class Member implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="3", max="8", minMessage="Le mot de passe doit faire entre 3 et 8")
     */
    private $pass;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()\Unique
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAT;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;
    /**
     * @Assert\EqualTo(propertyPath="pass", message="Alors ça troll ?")
     */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): self
    {
        $this->pass = $pass;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAT(): ?\DateTimeInterface
    {
        return $this->createdAT;
    }

    public function setCreatedAT(\DateTimeInterface $createdAT): self
    {
        $this->createdAT = $createdAT;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function eraseCredentials(){

    }
    public function getSalt() {}

    public function getRoles() {
        return ['ROLE_MEMBER'];
    }

    public function getPassword(){

    }
    public function getUsername(){}

}
