<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

// API
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiFilter;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 * @ApiResource(
 * attributes={
 * "order"={"createdAT":"DESC"},

 * },
 * paginationItemsPerPage=10,
 * normalizationContext={"groups"={"read:comment", "read:full:comment"}},
 * collectionOperations={
 * "get",
 * "post"={
 * "security"="is_granted('IS_AUTHENTICATED_FULLY')",
 * "controller"=App\Controller\ChatController::class}
 * },
 * itemOperations={"get"}
 * )
 * @ApiFilter(SearchFilter::class, 
 * properties={"user": "exact"}
 * )
 */
class Chat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read:comment"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:comment"})
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:comment"})
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:comment"})
     */
    private $createdAT;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chats",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:full:comment"})
     */
    private $user;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
