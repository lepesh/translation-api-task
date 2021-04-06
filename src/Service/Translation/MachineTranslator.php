<?php
declare(strict_types=1);

namespace App\Service\Translation;

use App\Exception\UnsupportedLanguage;

class MachineTranslator
{
    private TranslationClient $translationClient;

    public function __construct(TranslationClient $translationClient)
    {
        $this->translationClient = $translationClient;
    }

    /**
     * @throws UnsupportedLanguage
     */
    public function translate(string $text, string $targetLanguage, string $sourceLanguage = null): string
    {
        if (!$this->translationClient->supportsLanguage($targetLanguage)) {
            throw new UnsupportedLanguage(sprintf('Unsupported target language: "%s"', $targetLanguage));
        }
        if ($sourceLanguage && !$this->translationClient->supportsLanguage($sourceLanguage)) {
            throw new UnsupportedLanguage(sprintf('Unsupported source language: "%s"', $sourceLanguage));
        }

        return $this->translationClient->translate($text, $targetLanguage, $sourceLanguage);
    }
}
