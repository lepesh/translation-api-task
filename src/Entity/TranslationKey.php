<?php

namespace App\Entity;

use App\Repository\TranslationKeyRepository;
use App\Traits\IdentityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TranslationKeyRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("name")
 */
class TranslationKey
{
    use IdentityTrait, TimestampableTrait;

    /**
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private ?string $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
