<?php

namespace App\Entity;

use App\Repository\TranslationKeyRepository;
use App\Traits\IdentityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TranslationKeyRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class TranslationKey
{
    use IdentityTrait, TimestampableTrait;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
