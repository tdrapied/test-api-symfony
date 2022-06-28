<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['post:collection:get']]
        ],
        'post'
    ],
    itemOperations: [
        'get',
        'patch',
        'delete',
    ],
    denormalizationContext: [
        "groups" => ["post:write"]
    ],
    normalizationContext: [
        "groups" => ["post:read"]
    ]
)]
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['post:read', 'post:collection:get'])]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['post:read', 'post:collection:get', 'post:write'])]
    public string $title;

    #[ORM\Column(type: 'text')]
    #[Groups(['post:read', 'post:write'])]
    public string $content;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['post:read', 'post:collection:get'])]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['post:read', 'post:collection:get'])]
    public \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }
}
