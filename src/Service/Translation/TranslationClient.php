<?php
declare(strict_types=1);

namespace App\Service\Translation;

interface TranslationClient
{
    /**
     * @param string $isoCode ISO-639-1
     * @return bool
     */
    public function supportsLanguage(string $isoCode): bool;

    /**
     * @param string $text
     * @param string $targetLanguage
     * @param string|null $sourceLanguage
     * @return string
     */
    public function translate(string $text, string $targetLanguage, string $sourceLanguage = null): string;
}
