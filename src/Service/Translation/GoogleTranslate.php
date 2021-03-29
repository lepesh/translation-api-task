<?php

namespace App\Service\Translation;

use Google\Cloud\Translate\V2\TranslateClient;

final class GoogleTranslate implements TranslationClient
{
    private TranslateClient $client;

    private string $keyfilePath;

    private function getClient(): TranslateClient
    {
        if (!isset($this->client)) {
            $this->client = new TranslateClient(
                ['keyFile' => json_decode(file_get_contents($this->keyfilePath), true)
                ]);
        }

        return $this->client;
    }

    public function supportsLanguage(string $isoCode): bool
    {
        return in_array($isoCode, $this->getClient()->languages());
    }

    public function translate(string $text, string $targetLanguage, string $sourceLanguage = null): string
    {
        $options['target'] = $targetLanguage;
        if ($sourceLanguage) {
            $options['source'] = $sourceLanguage;
        }
        $translations = $this->getClient()->translate($text, $options);

        return $translations['text'];
    }

    public function setKeyfilePath(string $path): void
    {
        $this->keyfilePath = $path;
    }
}
