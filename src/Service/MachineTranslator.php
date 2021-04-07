<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Language;
use App\Entity\Translation;
use App\Exception\UnsupportedLanguage;
use App\Service\Translation\TranslationClient;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MachineTranslator
{
    private TranslationClient $translationClient;
    private ValidatorInterface $validator;
    private LoggerInterface $logger;

    public function __construct(
        TranslationClient $translationClient,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->translationClient = $translationClient;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @param Translation $sourceTranslation
     * @param Language $targetLanguage
     * @return Translation
     * @throws UnsupportedLanguage
     * @throws ServiceUnavailableHttpException
     * @throws UnprocessableEntityHttpException
     */
    public function translate(Translation $sourceTranslation, Language $targetLanguage): Translation
    {
        if (!$this->supportsLanguage($targetLanguage->getIsoCode())) {
            throw new UnsupportedLanguage(sprintf(
                'Unsupported target language: "%s"', $targetLanguage->getIsoCode()
            ));
        }
        if (!$this->supportsLanguage($sourceTranslation->getLanguage()->getIsoCode())) {
            throw new UnsupportedLanguage(sprintf(
                'Unsupported source language: "%s"', $sourceTranslation->getLanguage()->getIsoCode()
            ));
        }
        try {
            $translatedText = $this->translationClient->translate(
                $sourceTranslation->getValue(),
                $targetLanguage->getIsoCode()
            );
        } catch (Exception $ex) {
            $this->logger->critical($ex->getMessage());
            throw new ServiceUnavailableHttpException(3600, 'Translation service not available');
        }
        $newTranslation = new Translation($sourceTranslation->getTranslationKey(), $targetLanguage);
        $newTranslation->setValue($translatedText);
        // validate if key-language pair is unique
        $violations = $this->validator->validate($newTranslation);
        if ($violations->count() > 0) {
            throw new UnprocessableEntityHttpException($violations->__toString());
        }

        return $newTranslation;
    }

    public function supportsLanguage(string $languageIsoCode): bool
    {
        try {
            return $this->translationClient->supportsLanguage($languageIsoCode);
        } catch (Exception $ex) {
            $this->logger->critical($ex->getMessage());
            throw new ServiceUnavailableHttpException(3600, 'Translation service not available');
        }
    }
}
