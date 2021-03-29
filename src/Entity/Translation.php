<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use App\Traits\IdentityTrait;
use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TranslationRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(uniqueConstraints={
 *     @UniqueConstraint(name="translation_uniq", columns={"translation_key_id", "language_id"})
 * })
 * @UniqueEntity(
 *     fields={"translationKey", "language"},
 *     errorPath="translationKey",
 *     message="Key is already have value for this language"
 * )
 */
class Translation
{
    use IdentityTrait, TimestampableTrait;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity=TranslationKey::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?TranslationKey $translationKey;

    /**
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity=Language::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Language $language;

    /**
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @ORM\Column(type="text")
     */
    private $value;

    public function __construct(TranslationKey $translationKey = null, Language $language = null)
    {
        $this->translationKey = $translationKey;
        $this->language = $language;
    }

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
