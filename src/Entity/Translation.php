<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use App\Traits\IdentityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass=TranslationRepository::class)
 * @ORM\Table(uniqueConstraints={
 *     @UniqueConstraint(name="translation_uniq", columns={"translation_key_id", "language_id"})
 * })
 */
class Translation
{
    use IdentityTrait, TimestampableTrait;

    /**
     * @ORM\ManyToOne(targetEntity=TranslationKey::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $translationKey;

    /**
     * @ORM\ManyToOne(targetEntity=Language::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\Column(type="text")
     */
    private $value;

    public function getTranslationKey(): ?TranslationKey
    {
        return $this->translationKey;
    }

    public function setTranslationKey(?TranslationKey $translationKey): self
    {
        $this->translationKey = $translationKey;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
