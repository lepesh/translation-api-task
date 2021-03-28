<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use App\Traits\IdentityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
{
    use IdentityTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * Language ISO 639-1: two-letter code
     * @ORM\Column(type="string", length=2)
     */
    private string $isoCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rtl;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsoCode(): ?string
    {
        return $this->isoCode;
    }

    public function setIsoCode(string $isoCode): self
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    public function getRtl(): ?bool
    {
        return $this->rtl;
    }

    public function setRtl(bool $rtl): self
    {
        $this->rtl = $rtl;

        return $this;
    }
}
