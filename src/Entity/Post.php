<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['post:collection:get', 'category:read']],
        ],
        'post',
    ],
    itemOperations: [
        'get',
        'patch',
        'delete',
    ],
    denormalizationContext: [
        'groups' => ['post:write'],
    ],
    normalizationContext: [
        'groups' => ['post:read', 'category:read'],
    ],
    order: ['createdAt' => 'DESC'],
)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'ipartial', 'category' => 'exact'])]
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id, ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank, Assert\Length(min: 6, max: 50), Groups(['post:read', 'post:collection:get', 'post:write'])]
    public string $title;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank, Groups(['post:read', 'post:write'])]
    public string $content;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['post:read', 'post:collection:get'])]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['post:read', 'post:collection:get'])]
    public \DateTimeImmutable $updatedAt;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['post:read', 'post:collection:get', 'post:write'])]
    public Category $category;

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
